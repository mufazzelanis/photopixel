<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return blank($this->input('website'));
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:190'],
            'website' => ['nullable', 'size:0'],
        ];
    }
}
