<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalSector extends Model
{
  //  use HasFactory;
  const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'MedicalSectors';

    protected $fillable = ['MedicalSectorName','MedicalSectorDesc','Status'];

    protected $primaryKey = 'MedicalSectorID';
    
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\MedicalSectorFactory::new();
    // }
}
