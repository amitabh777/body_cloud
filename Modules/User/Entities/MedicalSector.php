<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalSector extends Model
{
  const CREATED_AT = 'CreatedAt';
  const UPDATED_AT = 'UpdatedAt';
  protected $table = 'medical_sectors';

  protected $fillable = ['MedicalSectorName', 'MedicalSectorDesc', 'Status'];

  protected $primaryKey = 'MedicalSectorID';
}
