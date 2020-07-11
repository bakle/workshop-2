<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'filter' => 'filled|array',
            'filter.first_name' => 'bail|nullable|min:3|max:80',
            'filter.last_name' => 'bail|nullable|min:3|max:80',
            'filter.email' => 'bail|nullable|email|max:80',
        ];
    }
}
