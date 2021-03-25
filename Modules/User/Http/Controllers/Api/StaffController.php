<?php

namespace Modules\User\Http\Controllers\Api;

use App\Helpers\CustomHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\Staff;
use Modules\User\Repositories\UserRepository;

class StaffController extends Controller
{

    protected $userRepo;
    public function __construct(UserRepository $user)
    {
        $this->userRepo = $user;
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
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
        $res = $this->staffCreateValidation($request);
        if($res!==true){
            return $res; //if validation not true then return response json 
        }
        //get parent user id
        $parentID = Auth::user()->UserID;
        $userData = array(
            'Email'=>$request->email,
            'Phone'=>$request->phone,
            'Password'=>$request->password,
            'ParentID'=>$parentID,            
        );
        //create staff profile
        $profileData = array(
            'FirstName'=>$request->first_name,
            'LastName'=>$request->input('last_name',''),
            'Gender'=>$request->input('gender',''),
            'UserID'=>'',           
        );
        $data = array(
            'user'=>$userData,
            'profile'=>$profileData
        );
        $staffRole = $request->staff_role;
        $res = $this->userRepo->addStaffUser($data,$staffRole);
        if($res!==true){
            return response()->json(['message' => 'something went wrong', 'error'=>$res, 'status' => 400]);
        }
        //staff successfully created do other stuff
        
        //upload profile image
        $file = $request->file('profile_image','');
        if($file!=''){
            $uploadPath = CustomHelper::uploadProfileImage($file);
            if($uploadPath){
                Staff::where(['ProfileImage'=>$uploadPath])->update();
            }
        }
        // todo: notify with email/phone
        

        return response()->json(['message' => 'Success', 'status' => 200]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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

    public function staffCreateValidation($request){
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'string',
            'email'=>'required|email|unique:users,Email',
            'phone'=>'required|digits:10|unique:users,Phone',
            'gender'=>'in:Male,Female',
            'password'=>'required|min:8|max:16',
            'profile_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'staff_role' => 'required|string|in:'.implode(',', array_keys(config('user.const.roles_staff'))),            
        ];
        $validator = Validator::make($request->all(), $rules);        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }
        return true;
    }

}
