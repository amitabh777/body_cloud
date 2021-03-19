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
    protected $fillable = ['LabServiceCategoryName','LabServiceCategoryDesc','Status'];

    protected $primaryKey = 'LabServiceCategoryID';    

    public function scopeActive($query){
       return $query->where('Status','Active');
    }

}
