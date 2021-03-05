<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
date_default_timezone_set('Asia/Kolkata');

Route::middleware('auth:api')->post('/user', function (Request $request) {
    
    return 'success';
    //return $request->user();
});

Route::namespace('Api\Auth')->group(function () {
    Route::post('register', 'RegistrationController@userRegistration');
    Route::post('login', 'LoginController@login');
    Route::post('forgot_password_send_otp', 'ForgotPasswordController@forgotPasswordSendOtp');
    Route::post('reset_password', 'ResetPasswordController@resetPassword');
    Route::post('verify_phone', 'VerificationController@verifyPhoneWithOtp');
  
});

Route::namespace('Api\Auth')->middleware('auth:api')->group(function(){
    Route::post('logout', 'LoginController@logout');
});

