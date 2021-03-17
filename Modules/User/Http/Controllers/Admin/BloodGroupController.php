<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\BloodGroup;
use Modules\User\Http\Requests\Admin\BloodGroupCreateRequest;
use Modules\User\Http\Requests\Admin\BloodGroupUpdateRequest;

class BloodGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bloodgroups = BloodGroup::select(['BloodGroupID','BloodGroupName','BloodGroupDesc','Status'])->get();
        return view('user::admin.master_data.bloodgroups',compact('bloodgroups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::admin.master_data.create_bloodgroup');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BloodGroupCreateRequest $request)
    {
        $data = $request->only(['BloodGroupName','BloodGroupDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = BloodGroup::create($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'error','message'=>'unable to create']);
        }
        return redirect()->route('admin.master_data.bloodgroups.index')->with(['status'=>'success','message'=>'Bloodgroup created']);
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
        $bloodgroup = BloodGroup::where('BloodGroupID',$id)->first();
        return view('user::admin.master_data.edit_bloodgroup',compact('bloodgroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BloodGroupUpdateRequest $request, $id)
    {
        $data = $request->only(['BloodGroupName','BloodGroupDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = BloodGroup::where('BloodGroupID',$id)->update($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'failed','message'=>'bloodgroup not updated']);
        }
        return redirect()->back()->with(['status'=>'success','message'=>'bloodgroup updated']);
    } 
    
    /**
     * Ajax Update bloodgroup status only.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateStatus(Request $request, $id)
    {
        $response = [];
        $validator = Validator::make($request->all(),['Status'=>'required|in:Active,Inactive']);
        if($validator->fails()){
            return response()->json(['message'=>$validator->errors()->first(),'errors'=>$validator->errors()],400);
        }
        $res = BloodGroup::where('BloodGroupID',$id)->update(['Status'=>$request->Status]);
        if(!$res){
            $response = response()->json(['message'=>'Update status failed','errors'=>[]],500);
        }
        $response = response()->json(['message'=>'status updated'],200);
        return $response;
    }    

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $res = BloodGroup::where('BloodGroupID',$id)->delete();
        if(!$res){
            $response = response()->json(['message'=>'Delete failed','errors'=>[]],500);
        }
        $response = response()->json(['message'=>'Deleted'],200);

        return $response;
    }
}
