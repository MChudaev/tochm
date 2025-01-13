<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontDrawingCreateRequest extends FormRequest
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
        return [

            'drawings_name'       => 'required|min:2|max:120',
            'drawings_email'       => 'required|email|max:255',
            'drawings_phone'       => 'required|max:255',

        ];
    }
}
