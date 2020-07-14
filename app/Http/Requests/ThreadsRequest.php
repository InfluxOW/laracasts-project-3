<?php

namespace App\Http\Requests;

use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;

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
            'channel_id' => [
                Rule::requiredIf($this->isMethod('POST')),
                Rule::exists('channels', 'id')->where(function ($query) {
                    $query->where('archived', false);
                })
            ],
            'g-recaptcha-response' => [Rule::requiredIf($this->isMethod('POST')), 'captcha'],
            'image' => [Rule::requiredIf($this->isMethod('POST')), 'url']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'image' => trim(Purify::clean($this->image)),
        ]);
    }
}
