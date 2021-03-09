<?php

namespace Modules\User\Repositories\Eloquent;

use App\Helpers\CustomHelper;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Ambulance;
use Modules\User\Entities\Doctor;
use Modules\User\Entities\DoctorSector;
use Modules\User\Entities\DoctorSpecialization;
use Modules\User\Entities\Hospital;
use Modules\User\Entities\HospitalSector;
use Modules\User\Entities\InsuranceCompany;
use Modules\User\Entities\Laboratory;
use Modules\User\Entities\Patient;
use Modules\User\Entities\RolesUser;
use Modules\User\Entities\VisitingHour;
use Modules\User\Repositories\ProfileRepository;

class EloquentProfileRepository implements ProfileRepository
{

    protected $patientModel;
    protected $doctorModel;
    protected $hospitalModel;
    protected $ambulanceModel;
    protected $laboratoryModel;
    protected $insuranceModel;
    function __construct(Patient $patient, Doctor $doctor,Hospital $hospital,Ambulance $ambulance,Laboratory $laboratory,InsuranceCompany $insuranceCompany)
    {
        $this->patientModel = $patient;
        $this->doctorModel = $doctor;
        $this->hospitalModel = $hospital;
        $this->ambulanceModel = $ambulance;
        $this->laboratoryModel = $laboratory;
        $this->insuranceModel = $insuranceCompany;
    }

