<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{ 
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'patients';
    protected $fillable = ['UserID','PatientName','PatientGender','PatientProfileImage','PatientDOB','BloodGroupID','PatientHeight','PatientWeight','PatientChronicDisease','PatientPermanentMedicines','EmergencyContactNo','Status'];
   
    protected $primaryKey = 'PatientID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

    protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'PatientID','PatientID')->select(['PatientID','DocumentFile','DocumentTypeID']);
    }

    public function bloodgroup(){
        return $this->hasOne(BloodGroup::class,'BloodGroupID','BloodGroupID');
    }
}
