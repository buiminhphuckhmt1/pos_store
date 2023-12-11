<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'last_name' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'image' => 'nullable|image',
            'role_id' => 'required|integer',
            'password' => 'required|string|min:6',

        ];
    }
}
