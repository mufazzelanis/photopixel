<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\AboutFeatureResource\Pages;
use App\Models\AboutFeature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutFeatureResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = AboutFeature::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationGroup = 'About Page';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Feature Cards';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Textarea::make('body')->rows(4)->columnSpanFull(),
            Forms\Components\TextInput::make('icon')->helperText('Icon key, e.g. users, bolt, badge-check, truck, star, headset.'),
            Forms\Components\ColorPicker::make('header_color')->default('#2F6BFF'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ColorColumn::make('header_color'),
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
            'index' => Pages\ListAboutFeatures::route('/'),
            'create' => Pages\CreateAboutFeature::route('/create'),
            'edit' => Pages\EditAboutFeature::route('/{record}/edit'),
        ];
    }
}
