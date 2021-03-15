<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Helpers\CustomHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Doctor;
use Modules\User\Entities\DocumentType;
use Modules\User\Entities\Hospital;
use Modules\User\Http\Requests\DoctorUpdateRequest;
use Modules\User\Repositories\ProfileRepository;

class DoctorController extends Controller
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
        $doctors = Doctor::all()->load('user')->load('hospital');
        return view('user::admin.manage_profiles.doctors',compact('doctors'));
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
        $doctor = Doctor::where('UserID', $userID)->first();     
        return view('user::admin.manage_profiles.show_doctor',compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $userID
     * @return Renderable
     */
    public function edit($userID)
    {
        $doctor = Doctor::where('UserID', $userID)->first();
        $documentTypes = DocumentType::active()->get();
        $hospitals = Hospital::active()->get();
        return view('user::admin.manage_profiles.edit_doctor', compact('doctor','documentTypes','hospitals'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(DoctorUpdateRequest $request, $userID)
    {
        $fields = ['DoctorName', 'DoctorGender', 'DoctorDOB', 'HospitalID', 'DoctorWebsite', 'DoctorBankAccountNo', 'DoctorBankName', 'DoctorMinReservationCharge'];
        $data = $request->only($fields);
        $data['DoctorDOB'] = date('Y-m-d',strtotime( $data['DoctorDOB']));
        $data['HospitalID'] = ($data['HospitalID']!='none')?$data['HospitalID']:null;
        $profileImage =  $request->file('DoctorProfileImage', null); //upload profile image
        if ($profileImage != null) {
            $path = CustomHelper::uploadProfileImage($profileImage);
            if ($path != false) {
                //store file path
                $data['DoctorProfileImage'] = $path;
            }
        }
        $res = $this->profileRepository->doctorProfileOnlyUpdate($data, $userID);
        if ($res !== true) {
            return redirect()->back()->with(['status' => 'failed', 'message' => $res]);
        }
        return redirect()->back()->with(['status' => 'success', 'message' => 'Doctor profile updated']);
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
