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
        $otp = rand(1111, 9999);
        $res = User::where('Phone', $phone)->update(['Otp' => $otp]);
        if ($res) {
            return $otp;
        }
        Log::error('Unable to send otp');
        return false;
    }
}