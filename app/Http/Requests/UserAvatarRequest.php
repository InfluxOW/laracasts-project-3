<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAvatarRequest extends FormRequest
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
            'avatar' => [Rule::requiredIf(empty($this->banner)), 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:1024', 'dimensions:ratio=1/1'],
            'banner' => [Rule::requiredIf(empty($this->avatar)), 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
        ];
    }
}
