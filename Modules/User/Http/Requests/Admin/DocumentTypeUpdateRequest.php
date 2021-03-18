<?php

namespace Modules\User\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DocumentTypeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'DocumentTypeName' => 'required|unique:document_types,DocumentTypeName,'.$this->DocumentTypeID.',DocumentTypeID',
            'DocumentTypeDesc' => 'required',
            'Status'=>'in:Active,Inactive',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}