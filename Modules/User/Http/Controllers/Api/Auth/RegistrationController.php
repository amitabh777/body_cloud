<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\Helpers\CustomHelper;
use App\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
    public function userRegistration(Request $request)
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
                    return response()->json([ 'message' => 'unable to register', 'status' => 400]);
                }
                //patient registered
                $otp = ($result != 'otp_failed') ? $result : ''; //check if otp failed
                $message = ($otp != '') ? 'Patient Registered' : "Patient Registered, Otp didn't sent";
                return response()->json(['status' => 200, 'data' => ['Otp' => $otp], 'message' => $message]);

                break;

            case 'doctor':

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

    // /**
    //  * Send OTP
    //  */
    // public function sendOtp($phone)
    // {
    //     //Todo: code for sending sms 
    //     $otp = rand(11111, 99999);
    //     $res = User::where('Phone', $phone)->update(['Otp' => $otp]);
    //     if ($res) {
    //         return $otp;
    //     }
    //     Log::error('Unable to send otp');
    //     return false;
    // }

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
        $userData = array(
            'Email' => $request->input('Email'),
            'Phone' => $request->input('Phone'),
            'ParentID' => $request->input('ParentID', null),
            'UniqueID' => $request->input('UniqueID'),
            'Password' => Hash::make($request->input('Password')),
            'Address' => $request->input('Address', ''),
            'DeviceType' => $request->input('DeviceType', 'android'),
            'DeviceToken' => $request->input('DeviceToken', null),
            'api_token' => $this->quickRandom()
        );
        $profileData = [
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
        $user = null;
        $success = false;
        try {
            DB::transaction(function () use ($userData, $profileData, $user) {
                //create user
                $user = User::create($userData);
                if ($user) {
                    $patientRole = Role::patient()->first();
                }
                UserRole::create(['RoleID' => $patientRole->RoleID, 'UserID' => $user->UserID]);
                $profileData['UserID'] = $user->UserID;
                $profileData['Otp'] = $user->Otp;
                Patient::create($profileData);
            });
            $success = true;
        } catch (Exception $e) {
            Log::error('Unable to create user');
            Log::error($e->getMessage());
        }
        if ($success) {
            //upload file
           // $docType = DocumentType::where('DocumentTypeName', config('user.const.document_types.image'))->first();
            if ($request->hasFile('DocumentFile')) {
                // $filename = $this->uploadDocument($request->file('DocumentFile'));
                // if ($filename) {
                //     Log::info('filename: '.$filename);
                //     //saving in documents table
                //     $res = Document::create(['DocumentTypeID' => $docType->DocumentTypeID, 'PatientID' => $profileData['UserID'], 'DocumentFile' => $filename]);
                //     Log::info('document created');
                // }
            }
            //t $otp = $this->sendOtp($userData['Phone']);
            $otp = CustomHelper::sendOtp($userData['Phone']);
            return $otp ? $otp : 'otp_failed';
        }
        return $success;
    }

    public function quickRandom($length = 80)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Upload documents
     */
    public function uploadDocument($file)
    {
        // $filename= $file->getClientOriginalName();
        // $fileExt = $file->getClientOriginalExtension();
        // $filenameArr = explode('.',$filename);
        // $newfile = $filenameArr[0];
        // $path = $file->storeAs(
        //     'documents/profile_images', $id
        // );
        // $path = Storage::disk('public')->put('documents/profile_images/'.$newfile.'_'.$id.'.'.$fileExt,$file);
        //  $path = Storage::disk('public')->put('documents/profile_images',$file);

        $file_name = $file->hashName();
        $path = $file->storeAs('public/documents/profile_images', $file_name);
        if ($path) {
            return $file_name;
        }
        return false;
    }
}
