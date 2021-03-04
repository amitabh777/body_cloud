<?php

namespace Modules\User\Http\Controllers\Api;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\Patient;
use Modules\User\Entities\Role;
use Modules\User\Entities\UserRole;

class RegistrationController extends Controller
{
    /**
     * user registration
     * 
     */
    public function register(Request $request)
    {
        $data = $request->all();      
        //Check user data validation
        $validator = $this->validateUserData($data);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $uniqueId = User::latest()->pluck('UniqueID')->first();
        if ($uniqueId) {           
            $uniqArr = explode('_', $uniqueId);           
            $uniqNum = $uniqArr[1] + 1;
            $uniqueId = 'BDY_' . $uniqNum;
        } else {
            $uniqueId = 'BDY_1';
        }
        $data['DeviceType'] = $request->input('DeviceType', '');
        $data['DeviceToken'] = $request->input('DeviceToken', '');
        $data['Address'] = $request->input('Address', '');
        $data['PatientID'] = $request->input('PatientID', '');
        $data['BloodGroupID'] = $request->input('BloodGroupID', NULL);
        $data['PatientChronicDisease'] = $request->input('PatientChronicDisease', '');
        $data['PatientPermanentMedicines'] = $request->input('PatientPermanentMedicines', '');
        $data['UniqueID'] = $uniqueId;

        switch ($data['RoleSlug']) {
            case 'patient':
                //validate profile data
                $validator = $this->validatePatientProfile($data);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                $result = $this->patientRegster($data);
                if(!$result){
                    return response()->json(['error'=>'something went wrong'],500);
                }
                return response()->json(['status'=>'Success'],200);
                break;
        }
        return response()->json(['status' => 'success'], 200);
    }
    public function validateUserData($data)
    {
        $userRules = [
            'Email' => 'required|email|max:150|unique:users,Email',
            'Phone' => 'required|min:13|max:13|unique:users,Phone',
            'Password' => ['required', 'string', 'min:8'],
            'RoleSlug' => 'required'
        ];
        $message = [
            'Phone.min' => 'Phone must be 10 digits',
            'Phone.max' => 'Phone must be 10 digits',
            'RoleSlug.required' => 'Role is required'
        ];
        return Validator::make($data, $userRules, $message, []);
    }
    public function validatePatientProfile($data)
    {
        $userRules = [
            'PatientName' => 'required',
            'PatientGender' => 'required',
            'PatientDOB' => ['required'],
            'PatientHeight' => 'required',
            'PatientWeight' => 'required',
            'EmergencyContactNo' => 'required',
        ];
        return Validator::make($data, $userRules, [], []);
    }

    /**
     * Send OTP
     */
    public function sendOtp($phone)
    {
        //Todo: code for sending sms 
        $otp = rand(11111,99999);
        $res = User::where('Phone',$phone)->update(['Otp'=>$otp]);
        if($res){
            return true;
        }
        Log::error('Unable to send otp');
        return false;
    }

    /**
     * patient register
     */
    public function patientRegster($data)
    {        
        $userData = array(
            'Email' => $data['Email'],
            'Phone' => $data['Phone'],
            'PatientID' => $data['PatientID'],
            'UniqueID' => $data['UniqueID'],
            'Password' => Hash::make($data['Password']),
            'Address' => $data['Address'],
            'DeviceType' => $data['DeviceType'],
            'DeviceToken' => $data['DeviceToken'],
            'api_token'=> $this->quickRandom()
        );
        $profileData = [
            'UserID' => '',
            'PatientName' => $data['PatientName'],
            'PatientGender' => $data['PatientGender'],
            'PatientDOB' => $data['PatientDOB'],
            'BloodGroupID' => $data['BloodGroupID'],
            'PatientHeight' => $data['PatientHeight'],
            'PatientWeight' => $data['PatientWeight'],
            'PatientChronicDisease' => $data['PatientChronicDisease'],
            'PatientPermanentMedicines' => $data['PatientPermanentMedicines'],
            'EmergencyContactNo' => $data['EmergencyContactNo'],
        ];

        $success = false;
        try{
            DB::transaction(function () use ($userData,$profileData) {
                //create user
                $user = User::create($userData);
                if ($user) {
                    $patientRole = Role::patient()->first();
                }
                UserRole::create(['RoleID'=>$patientRole->RoleID,'UserID'=>$user->UserID]);
                $profileData['UserID'] = $user->UserID;
                Patient::create($profileData);                
            });
            $success =true;            
        }catch(Exception $e){
            Log::error('Unable to create user');
            Log::error($e->getMessage());
        }
        if($success){
            $this->sendOtp($userData['Phone']);
        }
        return $success;
    }

    public function quickRandom($length = 80)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

}
