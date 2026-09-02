<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UploadServerResource\Pages;
use App\Models\UploadServer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UploadServerResource extends Resource
{
    protected static ?string $model = UploadServer::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Upload Servers';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('url')->url()->required(),
            Forms\Components\TextInput::make('icon')->helperText('e.g. wetransfer, dropbox'),
            Forms\Components\Select::make('button_style')->options(['primary' => 'Primary', 'outline' => 'Outline'])->default('primary'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('url')->limit(40),
                Tables\Columns\TextColumn::make('button_style')->badge(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUploadServers::route('/'),
            'create' => Pages\CreateUploadServer::route('/create'),
            'edit' => Pages\EditUploadServer::route('/{record}/edit'),
        ];
    }
}
