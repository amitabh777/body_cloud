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
    // Route::get('login','LoginController@index')->name('admin.login.index');
    // Route::post('login','LoginController@login')->name('admin.login');
    Route::post('logout','LoginController@logout')->name('admin.logout');
    Route::get('register','RegistrationController@index');   
});

Route::prefix('admin')->namespace('Admin')->middleware(['auth'])->group(function(){
    Route::get('dashboard','DashboardController@index')->name('admin.dashboard.index');
});

//Manage profiles
Route::prefix('admin/manage-profiles')->namespace('Admin')->middleware(['auth'])->group(function(){
    Route::patch('users/{UserID}','UserController@update')->name('admin.manage_profiles.user.update');

    Route::get('patients','PatientController@index')->name('admin.manage_profiles.patient.index');
    Route::get('patients/{UserID}/edit','PatientController@edit')->name('admin.manage_profiles.patient.edit');
    Route::patch('patients/{UserID}','PatientController@update')->name('admin.manage_profiles.patient.update');
    
    Route::get('doctors','DoctorController@index')->name('admin.manage_profiles.doctor.index');
    Route::get('hospitals','HospitalController@index')->name('admin.manage_profiles.hospital.index');
    Route::get('ambulances','AmbulanceController@index')->name('admin.manage_profiles.ambulance.index');
     Route::get('laboratories','LaboratoryController@index')->name('admin.manage_profiles.laboratory.index');
    Route::get('insurance-companies','InsuranceCompanyController@index')->name('admin.manage_profiles.insurance_company.index');
});