<?php

namespace Modules\User\Http\Controllers\Admin;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Role;
use Modules\User\Entities\UserRole;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();
        return view('user::admin.master_data.roles',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::orderBy('RoleName')->where(['ParentRoleID'=>null])->get();
        return view('user::admin.master_data.create_role',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->only(['RoleName', 'RoleSlug','ParentRoleID']);
        $data['ParentRoleID'] = $data['ParentRoleID']!='none'?$data['ParentRoleID']:null;
        $res = Role::create($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'unable to create']);
        }
        return redirect()->route('admin.master_data.roles.index')->with(['status' => 'success', 'message' => 'Role created']);
  
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
        $role = Role::where('RoleID',$id)->first();
        $roles = Role::orderBy('RoleName')->get();
        return view('user::admin.master_data.edit_role',compact('role','roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['RoleName', 'RoleSlug','ParentRoleID']);
        $data['ParentRoleID'] = $data['ParentRoleID']!='none'?$data['ParentRoleID']:null;
        $res = Role::where('RoleID',$id)->update($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'unable to update']);
        }
        return redirect()->route('admin.master_data.roles.index')->with(['status' => 'success', 'message' => 'Role Updated']);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Json
     */
    public function destroy(Request $request,$id)
    {
        $confirm = $request->input('confirm',false);  //check if confirmed to delete or not
        $res = $this->isRoleUsed($id);
        if($res && $confirm=="false"){           
            return response()->json(['message'=>'Role already used, Confirm?','status'=>'already_used']);
        }
        $res = Role::where('RoleID',$id)->delete();
        if(!$res){
            $response = response()->json(['message'=>'Delete failed','errors'=>[]],500);
        }
        $response = response()->json(['message'=>'Deleted'],200);
        return $response;
    }

    /**
     * Check if role is used with existing data
     * @param int $id [RoleID]
     * @return boolean
     */
    public function isRoleUsed($id)
    {
        $exist = UserRole::where('RoleID', $id)->first();
        if (!$exist) {
            return false; //not associated
        }
        return true;
    }
}
