<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Helpers\CustomHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\BloodGroup;
use Modules\User\Entities\DocumentType;
use Modules\User\Entities\Hospital;
use Modules\User\Entities\Patient;
use Modules\User\Http\Requests\PatientUpdateRequest;
use Modules\User\Repositories\ProfileRepository;

class PatientController extends Controller
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profile)
    {
        $this->profileRepository = $profile;
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $patients = Patient::paginate(10);
        $patients = Patient::with(['user'])->get();
        return view('user::admin.manage_profiles.patients', compact('patients'));
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
    public function show($userID)
    {
        $patient = Patient::where('UserID', $userID)->first();
        return view('user::admin.manage_profiles.show_patient',compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($userID)
    {
        $patient = Patient::where('UserID', $userID)->first();
        $bloodGroups = BloodGroup::active()->get();
        $documentTypes = DocumentType::active()->get();
        return view('user::admin.manage_profiles.edit_patient', compact('patient', 'bloodGroups','documentTypes'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PatientUpdateRequest $request, $userID)
    {
        $fields = ['PatientName', 'PatientGender', 'PatientDOB', 'BloodGroupID', 'PatientHeight', 'PatientWeight', 'PatientChronicDisease', 'PatientPermanentMedicines', 'EmergencyContactNo'];
        $data = $request->only($fields);
        $data['PatientDOB'] = date('Y-m-d',strtotime( $data['PatientDOB']));
        $data['BloodGroupID'] = ($data['BloodGroupID']!='none')?$data['BloodGroupID']:null;
        $profileImage =  $request->file('PatientProfileImage', null);
        if ($profileImage != null) {
            $path = CustomHelper::uploadProfileImage($profileImage);
            if ($path != false) {
                //store file path
                $data['PatientProfileImage'] = $path;
            }
        }

        $res = $this->profileRepository->patientProfileUpdate($data, $userID);
        if ($res !== true) {
            return redirect()->back()->with(['status' => 'failed', 'message' => $res]);
        }
        return redirect()->back()->with(['status' => 'success', 'message' => 'Patient profile updated']);
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
