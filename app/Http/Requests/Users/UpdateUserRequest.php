<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'required|min:3|max:80',
            'last_name' => 'required|min:3|max:80',
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($this->route('user')),
                ],
            'password' => 'bail|nullable|confirmed|min:8|max:80',
            'country' => 'bail|required|numeric|exists:countries,id',
        ];
    }
}
