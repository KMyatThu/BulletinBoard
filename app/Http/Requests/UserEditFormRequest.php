<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditFormRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.request()->id, 'regex:/^.+@.+$/i'],
            'type' => ['required', 'int', 'regex:/^[0-1]$/i'],
            'phone' => ['required', 'numeric', 'regex:/(0)[0-9]{10}$/'],
            'dob' => ['required', 'string', 'date_format:m/d/Y'],
            'address' => ['required', 'string'],
        ];
        if(request()->hasFile('profile')){
            $rules +=['profile' => ['image', 'mimes:jpg,bmp,png,jpeg']];
        }
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.regex' => 'Phone no starting with 0 and following 10 digits'
        ];
    }
}
