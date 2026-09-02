<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CtaBandResource\Pages;
use App\Models\CtaBand;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CtaBandResource extends Resource
{
    protected static ?string $model = CtaBand::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'CTA Bands';

    protected static ?string $recordTitleAttribute = 'heading';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('key')->required()->disabledOn('edit')
                ->helperText('Identifier the frontend references, e.g. cta_perfection.'),
            Forms\Components\TextInput::make('heading')->required()->columnSpanFull(),
            Forms\Components\Textarea::make('sub_text')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('btn_label'),
            Forms\Components\TextInput::make('btn_url'),
            Forms\Components\Select::make('bg_style')->options(['gradient' => 'Gradient', 'solid' => 'Solid', 'image' => 'Image'])->default('gradient'),
            SpatieMediaLibraryFileUpload::make('background')->collection('background')->image()->visible(fn (Forms\Get $get) => $get('bg_style') === 'image'),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('heading')->searchable()->wrap()->weight('bold'),
                Tables\Columns\TextColumn::make('bg_style')->badge(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCtaBands::route('/'),
            'create' => Pages\CreateCtaBand::route('/create'),
            'edit' => Pages\EditCtaBand::route('/{record}/edit'),
        ];
    }
}
