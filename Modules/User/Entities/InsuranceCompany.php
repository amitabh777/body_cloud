<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceCompany extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'insurance_companies';
    protected $fillable = ['UserID','InsuranceCompanyName','InsuranceCompanyInfo','InsuranceCompanyProfileImage','InsuranceCompanyWebsite','InsuranceCompanyBankAccountNo','InsuranceCompanyBankName','Status'];
   
    protected $primaryKey = 'InsuranceCompanyID';

    protected $hidden = [
        'CreatedAt', 'UpdatedAt'
    ];

    // protected $with = ['documents'];

    public function user()
    {
        return $this->belongsTo(User::class,'UserID','UserID');
    }
    
    public function documents(){
        return $this->hasMany(Document::class,'InsuranceCompanyID','InsuranceCompanyID')->select(['InsuranceCompanyID','DocumentFile','DocumentTypeID']);
    }
}
