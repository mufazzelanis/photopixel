<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValueCardResource\Pages;
use App\Models\ValueCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ValueCardResource extends Resource
{
    protected static ?string $model = ValueCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Value Cards';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Textarea::make('body')->rows(4)->columnSpanFull(),
            Forms\Components\TextInput::make('icon')->helperText('Icon key, e.g. chart, truck, wallet, headset.'),
            Forms\Components\ColorPicker::make('header_color')->required()->default('#EC4899'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ColorColumn::make('header_color'),
                Tables\Columns\TextColumn::make('title')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('body')->limit(60)->toggleable(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValueCards::route('/'),
            'create' => Pages\CreateValueCard::route('/create'),
            'edit' => Pages\EditValueCard::route('/{record}/edit'),
        ];
    }
}
