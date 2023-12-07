<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
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
        $brand_id = $this->route('brand')->id;
        return [
            'name' => 'required|string|max:255|unique:brands,name,' . $brand_id,
            'image' => 'nullable|image',
        ];
    }
}
