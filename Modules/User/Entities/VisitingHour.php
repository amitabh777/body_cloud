<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class VisitingHour extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'visiting_hours';

    protected $fillable = [
        'HospitalID', 'DoctorID','LaboratoryID','InsuranceCompanyID','VisitingDay','VisitingStartTime','VisitingEndTime','VisitingSlot','IsAvailable','Status'
    ];

    protected $primaryKey = 'VisitingHourID';
   

}
