<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkSampleResource\Pages;
use App\Models\WorkSample;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkSampleResource extends Resource
{
    protected static ?string $model = WorkSample::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Work Samples';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title'),
            Forms\Components\TextInput::make('category')->helperText('e.g. Retouching, Color Correction'),
            SpatieMediaLibraryFileUpload::make('before')->collection('before')->image()->imageEditor(),
            SpatieMediaLibraryFileUpload::make('after')->collection('after')->image()->imageEditor(),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('before')->collection('before')->square()->label('Before'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('after')->collection('after')->square()->label('After'),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category')->badge(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkSamples::route('/'),
            'create' => Pages\CreateWorkSample::route('/create'),
            'edit' => Pages\EditWorkSample::route('/{record}/edit'),
        ];
    }
}
