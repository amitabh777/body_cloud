<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceCategory extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'insurance_categories';

    protected $fillable = ['InsuranceCategoryName','InsuranceCategoryDesc','Status'];
    protected $primaryKey = 'InsuranceCategoryID';
  
}
