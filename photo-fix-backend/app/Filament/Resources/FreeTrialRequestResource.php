<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

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
    use GloballySearchable;

    protected static ?string $recordTitleAttribute = 'name';

    protected static array $globalSearch = ['name', 'email', 'phone', 'country', 'requirements'];

    protected static array $globalSearchDetails = ['Email' => 'email', 'Country' => 'country', 'Status' => 'status'];


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
                ->description(fn (FreeTrialRequest $record) => $record->getMedia('samples')->count()
                    .' file(s) — hover to download in the original format.')
                ->schema([
                    Infolists\Components\View::make('filament.resources.free-trial.samples-gallery')
                        ->viewData(fn (FreeTrialRequest $record) => ['media' => $record->getMedia('samples')])
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
        $ph = fn (string $name, ?string $label, \Closure $content) => Forms\Components\Placeholder::make($name)
            ->label($label ?? str($name)->headline())
            ->content($content);

        return $form->schema([
            Forms\Components\Section::make('Contact')->columns(2)->schema([
                $ph('name', 'Name', fn (FreeTrialRequest $r) => $r->name),
                $ph('email', 'Email', fn (FreeTrialRequest $r) => new \Illuminate\Support\HtmlString(
                    '<a class="text-primary-600 underline" href="mailto:'.e($r->email).'">'.e($r->email).'</a>')),
                $ph('phone', 'Phone', fn (FreeTrialRequest $r) => $r->phone ?: '—'),
                $ph('country', 'Country', fn (FreeTrialRequest $r) => $r->country ?: '—'),
            ]),

            Forms\Components\Section::make('Request')->columns(2)->schema([
                $ph('trial_type', 'Trial type', fn (FreeTrialRequest $r) => $r->trial_type ?: 'photo'),
                $ph('delivery_timeline', 'Delivery timeline', fn (FreeTrialRequest $r) => $r->delivery_timeline ?: '—'),
                $ph('file_format', 'Required file format', fn (FreeTrialRequest $r) => $r->file_format ?: '—'),
                $ph('how_found', 'Found us via', fn (FreeTrialRequest $r) => $r->how_found ?: '—'),
                $ph('services', 'Services requested', fn (FreeTrialRequest $r) => implode(', ', (array) $r->services) ?: '—')
                    ->columnSpanFull(),
                $ph('file_link', 'File link', fn (FreeTrialRequest $r) => $r->file_link
                    ? new \Illuminate\Support\HtmlString('<a class="text-primary-600 underline" target="_blank" href="'.e($r->file_link).'">'.e($r->file_link).'</a>')
                    : '—')->columnSpanFull(),
                $ph('requirements', 'Editing instructions', fn (FreeTrialRequest $r) => $r->requirements ?: '—')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Uploaded sample images')
                ->description(fn (FreeTrialRequest $r) => $r->getMedia('samples')->count()
                    .' file(s) — hover an image to download it in the exact format the customer sent.')
                ->schema([
                    Forms\Components\View::make('filament.resources.free-trial.samples-gallery')
                        ->viewData(fn (FreeTrialRequest $r) => ['media' => $r->getMedia('samples')])
                        ->columnSpanFull(),
                ])
                ->visible(fn (FreeTrialRequest $r) => $r->getMedia('samples')->isNotEmpty()),

            Forms\Components\Section::make('Manage')->schema([
                Forms\Components\Select::make('status')
                    ->options(array_combine(FreeTrialRequest::STATUSES, FreeTrialRequest::STATUSES))
                    ->required()->native(false),
            ]),
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
