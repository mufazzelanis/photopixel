<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\NewsletterSubscriber;
use App\Models\QuoteRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newQuotes = QuoteRequest::where('status', 'new')->count();
        $weekQuotes = QuoteRequest::where('created_at', '>=', now()->subWeek())->count();

        return [
            Stat::make('New quote requests', $newQuotes)
                ->description($weekQuotes.' in the last 7 days')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($newQuotes > 0 ? 'warning' : 'success'),

            Stat::make('Unread contact messages', ContactMessage::where('status', 'new')->count())
                ->color('primary'),

            Stat::make('Free trial requests', FreeTrialRequest::where('status', 'new')->count())
                ->color('info'),

            Stat::make('Newsletter subscribers', NewsletterSubscriber::whereNull('unsubscribed_at')->count())
                ->color('gray'),
        ];
    }
}
