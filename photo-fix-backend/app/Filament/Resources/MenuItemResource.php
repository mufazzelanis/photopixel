<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    use GloballySearchable;

    protected static array $globalSearch = ['label', 'url'];

    protected static array $globalSearchDetails = ['URL' => 'url'];


    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Header Menu';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\TextInput::make('url')->default('#'),
            Forms\Components\Select::make('parent_id')
                ->label('Parent (for dropdown items)')
                ->options(fn () => MenuItem::whereNull('parent_id')->pluck('label', 'id'))
                ->searchable()->nullable(),
            Forms\Components\Select::make('target')->options(['_self' => 'Same tab', '_blank' => 'New tab'])->default('_self'),
            Forms\Components\Toggle::make('is_button')->label('Render as button (e.g. GET A QUOTE)'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('label')->description(fn (MenuItem $r) => $r->parent?->label ? '↳ under '.$r->parent->label : null)->weight('bold'),
                Tables\Columns\TextColumn::make('url')->color('gray'),
                Tables\Columns\IconColumn::make('is_button')->boolean(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
