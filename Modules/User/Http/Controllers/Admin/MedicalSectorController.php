<?php

namespace Modules\User\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\DoctorSector;
use Modules\User\Entities\DoctorSpecialization;
use Modules\User\Entities\HospitalSector;
use Modules\User\Entities\MedicalSector;

class MedicalSectorController extends Controller
{
    /**
     * List all medical sectors
     * @return Renderable
     */
    public function index()
    {
        $medicalSectors = MedicalSector::orderBy('MedicalSectorName')->get();
        return view('user::admin.master_data.medical_sectors', compact('medicalSectors'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::admin.master_data.create_medical_sector');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->only(['MedicalSectorName', 'MedicalSectorDesc', 'Status']);
        $data['Status'] = $request->input('Status', 'Inactive');
        $res = MedicalSector::create($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'failed', 'message' => 'couldnot create']);
        }
        return redirect()->route('admin.master_data.medical_sectors.index')->with(['status' => 'success', 'message' => 'Medical Sector created']);
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
        $medicalSector = MedicalSector::where('MedicalSectorID', $id)->first();
        return view('user::admin.master_data.edit_medical_sector', compact(['medicalSector']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['MedicalSectorName', 'MedicalSectorDesc', 'Status']);
        $data['Status'] = $request->input('Status', 'Inactive');
        $res = MedicalSector::where('MedicalSectorID', $id)->update($data);
        if (!$res) {
            return redirect()->back()->with(['status' => 'failed', 'message' => 'Medical Sector not updated']);
        }
        return redirect()->route('admin.master_data.medical_sectors.index')->with(['status' => 'success', 'message' => 'Medical Sector updated']);
    }

    /**
     * Ajax Update medical sector status only.
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
        $res = MedicalSector::where('MedicalSectorID', $id)->update(['Status' => $request->Status]);
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
        $confirm = $request->input('confirm', false);  //check if confirmed to delete or not 
        $res = $this->isMedicalSectorUsed($id); //check medical sector used in other table
        if ($res && $confirm == "false") {
            return response()->json(['message' => 'Medical sector already used in medical sector table', 'status' => 'already_used']);
        }
        try {
            $res = MedicalSector::where('MedicalSectorID', $id)->delete();
            if (!$res) {
                $response = response()->json(['message' => 'Delete failed', 'errors' => []], 500);
            }
        } catch (Exception $e) {
            Log::error('error in deleting medical sectors'.$e->getMessage());
            return response()->json(['status'=>'failed','message' => 'Unable to delete due to data used.', 'errors' => ['message'=>$e->getMessage()]], 500);
        }
        $response = response()->json(['status' => 'sucsess', 'message' => 'Deleted'], 200);
        return $response;
    }

    /**
     * Check if medical sector is used with existing data
     * @param int $id [MedicalSectorID]
     * @return boolean
     */
    public function isMedicalSectorUsed($MedicalSectorID)
    {
        //Check doctor specialization table
        $exist = DoctorSpecialization::where('SpecializeIn', $MedicalSectorID)->first();
        if ($exist) {
            return true;
        }
        $exist = DoctorSector::where('SectorID', $MedicalSectorID)->first();
        if ($exist) {
            return true; //not associated
        }
        $exist = HospitalSector::where('MedicalSectorID', $MedicalSectorID)->first();
        if ($exist) {
            return false; //not associated
        }
        return false;
    }
}
