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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    
    return 'success';
    //return $request->user();
});
Route::middleware('auth:api')->post('/user1', function (Request $request) {
    
    return 'success';
    //return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::post('register', 'RegistrationController@register');
    Route::post('login', 'LoginController@login');
});

Route::namespace('Api')->middleware('auth:api')->group(function(){
    
});
