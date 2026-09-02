<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Concerns\VerifiesRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class FreeTrialFormRequest extends FormRequest
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
            'country' => ['nullable', 'string', 'max:80'],
            'delivery_timeline' => ['nullable', 'string', 'max:80'],
            'file_format' => ['nullable', 'string', 'max:40'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', 'max:120'],
            'file_link' => ['nullable', 'url', 'max:2048'],
            'requirements' => ['nullable', 'string', 'max:2000'],
            'how_found' => ['nullable', 'string', 'max:80'],
            'trial_type' => ['nullable', 'in:photo,video'],
            'samples' => ['nullable', 'array', 'max:10'],
            'samples.*' => ['file', 'image', 'max:10240'], // 10 MB each
            'recaptcha_token' => ['nullable', 'string'],
            'website' => ['nullable', 'size:0'],
        ];
    }
}
