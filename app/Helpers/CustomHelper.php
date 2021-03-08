<?php 

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Log;

class CustomHelper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }
    
    /**
     * Send OTP and reset in users table
     */
    public static function sendOtp($phone)
    {
        //Todo: code for sending sms 
        $otp = 4444;//rand(1111, 9999);
        $res = User::where('Phone', $phone)->update(['Otp' => $otp]);
        if ($res) {
            return $otp;
        }
        Log::error('Unable to send otp');
        return false;
    }

    //get profile id table key name: HospitalID/PatientID etc
    public static function getProfileIdKey($role)
    {
        if ($role == config('user.const.role_slugs.patient')) {
            $profileIDKey = 'PatientID';
        }elseif ($role == config('user.const.role_slugs.doctor')) {
            $profileIDKey = 'DoctorID';
        }elseif ($role == config('user.const.role_slugs.hospital')) {
            $profileIDKey = 'HospitalID';
        } elseif ($role == config('user.const.role_slugs.lab')) {
            $profileIDKey = 'LaboratoryID';
        }elseif ($role == config('user.const.role_slugs.ambulance')) {
            $profileIDKey = 'AmbulanceID';
        }elseif ($role == config('user.const.role_slugs.insurance_company')) {
            $profileIDKey = 'InsuranceCompanyID';
        }
        else{
            return false;
        }
        return $profileIDKey;
    }

    //convert time to 24 hours format
    public static function convertTimeTo24($time){
        return date('H:i',strtotime($time));
    }
}