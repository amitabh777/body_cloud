<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\Helpers\CustomHelper;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\Ambulance;
use Modules\User\Entities\Doctor;
use Modules\User\Entities\DoctorSector;
use Modules\User\Entities\Document;
use Modules\User\Entities\DocumentType;
use Modules\User\Entities\Hospital;
use Modules\User\Entities\InsuranceCompany;
use Modules\User\Entities\Laboratory;
use Modules\User\Entities\Patient;
use Modules\User\Entities\Role;
use Modules\User\Entities\UserRole;

class RegistrationController extends Controller
{
    /**
     * user registration
     * 
     */
    public function registration(Request $request)
    {
        $data = $request->all();
        //Check user data validation
        $validator = $this->validateUserData($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }
        $uniqueId = $this->getNewUniqueId();
        $request->merge(['UniqueID' => $uniqueId]);

        switch ($request->input('RoleSlug')) {
            case config('user.const.role_slugs.patient'):
                //validate profile data
                $validator = $this->validatePatientProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'data' => [], 'status' => 400]);
                }
                $result = $this->patientRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                //patient registered
                $otp = ($result != 'otp_failed') ? $result : ''; //check if otp failed
                $message = ($otp != '') ? 'Patient Registered' : "Patient Registered, Otp didn't sent";
                return response()->json(['status' => 200, 'data' => ['Otp' => $otp], 'message' => $message]);

                break;

            case config('user.const.role_slugs.doctor'):
                $validator = $this->validateDoctorProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
                }
                $result = $this->doctorRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                break;

            case config('user.const.role_slugs.hospital'):
                $validator = $this->validateHospitalProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
                }
                $result = $this->hospitalRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                break;
            case config('user.const.role_slugs.ambulance'):
                $validator = $this->validateAmbulanceProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
                }
                $result = $this->ambulanceRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                break;
            case config('user.const.role_slugs.lab'):
                $validator = $this->validateLabProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
                }
                $result = $this->laboratoryRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                break;
            case config('user.const.role_slugs.insurance_company'):
                $validator = $this->validateInsuranceCompanyProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
                }
                $result = $this->insuranceCompanyRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                break;

            default:
                return response()->json(['message' => 'Role not found', 'status' => 400]);
                break;
        }
        return response()->json(['message' => 'success', 'status' => 200]);
    }

    /**
     * get New UniqueID for registration
     */
    public function getNewUniqueId()
    {
        $uniqueId = User::latest()->pluck('UniqueID')->first();
        if ($uniqueId) {
            $uniqArr = explode('_', $uniqueId);
            $uniqNum = $uniqArr[1] + 1;
            $newUniqueId = 'BDY_' . $uniqNum;
        } else {
            $newUniqueId = 'BDY_1';
        }
        return $newUniqueId;
    }

    /**
     * patient register
     */
    public function patientRegister($request)
    {
        $userData = $this->getUserData($request);
        $profileData = $this->getPatientProfileData($request);
        $success = false;

        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $patientRole = Role::patient()->first();
            }
            UserRole::create(['RoleID' => $patientRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $patient = Patient::create($profileData);
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            $success = false;
            Log::error('Unable to create user ');
            Log::error($e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $patient->PatientProfileImage = $filename;
                    $patient->save();
                } else {
                    Log::error('User registration: unable to upload profile image.');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }

    /**
     * Doctor register
     */
    public function doctorRegister($request)
    {
        $userData = $this->getUserData($request);
        $profileData = $this->getDoctorProfileData($request);
        $success = false;

        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $doctorRole = Role::doctor()->first();
            }
            UserRole::create(['RoleID' => $doctorRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $doctor = Doctor::create($profileData);
            //set medical sectors
            if ($profileData['SectorID']) {
                $this->setMedicalSectors($profileData['SectorID'], $doctor->DoctorID);
            }
            //set Visiting hours 
            $this->setVisitingHours($request->VisitingHours, $doctor->DoctorID, config('user.const.role_slugs.doctor'));
            //Upload registered papers
            $this->uploadDocuments($request->file('Documents'), config('user.const.role_slugs.doctor'), $doctor->DoctorID, config('user.const.document_types.registered_paper'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed rollback
            Log::error('Unable to create user.');
            Log::error($e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $doctor->DoctorProfileImage = $filename;
                    $doctor->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }

    /**
     * Hospital register
     */
    public function hospitalRegister($request)
    {
        $userData = $this->getUserData($request);
        $profileData = $this->getHospitalProfileData($request);

        $success = false;
        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $hospitalRole = Role::hospital()->first();
            }
            UserRole::create(['RoleID' => $hospitalRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $hospital = Hospital::create($profileData);
            //set Visiting hours 
            $this->setVisitingHours($request->VisitingHours, $hospital->HospitalID, config('user.const.role_slugs.hospital'));
            //Upload registered papers
            $this->uploadDocuments($request->file('Documents'), config('user.const.role_slugs.hospital'), $hospital->HospitalID, config('user.const.document_types.registered_paper'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed rollback
            Log::error('Unable to create user');
            Log::error($e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $hospital->HospitalProfileImage = $filename;
                    $hospital->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }

    public function ambulanceRegister($request)
    {
        $userData = $this->getUserData($request);
        $profileData = $this->getAmbulanceProfileData($request);

        $success = false;
        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $ambulanceRole = Role::ambulance()->first();
            }
            UserRole::create(['RoleID' => $ambulanceRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $ambulance = Ambulance::create($profileData);
            //Upload registered papers
            $this->uploadDocuments($request->file('Documents'), config('user.const.role_slugs.ambulance'), $ambulance->AmbulanceID, config('user.const.document_types.driving_license'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed rollback
            Log::error('Unable to create user' . $e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $ambulance->AmbulanceProfileImage = $filename;
                    $ambulance->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }

    //Laboratory Registration
    public function laboratoryRegister($request)
    {
        $userData = $this->getUserData($request);
        $profileData = $this->getLabProfileData($request);

        $success = false;
        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $laboratoryRole = Role::laboratory()->first();
            }
            UserRole::create(['RoleID' => $laboratoryRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $laboratory = Laboratory::create($profileData);
             //set Visiting hours 
             $this->setVisitingHours($request->VisitingHours, $laboratory->LaboratoryID, config('user.const.role_slugs.lab'));
            //Upload registered papers
            $this->uploadDocuments($request->file('Documents'), config('user.const.role_slugs.lab'), $laboratory->LaboratoryID, config('user.const.document_types.registered_paper'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed rollback
            Log::error('Unable to create user' . $e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $laboratory->LaboratoryProfileImage = $filename;
                    $laboratory->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }
    //Insurance Company
    public function insuranceCompanyRegister($request)
    {
        // print_r($request->all());
        // exit;
        $userData = $this->getUserData($request);
        $profileData = $this->getInsuranceCompanyProfileData($request);

        $success = false;
        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $insuranceCompanyRole = Role::insuranceCompany()->first();
            }
            UserRole::create(['RoleID' => $insuranceCompanyRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $insuranceCompany = InsuranceCompany::create($profileData);
             //set Visiting hours 
             $this->setVisitingHours($request->VisitingHours, $insuranceCompany->InsuranceCompanyID, config('user.const.role_slugs.insurance_company'));
            //Upload registered papers
            $this->uploadDocuments($request->file('Documents'), config('user.const.role_slugs.insurance_company'), $insuranceCompany->InsuranceCompanyID, config('user.const.document_types.registered_paper'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed rollback
            Log::error('Unable to create user' . $e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $insuranceCompany->InsuranceCompanyProfileImage = $filename;
                    $insuranceCompany->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }

    public function validateUserData($data)
    {
        $userRules = [
            'Email' => 'required|email|max:150|unique:users,Email',
            'Phone' => 'required|min:10|max:10|unique:users,Phone',
            'Password' => ['required', 'string', 'min:8'],
            'RoleSlug' => 'required'
        ];
        $message = [
            'RoleSlug.required' => 'Role is required'
        ];
        return Validator::make($data, $userRules, $message, []);
    }

    public function validatePatientProfile($request)
    {
        $userRules = [
            'PatientName' => 'required',
            'PatientGender' => 'required',
            'PatientDOB' => 'required',
            'PatientHeight' => 'required',
            'PatientWeight' => 'required',
            'EmergencyContactNo' => 'required|max:10|min:10',
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function validateDoctorProfile($request)
    {
        $userRules = [
            'DoctorName' => 'required',
            'DoctorGender' => 'required',
            'VisitingHours' => 'required'
        ];
        return Validator::make($request->all(), $userRules);
    }
    //Validate fields
    public function validateHospitalProfile($request)
    {
        $userRules = [
            'HospitalName' => 'required',
            'HospitalContactName' => 'required',
            'VisitingHours' => 'required'
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function validateAmbulanceProfile($request)
    {
        $userRules = [
            'ContactName' => 'required',
            'AmbulanceNumber' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
    }
    public function validateLabProfile($request)
    {
        $userRules = [
            'ContactName' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
    }
    public function validateInsuranceCompanyProfile($request)
    {
        $userRules = [
            'CompanyName' => 'required',
            'Website' => 'required',
            'VisitingHours' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function setMedicalSectors($sectorIDs, $doctorID)
    {
        $now = Carbon::now();
        $sectors = [];
        if ($sectorIDs && is_array($sectorIDs)) {
            foreach ($sectorIDs as $sectorID) {
                $sectors[] = ['SectorID' => $sectorID, 'DoctorID' => $doctorID, 'CreatedAt' => $now->toDateTimeString()];
            }
            DB::table('doctor_sectors')->insert($sectors);
        } else {
            DoctorSector::create(['SectorID' => $sectorIDs, 'DoctorID' => $doctorID]);
        }
    }
    //Set doctor's visiting hours
    public function setVisitingHours($visitingHours, $profileID, $roleSlug)
    {
        if (!$visitingHours) {
            Log::error('Visiting hours not defined');
            return false;
        }
        $now = Carbon::now();
        $rows = [];
        $profileIDKey = CustomHelper::getProfileIdKey($roleSlug); //get profile id column name
        $days = is_array($visitingHours) ? $visitingHours : json_decode($visitingHours, true);
        if ($days['days']) {
            foreach ($days['days'] as $day => $details) {
                $rows[] = array(
                    $profileIDKey => $profileID,
                    'VisitingDay' => $day,
                    'VisitingStartTime' => CustomHelper::convertTimeTo24($details['start_time']),
                    'VisitingEndTime' => CustomHelper::convertTimeTo24($details['end_time']),
                    'VisitingSlot' => $details['visiting_slot'],
                    'IsAvailable' => $details['is_available'],
                    'CreatedAt' => $now->toDateTimeString()
                );
            }
        }
        //Insert into visitng hours
        DB::table('visiting_hours')->insert($rows);
    }

    public function getUserData($request)
    {
        return array(
            'Email' => $request->input('Email'),
            'Phone' => $request->input('Phone'),
            'ParentID' => $request->input('ParentID', null),
            'UniqueID' => $request->input('UniqueID'),
            'Password' => Hash::make($request->input('Password')),
            'Address' => $request->input('Address', ''),
            'DeviceType' => $request->input('DeviceType', ''),
            'DeviceToken' => $request->input('DeviceToken', ''),
            'api_token' => $this->createToken()
        );
    }
    //Patient fields
    public function getPatientProfileData($request)
    {
        return [
            'UserID' => '',
            'PatientName' => $request->input('PatientName'),
            'PatientGender' => $request->input('PatientGender'),
            'PatientDOB' => $request->input('PatientDOB'),
            'BloodGroupID' => $request->input('BloodGroupID', null),
            'PatientHeight' => (float) $request->input('PatientHeight'),
            'PatientWeight' => (float)$request->input('PatientWeight'),
            'PatientChronicDisease' => $request->input('PatientChronicDisease', null),
            'PatientPermanentMedicines' => $request->input('PatientPermanentMedicines', null),
            'EmergencyContactNo' => $request->input('EmergencyContactNo'),
        ];
    }
    //Doctor fields
    public function getDoctorProfileData($request)
    {
        return [
            'UserID' => '',
            'DoctorName' => $request->input('DoctorName'),
            'DoctorInfo' => $request->input('DoctorInfo'),
            'DoctorGender' => $request->input('DoctorGender'),
            'HospitalID' => $request->input('HospitalID', null),
            'DoctorWebsite' => $request->input('DoctorWebsite', null),
            'DoctorBankAccountNo' => $request->input('DoctorBankAccountNo', null),
            'DoctorBankName' => $request->input('DoctorBankName', null),
            'DoctorMinReservationCharge' => $request->input('DoctorMinReservationCharge', null),
            'SectorID' => $request->input('SectorID', []),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }
    //Hospital fields
    public function getHospitalProfileData($request)
    {
        return [
            'UserID' => '',
            'HospitalName' => $request->input('HospitalName'),
            'HospitalInfo' => $request->input('HospitalInfo'),
            'HospitalWebsite' => $request->input('HospitalWebsite'),
            'HospitalContactName' => $request->input('HospitalContactName'),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }
    //Ambulance profile
    public function getAmbulanceProfileData($request)
    {
        return [
            'AmbulanceContactName' => $request->input('ContactName'),
            'AmbulanceNumber' => $request->input('AmbulanceNumber'),
        ];
    }
    //Lab profile
    public function getLabProfileData($request)
    {
        return [
            'LaboratoryContactName' => $request->input('ContactName'),
            'LaboratoryInfo' => $request->input('LaboratoryInfo'),
            'LaboratoryWebsite' => $request->input('LaboratoryWebsite'),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }
    //Lab profile
    public function getInsuranceCompanyProfileData($request)
    {
        return [
            'InsuranceCompanyName' => $request->input('CompanyName'),
            'InsuranceCompanyInfo' => $request->input('CompanyInfo'),
            'InsuranceCompanyWebsite' => $request->input('Website'),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }

    public function createToken()
    {
        return hash('sha256', time() . '0123456789ab25');
    }

    /**
     * Upload documents
     */
    public function uploadDocuments($files, $role, $profileId, $doctype)
    {
        $now = Carbon::now();
        //multiple uploads
        if ($files) {
            $docType = DocumentType::where('DocumentTypeName', $doctype)->first();
            $profileKey = CustomHelper::getProfileIdKey($role);
            $uploadedFiles = [];
            foreach ($files as $file) {
                $fileName = $file->hashName();
                $path = $file->storeAs('public/documents/doctors', $fileName);
                if ($path) {
                    $uploadedFiles[] =  array('DocumentTypeID' => $docType->DocumentTypeID, $profileKey => $profileId, 'DocumentFile' => $fileName, 'CreatedAt' => $now->toDateTimeString());
                }
            }
            if (!empty($uploadedFiles)) {
                Document::insert($uploadedFiles);
            }
            return true;
        }
        return false;
    }

    public function uploadProfileImage($file)
    {
        $file_name = $file->hashName();
        $path = $file->storeAs('public/documents/profile_images', $file_name);
        if ($path) {
            return $file_name;
        }
        return false;
    }
}
