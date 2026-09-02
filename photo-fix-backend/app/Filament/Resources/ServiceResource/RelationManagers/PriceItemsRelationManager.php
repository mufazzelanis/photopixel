<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PriceItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'priceItems';

    protected static ?string $title = 'Pricing table (/pricing page)';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')->required()->columnSpan(2),
            Forms\Components\TextInput::make('price')->required()->helperText('e.g. $0.39')->columnSpan(1),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ])->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('label')->wrap(),
                Tables\Columns\TextColumn::make('price')->badge()->color('success'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
