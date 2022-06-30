<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'nullable|max:255|email|unique:users,email,' . $this->user->id,
            'name' => 'required|max:255',
            'password' => 'confirmed',
            'image' => 'nullable',
            'phone_number' => 'numeric|nullable',
            'post_code' => 'numeric|nullable'
        ];
    }
}
