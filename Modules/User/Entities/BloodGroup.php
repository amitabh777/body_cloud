<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodGroup extends Model
{
    // use HasFactory;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'BloodGroups';

    protected $fillable = ['BloodGroupName','BloodGroupDesc','Status'];
    protected $primaryKey = 'BloodGroupID';
    
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\BloodGroupFactory::new();
    // }
}
