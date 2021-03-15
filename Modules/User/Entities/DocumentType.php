<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentType extends Model
{
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'document_types';
    protected $fillable = ['DocumentTypeName', 'DocumentTypeDesc', 'Status'];

    protected $primaryKey = 'DocumentTypeID';

    public function scopeRegisteredDocType($query)
    {
        return $query->where('DocumentTypeName', config('user.const.document_types.registered_paper'));
    }

    public function scopeActive($query)
    {
        return $query->where('Status', 'Active');
    }
}
