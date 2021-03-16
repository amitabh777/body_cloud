<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSector extends Model
{
   
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'doctor_sectors';
    protected $fillable = ['DoctorID','SectorID'];
   
    protected $primaryKey = 'DoctorSectorID';

    // protected $hidden = [
    //     'CreatedAt', 'UpdatedAt'
    // ];

    public function sector(){
        return $this->hasOne(MedicalSector::class,'MedicalSectorID','SectorID')->select(['MedicalSectorID','MedicalSectorName', 'MedicalSectorDesc', 'Status']);
    }
        
}
