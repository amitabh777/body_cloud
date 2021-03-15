<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'PatientName' => 'required|regex:/^[a-zA-Z ]+$/u',
            'PatientGender' => 'required|in:Male,Female',
            'PatientDOB' => 'required',
            'PatientHeight' => 'required|numeric|min:100|max:270',
            'PatientWeight' => 'required|numeric|min:20|max:170',
            'EmergencyContactNo' => 'required|max:11|min:11',
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

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'PatientHeight.min' => 'Height should be more than 100 cm',
            'PatientHeight.max' => 'Height should be more than 270 cm',
            'EmergencyContactNo.min' => 'EmergencyContactNo must be 11 digits',
            'EmergencyContactNo.max' => 'EmergencyContactNo must be 11 digits',
        ];
    }
}
