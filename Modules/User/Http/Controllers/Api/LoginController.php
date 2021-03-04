<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        //   $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'Phone';
    }

    // public function getCredentials(Request $request)
    // {
    //     return $request->only('Phone', 'Password');
    // }

    /**
     * Login Controller
     */
    public function login(Request $request)
    {
        $data = $request->all();

        $validator = $this->validateCredentials($data);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $auth = Auth::attempt(['Phone' => $data['Phone'], 'password' => $data['Password']]);
        if (!$auth) {
            return response()->json(['data' => [], 'message' => 'Invalid Credentials', 'status' => 400]);
        }
        $user = Auth::user()->load('patientProfile');       
        return response()->json(['data' => $user, 'message' => 'Success Login', 'status' => 200]);      
    }

    public function validateCredentials($data)
    {
        $userRules = [
            'Phone' => 'required|min:13|max:13',
            'Password' => ['required', 'string', 'min:8'],
            'DeviceToken' => 'required',
            'DeviceType' => 'required'
        ];
        $message = [];
        return Validator::make($data, $userRules, $message, []);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            // 'token_type'   => 'bearer',
            // 'expires_in'   =>  //auth()->factory()->getTTL() * 60
        ]);
    }
}
