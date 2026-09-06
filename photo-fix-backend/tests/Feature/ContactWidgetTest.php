<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Services\SitePayload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactWidgetTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private function widget(): array
    {
        return app(SitePayload::class)->contactWidget();
    }

    public function test_only_active_widget_flagged_channels_are_returned(): void
    {
        SocialLink::query()->update(['show_in_widget' => false]);
        SocialLink::where('platform', 'WhatsApp')->update(['show_in_widget' => true, 'is_active' => true]);
        SocialLink::where('platform', 'Telegram')->update(['show_in_widget' => true, 'is_active' => false]); // hidden -> excluded

        $channels = collect($this->widget()['channels'])->pluck('platform');

        $this->assertTrue($channels->contains('WhatsApp'));
        $this->assertFalse($channels->contains('Telegram'));
        $this->assertFalse($channels->contains('Facebook'));
    }

    public function test_widget_can_be_switched_off(): void
    {
        SiteSetting::updateOrCreate(
            ['group' => 'contact_widget', 'key' => 'enabled'],
            ['value' => '0', 'type' => 'boolean'],
        );

        $this->assertFalse($this->widget()['enabled']);
    }

    public function test_free_trial_shortcut_toggle_and_label_flow_through(): void
    {
        SiteSetting::updateOrCreate(['group' => 'contact_widget', 'key' => 'show_free_trial'], ['value' => '0', 'type' => 'boolean']);
        SiteSetting::updateOrCreate(['group' => 'contact_widget', 'key' => 'label'], ['value' => 'Talk to us', 'type' => 'text']);

        $w = $this->widget();

        $this->assertFalse($w['show_free_trial']);
        $this->assertSame('Talk to us', $w['label']);
    }

    public function test_home_payload_includes_the_widget(): void
    {
        $this->getJson('/api/v1/home')
            ->assertOk()
            ->assertJsonStructure(['contact_widget' => ['enabled', 'label', 'show_free_trial', 'channels']]);
    }
}
