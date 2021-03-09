<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\Helpers\CustomHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    
    /**
     * Send New Otp for forgot password
     */
    public function forgotPasswordSendOtp(Request $request){
        $data = $request->all();
        //validate and check phone exists or not
        $validator = $this->validateCredentials($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }
        //send otp
        $otp = CustomHelper::sendOtp($data['Phone']);
        if(!$otp){
            return response()->json([ 'message' => 'Could not send otp', 'status' => 500]);
        }
        return response()->json(['data' => ['Otp'=>$otp,'Phone'=>$data['Phone']], 'message' => 'Otp Sent', 'status' => 200]);
    }

    /**
     * Validate incoming request
     */
    public function validateCredentials($data)
    {
        $userRules = [
            'Phone' => 'required|min:11|max:11|exists:users,Phone', 
        ];
        $message = [
            'Phone.exists'=>'Phone number not exists',
            'Phone.min'=>'Phone must be 11 digits',
            'Phone.max'=>'Phone must be 11 digits',
        ];
        return Validator::make($data, $userRules, $message, []);
    }

}
