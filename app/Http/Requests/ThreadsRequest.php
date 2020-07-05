<?php

namespace App\Http\Requests;

use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThreadsRequest extends FormRequest
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
            'body' => ['required', 'string', 'min:100', 'max:10000', new SpamFree()],
            'title' => ['required', 'string', 'min:3', 'max:200', new SpamFree()],
            'channel_id' => [Rule::requiredIf($this->isMethod('POST')), 'exists:channels,id'],
            'g-recaptcha-response' => [Rule::requiredIf($this->isMethod('POST')), 'captcha']
        ];
    }
}
