<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'hospitals';
    protected $fillable = ['UserID','HospitalName','HospitalInfo','HospitalProfileImage','HospitalContactName','HospitalWebsite','HospitalBankAccountNo','HospitalBankName','HospitalMinReservationCharge','Status'];
   
    protected $primaryKey = 'HospitalID';

    protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'HospitalID','HospitalID')->select(['HospitalID','DocumentFile','DocumentTypeID']);
    }

    public function scopeActive($query){
        return $query->where('Status','Active');
     }
     public function medicalSectors(){
        return $this->hasMany(HospitalSector::class,'HospitalID','HospitalID');
    }
}
