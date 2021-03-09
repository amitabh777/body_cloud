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
//Authentications
Route::namespace('Api\Auth')->group(function () {
    Route::post('register', 'RegistrationController@registration');
    Route::post('login', 'LoginController@login');
    Route::post('forgot_password_send_otp', 'ForgotPasswordController@forgotPasswordSendOtp');
    Route::post('reset_password', 'ResetPasswordController@resetPassword');
    Route::post('verify_phone', 'VerificationController@verifyPhoneWithOtp');  
    Route::post('logout', 'LoginController@logout')->middleware(['auth:api']);
});

Route::namespace('Api')->group(function(){
    Route::get('blood_groups','BloodGroupController@index');
    Route::get('medical_sectors','MedicalSectorController@index');
});

//Profile endpoints with authentication
Route::namespace('Api')->prefix('profile')->middleware(['auth:api','role_check'])->group(function(){
    Route::get('user/me', 'UserController@myProfile'); //view profile 
    Route::post('update', 'ProfileController@update');
    Route::post('image/upload', 'ProfileController@uploadProfileImage');
    
});


