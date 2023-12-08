<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'barcode' => 'required|string|max:50|unique:products',
            'category_id'=>'required|integer',
            'brand_id'=>'required|integer',
            'unit_sale' => 'required|string',
            'unit_purchas' => 'required|string',
            
            'inputprice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'outputprice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'required|integer',
            'status' => 'required|boolean',

        ];
    }
}
