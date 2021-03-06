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
    protected $fillable = ['UserID','DoctorName','DoctorInfo','DoctorGender','DoctorProfileImage','HospitalID','DoctorWebsite','DoctorBankAccountNo','DoctorBankName','DoctorMinReservationCharge','Status'];
   
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
        return $this->hasMany(Document::class,'DoctorID','DoctorID')->select(['DoctorID','DocumentFile','DocumentTypeID']);
    }

    public function medicalSectors(){
        return $this->hasMany(DoctorSector::class,'DoctorID','DoctorID');
    }
}
