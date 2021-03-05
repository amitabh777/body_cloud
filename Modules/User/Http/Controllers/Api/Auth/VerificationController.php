<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
            return response()->json(['message' => $validator->errors()->first(), 'data' => [], 'status' => 400], 400);
        }
        //send otp
        $otp = CustomHelper::sendOtp($data['Phone']);
        if(!$otp){
            return response()->json(['data' => [], 'message' => 'Could not send otp', 'status' => 500],500);
        }
        return response()->json(['data' => ['Otp'=>$otp,'Phone'=>$data['Phone']], 'message' => 'Otp Sent', 'status' => 200]);
    }
}
