<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\StatResource\Pages;
use App\Models\Stat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StatResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = Stat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 13;

    protected static ?string $navigationLabel = 'Magnificent Numbers';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\TextInput::make('value_number')->numeric()->required()->helperText('e.g. 2.4 with suffix "M" renders 2.4M'),
            Forms\Components\TextInput::make('value_prefix')->maxLength(8),
            Forms\Components\TextInput::make('value_suffix')->maxLength(8),
            Forms\Components\TextInput::make('icon')->helperText('e.g. file-check, layers, folder-check, users'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('value_number')->label('Value')
                    ->formatStateUsing(fn ($state, Stat $r) => $r->value_prefix.rtrim(rtrim((string) $state, '0'), '.').$r->value_suffix),
                Tables\Columns\TextColumn::make('label')->searchable()->weight('bold'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStats::route('/'),
            'create' => Pages\CreateStat::route('/create'),
            'edit' => Pages\EditStat::route('/{record}/edit'),
        ];
    }
}
