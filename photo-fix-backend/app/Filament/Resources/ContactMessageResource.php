<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    use GloballySearchable;

    protected static ?string $recordTitleAttribute = 'name';

    protected static array $globalSearch = ['name', 'email', 'phone', 'subject', 'message'];

    protected static array $globalSearchDetails = ['Email' => 'email', 'Subject' => 'subject', 'Status' => 'status'];


    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Leads';

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return (string) ContactMessage::where('status', 'new')->count() ?: null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    protected static function statusColor(?string $state): string
    {
        return match ($state) {
            'new' => 'warning',
            'read' => 'info',
            'replied' => 'success',
            default => 'gray',
        };
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('From')->columns(2)->schema([
                Infolists\Components\TextEntry::make('name')->weight('bold'),
                Infolists\Components\TextEntry::make('email')->copyable()->icon('heroicon-m-envelope')
                    ->url(fn ($state) => "mailto:$state"),
                Infolists\Components\TextEntry::make('phone')->copyable()->icon('heroicon-m-phone')
                    ->url(fn ($state) => $state ? 'tel:'.preg_replace('/\s+/', '', $state) : null)
                    ->placeholder('—'),
                Infolists\Components\TextEntry::make('subject')->placeholder('—'),
            ]),
            Infolists\Components\Section::make('Message')->schema([
                Infolists\Components\TextEntry::make('message')->hiddenLabel()->prose(),
            ]),
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
            Forms\Components\Placeholder::make('from')
                ->content(fn (ContactMessage $r) => "{$r->name} · {$r->email}".($r->phone ? " · {$r->phone}" : '')),
            Forms\Components\Placeholder::make('subject')->content(fn (ContactMessage $r) => $r->subject ?: '—'),
            Forms\Components\Placeholder::make('message')
                ->content(fn (ContactMessage $r) => $r->message)
                ->columnSpanFull(),
            Forms\Components\Select::make('status')
                ->options(array_combine(ContactMessage::STATUSES, ContactMessage::STATUSES))
                ->required()->native(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Received')->dateTime('M j, g:i a')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable()->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('subject')->limit(40)->toggleable(),
                Tables\Columns\TextColumn::make('message')->limit(50)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\SelectColumn::make('status')
                    ->options(array_combine(ContactMessage::STATUSES, ContactMessage::STATUSES)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(array_combine(ContactMessage::STATUSES, ContactMessage::STATUSES)),
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
            'index' => Pages\ListContactMessages::route('/'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
