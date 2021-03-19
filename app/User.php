<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Ambulance;
use Modules\User\Entities\Doctor;
use Modules\User\Entities\Hospital;
use Modules\User\Entities\InsuranceCompany;
use Modules\User\Entities\Laboratory;
use Modules\User\Entities\Patient;
use Modules\User\Entities\Role;
use Modules\User\Entities\UserRole;

class User extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UniqueID', 'ParentID', 'Email', 'Phone', 'Password', 'Address', 'Status', 'DeviceType', 'DeviceToken', 'Otp', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Password', 'remember_token', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $primaryKey = 'UserID'; //custom primary key 

    // protected $with = ['profile'];

    public function getAuthPassword()
    {
        return $this->Password; // case sensitive
    }

    public function profile($type)
    {
        $relation = '';
        if ($type == config('user.const.role_slugs.patient')) {
            $relation = $this->hasOne(Patient::class, 'UserID', 'UserID')->first();
        } elseif ($type ==  config('user.const.role_slugs.doctor')) {
            $relation = $this->hasOne(Doctor::class, 'UserID', 'UserID')->first();
        } elseif ($type ==  config('user.const.role_slugs.hospital')) {
            $relation =  $this->hasOne(Hospital::class, 'UserID', 'UserID')->first();
        } elseif ($type == config('user.const.role_slugs.ambulance')) {
            $relation = $this->hasOne(Ambulance::class, 'UserID', 'UserID')->first();
        } elseif ($type == config('user.const.role_slugs.lab')) {
            $relation = $this->hasOne(Laboratory::class, 'UserID', 'UserID')->first();
        } elseif ($type == config('user.const.role_slugs.insurance_company')) {
            $relation = $this->hasOne(InsuranceCompany::class, 'UserID', 'UserID')->first();
        }
        return $relation;
    }
    //customize fields for login
    public function customeProfileForLogin($type)
    {
        $relation = '';
        if ($type == config('user.const.role_slugs.patient')) {
            $relation = $this->hasOne(Patient::class, 'UserID', 'UserID')->select(['PatientName As Name','EmergencyContactNo','PatientProfileImage As ProfileImage'])->first();
        } elseif ($type ==  config('user.const.role_slugs.doctor')) {
            $relation = $this->hasOne(Doctor::class, 'UserID', 'UserID')->select(['DoctorName As Name','DoctorProfileImage As ProfileImage'])->first();
        } elseif ($type ==  config('user.const.role_slugs.hospital')) {
            $relation =  $this->hasOne(Hospital::class, 'UserID', 'UserID')->select(['HospitalName As Name','HospitalContactName','HospitalProfileImage As ProfileImage'])->first();
        } elseif ($type == config('user.const.role_slugs.ambulance')) {
            $relation = $this->hasOne(Ambulance::class, 'UserID', 'UserID')->select(['AmbulanceContactName As Name','AmbulanceProfileImage As ProfileImage'])->first();
        } elseif ($type == config('user.const.role_slugs.lab')) {
            $relation = $this->hasOne(Laboratory::class, 'UserID', 'UserID')->select(['LaboratoryCompanyName As Name','LaboratoryProfileImage As ProfileImage'])->first();
        } elseif ($type == config('user.const.role_slugs.insurance_company')) {
            $relation = $this->hasOne(InsuranceCompany::class, 'UserID', 'UserID')->select(['InsuranceCompanyName As Name','InsuranceCompanyProfileImage As ProfileImage'])->first();
        }
        return $relation;
    }

    //get Role
    public function role()
    {
        $rel = $this->hasOne(UserRole::class, 'UserID', 'UserID')->first();
        return $rel->role();
    }
    //get Role
    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'UserID', 'UserID');//->first();
    }

    public function scopeGenerateToken()
    {
        return hash('sha256', time() . '0123456789ab25');
    }
    
    public function scopeIsSuperAdmin()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.super_admin')) {
            return true;
        }
        return false;
    }
    public function scopeIsPatient()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.patient')) {
            return true;
        }
        return false;
    }
    public function scopeIsDoctor()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.doctor')) {
            return true;
        }
        return false;
    }
    public function scopeIsHospital()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.hospital')) {
            return true;
        }
        return false;
    }
    public function scopeIsAmbulance()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.ambulance')) {
            return true;
        }
        return false;
    }
    public function scopeIsLaboratory()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.lab')) {
            return true;
        }
        return false;
    }
    public function scopeIsInsuranceCompany()
    {
        $userRole = $this->userRole;
        if ($userRole->role->RoleSlug == config('user.const.role_slugs.insurance_company')) {
            return true;
        }
        return false;
    }
}
