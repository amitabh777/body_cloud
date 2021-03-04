<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Http\Requests\UserRegistrationRequest;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function register(Request $request)
    {
        $data = $request->all();
        //Check user data validation
        $validator = $this->validateUserData($data);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //validate profile data
        $this->validatePatientProfile($data);
        
        return response()->json(['status'=>'success'],200);
       
    }

    public function validateUserData($data){
        $userRules= [
            'Email'=>'required|email|max:150|unique:users,Email',
            'Phone'=>'required|min:13|max:13|unique:users,Phone',
            'Password'=>['required', 'string', 'min:8'],
            'RoleSlug'=>'required'
        ];
        $message = [
            'Phone.min'=>'Phone must be 10 digits',
            'Phone.max'=>'Phone must be 10 digits',
            'RoleSlug.required'=>'Role is required'
        ];
        return Validator::make($data, $userRules,$message,[]);

    }

    public function validatePatientProfile($data){
        $userRules= [
            'PatientName'=>'required|email|max:150|unique:users,Email',
            'PatientGender'=>'required|min:13|max:13|unique:users,Phone',
            'PatientDOB'=>['required', 'string', 'min:8'],
            'PatientHeight'=>'required',
            'PatientWeight'=>'',
            'EmergencyContactNo'=>''
        ];
        return Validator::make($data, $userRules,['RoleSlug.required'=>'Role is required'],[]);

    }

    /**
     * Send OTP
     */
    public function sendOtp($phone){
        
    }
}
