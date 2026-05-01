<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductDetailRequest extends FormRequest
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
            'image_details' => 'required|array|min:1|max:3',
            'image_details.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'skin_type' => 'required|string',
            'product_type' => 'required|string',
            'ingredients' => 'required|string',
            'benefits' => 'required|string',
            'usage' => 'required|string',
            'volume_unit' => 'required|string',
            'texture' => 'required|string',
            'origin_country' => 'required|string',
            'expiry_date' => 'required|date',
            'manufacture_date' => 'required|date',
            'product_id' => 'required|exists:products,id',
        ];
    }
}
