<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'documents';
    protected $fillable = ['DocumentTypeID','HospitalID','DoctorID','LaboratoryID','PatientID','InsuranceCompanyID','DocumentFile','Status'];

    protected $primaryKey = 'DocumentTypeID';
    
}
