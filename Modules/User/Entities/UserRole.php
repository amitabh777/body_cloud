<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'UserRoles';

    protected $fillable = [
        'RoleID', 'UserID',
    ];

    protected $primaryKey = 'UserRoleID';
}
