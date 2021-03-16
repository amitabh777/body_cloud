<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'doctors';
    protected $fillable = ['UserID','DoctorName','DoctorInfo','DoctorGender','DoctorDOB','DoctorProfileImage','HospitalID','DoctorWebsite','DoctorBankAccountNo','DoctorBankName','DoctorMinReservationCharge','Status'];
   
    protected $primaryKey = 'DoctorID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

    protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'DoctorID','DoctorID')->select(['DoctorID','DocumentFile','DocumentTypeID','DocumentID']);
    }

    public function medicalSectors(){
       return $this->hasMany(DoctorSector::class,'DoctorID','DoctorID');//->with(['sector']);
        // return $this->hasManyThrough(MedicalSector::class,DoctorSector::class,'DoctorID','MedicalSectorID','DoctorID','DoctorID');//->with(['sector']);
    }
    public function specializations(){
       return $this->hasMany(DoctorSpecialization::class,'DoctorID','DoctorID');//->with(['sector']);
    }

    public function hospital(){
        return $this->hasOne(Hospital::class,'HospitalID','HospitalID');
    }

    public function experiences(){
        return $this->hasMany(DoctorExperience::class,'DoctorID','DoctorID');
    }
    public function awards(){
        return $this->hasMany(DoctorAward::class,'DoctorID','DoctorID');
    }

}
