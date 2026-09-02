<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientTypeResource\Pages;
use App\Models\ClientType;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientTypeResource extends Resource
{
    protected static ?string $model = ClientType::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Top-Tier Clients';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Textarea::make('body')->rows(4)->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('image')->collection('image')->image()->imageEditor(),
            Forms\Components\TextInput::make('link_label')->default('Learn more'),
            Forms\Components\TextInput::make('link_url'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')->collection('image')->square(),
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
            'index' => Pages\ListClientTypes::route('/'),
            'create' => Pages\CreateClientType::route('/create'),
            'edit' => Pages\EditClientType::route('/{record}/edit'),
        ];
    }
}
