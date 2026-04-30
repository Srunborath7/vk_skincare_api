<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',

            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',

            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',

            'sku' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($this->route('id')),
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products', 'barcode')->ignore($this->route('id')),
            ],

            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // or image if upload
            'image_url' => 'nullable|url',

            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',

            'creator' => 'nullable|exists:users,id',
        ];
    }
}
