<?php

namespace Modules\User\Http\Controllers\Api;

use App\Helpers\CustomHelper;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\User\Repositories\ProfileRepository;

class ProfileController extends Controller
{
    protected $profileRepository;
    public function __construct(ProfileRepository $profileRepo)
    {
        $this->profileRepository = $profileRepo;
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
     * @return Response
     */
    public function update(Request $request, $userid)
    {
        $data = $request->all();
        // Validate user data
        $validateUser = $this->validateUserData($data, $userid);
        if ($validateUser->fails()) {
            return response()->json(['message' => $validateUser->errors()->first(), 'status' => 400]);
        }
        $userData = $this->userData($data);
        //update user
        $user = User::where('UserID', $userid)->update($userData);
        if (!$user) {
            return response()->json(['message' => 'User update failed', 'status' => 400]);
        }
        $success = 0;
        $roleSlug = $data['RoleSlug'];
        //check user type
        if ($roleSlug == config('user.const.role_slugs.patient')) {
            $validate = $this->validatePatientProfile($data);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
            }
            $profileData = $this->patientProfileData($request); //get fields

            $res = $this->profileRepository->patientProfileUpdate($profileData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } elseif ($roleSlug == config('user.const.role_slugs.doctor')) {
            $validate = $this->validateDoctorProfile($data);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
            }
            $profileData = $this->doctorProfileData($request);

            $res = $this->profileRepository->doctorProfileUpdate($profileData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } elseif ($roleSlug == config('user.const.role_slugs.hospital')) {
            $validate = $this->validateHospitalProfile($data);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
            }
            $profileData = $this->hospitalProfileData($request);

            $res = $this->profileRepository->hospitalProfileUpdate($profileData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } elseif ($roleSlug == config('user.const.role_slugs.ambulance')) {
            //fjdslkj
        } elseif ($roleSlug == config('user.const.role_slugs.lab')) {
            //dslkjfkds
        } elseif ($roleSlug == config('user.const.role_slugs.insurance_companies')) {
            //fsdjlfkjd
        }

        if ($success) {
            return response()->json(['status' => 200, 'message' => 'Updated']);
        }
    }

    /**
     * validate user data
     */
    public function validateUserData($data, $id)
    {
        $userRules = [
            'Email' => 'required|email|max:150|unique:users,Email,' . $id . ',UserID',
            'Phone' => 'required|min:10|max:10|unique:users,Phone,' . $id . ',UserID',
            'RoleSlug' => ['required', 'in:' . implode(',', array_keys(config('user.const.role_slugs')))],
        ];
        $message = [
            'RoleSlug.required' => 'Role is required'
        ];
        return Validator::make($data, $userRules, $message, []);
    }

    public function validatePatientProfile($data)
    {
        $userRules = [
            'PatientName' => 'required',
            'Gender' => 'required',
            'DOB' => 'required',
            'PatientHeight' => 'required',
            'PatientWeight' => 'required',
            'EmergencyContactNo' => 'required|max:10|min:10',
        ];
        return Validator::make($data, $userRules);
    }

    public function validateDoctorProfile($request)
    {
        $userRules = [
            'DoctorName' => 'required',
            // 'DoctorGender' => 'required',
            // 'VisitingHours' => 'required'
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function validateHospitalProfile($request)
    {
        $userRules = [
            'HospitalName' => 'required',
            'HospitalContactName' => 'required',
            'VisitingHours' => 'required'
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function validateAmbulanceProfile($request)
    {
        $userRules = [
            'ContactName' => 'required',
            'AmbulanceNumber' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
    }
    public function validateLabProfile($request)
    {
        $userRules = [
            'CompanyName' => 'required',
            'VisitingHours' => 'required',
        ];
        return Validator::make($request->all(), $userRules, [], []);
    }
    public function validateInsuranceCompanyProfile($request)
    {
        $userRules = [
            'CompanyName' => 'required',
            'VisitingHours' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
    }

    //Prepare data
    public function userData($data)
    {
        return array(
            'Email' => $data['Email'],
            'Phone' => $data['Phone'],
            'Address' => $data['Address'] ? $data['Address'] : '',
        );
    }
    //Patient fields
    public function patientProfileData($request)
    {
        return [
            'PatientName' => $request->input('PatientName'),
            'PatientGender' => $request->input('Gender'),
            'PatientDOB' => $request->input('DOB'),
            'BloodGroupID' => $request->input('BloodGroupID', null),
            'PatientHeight' => (float)$request->input('PatientHeight'),
            'PatientWeight' => (float)$request->input('PatientWeight'),
            /// 'PatientChronicDisease' => $data['PatientChronicDisease', null),
            'PatientPermanentMedicines' => $request->input('PatientPermanentMedicines', ''),
            'EmergencyContactNo' => $request->input('EmergencyContactNo'),
        ];
    }
    //Doctor fields
    public function prepareDoctorProfileData($request)
    {
        return [
            'DoctorName' => $request->input('DoctorName'),
            'DoctorInfo' => $request->input('DoctorInfo', ''),
            'DoctorGender' => $request->input('DoctorGender'),
            'HospitalID' => $request->input('HospitalID', null),
            // 'DoctorWebsite' => $request->input('DoctorWebsite', null),
            // 'DoctorBankAccountNo' => $request->input('DoctorBankAccountNo', null),
            // 'DoctorBankName' => $request->input('DoctorBankName', null),
            // 'DoctorMinReservationCharge' => $request->input('DoctorMinReservationCharge', null),
            'SectorID' => $request->input('SectorID', []),
            'VisitingHours' => $request->input('VisitingHours', null),
        ];
    }
    //Hospital fields
    public function getHospitalProfileData($request)
    {
        return [
            'HospitalName' => $request->input('HospitalName'),
            'HospitalInfo' => $request->input('HospitalInfo', ''),
            'HospitalWebsite' => $request->input('HospitalWebsite'),
            'HospitalContactName' => $request->input('HospitalContactName'),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }
    // //Ambulance profile
    // public function getAmbulanceProfileData($data)
    // {
    //     return [
    //         'AmbulanceContactName' => $data'ContactName'),
    //         'AmbulanceNumber' => $data'AmbulanceNumber'),
    //     ];
    // }
    // //Lab profile
    // public function getLabProfileData($request)
    // {
    //     return [
    //         'LaboratoryCompanyName' => $data['CompanyName'],
    //         'LaboratoryInfo' => $data'LaboratoryInfo',''),
    //         'LaboratoryWebsite' => $data'Website',''),
    //         'VisitingHours' => $request->input('VisitingHours'),
    //     ];
    // }
    //Lab profile
    public function getInsuranceCompanyProfileData($request)
    {
        return [
            'InsuranceCompanyName' => $request->input('CompanyName'),
            'InsuranceCompanyInfo' => $request->input('CompanyInfo', ''),
            'InsuranceCompanyWebsite' => $request->input('Website'),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }

    /**
     * Upload profile image, api method
     */
    public function uploadProfileImage(Request $request)
    {
        $rule = ['Role' => 'required', 'ProfileImage' => 'required', 'UserID' => 'required'];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
        }

        $role = $request->Role;
        if ($request->hasFile('ProfileImage')) {
            $file = $request->file('ProfileImage');
            $path = CustomHelper::uploadProfileImage($file);
            if (!$path) {
                return response()->json(['message' => 'could not upload', 'status' => 400]);
            }
            $model = CustomHelper::getModelUserRole($role);
            $profileImageKey = CustomHelper::getProfileImageKey($role);
            $model::where('UserID', $request->UserID)->update([$profileImageKey => $path]);
            return response()->json(['message' => 'success', 'status' => 200]);
        } else {
            return response()->json(['message' => 'ProfileImage not found', 'status' => 400]);
        }
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
