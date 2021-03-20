<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\Helpers\CustomHelper;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    //change username as Phone
    public function username()
    {
        return 'Phone';
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return json response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateCredentials($data);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }      
        $auth = Auth::attempt(['Phone' => $data['Phone'], 'password' => $data['Password']]);
        if (!$auth) {
            return response()->json(['message' => 'Invalid Credentials', 'status' => 400]);
        }
        if (Auth::user()->Status != config('user.const.account_status.active')) {
            Auth::logout();
            return response()->json(['data' => ['is_active' => 'Inactive'], 'message' => 'Phone number not verified.', 'status' => 400]);
        }
        $responseData = [];
        $loginSuccess = 0;
        $responseJson = '';
        try {
            $user =$request->user(); //User::find(Auth::user()->UserID); //get user   
            $responseData = $user->toArray(); //->select(['UserID','UniqueID','Email','Phone','Status','api_token'])->first();       
            if ($user->userRole == null) {
                throw new Exception("User role does not exist", 1);
            }
            $role = $user->userRole->role; //$user->userRole->role; //User Role         
            $profile = $user->customeProfileForLogin($role->RoleSlug);  //User profile          
            $user->api_token = $user->generateToken(); //generate new token
            $user->save();
            $responseData['api_token'] = $user->api_token; //return newly generated api_token
            $responseData['UserType'] = $user->role->RoleSlug;
            $responseData['Profile'] = $profile;//->select(['PatientName','EmergencyContactNo','PatientProfileImage'])->first();
            $loginSuccess = 1;
        } catch (Exception $e) {
            $responseJson = response()->json(['data' => [], 'message' => 'Login failed', 'status' => 400, 'error_log' => $e->getMessage()]);
            Log::error('Api Login Error: ' . $e->getMessage());
        }
        if ($loginSuccess) {
            $responseJson =  response()->json(['data' => $responseData, 'message' => 'Success Login', 'status' => 200]);
        }
        return $responseJson;
    }
    /**
     * validate Login Credentials
     *
     * @param array $data
     * @return validator
     */
    public function validateCredentials($data)
    {
        $userRules = [
            'Phone' => 'required|min:11|max:11',
            'Password' => ['required', 'string', 'min:8'],
            'DeviceToken' => 'required',
            'DeviceType' => 'required|in:android,ios',
        ];
        $message = [
            'Phone.min' => 'Phone must be 11 digits',
            'Phone.max' => 'Phone must be 11 digits',
        ];
        return Validator::make($data, $userRules, $message, []);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user =  Auth::user(); //Auth::loginUsingId(4);//Auth::user();
        User::where('UserID', $user->UserID)->update(['api_token' => '']);
        Auth::logout();
        return response()->json(['status' => 200, 'message' => 'logout']);
    }
}
