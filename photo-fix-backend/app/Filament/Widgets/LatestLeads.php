<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\FreeTrialRequestResource;
use App\Filament\Resources\QuoteRequestResource;
use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\QuoteRequest;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

/**
 * One chronological feed of the newest quote / contact / free-trial
 * submissions, so the admin sees "who needs a reply" the moment they log in.
 * The status of each row can be changed inline.
 */
class LatestLeads extends Widget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.latest-leads';

    protected static bool $isLazy = false;

    /** kind => [model, statuses] */
    private const KINDS = [
        'quote' => [QuoteRequest::class, QuoteRequest::STATUSES],
        'contact' => [ContactMessage::class, ContactMessage::STATUSES],
        'trial' => [FreeTrialRequest::class, FreeTrialRequest::STATUSES],
    ];

    public function getLeads(): array
    {
        $quotes = QuoteRequest::query()->latest()->take(8)->get()->map(fn (QuoteRequest $r) => [
            'kind' => 'quote',
            'id' => $r->id,
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
            'statuses' => QuoteRequest::STATUSES,
            'at' => $r->created_at,
            'url' => QuoteRequestResource::getUrl('edit', ['record' => $r]),
        ]);

        $contacts = ContactMessage::query()->latest()->take(8)->get()->map(fn (ContactMessage $r) => [
            'kind' => 'contact',
            'id' => $r->id,
            'type' => 'Contact',
            'color' => 'primary',
            'name' => $r->name,
            'email' => $r->email,
            'phone' => $r->phone,
            'detail' => collect([$r->subject, $r->message ? Str::limit($r->message, 50) : null])->filter()->join(' · ') ?: '—',
            'status' => $r->status,
            'statuses' => ContactMessage::STATUSES,
            'at' => $r->created_at,
            'url' => ContactMessageResource::getUrl('edit', ['record' => $r]),
        ]);

        $trials = FreeTrialRequest::query()->latest()->take(8)->get()->map(fn (FreeTrialRequest $r) => [
            'kind' => 'trial',
            'id' => $r->id,
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
            'statuses' => FreeTrialRequest::STATUSES,
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

    /** Inline status change straight from the dashboard feed. */
    public function setStatus(string $kind, int $id, string $status): void
    {
        if (! isset(self::KINDS[$kind])) {
            return;
        }

        [$model, $allowed] = self::KINDS[$kind];

        if (! in_array($status, $allowed, true)) {
            return;
        }

        $record = $model::find($id);

        if (! $record || $record->status === $status) {
            return;
        }

        $record->update(['status' => $status]);

        Notification::make()
            ->title("{$record->name} → ".ucfirst($status))
            ->success()
            ->send();

        // keep the KPI cards / chart in sync
        $this->dispatch('lead-status-changed');
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
