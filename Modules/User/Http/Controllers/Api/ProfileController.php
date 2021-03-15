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
     * @return response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Update profile data according to role slug
     * @param Request $request
     * @param int $userid
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'user not loggedin/authenticated', 'status' => 400]);
        }
        $userid = $user->UserID; //get user id 
        // Validate user data
        $validateUser = $this->validateUserData($data, $userid);
        if ($validateUser->fails()) {
            return response()->json(['message' => $validateUser->errors()->first(), 'status' => 400]);
        }
        $userData = $this->userData($data); //get fillable fields
        //update user
        $user = User::where('UserID', $userid)->update($userData);
        if (!$user) {
            return response()->json(['message' => 'User update failed', 'status' => 400]);
        }
        $success = 0;
        $roleSlug = $data['RoleSlug'];
        //Check user type
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
            $allData['ProfileData'] = $profileData;
            $allData['SpecializeIn'] = $request->input('SpecializeIn', null);
            $allData['VisitingHours'] = $request->input('VisitingHours', null);
            $allData['Experiences'] = $request->input('Experiences', null);
            $allData['Awards'] = $request->input('Awards', null);
            $res = $this->profileRepository->doctorProfileUpdate($allData, $userid);
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
            $allData['ProfileData'] = $profileData;
            $allData['SpecializeIn'] = $request->input('SpecializeIn', null);
            $allData['VisitingHours'] = $request->input('VisitingHours', null);

            $res = $this->profileRepository->hospitalProfileUpdate($allData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } elseif ($roleSlug == config('user.const.role_slugs.ambulance')) {
            //Ambulance update
            $validate = $this->validateAmbulanceProfile($data);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
            }
            $profileData = $this->ambulanceProfileData($request);
            $allData['ProfileData'] = $profileData;

            $res = $this->profileRepository->ambulanceProfileUpdate($allData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } elseif ($roleSlug == config('user.const.role_slugs.lab')) {
            //laboratory update
            $validate = $this->validateLabProfile($data);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
            }
            $profileData = $this->labProfileData($request);
            $allData['ProfileData'] = $profileData;
            $allData['VisitingHours'] = $request->input('VisitingHours', null);

            $res = $this->profileRepository->laboratoryProfileUpdate($allData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } elseif ($roleSlug == config('user.const.role_slugs.insurance_company')) {
            //insurance update
            $validate = $this->validateInsuranceCompanyProfile($data);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
            }
            $profileData = $this->insuranceCompanyProfileData($request);        
            $allData['ProfileData'] = $profileData;
            $allData['VisitingHours'] = $request->input('VisitingHours', null);

            $res = $this->profileRepository->insuranceCompanyProfileUpdate($allData, $userid);
            if ($res !== true) {
                return response()->json(['message' => 'Could not update', 'data' => ['errror_message' => $res], 'status' => 400]);
            }
            $success = 1;
        } else {
            return response()->json(['message' => 'Invalid role', 'status' => 400]);
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
            'Phone' => 'required|min:11|max:11|unique:users,Phone,' . $id . ',UserID',
            'RoleSlug' => ['required', 'in:' . implode(',', array_keys(config('user.const.role_slugs')))],
        ];
        $message = [
            'RoleSlug.required' => 'Role is required',
            'Phone.min'=>'Phone must be 11 digits',
            'Phone.max'=>'Phone must be 11 digits',
        ];
        return Validator::make($data, $userRules, $message, []);
    }

    public function validatePatientProfile($data)
    {
        $userRules = [
            'PatientName' => 'required|regex:/^[a-zA-Z ]+$/u',
            'Gender' => 'required',
            'DOB' => 'required',
            'PatientHeight' => 'required|numeric|min:100|max:250',
            'PatientWeight' => 'required|numeric',
            'EmergencyContactNo' => 'required|max:11|min:11',
        ];
        $message = [
            'PatientHeight.min' => 'Height should be more than 100 cm',
            'EmergencyContactNo.min'=>'EmergencyContactNo must be 11 digits',
            'EmergencyContactNo.max'=>'EmergencyContactNo must be 11 digits',
        ];
        return Validator::make($data, $userRules, $message);
    }

    public function validateDoctorProfile($data)
    {
        $hospitalIDRule ='';
        if(isset($data['HospitalID']) && $data['HospitalID']!=null){
            $hospitalIDRule = 'exists:hospitals,HospitalID';
        }
        $userRules = [
            'DoctorName' => 'required|regex:/^[a-zA-Z ]+$/u',
            'Gender' => 'required',
            'Website'=>'url',
            'HospitalID'=>$hospitalIDRule
        ];
        return Validator::make($data, $userRules);
    }

    public function validateHospitalProfile($data)
    {
        $userRules = [
            'HospitalName' => 'required',
            'ContactName' => 'required|regex:/^[a-zA-Z ]+$/u',
            'VisitingHours' => 'required',
            'Website'=>'url',            
        ];
        return Validator::make($data, $userRules);
    }

    public function validateAmbulanceProfile($data)
    {
        $userRules = [
            'ContactName' => 'required|regex:/^[a-zA-Z ]+$/u',
            'AmbulanceNumber' => 'required',
        ];
        return Validator::make($data, $userRules);
    }
    public function validateLabProfile($data)
    {
        $userRules = [
            'CompanyName' => 'required',
            'VisitingHours' => 'required',
            'Website'=>'url'
        ];
        return Validator::make($data, $userRules, [], []);
    }
    public function validateInsuranceCompanyProfile($data)
    {
        $userRules = [
            'CompanyName' => 'required',
            'VisitingHours' => 'required',
            'Website'=>'url'
        ];
        return Validator::make($data, $userRules);
    }


    /**
     * Process user data
     * @param Array $data
     * @return Array db fields
     */
    public function userData($data)
    {
        return array(
            'Email' => $data['Email'],
            'Phone' => $data['Phone'],
            'Address' => isset($data['Address']) ? $data['Address'] : '',
        );
    }
    /**
     * Process patient profile data
     * @param Array $data
     * @return Array db fields
     */
    public function patientProfileData($request)
    {
        return [
            'PatientName' => $request->input('PatientName'),
            'PatientGender' => $request->input('Gender'),
            'PatientDOB' => $request->input('DOB'),
            'BloodGroupID' => $request->input('BloodGroupID', null),
            'PatientHeight' => (float)$request->input('PatientHeight'),
            'PatientWeight' => (float)$request->input('PatientWeight'),
            // 'PatientChronicDisease' => $request('PatientChronicDisease', null),
            'PatientPermanentMedicines' => $request->input('PatientPermanentMedicines', ''),
            'EmergencyContactNo' => $request->input('EmergencyContactNo'),
        ];
    }
    /**
     * Process doctor profile data
     * @param Array $data
     * @return Array db fields
     */
    public function doctorProfileData($request)
    {
        return [
            'DoctorName' => $request->input('DoctorName'),
            'DoctorInfo' => $request->input('DoctorInfo', ''),
            'DoctorGender' => $request->input('Gender'),
            'HospitalID' => $request->input('HospitalID', null),            
            'DoctorWebsite' => $request->input('Website', null),
            // 'DoctorBankAccountNo' => $request->input('DoctorBankAccountNo', null),
            // 'DoctorBankName' => $request->input('DoctorBankName', null),
            // 'DoctorMinReservationCharge' => $request->input('DoctorMinReservationCharge', null),
        ];
    }
    /**
     * Process hospital profile data
     * @param Array $data
     * @return Array db fields
     */
    public function hospitalProfileData($request)
    {
        return [
            'HospitalName' => $request->input('HospitalName'),
            'HospitalInfo' => $request->input('HospitalInfo', ''),
            'HospitalWebsite' => $request->input('Website', ''),
            'HospitalContactName' => $request->input('ContactName'),
        ];
    }
    /**
     * Process ambulance profile data
     * @param Array $data
     * @return Array db fields
     */
    public function ambulanceProfileData($request)
    {
        return [
            'AmbulanceContactName' => $request->input('ContactName'),
            'AmbulanceNumber' => $request->input('AmbulanceNumber'),
        ];
    }
    /**
     * Process lab profile data
     * @param Array $data
     * @return Array db fields
     */
    public function labProfileData($request)
    {
        return [
            'LaboratoryCompanyName' => $request->input('CompanyName'),
            'LaboratoryInfo' => $request->input('LaboratoryInfo', ''),
            'LaboratoryWebsite' => $request->input('Website', ''),
        ];
    }
    /**
     * Process insurance company profile data
     * @param Array $data
     * @return Array db fields
     */
    public function insuranceCompanyProfileData($request)
    {
        return [
            'InsuranceCompanyName' => $request->input('CompanyName'),
            'InsuranceCompanyInfo' => $request->input('CompanyInfo', ''),
            'InsuranceCompanyWebsite' => $request->input('Website'),
        ];
    }

    /**
     * Upload profile image, api method
     */
    public function uploadProfileImage(Request $request)
    {
        $rule = ['RoleSlug' => 'required', 'ProfileImage' => 'required', 'UserID' => 'required'];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()->first(), 'status' => 400]);
        }

        $role = $request->RoleSlug;       
        if ($request->hasFile('ProfileImage')) {
            $file = $request->file('ProfileImage');
            $path = CustomHelper::uploadProfileImage($file);
            if (!$path) {
                return response()->json(['message' => 'could not upload', 'status' => 400]);
            }
            $model = CustomHelper::getModelUserRole($role); //get model dynamically according to role
            $profileImageKey = CustomHelper::getProfileImageKey($role); //dynamically get profile id field 
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
