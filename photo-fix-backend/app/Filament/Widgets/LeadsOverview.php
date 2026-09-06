<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\FreeTrialRequestResource;
use App\Filament\Resources\NewsletterSubscriberResource;
use App\Filament\Resources\QuoteRequestResource;
use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\NewsletterSubscriber;
use App\Models\QuoteRequest;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newQuotes = QuoteRequest::where('status', 'new')->count();
        $newContact = ContactMessage::where('status', 'new')->count();
        $newTrials = FreeTrialRequest::where('status', 'new')->count();

        return [
            Stat::make('New quote requests', $newQuotes)
                ->description(QuoteRequest::where('created_at', '>=', now()->subWeek())->count().' in the last 7 days')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart($this->dailyCounts(QuoteRequest::class))
                ->color($newQuotes > 0 ? 'warning' : 'success')
                ->url(QuoteRequestResource::getUrl('index')),

            Stat::make('Unread contact messages', $newContact)
                ->description(ContactMessage::where('created_at', '>=', now()->subWeek())->count().' in the last 7 days')
                ->descriptionIcon('heroicon-m-envelope')
                ->chart($this->dailyCounts(ContactMessage::class))
                ->color($newContact > 0 ? 'warning' : 'success')
                ->url(ContactMessageResource::getUrl('index')),

            Stat::make('New free trial requests', $newTrials)
                ->description(FreeTrialRequest::where('created_at', '>=', now()->subWeek())->count().' in the last 7 days')
                ->descriptionIcon('heroicon-m-gift')
                ->chart($this->dailyCounts(FreeTrialRequest::class))
                ->color($newTrials > 0 ? 'warning' : 'success')
                ->url(FreeTrialRequestResource::getUrl('index')),

            Stat::make('Newsletter subscribers', NewsletterSubscriber::whereNull('unsubscribed_at')->count())
                ->description(NewsletterSubscriber::where('created_at', '>=', now()->subWeek())->count().' new this week')
                ->descriptionIcon('heroicon-m-users')
                ->chart($this->dailyCounts(NewsletterSubscriber::class))
                ->color('gray')
                ->url(NewsletterSubscriberResource::getUrl('index')),
        ];
    }

    /** @return int[] one submission count per day for the last 7 days (oldest → newest) */
    private function dailyCounts(string $model, int $days = 7): array
    {
        /** @var Model $model */
        $byDay = $model::query()
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->get(['created_at'])
            ->groupBy(fn ($r) => $r->created_at->toDateString())
            ->map->count();

        return collect(range($days - 1, 0))
            ->map(fn ($i) => (int) ($byDay[now()->subDays($i)->toDateString()] ?? 0))
            ->all();
    }
}
