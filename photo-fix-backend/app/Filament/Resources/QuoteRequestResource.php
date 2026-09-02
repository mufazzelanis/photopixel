<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Models\QuoteRequest;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Leads';

    protected static ?string $navigationLabel = 'Quote Requests';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) QuoteRequest::where('status', 'new')->count() ?: null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    protected static function statusColor(?string $state): string
    {
        return match ($state) {
            'new' => 'warning',
            'contacted' => 'info',
            'won' => 'success',
            'lost' => 'danger',
            default => 'gray',
        };
    }

    /** Resolve the submitted service ids to their titles. */
    public static function serviceTitles(QuoteRequest $record): array
    {
        $ids = $record->service_ids ?: [];

        return $ids ? Service::whereIn('id', $ids)->orderBy('sort_order')->pluck('title')->all() : [];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Contact')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('name')->weight('bold'),
                    Infolists\Components\TextEntry::make('email')->copyable()->icon('heroicon-m-envelope')
                        ->url(fn ($state) => "mailto:$state"),
                    Infolists\Components\TextEntry::make('phone')->copyable()->icon('heroicon-m-phone')
                        ->url(fn ($state) => $state ? 'tel:'.preg_replace('/\s+/', '', $state) : null)
                        ->placeholder('—'),
                    Infolists\Components\TextEntry::make('company')->placeholder('—'),
                ]),

            Infolists\Components\Section::make('Request')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('services')
                        ->label('Services requested')
                        ->state(fn (QuoteRequest $record) => static::serviceTitles($record))
                        ->badge()
                        ->color('primary')
                        ->placeholder('None selected')
                        ->columnSpanFull(),
                    Infolists\Components\TextEntry::make('file_link')
                        ->label('File link')
                        ->url(fn ($state) => $state)
                        ->openUrlInNewTab()
                        ->color('primary')
                        ->icon('heroicon-m-link')
                        ->placeholder('—'),
                    Infolists\Components\TextEntry::make('budget')->placeholder('—'),
                    Infolists\Components\TextEntry::make('message')
                        ->label('Project details')
                        ->placeholder('—')
                        ->columnSpanFull()
                        ->prose(),
                ]),

            Infolists\Components\Section::make('Meta')
                ->columns(3)
                ->collapsed()
                ->schema([
                    Infolists\Components\TextEntry::make('status')->badge()->color(fn ($state) => static::statusColor($state)),
                    Infolists\Components\TextEntry::make('created_at')->label('Submitted')->dateTime('M j, Y g:i a'),
                    Infolists\Components\TextEntry::make('ip')->label('IP address')->placeholder('—'),
                    Infolists\Components\TextEntry::make('source')->label('Came from')->placeholder('—')->columnSpanFull(),
                    Infolists\Components\TextEntry::make('admin_note')->placeholder('—')->columnSpanFull(),
                ]),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('summary')
                ->label('Lead')
                ->content(fn (QuoteRequest $r) => "{$r->name} · {$r->email}".($r->phone ? " · {$r->phone}" : '')),
            Forms\Components\Placeholder::make('services')
                ->label('Services requested')
                ->content(fn (QuoteRequest $r) => implode(', ', static::serviceTitles($r)) ?: '—'),
            Forms\Components\Placeholder::make('file_link')
                ->label('File link')
                ->content(fn (QuoteRequest $r) => $r->file_link
                    ? new \Illuminate\Support\HtmlString('<a class="text-primary-600 underline" target="_blank" href="'.e($r->file_link).'">'.e($r->file_link).'</a>')
                    : '—'),
            Forms\Components\Placeholder::make('message')
                ->label('Project details')
                ->content(fn (QuoteRequest $r) => $r->message ?: '—')
                ->columnSpanFull(),
            Forms\Components\Select::make('status')
                ->options(array_combine(QuoteRequest::STATUSES, QuoteRequest::STATUSES))
                ->required()
                ->native(false),
            Forms\Components\Textarea::make('admin_note')->rows(4)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Received')->dateTime('M j, g:i a')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold')
                    ->description(fn (QuoteRequest $r) => $r->company),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable()->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('phone')->toggleable()->copyable(),
                Tables\Columns\TextColumn::make('services')
                    ->badge()
                    ->color('primary')
                    ->state(fn (QuoteRequest $r) => static::serviceTitles($r))
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('file_link')->label('File')->boolean()
                    ->trueIcon('heroicon-o-link')->falseIcon('heroicon-o-minus-small')
                    ->url(fn (QuoteRequest $r) => $r->file_link)->openUrlInNewTab(),
                Tables\Columns\SelectColumn::make('status')
                    ->options(array_combine(QuoteRequest::STATUSES, QuoteRequest::STATUSES)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(array_combine(QuoteRequest::STATUSES, QuoteRequest::STATUSES)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuoteRequests::route('/'),
            'edit' => Pages\EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
