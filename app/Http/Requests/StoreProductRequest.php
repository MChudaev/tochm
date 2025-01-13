<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|min:2|max:120',
            'vendor_id'  => 'required|exists:vendors,id',
            'product_style_id' => 'required|exists:product_styles,id',
            // 'product_type_id' => 'required|exists:product_types,id',
            'product_subtype_id' => 'required|exists:product_subtypes,id',


        ];
    }
}
