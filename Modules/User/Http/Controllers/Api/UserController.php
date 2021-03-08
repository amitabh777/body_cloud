<?php

namespace Modules\User\Http\Controllers\Api;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use AuthenticatesUsers;
    /**
     * 
     * return user data
     */
    public function index()
    {
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
     */
    public function show($id)
    {
    }

    public function showMyProfile()
    {
        $user = User::find(Auth::user()->UserID); //get user
        $role = $user->userRole()->role; //User Role
        $profile = $user->profile($role->RoleSlug); //User profile
        
        //merge in user response
        $user['UserType'] = $role->RoleSlug; 
        $user['Profile'] = $profile;   
        return response()->json(['data'=>$user,'message' => 'Success', 'status' => 200]);
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
        //Validate user data
        $validateUser = $this->validateUserData($data,$id);
        if ($validateUser->fails()) {
            return response()->json(['message' => $validateUser->errors()->first(), 'status' => 400]);
        }

        $roleSlug = $data['RoleSlug'];
        //validate user profile data
        if($roleSlug==config('user.const.role_slugs.patient')){
            $this->patientProfileUpdate($data);
        }elseif($roleSlug==config('user.const.role_slugs.doctor')){

        }elseif($roleSlug==config('user.const.role_slugs.hospital')){

        }elseif($roleSlug==config('user.const.role_slugs.ambulance')){

        }elseif($roleSlug==config('user.const.role_slugs.lab')){

        }elseif($roleSlug==config('user.const.role_slugs.insurance_companies')){

        }


        return 'sdfdsfds';
    }
    /**
     * validate user data
     * 
     */
    public function validateUserData($data,$id)
    {
        $userRules = [
            'Email' => 'required|email|max:150|unique:users,Email,'.$id.',UserID',
            'Phone' => 'required|min:10|max:10|unique:users,Phone,'.$id.',UserID',           
            'RoleSlug' => ['required','in:'. implode(',',array_keys(config('user.const.role_slugs')))],         
        ];
        $message = [
            'RoleSlug.required' => 'Role is required'
        ];
        return Validator::make($data, $userRules, $message, []);
    }

    public function validatePatientProfile($request)
    {
        $userRules = [
            'PatientName' => 'required',
            'PatientGender' => 'required',
            'PatientDOB' => 'required',
            'PatientHeight' => 'required',
            'PatientWeight' => 'required',
            'EmergencyContactNo' => 'required|max:10|min:10',
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function validateDoctorProfile($request)
    {
        $userRules = [
            'DoctorName' => 'required',
            'DoctorGender' => 'required',
            'VisitingHours' => 'required'
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
        return Validator::make($request->all(), $userRules,[],[]);
    }
    public function validateInsuranceCompanyProfile($request)
    {
        $userRules = [
            'CompanyName' => 'required',
            'VisitingHours' => 'required',
        ];
        return Validator::make($request->all(), $userRules);
    }

    public function prepareUserData($data)
    {
        return array(
            'Email' => $data['Email'],
            'Phone' => $data['Phone'],
            'Address' =>$data['Address'],
        );
    }
    //Patient fields
    public function preparePatientProfileData($data)
    {
        return [
            'PatientName' => $data['PatientName'],
            'PatientGender' => $data['Gender'],
            'PatientDOB' => $data['DOB'],
            'BloodGroupID' => $data['BloodGroupID'],
            'PatientHeight' => (float)$data['PatientHeight'],
            'PatientWeight' => (float)$data['PatientWeight'],
           /// 'PatientChronicDisease' => $data['PatientChronicDisease', null),
            'PatientPermanentMedicines' => $data['PatientPermanentMedicines'],
            'EmergencyContactNo' => $data['EmergencyContactNo'],
        ];
    }
    //Doctor fields
    public function prepareDoctorProfileData($request)
    {
        return [
            'DoctorName' => $data['DoctorName'],
            'DoctorInfo' => $data['DoctorInfo'],
            'DoctorGender' => $data['Gender'],
            'DoctorDOB' => $data['DOB'],
            'HospitalID' => $data['HospitalID']?$data['HospitalID']:null,
            'DoctorWebsite' => $data['Website'],
            'DoctorInfo' => $data['About'],           
            // 'SectorID' => $data['SectorID', []),
            'VisitingHours' => $data['VisitingHours'],
        ];
    }
    //Hospital fields
    public function getHospitalProfileData($request)
    {
        return [
            'UserID' => '',
            'HospitalName' => $data'HospitalName'),
            'HospitalInfo' => $data'HospitalInfo',''),
            'HospitalWebsite' => $data'HospitalWebsite'),
            'HospitalContactName' => $data'HospitalContactName'),
            'VisitingHours' => $data'VisitingHours'),
        ];
    }
    //Ambulance profile
    public function getAmbulanceProfileData($request)
    {
        return [
            'AmbulanceContactName' => $data'ContactName'),
            'AmbulanceNumber' => $data'AmbulanceNumber'),
        ];
    }
    //Lab profile
    public function getLabProfileData($request)
    {
        return [
            'LaboratoryCompanyName' => $data'CompanyName'),
            'LaboratoryInfo' => $data'LaboratoryInfo',''),
            'LaboratoryWebsite' => $data'Website',''),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }
    //Lab profile
    public function getInsuranceCompanyProfileData($request)
    {
        return [
            'InsuranceCompanyName' => $request->input('CompanyName'),
            'InsuranceCompanyInfo' => $request->input('CompanyInfo',''),
            'InsuranceCompanyWebsite' => $request->input('Website'),
            'VisitingHours' => $request->input('VisitingHours'),
        ];
    }

    public function patientProfileUpdate($request,$profileData,$roleSlug){       
        $userData = $this->getUserData($request);
        $profileData = $this->getLabProfileData($request);

        $success = false;
        DB::beginTransaction();
        try {
            //create user with role and profile
            $user = User::create($userData);
            if ($user) {
                $laboratoryRole = Role::laboratory()->first();
            }
            UserRole::create(['RoleID' => $laboratoryRole->RoleID, 'UserID' => $user->UserID]);
            $profileData['UserID'] = $user->UserID;
            $profileData['Otp'] = $user->Otp;
            $laboratory = Laboratory::create($profileData);
            //set Visiting hours 
            $this->setVisitingHours($request->VisitingHours, $laboratory->LaboratoryID, config('user.const.role_slugs.lab'));
            //Upload registered papers
            $this->uploadDocuments($request->file('Documents'), config('user.const.role_slugs.lab'), $laboratory->LaboratoryID, config('user.const.document_types.registered_paper'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed rollback
            Log::error('Unable to create user' . $e->getMessage());
        }
        if ($success) {
            //upload files
            if ($request->file('ProfileImage')) {
                $filename = $this->uploadProfileImage($request->file('ProfileImage'));
                if ($filename) {
                    $laboratory->LaboratoryProfileImage = $filename;
                    $laboratory->save();
                } else {
                    Log::error('User registration: unable to upload profile image');
                }
            }
            $otp = CustomHelper::sendOtp($userData['Phone']); //send otp
            return $otp ? $otp : 'otp_failed';
        }
        return $success;

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
