<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Role extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'roles';

    protected $fillable = [
        'RoleName', 'RoleSlug', 'ParentRoleID',
    ];

    protected $primaryKey = 'RoleID';

    public function scopePatient($query){
        return $query->where('RoleSlug', 'patient');
    }    

}
