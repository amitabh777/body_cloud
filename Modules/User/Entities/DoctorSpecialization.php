<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSpecialization extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'doctor_specializations';
    protected $fillable = ['DoctorID','SpecializeIn','Status'];
   
    protected $primaryKey = 'DoctorSpecializationID';

}
