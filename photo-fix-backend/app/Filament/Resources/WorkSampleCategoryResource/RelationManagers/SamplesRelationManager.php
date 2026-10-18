<?php

namespace App\Filament\Resources\WorkSampleCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SamplesRelationManager extends RelationManager
{
    protected static string $relationship = 'samples';

    protected static ?string $title = 'Work samples';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('combined')->collection('combined')->image()->maxSize(20480)
                ->label('Single Before/After Image')
                ->helperText(
                    'Upload ONE square image with Before on the left half and After on the right half, split exactly down the middle. '
                    . 'Recommended size: 1600×1600px (minimum 1200×1200px). A square image fills the card perfectly on both desktop and '
                    . 'mobile — the card is always a perfect square, so this one size works everywhere, no separate mobile version needed. '
                    . 'Upload this OR the two separate photos below — not both. JPG or PNG, max 20MB.'
                ),
            SpatieMediaLibraryFileUpload::make('before')->collection('before')->image()->maxSize(20480)->helperText('Max 20MB.'),
            SpatieMediaLibraryFileUpload::make('after')->collection('after')->image()->maxSize(20480)->helperText('Max 20MB.'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('combined')->collection('combined')->square()->label('Combined'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('before')->collection('before')->square()->label('Before'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('after')->collection('after')->square()->label('After'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
