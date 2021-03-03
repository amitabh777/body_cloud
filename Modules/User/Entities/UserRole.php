<?php

namespace App\models;

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
}
