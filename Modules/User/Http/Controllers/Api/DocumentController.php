<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\Document;
use Modules\User\Repositories\DocumentRepository;

class DocumentController extends Controller
{
    protected $documentRepository;
    public function __construct(DocumentRepository $docRepo)
    {
        $this->documentRepository = $docRepo;
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
     * Store Files
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $rules = [
            'Files' => 'required|max:15000',
            'RoleSlug' => 'required|in:' . implode(',', array_keys(config('user.const.role_slugs'))),
            'ProfileID' => 'required',
            'DocType' => 'required|in:' . implode(',', array_keys(config('user.const.document_types'))),
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400]);
        }

        $res = $this->documentRepository->uploadDocuments($request->file('Files'), $request->RoleSlug, $request->ProfileID, $request->DocType);
        if (!$res) {
            return response()->json(['message' => 'Unable to upload', 'status' => 400]);
        }
        return response()->json(['message' => 'Success', 'status' => 200]);;
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
     * Delete document by DocumentID.
     * @param int $id [Document id]
     * @return Renderable
     */
    public function destroy($id)
    {
        $doc = Document::find($id);
        if (!$doc) {
            return response()->json(['status' => 'failed', 'message' => 'Not found'], 400);
        }
        $res = Document::where('DocumentID', $id)->delete();
        if (!$res) {
            $response = response()->json(['status' => 'failed', 'message' => 'not deleted'], 400);
        } else {
            $response = response()->json(['status' => 'success', 'message' => 'Deleted'], 200);
        }
        return $response;
    }
}
