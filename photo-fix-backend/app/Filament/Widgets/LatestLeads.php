<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\FreeTrialRequestResource;
use App\Filament\Resources\QuoteRequestResource;
use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\QuoteRequest;
use Illuminate\Support\Str;
use Filament\Widgets\Widget;

/**
 * One chronological feed of the newest quote / contact / free-trial
 * submissions, so the admin sees "who needs a reply" the moment they log in.
 */
class LatestLeads extends Widget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.latest-leads';

    protected static bool $isLazy = false;

    public function getLeads(): array
    {
        $quotes = QuoteRequest::query()->latest()->take(8)->get()->map(fn (QuoteRequest $r) => [
            'type' => 'Quote',
            'color' => 'warning',
            'name' => $r->name,
            'email' => $r->email,
            'phone' => $r->phone,
            'detail' => collect([
                $r->budget,
                is_array($r->service_ids) && $r->service_ids ? count($r->service_ids).' service(s)' : null,
                $r->message ? Str::limit($r->message, 50) : null,
            ])->filter()->join(' · ') ?: '—',
            'status' => $r->status,
            'at' => $r->created_at,
            'url' => QuoteRequestResource::getUrl('edit', ['record' => $r]),
        ]);

        $contacts = ContactMessage::query()->latest()->take(8)->get()->map(fn (ContactMessage $r) => [
            'type' => 'Contact',
            'color' => 'primary',
            'name' => $r->name,
            'email' => $r->email,
            'phone' => $r->phone,
            'detail' => collect([$r->subject, $r->message ? Str::limit($r->message, 50) : null])->filter()->join(' · ') ?: '—',
            'status' => $r->status,
            'at' => $r->created_at,
            'url' => ContactMessageResource::getUrl('edit', ['record' => $r]),
        ]);

        $trials = FreeTrialRequest::query()->latest()->take(8)->get()->map(fn (FreeTrialRequest $r) => [
            'type' => 'Free trial',
            'color' => 'info',
            'name' => $r->name,
            'email' => $r->email,
            'phone' => $r->phone,
            'detail' => collect([
                $r->num_images ? $r->num_images.' images' : null,
                $r->delivery_timeline,
                is_array($r->services) && $r->services ? implode(', ', array_slice($r->services, 0, 2)) : null,
            ])->filter()->join(' · ') ?: '—',
            'status' => $r->status,
            'at' => $r->created_at,
            'url' => FreeTrialRequestResource::getUrl('edit', ['record' => $r]),
        ]);

        return $quotes
            ->concat($contacts)
            ->concat($trials)
            ->sortByDesc('at')
            ->take(10)
            ->values()
            ->all();
    }

    public static function statusColor(string $status): string
    {
        return match ($status) {
            'new' => 'warning',
            'won', 'delivered', 'replied' => 'success',
            'lost', 'closed' => 'danger',
            default => 'gray',
        };
    }
}
