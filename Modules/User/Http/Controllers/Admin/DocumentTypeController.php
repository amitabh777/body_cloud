<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\DocumentType;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $documentTypes = DocumentType::orderBy('DocumentTypeName')->get();
        return view('user::admin.master_data.document_types',compact('documentTypes'));
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
     * Ajax Update document type status only.
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
        $res = DocumentType::where('DocumentTypeID',$id)->update(['Status'=>$request->Status]);
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
        //
    }
}
