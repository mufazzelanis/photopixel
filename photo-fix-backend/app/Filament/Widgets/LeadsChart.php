<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\QuoteRequest;
use Filament\Widgets\ChartWidget;

class LeadsChart extends ChartWidget
{
    protected static ?string $heading = 'Leads — last 14 days';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '220px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $days = 14;
        $labels = [];
        $quote = [];
        $contact = [];
        $trial = [];

        $q = $this->countByDay(QuoteRequest::class, $days);
        $c = $this->countByDay(ContactMessage::class, $days);
        $t = $this->countByDay(FreeTrialRequest::class, $days);

        foreach (range($days - 1, 0) as $i) {
            $date = now()->subDays($i);
            $key = $date->toDateString();
            $labels[] = $date->format('M j');
            $quote[] = $q[$key] ?? 0;
            $contact[] = $c[$key] ?? 0;
            $trial[] = $t[$key] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Quote requests',
                    'data' => $quote,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245,158,11,0.12)',
                    'tension' => 0.35,
                    'fill' => true,
                ],
                [
                    'label' => 'Contact messages',
                    'data' => $contact,
                    'borderColor' => '#6c4cf1',
                    'backgroundColor' => 'rgba(108,76,241,0.12)',
                    'tension' => 0.35,
                    'fill' => true,
                ],
                [
                    'label' => 'Free trial requests',
                    'data' => $trial,
                    'borderColor' => '#2f6bff',
                    'backgroundColor' => 'rgba(47,107,255,0.12)',
                    'tension' => 0.35,
                    'fill' => true,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
            ],
        ];
    }

    /** @return array<string,int> date-string => count */
    private function countByDay(string $model, int $days): array
    {
        return $model::query()
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->get(['created_at'])
            ->groupBy(fn ($r) => $r->created_at->toDateString())
            ->map->count()
            ->all();
    }
}
