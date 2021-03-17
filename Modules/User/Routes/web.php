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
    Route::get('patients/{UserID}','PatientController@show')->name('admin.manage_profiles.patient.show');
    Route::get('patients/{UserID}/edit','PatientController@edit')->name('admin.manage_profiles.patient.edit');    
    Route::patch('patients/{UserID}','PatientController@update')->name('admin.manage_profiles.patient.update');
    
    Route::get('doctors','DoctorController@index')->name('admin.manage_profiles.doctor.index');
    Route::get('doctors/{UserID}','DoctorController@show')->name('admin.manage_profiles.doctor.show');
    Route::get('doctors/{UserID}/edit','DoctorController@edit')->name('admin.manage_profiles.doctor.edit');
    Route::patch('doctors/{UserID}','DoctorController@update')->name('admin.manage_profiles.doctor.update');
    
    
    Route::get('hospitals','HospitalController@index')->name('admin.manage_profiles.hospital.index');
    Route::get('hospitals/{UserID}','HospitalController@show')->name('admin.manage_profiles.hospital.show');

    Route::get('ambulances','AmbulanceController@index')->name('admin.manage_profiles.ambulance.index');
    Route::get('ambulances/{UserID}','AmbulanceController@show')->name('admin.manage_profiles.ambulance.show');

    Route::get('laboratories','LaboratoryController@index')->name('admin.manage_profiles.laboratory.index');
    Route::get('laboratories/{UserID}','LaboratoryController@show')->name('admin.manage_profiles.laboratory.show');
    
    Route::get('insurance-companies','InsuranceCompanyController@index')->name('admin.manage_profiles.insurance_company.index');
    Route::get('insurance-companies/{UserID}','InsuranceCompanyController@show')->name('admin.manage_profiles.insurance_company.show');

});

//Manage profiles
Route::prefix('admin/manage-users')->namespace('Admin')->group(function(){
    Route::post('status/{UserID}','UserController@updateUserStatus')->name('admin.user.status.update');
});
//manage master data
Route::prefix('admin/master-data')->namespace('Admin')->group(function(){
    Route::get('bloodgroups','BloodGroupController@index')->name('admin.master_data.bloodgroups.index');
    Route::get('bloodgroups/{BloodGroupID}/edit','BloodGroupController@edit')->name('admin.master_data.bloodgroups.edit');
    Route::get('bloodgroups/create','BloodGroupController@create')->name('admin.master_data.bloodgroups.create');
    Route::patch('bloodgroups/{BloodGroupID}/status','BloodGroupController@updateStatus')->name('admin.master_data.bloodgroup.status.update');
    Route::patch('bloodgroups/{BloodGroupID}','BloodGroupController@update')->name('admin.master_data.bloodgroup.update');
    Route::post('bloodgroups','BloodGroupController@store')->name('admin.master_data.bloodgroup.store');
    Route::delete('bloodgroups/{BloodGroupID}','BloodGroupController@destroy')->name('admin.master_data.bloodgroups.destroy');

    Route::get('document-types','DocumentTypeController@index')->name('admin.master_data.document_types.index');
    Route::get('document-types/{DocumentTypeID}/edit','DocumentTypeController@edit')->name('admin.master_data.document_type.edit');
    Route::get('document-types/create','DocumentTypeController@create')->name('admin.master_data.document_types.create');
    Route::patch('document-types/{DocumentTypeID}/status','DocumentTypeController@updateStatus')->name('admin.master_data.document_type.status.update');
    Route::patch('document-types/{DocumentTypeID}','DocumentTypeController@update')->name('admin.master_data.document_type.update');
    Route::post('document-types','DocumentTypeController@store')->name('admin.master_data.document_type.store');
    Route::delete('document-types/{DocumentTypeID}','DocumentTypeController@destroy')->name('admin.master_data.document_type.destroy');

    
    Route::get('medical-sectors','MedicalSectorController@index')->name('admin.master_data.medical_sectors.index');

});


//Documents upload
Route::prefix('admin/manage-documents')->namespace('Admin')->middleware(['auth'])->group(function(){
    Route::post('upload','DocumentController@store')->name('admin.manage_documents.upload');
    
});