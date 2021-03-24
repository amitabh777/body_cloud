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

//public routes for list
Route::namespace('Api')->group(function(){
    Route::get('blood_groups','BloodGroupController@index');
    Route::get('medical_sectors','MedicalSectorController@index');
});

Route::namespace('Api')->middleware(['auth:api'])->group(function(){
    Route::get('user/me', 'UserController@myProfile'); //view profile 
});

//Profile endpoints with authentication
Route::namespace('Api')->prefix('profile')->middleware(['auth:api','role_check'])->group(function(){   
    Route::post('update', 'ProfileController@update');    
    Route::post('image/upload', 'ProfileController@uploadProfileImage');
    Route::post('documents/upload', 'DocumentController@store');
    Route::post('documents/{document_id}/delete', 'DocumentController@destroy');
    
});
//Hospital list
Route::prefix('hospital')->namespace('Api')->middleware(['auth:api'])->group(function () {
    Route::get('list','HospitalController@index');
});

//Manage staff
Route::namespace('Api')->group(function () {
    Route::get('staffs','StaffController@index');
    Route::get('staffs/{user_id}','StaffController@show');
    Route::post('staffs','StaffController@store');
});


