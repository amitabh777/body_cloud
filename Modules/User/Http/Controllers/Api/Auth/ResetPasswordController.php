<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /**
     * reset password
     */
    public function resetPassword(Request $request){
        $data = $request->all();
        //validate and check phone exists or not
        $validator = $this->validateCredentials($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'data' => [], 'status' => 400], 400);
        }
        $password = Hash::make($data['NewPassword']);
      
        $res = User::where(['UserID'=>$data['UserID'],'Otp'=>$data['Otp']])->update(['Password'=>$password]);
        if(!$res){
            return response()->json(['data' => [], 'message' => 'Could not reset password', 'status' => 500],500);
        }
        return response()->json(['data' => [], 'message' => 'Password Reset', 'status' => 200]);
    }

    /**
     * Validate incoming request
     */
    public function validateCredentials($data)
    {
        $userRules = [
            'UserID' => 'required|exists:users,UserID', 
            'NewPassword'=>'required|min:8',
            'Otp'=>'required|exists:users,Otp'
        ];
        $message = [
            'UserID.exists'=>'UserID not exists',
            'Otp.exists'=>'Otp not matched',
        ];
        return Validator::make($data, $userRules, $message, []);
    }

}
