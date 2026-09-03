<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\FooterColumnResource\Pages;
use App\Filament\Resources\FooterColumnResource\RelationManagers\LinksRelationManager;
use App\Models\FooterColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterColumnResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = FooterColumn::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Footer Columns';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('title')->weight('bold'),
                Tables\Columns\TextColumn::make('links_count')->counts('links')->label('Links'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [LinksRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFooterColumns::route('/'),
            'create' => Pages\CreateFooterColumn::route('/create'),
            'edit' => Pages\EditFooterColumn::route('/{record}/edit'),
        ];
    }
}
