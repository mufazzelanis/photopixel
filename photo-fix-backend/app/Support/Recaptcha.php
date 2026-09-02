<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;

/**
 * Google reCAPTCHA v2 verification, driven entirely by admin settings
 * (Settings → General → Security tab). When it isn't enabled or the keys
 * are missing, verification is skipped so forms keep working (the honeypot
 * stays active regardless).
 */
class Recaptcha
{
    public static function enabled(): bool
    {
        return (bool) SiteSetting::value('recaptcha', 'enabled')
            && filled(SiteSetting::value('recaptcha', 'site_key'))
            && filled(SiteSetting::value('recaptcha', 'secret_key'));
    }

    public static function siteKey(): ?string
    {
        return SiteSetting::value('recaptcha', 'site_key') ?: null;
    }

    /** True when the token is valid, or when reCAPTCHA is not configured. */
    public static function passes(?string $token, ?string $ip = null): bool
    {
        if (! self::enabled()) {
            return true;
        }

        if (blank($token)) {
            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout(8)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => SiteSetting::value('recaptcha', 'secret_key'),
                    'response' => $token,
                    'remoteip' => $ip,
                ])
                ->json();
        } catch (\Throwable) {
            return false;
        }

        return (bool) ($response['success'] ?? false);
    }
}
