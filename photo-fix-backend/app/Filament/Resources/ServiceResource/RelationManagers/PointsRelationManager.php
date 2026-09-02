<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PointsRelationManager extends RelationManager
{
    protected static string $relationship = 'points';

    protected static ?string $title = 'Bullet points';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('text')->required()->maxLength(255)->columnSpanFull(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#'),
                Tables\Columns\TextColumn::make('text')->wrap(),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }
}
