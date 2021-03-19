<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\LabServiceCategory;
use Modules\User\Entities\LabTest;

class LabServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
         $labServiceCategories = LabServiceCategory::orderBy('LabServiceCategoryName')->get();
         return view('user::admin.master_data.lab_service_categories',compact('labServiceCategories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //todo
        return view('user::admin.master_data.create_lab_service_category');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {        
        $data = $request->only(['LabServiceCategoryName','LabServiceCategoryDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = LabServiceCategory::create($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'error','message'=>'unable to create']);
        }
        return redirect()->route('admin.master_data.lab_service_categories.index')->with(['status'=>'success','message'=>'LabService Category created']);
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
        $labServiceCategory = LabServiceCategory::where('LabServiceCategoryID',$id)->first();
        return view('user::admin.master_data.edit_lab_service_category',compact('labServiceCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['LabServiceCategoryName', 'LabServiceCategoryDesc', 'Status']);
        $data['Status'] = $request->input('Status', 'Inactive');
        $res = LabServiceCategory::where('LabServiceCategoryID', $id)->update($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'failed', 'message' => 'Lab service category not updated']);
        }
        return redirect()->route('admin.master_data.lab_service_categories.index')->with(['status' => 'success', 'message' => ' lab service category updated']);
 
    }

    /**
     * Ajax Update insurance category status only.
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
        $res = LabServiceCategory::where('LabServiceCategoryID',$id)->update(['Status'=>$request->Status]);
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
        $res = $this->isLabServiceCategoryUsed($id);
        if($res && $confirm=="false"){           
            return response()->json(['message'=>'Lab service category already used','status'=>'already_used']);
        }
        $res = LabServiceCategory::where('LabserviceCategoryID', $id)->delete();
        if (!$res) {
            $response = response()->json(['message' => 'Delete failed', 'errors' => []], 500);
        }
        $response = response()->json(['status'=>'sucsess','message' => 'Deleted'], 200);
        return $response;
    }

    /**
     * Check if category is used with existing data
     * @param int $id [LabServiceCategoryID]
     * @return boolean
     */
    public function isLabServiceCategoryUsed($id)
    {
        return false;
        // $exist = LabServiceCategory::where('LabserviceCategoryID', $id)->first();
        // if (!$exist) {
        //     return false; //not associated
        // }
        // return true;
    }
}
