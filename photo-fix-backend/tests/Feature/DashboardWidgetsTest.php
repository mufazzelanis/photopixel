<?php

namespace Tests\Feature;

use App\Filament\Widgets\LatestLeads;
use App\Filament\Widgets\LeadsChart;
use App\Filament\Widgets\LeadsOverview;
use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::where('email', 'admin@photofixzone.com')->firstOrFail());

        QuoteRequest::create(['name' => 'Q', 'email' => 'q@x.com', 'phone' => '1', 'service_ids' => [1, 2], 'budget' => '$100', 'message' => 'hi', 'status' => 'new', 'ip' => '127.0.0.1']);
        ContactMessage::create(['name' => 'C', 'email' => 'c@x.com', 'subject' => 'Hey', 'message' => 'hello', 'status' => 'new', 'ip' => '127.0.0.1']);
        FreeTrialRequest::create(['name' => 'T', 'email' => 't@x.com', 'file_link' => 'https://x.io/f', 'num_images' => '3', 'delivery_timeline' => '48h', 'services' => ['Clipping Path'], 'requirements' => 'r', 'status' => 'new', 'ip' => '127.0.0.1']);
    }

    public function test_dashboard_renders_with_all_lead_widgets(): void
    {
        $this->get('/admin')->assertSuccessful();

        Livewire::test(LeadsOverview::class)->assertOk();
        Livewire::test(LeadsChart::class)->assertOk();
        Livewire::test(LatestLeads::class)
            ->assertOk()
            ->assertSee('Q')
            ->assertSee('C')
            ->assertSee('T')
            ->assertSee('Open');
    }

    public function test_latest_leads_feed_is_merged_and_sorted(): void
    {
        $leads = (new LatestLeads())->getLeads();

        $this->assertNotEmpty($leads);
        $this->assertEqualsCanonicalizing(
            ['Quote', 'Contact', 'Free trial'],
            collect($leads)->pluck('type')->unique()->values()->all(),
        );
        // newest first
        $times = collect($leads)->pluck('at');
        $this->assertTrue($times->first()->greaterThanOrEqualTo($times->last()));
    }
}
