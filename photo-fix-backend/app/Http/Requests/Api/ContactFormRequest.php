<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Concerns\VerifiesRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    use VerifiesRecaptcha;

    public function authorize(): bool
    {
        return blank($this->input('website'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
            'recaptcha_token' => ['nullable', 'string'],
            'website' => ['nullable', 'size:0'],
        ];
    }
}
