<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
});


Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::get('login','LoginController@index');
    Route::get('register','RegistrationController@index');   
});

Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::get('dashboard','DashboardController@index')->name('admin.dashboard.index');
});

//Manage profiles
Route::prefix('admin/manage-profiles')->namespace('Admin')->group(function(){
    Route::get('patients','PatientController@index')->name('admin.manage_profile.patient.index');
});