    public function patientProfileUpdate($data,$userid){
        $success = false;
        DB::beginTransaction();
        try { 
            $this->patientModel->where('UserID',$userid)->update($data);
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            Log::error('update failed ');
            Log::error($e->getMessage());
        }
        return $success?$success:$e->getMessage();
    }
    //doctor profile update
    public function doctorProfileUpdate($data,$userid){
        $doctor = $this->doctorModel->where('UserID',$userid)->first();
        $success = false;       
        DB::beginTransaction();
        try { 
            $this->doctorModel->where('UserID',$userid)->update($data['ProfileData']);
            //set specializations sectors
            $this->setDoctorSpecialization($data['SpecializeIn'],$doctor->DoctorID);
            //set visiting hours
            $this->setVisitingHours($data['VisitingHours'],$doctor->DoctorID,config('user.const.role_slugs.doctor'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            Log::error('update failed ');
            Log::error($e->getMessage());
        }
        return $success?$success:$e->getMessage();
    }
    //Hospital profile update
    public function hospitalProfileUpdate($data,$userid){
        $hospital = $this->hospitalModel->where('UserID',$userid)->first();
        $success = false;
        DB::beginTransaction();
        try { 
            $this->hospitalModel->where('UserID',$userid)->update($data['ProfileData']);
            //set specializations sectors
            $this->setHospitalSpecialization($data['SpecializeIn'],$hospital->HospitalID);
            //set visiting hours
            $this->setVisitingHours($data['VisitingHours'],$hospital->HospitalID,config('user.const.role_slugs.hospital'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            Log::error('update failed ');
            Log::error($e->getMessage());
        }
        return $success?$success:$e->getMessage();
    }
    //Ambulance profile update
    public function ambulanceProfileUpdate($data,$userid){
        $ambulance = $this->ambulanceModel->where('UserID',$userid)->first();
        $success = false;
        DB::beginTransaction();
        try { 
            $this->ambulanceModel->where('UserID',$userid)->update($data['ProfileData']);
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            Log::error('ambulance update failed ');
            Log::error($e->getMessage());
        }
        return $success?$success:$e->getMessage();
    }
    //Laboratory profile update
    public function laboratoryProfileUpdate($data, $userid)
    {
        $laboratory = $this->laboratoryModel->where('UserID',$userid)->first();
        $success = false;
        DB::beginTransaction();
        try { 
            $this->laboratoryModel->where('UserID',$userid)->update($data['ProfileData']);
            $this->setVisitingHours($data['VisitingHours'],$laboratory->LaboratoryID,config('user.const.role_slugs.lab'));

            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            Log::error('laboratory profile update failed: ');
            Log::error($e->getMessage());
        }
        return $success?$success:$e->getMessage();
    }
    //Insurance profile update
    public function insuranceCompanyProfileUpdate($data, $userid)
    {
        $insuranceCompany = $this->insuranceModel->where('UserID',$userid)->first();
        $success = false;
        DB::beginTransaction();
        try { 
            $this->insuranceModel->where('UserID',$userid)->update($data['ProfileData']);
            $this->setVisitingHours($data['VisitingHours'],$insuranceCompany->InsuranceCompanyID,config('user.const.role_slugs.insurance_company'));
            DB::commit(); //success
            $success = true;
        } catch (Exception $e) {
            DB::rollBack(); //failed
            Log::error('insurance company profile update failed: ');
            Log::error($e->getMessage());
        }
        return $success?$success:$e->getMessage();
    }
    //set visiting hours
    public function setVisitingHours($visitingHours, $profileID, $roleSlug)
    {
        if (!$visitingHours || empty($visitingHours)) {
            Log::error('Visiting hours not defined');
            return false;
        }     

        $now = Carbon::now();
        $rows = [];
        $profileIDKey = CustomHelper::getProfileIdKey($roleSlug); //get profile id column name
         //delete old entries
        VisitingHour::where([$profileIDKey=>$profileID])->delete();        
        $days = is_array($visitingHours) ? $visitingHours : json_decode($visitingHours, true);
        if ($days['days']) {
            foreach ($days['days'] as $day => $details) {
                $rows[] = array(
                    $profileIDKey => $profileID,
                    'VisitingDay' => $day,
                    'VisitingStartTime' => CustomHelper::convertTimeTo24($details['start_time']),
                    'VisitingEndTime' => CustomHelper::convertTimeTo24($details['end_time']),
                    'VisitingSlot' => $details['visiting_slot'],
                    'IsAvailable' => $details['is_available'],
                    'CreatedAt' => $now->toDateTimeString()
                );
            }
        }
        //Insert into visitng hours
        $res =DB::table('visiting_hours')->insert($rows);
        if(!$res){
            return false;
        }
        return true;
    }
    /**
     * Set medical sector
     * @param Array $sectorIDs
     * @param int $doctorID
     * @return Response
     */
    public function setMedicalSectors($sectorIDs, $doctorID)
    {
        $now = Carbon::now();
        $sectors = [];
        if ($sectorIDs!=null && is_array($sectorIDs)) {
            foreach ($sectorIDs as $sectorID) {
                $sectors[] = ['SectorID' => $sectorID, 'DoctorID' => $doctorID, 'CreatedAt' => $now->toDateTimeString()];
            }
            DB::table('doctor_sectors')->insert($sectors);
        }
    }

    /**
     * Set doctor specializations
     * @param Array $sectorIDs
     * @param int $doctorID
     * @return Response
     */
    public function setDoctorSpecialization($sectorIDs, $doctorID)
    {
        $now = Carbon::now();
        //delete previous entries
        DoctorSpecialization::where('DoctorID',$doctorID)->delete();
        $sectors = [];
        if ($sectorIDs && is_array($sectorIDs)) {
            foreach ($sectorIDs as $sectorID) {
                $sectors[] = ['SpecializeIn' => $sectorID, 'DoctorID' => $doctorID, 'CreatedAt' => $now->toDateTimeString()];
            }
           $res= DB::table('doctor_specializations')->insert($sectors);
        } else {
         //  $res= DoctorSpecialization::create(['SpecializeIn' => $sectorIDs, 'DoctorID' => $doctorID]);
        }
        return $res;
    }

    /**
     * Set hospital sectors
     * @param Array $sectorIDs
     * @param int $hospital
     * @return Response
     */
    public function setHospitalSpecialization($sectorIDs, $hospitalID)
    {
        $now = Carbon::now();
        //delete previous entries
        HospitalSector::where('HospitalID',$hospitalID)->delete();
        $sectors = [];
        if ($sectorIDs!=null && is_array($sectorIDs)) {
            foreach ($sectorIDs as $sectorID) {
                $sectors[] = ['MedicalSectorID' => $sectorID, 'HospitalID' => $hospitalID, 'CreatedAt' => $now->toDateTimeString()];
            }
           $res= DB::table('hospital_sectors')->insert($sectors);
        }
        return $res;
    }

    //Create user with roles
    public function createWithRoles($data, $role)
    {
        //Hash encrypt password
        $data['password'] = Hash::make($data['password']);
        $user = null;
        try {
            $user = DB::transaction(function () use ($data, $role, $user) {
                $user = User::create($data);
                $roleuser = array(
                    'role_id' => $role,
                    'user_id' => $user->id
                );
                RolesUser::create($roleuser);
                Log::info('db trans executed: ');
                return $user;
            });           
            return $user;
        } catch (Exception $e) {
            Log::error('Create user with role: ' . $e->getMessage());
            return false;
        }
    }

    public function isAdmin($user)
    {
        if (isset($user->roles)) {
            $role = $user->roles[0]->role;
            if ($role->slug == config('user.const.roles.admin')) {
                return true;
            }
        }
        return false;
    }

}
