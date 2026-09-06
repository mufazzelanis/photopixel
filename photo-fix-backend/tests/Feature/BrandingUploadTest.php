<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageBranding;
use App\Models\Branding;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class BrandingUploadTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::where('email', 'admin@pixelgraphicstudio.com')->firstOrFail());
    }

    public function test_logo_and_favicon_upload_and_persist_to_media(): void
    {
        Storage::fake('public');

        Livewire::test(ManageBranding::class)
            ->set('data.logo', [UploadedFile::fake()->image('logo.png', 240, 60)])
            ->set('data.favicon', [UploadedFile::fake()->image('favicon.png', 512, 512)])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        $branding = Branding::current();

        $this->assertNotNull($branding->getFirstMedia('logo'), 'logo media missing');
        $this->assertNotNull($branding->getFirstMedia('favicon'), 'favicon media missing');
        $this->assertStringEndsWith('.png', (string) $branding->getFirstMediaUrl('logo'));
    }

    public function test_navigation_payload_exposes_uploaded_logo(): void
    {
        Storage::fake('public');

        $branding = Branding::current();
        $branding->addMedia(UploadedFile::fake()->image('l.png', 200, 48))->toMediaCollection('logo');

        $nav = app(\App\Services\SitePayload::class)->navigation();

        $this->assertArrayHasKey('logo', $nav);
        $this->assertNotNull($nav['logo']);
        $this->assertArrayHasKey('favicon', $nav);
    }

    public function test_logo_display_options_persist_and_reach_the_api(): void
    {
        Storage::fake('public');

        Livewire::test(ManageBranding::class)
            ->set('data.logo', [UploadedFile::fake()->image('logo.png', 240, 60)])
            ->set('data.logo_bg', 'dark')
            ->set('data.logo_height', 44)
            ->call('save')
            ->assertHasNoFormErrors();

        $b = Branding::current();
        $this->assertSame('dark', $b->logo_bg);
        $this->assertSame(44, $b->logo_height);

        $nav = app(\App\Services\SitePayload::class)->navigation();
        $this->assertSame('dark', $nav['logo_bg']);
        $this->assertSame(44, $nav['logo_height']);
    }
}
