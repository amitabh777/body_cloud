<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'documents';

    protected $fillable = ['DocumentTypeID','HospitalID','DoctorID','LaboratoryID','AmbulanceID','PatientID','InsuranceCompanyID','DocumentFile','Status'];

    protected $primaryKey = 'DocumentID';
    protected $with=['documentType'];

    public function documentType(){
        return $this->hasOne(DocumentType::class,'DocumentTypeID','DocumentTypeID')->select(['DocumentTypeID','DocumentTypeName']);
    }
    
}
