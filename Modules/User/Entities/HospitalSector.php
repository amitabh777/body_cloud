<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalSector extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'hospital_sectors';
    protected $fillable = ['MedicalSectorID','HospitalID'];
   
    protected $primaryKey = 'HospitalSectorID';

    public function sector(){
        return $this->hasOne(MedicalSector::class,'MedicalSectorID','MedicalSectorID')->select(['MedicalSectorID','MedicalSectorName', 'MedicalSectorDesc', 'Status']);
    }
}
