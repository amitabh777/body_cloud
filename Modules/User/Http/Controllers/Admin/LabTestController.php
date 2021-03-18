<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\LabTest;
use Modules\User\Http\Requests\Admin\LabTestCreateRequest;
use Modules\User\Http\Requests\Admin\LabTestUpdateRequest;

class LabTestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $labTests = LabTest::orderBy('CreatedAt')->get();
        return view('user::admin.master_data.lab_tests',compact('labTests'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::admin.master_data.create_lab_test');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LabTestCreateRequest $request)
    {        
        $data = $request->only(['LabTestName','LabTestDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = LabTest::create($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'error','message'=>'unable to create']);
        }
        return redirect()->route('admin.master_data.lab_tests.index')->with(['status'=>'success','message'=>'Lab test created']);
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
        $labTest = LabTest::where('LabTestID',$id)->first();
        return view('user::admin.master_data.edit_lab_test',compact('labTest'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(LabTestUpdateRequest $request, $id)
    {
        $data = $request->only(['LabTestName','LabTestDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = LabTest::where('LabTestID',$id)->update($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'failed','message'=>'Lab test not updated']);
        }
        return redirect()->route('admin.master_data.lab_tests.index')->with(['status'=>'success','message'=>'Lab Test updated']);
  
    }

    /**
     * Ajax Update lab test status only.
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
        $res = LabTest::where('LabTestID',$id)->update(['Status'=>$request->Status]);
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
    public function destroy(Request $request, $id)
    {
        $confirm = $request->input('confirm',false);  //check if confirmed to delete or not
        $res = $this->isLabTestUsed($id);
        if($res && $confirm=="false"){           
            return response()->json(['message'=>'Lab test already used by system','status'=>'already_used']);
        }
        $res = LabTest::where('LabTestID',$id)->delete();
        if(!$res){
            $response = response()->json(['message'=>'Delete failed','errors'=>[]],500);
        }
        $response = response()->json(['message'=>'Deleted'],200);

        return $response;
    }

     /**
     * Check if lab test is used with existing data
     * @param int $id [LabTestID]
     * @return boolean
     */
    public function isLabTestUsed($id)
    {
        return false; //for now assume not being used
        // $exist = LabTest::where('LabTestID', $id)->first();
        // if (!$exist) {
        //     return false; //not associated
        // }
        return true;
    }
}
