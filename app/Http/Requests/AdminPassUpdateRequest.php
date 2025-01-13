<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPassUpdateRequest   extends FormRequest
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
            'oldpass' => 'required',
            'newpass' => 'required|max:60|min:8',
            'newpass_confirm' => 'required|same:newpass',  
        ];
 

    }


	public function messages()
	{ 
        return [
        'oldpass.required' => 'Необходимо указать ваш текущий пароль ',
        'newpass.required' => 'Необходимо указать новый пароль ',
        'newpass.max' => 'Не более 60 символов', 
        'newpass.min' => 'Не менее 8 символов',  
        'newpass_confirm.required' => 'Необходимо подтвердить пароль ',
        'newpass_confirm.same' => 'Пароль и подтверждение пароля не равны ', 
     ];
	}
}
