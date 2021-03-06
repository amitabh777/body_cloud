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
use Modules\User\Entities\Doctor;
use Modules\User\Entities\DoctorSector;
use Modules\User\Entities\Document;
use Modules\User\Entities\DocumentType;
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
            case 'patient':
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

            case 'doctor':
                $validator = $this->validateDoctorProfile($request);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'data' => [], 'status' => 400]);
                }
                $result = $this->doctorRegister($request);
                if (!$result) {
                    return response()->json(['message' => 'unable to register', 'status' => 400]);
                }
                break;

            default:
                break;
        }
        return response()->json(['status' => 'success']);
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
            // 'Phone.min' => 'Phone must be 10 digits',
            // 'Phone.max' => 'Phone must be 10 digits',
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
            'DoctorInfo' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
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
            Log::error('Unable to create user');
            Log::error($e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('PatientProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('PatientProfileImage'));
                if ($filename) {
                    $patient->PatientProfileImage = $filename;
                    $patient->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            /* fd $docType = DocumentType::where('DocumentTypeName', config('user.const.document_types.image'))->first();

            if ($request->file('PatientProfileImage')) {
                $filename = $this->uploadDocument($request->file('PatientProfileImage'));
                if ($filename) {
                    //saving in documents table
                    Document::create(['DocumentTypeID' => $docType->DocumentTypeID, 'PatientID' => $patient->PatientID, 'DocumentFile' => $filename]);
                    Log::info('document created');
                }
            }*/
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
        $now = Carbon::now();
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
            //secotor update
            $sectors = [];
            if ($profileData['SectorID'] && is_array($profileData['SectorID'])) {
                foreach ($profileData['SectorID'] as $sectorID) {
                    $sectors[] = ['SectorID'=>$sectorID,'DoctorID'=>$doctor->DoctorID];
                }
                DB::table('doctor_sectors')->insert($sectors);
            }else{
                DoctorSector::create( ['SectorID'=>$profileData['SectorID'],'DoctorID'=>$doctor->DoctorID]);
            }
            //set Visiting hours 

            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            $success = false;
            Log::error('Unable to create user');
            Log::error($e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('DoctorProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('DoctorProfileImage'));
                if ($filename) {
                    $doctor->DoctorProfileImage = $filename;
                    $doctor->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            /* fd $docType = DocumentType::where('DocumentTypeName', config('user.const.document_types.image'))->first();

            if ($request->file('PatientProfileImage')) {
                $filename = $this->uploadDocument($request->file('PatientProfileImage'));
                if ($filename) {
                    //saving in documents table
                    Document::create(['DocumentTypeID' => $docType->DocumentTypeID, 'PatientID' => $patient->PatientID, 'DocumentFile' => $filename]);
                    Log::info('document created');
                }
            }*/
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
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
            'DeviceType' => $request->input('DeviceType', 'android'),
            'DeviceToken' => $request->input('DeviceToken', null),
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
            'DoctorProfileImage' => '',
            'HospitalID' => $request->input('HospitalID', null),
            'DoctorWebsite' => $request->input('DoctorWebsite', null),
            'DoctorBankAccountNo' => $request->input('DoctorBankAccountNo', null),
            'DoctorBankName' => $request->input('DoctorBankName', null),
            'DoctorMinReservationCharge' => $request->input('DoctorMinReservationCharge', null),
            'SectorID' => $request->input('SectorID', []),
            'VisitingHours' => $request->input('VisitingHours', null),
        ];
    }

    public function createToken($length = 80)
    {
        return hash('sha256', time() . '0123456789ab');
    }

    /**
     * Upload documents
     */
    public function uploadDocument($files)
    {
        //multiple uploads
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
