<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class DoctorAward extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'doctor_awards';
    protected $fillable = ['DoctorID','AwardName','AwardFor','Status'];
   
    protected $primaryKey = 'DoctorAwardID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];
}
