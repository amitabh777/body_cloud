<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceCategory extends Model
{
    //use HasFactory;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'InsuranceCategories';

    protected $fillable = ['InsuranceCategoryName','InsuranceCategoryDesc','Status'];
    protected $primaryKey = 'InsuranceCategoryID';
    
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\InsuranceCategoryFactory::new();
    // }
}
