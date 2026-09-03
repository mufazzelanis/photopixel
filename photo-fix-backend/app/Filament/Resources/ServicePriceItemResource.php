<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;
use App\Filament\Resources\ServicePriceItemResource\Pages;
use App\Models\Service;
use App\Models\ServicePriceItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServicePriceItemResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = ServicePriceItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Pricing';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'All Price Rows';

    protected static ?string $modelLabel = 'price row';

    protected static ?string $recordTitleAttribute = 'label';

    protected static array $globalSearch = ['label', 'price'];

    protected static array $globalSearchDetails = ['Service' => 'service.title', 'Price' => 'price'];

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('service_id')
                ->label('Service')
                ->options(fn () => Service::query()->orderBy('sort_order')->pluck('title', 'id'))
                ->searchable()
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('label')->required()->columnSpanFull()
                ->helperText('e.g. "Basic Clipping Path (simple shape)"'),
            Forms\Components\TextInput::make('price')->required()->helperText('e.g. $0.39'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultGroup('service.title')
            ->groups([
                Tables\Grouping\Group::make('service.title')->label('Service')->collapsible(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('label')->wrap()->searchable(),
                Tables\Columns\TextInputColumn::make('price')->rules(['required', 'max:40']),
                Tables\Columns\TextColumn::make('service.title')->label('Service')->badge()->color('gray')
                    ->toggleable()->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Service')
                    ->options(fn () => Service::query()->orderBy('sort_order')->pluck('title', 'id')),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicePriceItems::route('/'),
            'create' => Pages\CreateServicePriceItem::route('/create'),
            'edit' => Pages\EditServicePriceItem::route('/{record}/edit'),
        ];
    }
}
