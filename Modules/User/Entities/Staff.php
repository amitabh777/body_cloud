<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
   
    protected $table = 'staffs';
    protected $fillable = ['UserID','FirstName','LastName','Gender','Designation','ProfileImage'];
   
    protected $primaryKey = 'StaffID';

    protected $hidden = [
       // 'CreatedAt', 'UpdatedAt'
    ];
}
