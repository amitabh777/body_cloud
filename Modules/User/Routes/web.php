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
    Route::get('login','LoginController@index')->name('admin.login.index');
    Route::post('login','LoginController@login')->name('admin.login');
    Route::get('register','RegistrationController@index');   
});

Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::get('dashboard','DashboardController@index')->name('admin.dashboard.index');
});

//Manage profiles
Route::prefix('admin/manage-profiles')->namespace('Admin')->group(function(){
    Route::get('patient','PatientController@index')->name('admin.manage_profiles.patient.index');
    Route::get('doctor','DoctorController@index')->name('admin.manage_profiles.doctor.index');
    Route::get('hospital','HospitalController@index')->name('admin.manage_profiles.hospital.index');
    Route::get('ambulance','AmbulanceController@index')->name('admin.manage_profiles.ambulance.index');
    Route::get('laboratory','Laboratoryontroller@index')->name('admin.manage_profiles.laboratory.index');
    Route::get('insurance-company','InsuranceCompanyController@index')->name('admin.manage_profiles.insurance_company.index');
});