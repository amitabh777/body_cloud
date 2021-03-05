<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{ 
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'patients';
    protected $fillable = ['UserID','PatientName','PatientGender','PatientDOB','BloodGroupID','PatientHeight','PatientWeight','PatientChronicDisease','PatientPermanentMedicines','EmergencyContactNo','Status'];
   
    protected $primaryKey = 'PatientID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

    protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(Patient::class,'PatientID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'PatientID','UserID')->select(['PatientID','DocumentFile']);
    }
}
