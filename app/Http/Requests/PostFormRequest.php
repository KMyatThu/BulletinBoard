<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
        if (request()->route()->uri() == "upload") {
            return [
                'file' => 'required|file|mimes:csv'
            ];
        } else {
            return [
                'title' => 'required|string',
                'description' => 'required|string',
            ];
        }
    }
}
