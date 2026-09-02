<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeTrialRequestResource\Pages;
use App\Models\FreeTrialRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FreeTrialRequestResource extends Resource
{
    protected static ?string $model = FreeTrialRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Leads';

    protected static ?string $navigationLabel = 'Free Trial Requests';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return (string) FreeTrialRequest::where('status', 'new')->count() ?: null;
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
            'delivered' => 'success',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Contact')->columns(2)->schema([
                Infolists\Components\TextEntry::make('name')->weight('bold'),
                Infolists\Components\TextEntry::make('email')->copyable()->icon('heroicon-m-envelope')
                    ->url(fn ($state) => "mailto:$state"),
                Infolists\Components\TextEntry::make('phone')->copyable()->icon('heroicon-m-phone')
                    ->url(fn ($state) => $state ? 'tel:'.preg_replace('/\s+/', '', $state) : null)
                    ->placeholder('—'),
                Infolists\Components\TextEntry::make('country')->placeholder('—'),
            ]),

            Infolists\Components\Section::make('Request')->columns(2)->schema([
                Infolists\Components\TextEntry::make('trial_type')->badge()->placeholder('photo'),
                Infolists\Components\TextEntry::make('delivery_timeline')->label('Delivery timeline')->placeholder('—'),
                Infolists\Components\TextEntry::make('file_format')->label('Required format')->placeholder('—'),
                Infolists\Components\TextEntry::make('how_found')->label('Found us via')->placeholder('—'),
                Infolists\Components\TextEntry::make('services')
                    ->badge()->color('primary')
                    ->placeholder('None selected')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('file_link')
                    ->label('File link')
                    ->url(fn ($state) => $state)->openUrlInNewTab()
                    ->color('primary')->icon('heroicon-m-link')->placeholder('—')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('requirements')
                    ->label('Editing instructions')
                    ->placeholder('—')->columnSpanFull()->prose(),
            ]),

            Infolists\Components\Section::make('Sample images')
                ->schema([
                    Infolists\Components\SpatieMediaLibraryImageEntry::make('samples')
                        ->collection('samples')
                        ->conversion('thumb')
                        ->hiddenLabel()
                        ->columnSpanFull(),
                ])
                ->visible(fn (FreeTrialRequest $record) => $record->getMedia('samples')->isNotEmpty()),

            Infolists\Components\Section::make('Meta')->columns(3)->collapsed()->schema([
                Infolists\Components\TextEntry::make('status')->badge()->color(fn ($state) => static::statusColor($state)),
                Infolists\Components\TextEntry::make('created_at')->label('Received')->dateTime('M j, Y g:i a'),
                Infolists\Components\TextEntry::make('ip')->label('IP address')->placeholder('—'),
            ]),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('contact')
                ->content(fn (FreeTrialRequest $r) => "{$r->name} · {$r->email}".($r->phone ? " · {$r->phone}" : '')),
            Forms\Components\Placeholder::make('services')
                ->content(fn (FreeTrialRequest $r) => implode(', ', (array) $r->services) ?: '—'),
            Forms\Components\Placeholder::make('requirements')
                ->label('Instructions')
                ->content(fn (FreeTrialRequest $r) => $r->requirements ?: '—')
                ->columnSpanFull(),
            Forms\Components\Select::make('status')
                ->options(array_combine(FreeTrialRequest::STATUSES, FreeTrialRequest::STATUSES))
                ->required()->native(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Received')->dateTime('M j, g:i a')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold')
                    ->description(fn (FreeTrialRequest $record) => $record->country),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable()->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('trial_type')->badge(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('samples')->collection('samples')
                    ->conversion('thumb')->circular()->stacked()->limit(3)->label('Samples'),
                Tables\Columns\SelectColumn::make('status')
                    ->options(array_combine(FreeTrialRequest::STATUSES, FreeTrialRequest::STATUSES)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(array_combine(FreeTrialRequest::STATUSES, FreeTrialRequest::STATUSES)),
                Tables\Filters\SelectFilter::make('trial_type')->options(['photo' => 'Photo', 'video' => 'Video']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFreeTrialRequests::route('/'),
            'edit' => Pages\EditFreeTrialRequest::route('/{record}/edit'),
        ];
    }
}
