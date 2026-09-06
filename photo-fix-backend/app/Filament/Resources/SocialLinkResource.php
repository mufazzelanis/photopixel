<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\SocialLinkResource\Pages;
use App\Models\SocialLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialLinkResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = SocialLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Social Links';

    protected static ?string $recordTitleAttribute = 'platform';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('platform')->required(),
            Forms\Components\TextInput::make('url')->url()->default('#')
                ->helperText('WhatsApp: https://wa.me/8801XXXXXXXXX · Telegram: https://t.me/username · Messenger: https://m.me/page'),
            Forms\Components\Select::make('icon')
                ->options([
                    'whatsapp' => 'WhatsApp', 'telegram' => 'Telegram', 'messenger' => 'Messenger',
                    'wechat' => 'WeChat', 'viber' => 'Viber', 'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn', 'instagram' => 'Instagram', 'x' => 'X (Twitter)',
                    'youtube' => 'YouTube', 'tiktok' => 'TikTok', 'pinterest' => 'Pinterest',
                    'discord' => 'Discord', 'phone' => 'Phone', 'mail' => 'Email', 'star' => 'Trustpilot / review',
                ])
                ->native(false)->searchable()
                ->helperText('Controls the icon and brand colour shown in the footer and the floating chat widget.'),
            Forms\Components\Toggle::make('is_active')->default(true)
                ->helperText('Show this link anywhere on the site.'),
            Forms\Components\Toggle::make('show_in_widget')->default(true)
                ->label('Show in the floating chat widget')
                ->helperText('The button that pops open in the bottom-right corner of the site.'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('platform')->weight('bold'),
                Tables\Columns\TextColumn::make('url')->limit(40),
                Tables\Columns\TextColumn::make('icon')->badge(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
                Tables\Columns\ToggleColumn::make('show_in_widget')->label('Widget'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialLinks::route('/'),
            'create' => Pages\CreateSocialLink::route('/create'),
            'edit' => Pages\EditSocialLink::route('/{record}/edit'),
        ];
    }
}
