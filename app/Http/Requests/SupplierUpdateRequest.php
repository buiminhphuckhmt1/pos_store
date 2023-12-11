<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
        $supplier_id = $this->route('supplier')->id;
        return [
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier_id,
            'phone' => 'required|string|max:50|unique:suppliers,phone,' . $supplier_id,
            'country' => 'required|string|max:255'
        ];
    }
}
