<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\AboutPartnershipPointResource\Pages;
use App\Models\AboutPartnershipPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutPartnershipPointResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = AboutPartnershipPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'About Page';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Partnership Points';

    protected static ?string $recordTitleAttribute = 'text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('text')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('icon')->helperText('Icon key, e.g. badge-check, globe, truck, credit-card, chart.'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#'),
                Tables\Columns\TextColumn::make('text')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('icon')->badge(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutPartnershipPoints::route('/'),
            'create' => Pages\CreateAboutPartnershipPoint::route('/create'),
            'edit' => Pages\EditAboutPartnershipPoint::route('/{record}/edit'),
        ];
    }
}
