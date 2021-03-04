<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Email'=>'required|email|max:150|unique.users',
            'Phone'=>'required|min:13|max:13|unique.users',
            'Password'=>['required', 'string', 'min:8'],            
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

    public function messages()
    {
        return [
            // 'title.required' => 'A title is required',
            // 'body.required'  => 'A message is required',
        ];
    }
    public function attributes()
    {
        return [
            // 'email' => 'email address',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // f $this->merge([
        //      'slug' => Str::slug($this->slug),
        //  ]);
    }
}
