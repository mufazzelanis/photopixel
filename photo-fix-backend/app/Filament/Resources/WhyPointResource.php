<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\WhyPointResource\Pages;
use App\Models\WhyPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WhyPointResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = WhyPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Why Us — Points';

    protected static ?string $recordTitleAttribute = 'text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('text')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#'),
                Tables\Columns\TextColumn::make('text')->wrap(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhyPoints::route('/'),
            'create' => Pages\CreateWhyPoint::route('/create'),
            'edit' => Pages\EditWhyPoint::route('/{record}/edit'),
        ];
    }
}
