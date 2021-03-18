<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTest extends Model
{  
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'lab_tests';

    protected $fillable = ['LabTestName','LabTestDesc','Status'];
    protected $primaryKey = 'LabTestID';
}
