<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Patient;
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

    //protected $with = ['profile'];

    public function getAuthPassword()
    {
        return $this->Password; // case sensitive
    }

    public function patientProfile()
    {
        
        //if($role->roleInfo->RoleSlug==config('const.role_slug.patient')){
            return $this->hasOne(Patient::class,'UserID','UserID');
       // }
       
        // if($role == config('const.role_slug.patient')){
        //     return $this->hasOne(Patient::class,'UserID','UserID');
        // }
        
    }
}
