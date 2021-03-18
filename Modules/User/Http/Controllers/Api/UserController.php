<?php

namespace Modules\User\Http\Controllers\Api;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\Doctor;

class UserController extends Controller
{
   // use AuthenticatesUsers;
    /**
     * 
     * return user data
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Get user info with profile
     *
     * @param Request $request
     * @return response json
     */
    public function myProfile(Request $request)
    {
        //get authenticated user
        $response = [];
        $user = $request->user(); //Auth::user();
        $response = $user->toArray();
        $role = $user->userRole->role; //User Role
        $profile = $user->profile($role->RoleSlug)->load('documents'); //User profile        
        //merge in user response       
        $response['UserType'] = $role->RoleSlug; 
        $response['Profile'] = $profile->toArray();  
        if($user->isDoctor()){      
          //get hospital name for hospital user profile
            $response['HospitalName'] =isset($profile->hospital->HospitalName)?$profile->hospital->HospitalName:'' ;
        }
        if($user->isPatient()){    
             
            //get blood group name for patient user profile
              $response['BloodGroupName'] =isset($profile->bloodGroup->BloodGroupName)?$profile->bloodGroup->BloodGroupName:'' ;
          }  

        return response()->json(['data'=>$response,'message' => 'Success', 'status' => 200]);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
