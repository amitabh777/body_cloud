<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ambulance extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'ambulances';
    protected $fillable = ['UserID','AmbulanceNumber','AmbulanceContactName','AmbulanceProfileImage','HospitalID','AmbulanceMinReservationCharge','Status'];
   
    protected $primaryKey = 'AmbulanceID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

    protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'AmbulanceID','AmbulanceID')->select(['AmbulanceID','DocumentFile','DocumentTypeID']);
    }

    public function hospital(){
        return $this->hasOne(Hospital::class,'HospitalID','HospitalID');
    }
   
}
