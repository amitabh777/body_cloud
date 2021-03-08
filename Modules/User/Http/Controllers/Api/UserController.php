<?php

namespace Modules\User\Http\Controllers\Api;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthenticatesUsers;
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

    public function showMyProfile()
    {
        $user = User::find(Auth::user()->UserID); //get user
        $role = $user->userRole()->role; //User Role
        $profile = $user->profile($role->RoleSlug); //User profile
        
        //merge in user response
        $user['UserType'] = $role->RoleSlug; 
        $user['Profile'] = $profile;   
        return response()->json(['data'=>$user,'message' => 'Success', 'status' => 200]);
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
}
