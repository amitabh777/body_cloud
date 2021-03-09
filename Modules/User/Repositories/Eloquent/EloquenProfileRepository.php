<?php

namespace Modules\User\Repositories\Eloquent;

use App\Helpers\CustomHelper;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Doctor;
use Modules\User\Entities\Hospital;
use Modules\User\Entities\Patient;
use Modules\User\Entities\RolesUser;
use Modules\User\Repositories\ProfileRepository;

class EloquentProfileRepository implements ProfileRepository
{

    protected $patientModel;
    protected $doctorModel;
    protected $hospitalModel;
    function __construct(Patient $patient, Doctor $doctor,Hospital $hospital)
    {
        $this->patientModel = $patient;
        $this->doctorModel = $doctor;
        $this->hospitalModel = $hospital;
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
            $this->doctorModel->where('UserID',$userid)->update($data);
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
    //doctor profile update
    public function hospitalProfileUpdate($data,$userid){
        $hospital = $this->hospitalModel->where('UserID',$userid)->first();
        $success = false;
        DB::beginTransaction();
        try { 
            $this->hospitalModel->where('UserID',$userid)->update($data);
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
    //set visiting hours
    public function setVisitingHours($visitingHours, $profileID, $roleSlug)
    {
        if (!$visitingHours) {
            Log::error('Visiting hours not defined');
            return false;
        }
        $now = Carbon::now();
        $rows = [];
        $profileIDKey = CustomHelper::getProfileIdKey($roleSlug); //get profile id column name
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
