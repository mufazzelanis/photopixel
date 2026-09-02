<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RecaptchaTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private function enableRecaptcha(): void
    {
        SiteSetting::updateOrCreate(['group' => 'recaptcha', 'key' => 'enabled'], ['value' => '1', 'type' => 'boolean']);
        SiteSetting::updateOrCreate(['group' => 'recaptcha', 'key' => 'site_key'], ['value' => 'site-x', 'type' => 'text']);
        SiteSetting::updateOrCreate(['group' => 'recaptcha', 'key' => 'secret_key'], ['value' => 'secret-x', 'type' => 'text']);
        \Illuminate\Support\Facades\Cache::flush();
    }

    public function test_forms_work_when_recaptcha_is_disabled(): void
    {
        $this->postJson('/api/v1/contact', [
            'name' => 'Jane', 'email' => 'jane@example.com', 'message' => 'Hello there',
        ])->assertCreated();
    }

    public function test_secret_key_is_never_exposed_in_the_api(): void
    {
        $this->enableRecaptcha();

        $home = $this->getJson('/api/v1/home')->assertOk()->json();

        $this->assertArrayNotHasKey('recaptcha', $home['settings']);
        $this->assertTrue($home['captcha']['enabled']);
        $this->assertSame('site-x', $home['captcha']['site_key']);
        $this->assertStringNotContainsString('secret-x', json_encode($home));
    }

    public function test_missing_token_is_rejected_when_enabled(): void
    {
        $this->enableRecaptcha();

        $this->postJson('/api/v1/contact', [
            'name' => 'Jane', 'email' => 'jane@example.com', 'message' => 'Hello there',
        ])->assertStatus(422)->assertJsonValidationErrors('recaptcha_token');
    }

    public function test_valid_token_passes_when_google_confirms(): void
    {
        $this->enableRecaptcha();
        Http::fake(['www.google.com/*' => Http::response(['success' => true])]);

        $this->postJson('/api/v1/contact', [
            'name' => 'Jane', 'email' => 'jane@example.com', 'message' => 'Hello there',
            'recaptcha_token' => 'valid-token',
        ])->assertCreated();
    }

    public function test_token_rejected_by_google_fails(): void
    {
        $this->enableRecaptcha();
        Http::fake(['www.google.com/*' => Http::response(['success' => false])]);

        $this->postJson('/api/v1/contact', [
            'name' => 'Jane', 'email' => 'jane@example.com', 'message' => 'Hello there',
            'recaptcha_token' => 'bad-token',
        ])->assertStatus(422)->assertJsonValidationErrors('recaptcha_token');
    }
}
