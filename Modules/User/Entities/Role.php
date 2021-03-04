<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'Roles';

    protected $fillable = [
        'RoleName', 'RoleSlug', 'ParentRoleID',
    ];

    protected $primaryKey = 'RoleID';
}
