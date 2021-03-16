<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratory extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'laboratories';
    protected $fillable = ['UserID','LaboratoryInfo','LaboratoryProfileImage','LaboratoryCompanyName','LaboratoryWebsite','LaboratoryBankAccountNo','LaboratoryBankName','LaboratoryMinReservationCharge','Status'];
   
    protected $primaryKey = 'LaboratoryID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

    // protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'LaboratoryID','LaboratoryID')->select(['LaboratoryID','DocumentFile','DocumentTypeID']);
    }
}
