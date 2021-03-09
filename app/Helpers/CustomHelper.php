<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Ambulance;
use Modules\User\Entities\Doctor;
use Modules\User\Entities\Hospital;
use Modules\User\Entities\InsuranceCompany;
use Modules\User\Entities\Laboratory;
use Modules\User\Entities\Patient;

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
        $otp = 4444; //rand(1111, 9999);
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
        } elseif ($role == config('user.const.role_slugs.doctor')) {
            $profileIDKey = 'DoctorID';
        } elseif ($role == config('user.const.role_slugs.hospital')) {
            $profileIDKey = 'HospitalID';
        } elseif ($role == config('user.const.role_slugs.lab')) {
            $profileIDKey = 'LaboratoryID';
        } elseif ($role == config('user.const.role_slugs.ambulance')) {
            $profileIDKey = 'AmbulanceID';
        } elseif ($role == config('user.const.role_slugs.insurance_company')) {
            $profileIDKey = 'InsuranceCompanyID';
        } else {
            return false;
        }
        return $profileIDKey;
    }

    //convert time to 24 hours format
    public static function convertTimeTo24($time)
    {
        return date('H:i', strtotime($time));
    }

    //upload user's profile image and return path/filename
    public static function uploadProfileImage($file)
    {
        $file_name = $file->hashName();
        $path = $file->storeAs('documents/profile_images', $file_name, 'public');
        if ($path) {
            return $path;
        }
        return false;
    }

    //get model according to user role
    public static function getModelUserRole($roleSlug)
    {
        $model=null;
        if ($roleSlug == config('user.const.role_slugs_patient')) {
            $model = Patient::class;
        } elseif ($roleSlug == config('user.const.role_slugs.doctor')) {
            $model = Doctor::class;
        } elseif ($roleSlug == config('user.const.role_slugs.hospital')) {
            $model = Hospital::class;
        } elseif ($roleSlug == config('user.const.role_slugs.ambulance')) {
            $model = Ambulance::class;
        } elseif ($roleSlug == config('user.const.role_slugs.lab')) {
            $model = Laboratory::class;
        } elseif ($roleSlug == config('user.const.role_slugs.insurance_companies')) {
            $model = InsuranceCompany::class;
        }
        return $model;
    }

    public static function getProfileImageKey($roleSlug){
        $key=null;
        if ($roleSlug == config('user.const.role_slugs_patient')) {
            $key = 'PatientProfileImage';
        } elseif ($roleSlug == config('user.const.role_slugs.doctor')) {
            $key = 'DoctorProfileImage';
        } elseif ($roleSlug == config('user.const.role_slugs.hospital')) {
            $model = Hospital::class;
        } elseif ($roleSlug == config('user.const.role_slugs.ambulance')) {
            $model = Ambulance::class;
        } elseif ($roleSlug == config('user.const.role_slugs.lab')) {
            $model = Laboratory::class;
        } elseif ($roleSlug == config('user.const.role_slugs.insurance_companies')) {
            $model = InsuranceCompany::class;
        }
        return $key;
    }
}
