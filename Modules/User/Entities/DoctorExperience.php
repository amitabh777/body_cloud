<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorExperience extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'doctor_experiences';
    protected $fillable = ['DoctorID','Institute','ExperienceFrom','ExperienceTo','Status'];
   
    protected $primaryKey = 'DoctorExperienceID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

}
