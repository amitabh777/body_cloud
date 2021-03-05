<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{

    /**
     * Verify phone using otp
     */
    public function verifyPhoneWithOtp(Request $request){
        $data = $request->all();
        //validate and check phone exists or not
        $validator = $this->validateCredentials($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }
        //check otp
        $user = User::where(['Phone'=>$data['Phone'],'Otp'=>$data['Otp']])->update(['Status'=>'Active']);
        if(!$user){
            return response()->json([ 'message' => 'unable to verify', 'status' => 500]);
        }
        return response()->json([ 'message' => 'Verified', 'status' => 200]);
    }

    public function validateCredentials($data)
    {
        $userRules = [
            'Phone' => 'required|exists:users,Phone',            
            'Otp'=>'required|exists:users,Otp'
        ];
        $message = [           
            'Otp.exists'=>'Otp not matched',
        ];
        return Validator::make($data, $userRules, $message, []);
    }
}
