<?php

namespace App\Http\Requests\Api\Concerns;

use App\Support\Recaptcha;
use Illuminate\Contracts\Validation\Validator;

/**
 * Mix into any FormRequest to enforce the admin-configured reCAPTCHA.
 * No-op when reCAPTCHA is disabled/unconfigured.
 */
trait VerifiesRecaptcha
{
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! Recaptcha::passes($this->input('recaptcha_token'), $this->ip())) {
                $validator->errors()->add(
                    'recaptcha_token',
                    'Please complete the "I\'m not a robot" verification.',
                );
            }
        });
    }
}
