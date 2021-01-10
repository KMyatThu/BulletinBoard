<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'profile' => 'required',
        ];
        if (request()->route()->uri() != "editProfile") {
            $rules += [
                'password' => ['required'],
                'confirm_password' => ['same:password'],
            ];
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
            'profile.required' => 'A profile upload is required',
        ];
    }
}
