<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'roles';

    protected $fillable = [
        'RoleName', 'RoleSlug', 'ParentRoleID',
    ];

    protected $primaryKey = 'RoleID';
}
