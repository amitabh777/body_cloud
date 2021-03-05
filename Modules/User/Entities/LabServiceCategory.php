<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabServiceCategory extends Model
{
    // use HasFactory;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $table = 'lab_service_categories';
    protected $fillable = [];
    
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\LabServiceCategoryFactory::new();
    // }
}
