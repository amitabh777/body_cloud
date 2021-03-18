<?php

namespace Modules\User\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LabTestUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'LabTestName' => 'required|unique:lab_tests,LabTestName,'.$this->LabTestID.',LabTestID',
            'LabTestDesc'=>'required',
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
