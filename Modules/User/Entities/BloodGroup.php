<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodGroup extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'blood_groups';

    protected $fillable = ['BloodGroupName','BloodGroupDesc','Status'];
    protected $primaryKey = 'BloodGroupID';
    

    public function scopeActive($query){
       return $query->where('Status','Active');
    }

}
