<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\InsuranceCategory;
use Modules\User\Http\Requests\Admin\InsuranceCategoryCreateRequest;

class InsuranceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $insuranceCategories = InsuranceCategory::orderBy('InsuranceCategoryName')->get();
        return view('user::admin.master_data.insurance_categories',compact('insuranceCategories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::admin.master_data.create_insurance_category');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(InsuranceCategoryCreateRequest $request)
    {
        $data = $request->only(['InsuranceCategoryName','InsuranceCategoryDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = InsuranceCategory::create($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'error','message'=>'unable to create']);
        }
        return redirect()->route('admin.master_data.insurance_categories.index')->with(['status'=>'success','message'=>'Insurance Category created']);
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
        $insuranceCategory = InsuranceCategory::where('InsuranceCategoryID',$id)->first();
        return view('user::admin.master_data.edit_insurance_category',compact('insuranceCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['InsuranceCategoryName','InsuranceCategoryDesc','Status']);
        $data['Status'] = $request->input('Status','Inactive');
        $res = InsuranceCategory::where('InsuranceCategoryID',$id)->update($data);
        if(!$res){
            return redirect()->back()->with(['status'=>'failed','message'=>'Insurance category not updated']);
        }
        return redirect()->route('admin.master_data.insurance_categories.index')->with(['status'=>'success','message'=>'Insurance category updated']);
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
        $res = InsuranceCategory::where('InsuranceCategoryID',$id)->update(['Status'=>$request->Status]);
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
        $res = $this->isInsuranceCategoryUsed($id);
        if($res && $confirm=="false"){           
            return response()->json(['message'=>'Insurance category already used.','status'=>'already_used']);
        }
        $res = InsuranceCategory::where('InsuranceCategoryID',$id)->delete();
        if(!$res){
            $response = response()->json(['message'=>'Delete failed','errors'=>[]],500);
        }
        $response = response()->json(['message'=>'Deleted'],200);
        return $response;
    }

     /**
     * Check if insurance category is used with existing data
     * @param int $id [InsuranceCategoryID]
     * @return boolean
     */
    public function isInsuranceCategoryUsed($id)
    {
        //TODO: check insurance category used in other table
        return false;
        // $exist = ::where('BloodGroupID', $id)->first();
        // if (!$exist) {
        //     return false; //not associated
        // }
        return true;
    }
}
