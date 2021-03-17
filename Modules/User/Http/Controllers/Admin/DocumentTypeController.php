<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\Document;
use Modules\User\Entities\DocumentType;
use Modules\User\Http\Requests\Admin\DocumentTypeCreateRequest;
use Modules\User\Http\Requests\Admin\DocumentTypeUpdateRequest;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $documentTypes = DocumentType::orderBy('DocumentTypeName')->get();
        return view('user::admin.master_data.document_types', compact('documentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::admin.master_data.create_document_type');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(DocumentTypeCreateRequest $request)
    {
        $data = $request->only(['DocumentTypeName', 'DocumentTypeDesc', 'Status']);
        $data['Status'] = $request->input('Status', 'Inactive');
        $res = DocumentType::create($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'unable to create']);
        }
        return redirect()->route('admin.master_data.document_types.index')->with(['status' => 'success', 'message' => 'Document Type created']);
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
        $documentType = DocumentType::where('DocumentTypeID', $id)->first();
        return view('user::admin.master_data.edit_document_type', compact(['documentType']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(DocumentTypeUpdateRequest $request, $id)
    {
        $data = $request->only(['DocumentTypeName', 'DocumentTypeDesc', 'Status']);
        $data['Status'] = $request->input('Status', 'Inactive');
        $res = DocumentType::where('DocumentTypeID', $id)->update($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'failed', 'message' => 'Document type not updated']);
        }
        return redirect()->route('admin.master_data.document_types.index')->with(['status' => 'success', 'message' => 'Document type updated']);
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
        $validator = Validator::make($request->all(), ['Status' => 'required|in:Active,Inactive']);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'errors' => $validator->errors()], 400);
        }
        $res = DocumentType::where('DocumentTypeID', $id)->update(['Status' => $request->Status]);
        if (!$res) {
            $response = response()->json(['message' => 'Update status failed', 'errors' => []], 500);
        }
        $response = response()->json(['message' => 'status updated'], 200);
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
        $res = $this->isDocumentTypeUsed($id);
        if($res && $confirm=="false"){           
            return response()->json(['message'=>'DocumentType already used in documents table','status'=>'already_used']);
        }
        $res = DocumentType::where('DocumentTypeID', $id)->delete();
        if (!$res) {
            $response = response()->json(['message' => 'Delete failed', 'errors' => []], 500);
        }
        $response = response()->json(['status'=>'sucsess','message' => 'Deleted'], 200);
        return $response;
    }

    /**
     * Check if document type is used with existing data
     * @param int $id [DocumentTypeID]
     * @return boolean
     */
    public function isDocumentTypeUsed($id)
    {
        $exist = Document::where('DocumentTypeID', $id)->first();
        if (!$exist) {
            return false; //not associated
        }
        return true;
    }
}
