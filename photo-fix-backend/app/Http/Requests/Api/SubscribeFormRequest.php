<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return blank($this->input('hp_confirm'));
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:190'],
            'hp_confirm' => ['nullable', 'size:0'],
        ];
    }
}
