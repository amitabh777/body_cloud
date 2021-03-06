<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use App\Helpers\CustomHelper;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\UserRole;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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
     * Login User
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
       // Auth::login(Auth::user());
        if(Auth::user()->Status != config('user.const.account_status.active')){
            Auth::logout();
            return response()->json(['message' => 'Phone number not verified.', 'status' => 400]);
        }
        $user = User::find(Auth::user()->UserID); //get user
        $role = $user->userRole()->role; //User Role
        $profile = $user->profile($role->RoleSlug); //User profile
        //merge in user response
        $user['UserType'] = $role->RoleSlug; 
        $user['Profile'] = $profile;   
        return response()->json(['data' => $user, 'message' => 'Success Login', 'status' => 200]);
    }

    public function validateCredentials($data)
    {
        $userRules = [
            'Phone' => 'required|min:10|max:10',
            'Password' => ['required', 'string', 'min:8'],
            'DeviceToken' => 'required',
            'DeviceType' => 'required'
        ];
        $message = [];
        return Validator::make($data, $userRules, $message, []);
    }
   // deleteDeviceToken


    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        
       // Auth::loginUsingId(1);
        $user =  Auth:: user();//Auth::loginUsingId(4);//Auth::user();
        var_dump(Auth::check());
        print_r($user);
        exit;
        User::where('UserID',$user->UserID)->deleteDeviceToken();
        Auth::logout();
        return response()->json(['status'=>200,'message'=>'logout']);
    }



}
