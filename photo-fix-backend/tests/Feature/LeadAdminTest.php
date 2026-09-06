<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Filament\Resources\FreeTrialRequestResource\Pages\ListFreeTrialRequests;
use App\Filament\Resources\QuoteRequestResource\Pages\ListQuoteRequests;
use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LeadAdminTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::where('email', 'admin@photofixzone.com')->firstOrFail());
    }

    public function test_quote_view_and_edit_render_with_all_data(): void
    {
        $lead = QuoteRequest::create([
            'name' => 'Mufazzel', 'email' => 'm@ibos.io', 'phone' => '01518303867',
            'company' => 'Ibos', 'service_ids' => [1, 2, 3],
            'file_link' => 'https://gitlab.ibos.io/x', 'message' => 'Test project',
            'status' => 'new', 'ip' => '127.0.0.1', 'source' => 'http://localhost:5173/',
        ]);

        Livewire::test(ListQuoteRequests::class)
            ->mountTableAction('view', $lead)
            ->assertHasNoTableActionErrors()
            ->assertSee('Clipping Path')
            ->assertSee('Photo Retouching')
            ->assertSee('https://gitlab.ibos.io/x')
            ->assertSee('Test project');

        Livewire::test(ListQuoteRequests::class)
            ->mountTableAction('edit', $lead)
            ->assertHasNoTableActionErrors();

        Livewire::test(\App\Filament\Resources\QuoteRequestResource\Pages\EditQuoteRequest::class, ['record' => $lead->id])
            ->assertOk()
            ->assertSee('Ibos')            // company
            ->assertSee('Clipping Path')   // resolved service title
            ->assertSee('Photo Retouching')
            ->assertSee('https://gitlab.ibos.io/x')
            ->assertSee('Test project')
            ->assertSee('Came from');
    }

    public function test_contact_and_free_trial_views_render(): void
    {
        $contact = ContactMessage::create([
            'name' => 'A', 'email' => 'a@b.com', 'phone' => '123', 'subject' => 'Hi',
            'message' => 'Hello there', 'status' => 'new', 'ip' => '127.0.0.1',
        ]);
        $trial = FreeTrialRequest::create([
            'name' => 'B', 'email' => 'b@c.com', 'file_link' => 'https://x.io/f',
            'num_images' => '5', 'requirements' => 'Cut out', 'status' => 'new', 'ip' => '127.0.0.1',
        ]);

        Livewire::test(ListContactMessages::class)
            ->mountTableAction('view', $contact)
            ->assertHasNoTableActionErrors()
            ->assertSee('Hello there');

        Livewire::test(ListFreeTrialRequests::class)
            ->mountTableAction('view', $trial)
            ->assertHasNoTableActionErrors()
            ->assertSee('https://x.io/f');
    }

    public function test_free_trial_edit_page_shows_every_submitted_field(): void
    {
        $trial = FreeTrialRequest::create([
            'name' => 'Azad', 'email' => 'azad@x.com', 'phone' => '01711', 'country' => 'Bangladesh',
            'delivery_timeline' => '1-2 days', 'file_format' => 'PNG', 'how_found' => 'Google Search',
            'services' => ['Image Masking', 'Photo Retouch'], 'file_link' => 'https://drive.example/abc',
            'num_images' => '5', 'requirements' => 'clean up the edges please', 'trial_type' => 'photo',
            'status' => 'new', 'ip' => '127.0.0.1',
        ]);
        $trial->addMedia(\Illuminate\Http\UploadedFile::fake()->image('s1.jpg'))->toMediaCollection('samples');

        Livewire::test(\App\Filament\Resources\FreeTrialRequestResource\Pages\EditFreeTrialRequest::class, ['record' => $trial->id])
            ->assertOk()
            ->assertSee('Bangladesh')
            ->assertSee('1-2 days')
            ->assertSee('PNG')
            ->assertSee('Google Search')
            ->assertSee('Image Masking, Photo Retouch')
            ->assertSee('https://drive.example/abc')
            ->assertSee('clean up the edges please')
            ->assertSee('Uploaded sample images')
            ->assertSee('ftz-gallery', false)  // blade gallery rendered
            ->assertSee('download="', false)   // per-image download link
            ->assertSee('ftz-btn', false);
    }
}
