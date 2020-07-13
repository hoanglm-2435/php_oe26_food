<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'price_sale' => 'required|numeric|lte:price',
            'image_path' => 'required',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
