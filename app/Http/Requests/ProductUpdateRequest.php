<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
        $product_id = $this->route('product')->id;
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'barcode' => 'required|string|max:50|unique:products,barcode,' . $product_id,
            'inputprice' => 'required|regex:/^\d+(\.\d{1})?$/',
            'outputprice' => 'required|regex:/^\d+(\.\d{1})?$/',
            'quantity' => 'required|integer',
            'status' => 'required|boolean',
        ];
    }
}
