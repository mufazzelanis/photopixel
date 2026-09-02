<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Concerns\VerifiesRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class QuoteFormRequest extends FormRequest
{
    use VerifiesRecaptcha;

    public function authorize(): bool
    {
        // Honeypot: bots fill hidden fields, humans don't.
        return blank($this->input('website'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:150'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer'],
            'file_link' => ['nullable', 'url', 'max:2048'],
            'budget' => ['nullable', 'string', 'max:60'],
            'message' => ['nullable', 'string', 'max:5000'],
            'recaptcha_token' => ['nullable', 'string'],
            'website' => ['nullable', 'size:0'], // honeypot
        ];
    }
}
