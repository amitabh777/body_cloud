<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'user_roles';

    protected $fillable = [
        'RoleID', 'UserID',
    ];

    protected $primaryKey = 'UserRoleID';
    protected $with = ['role'];

    public function role(){
        return $this->hasOne(Role::class,'RoleID','RoleID')->select(['RoleID','RoleName','RoleSlug']);
    }
  
}
