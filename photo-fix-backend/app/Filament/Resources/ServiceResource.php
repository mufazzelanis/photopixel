<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers\PointsRelationManager;
use App\Filament\Resources\ServiceResource\RelationManagers\PriceItemsRelationManager;
use App\Models\Service;
use App\Models\WorkSampleCategory;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    use GloballySearchable;

    protected static array $globalSearch = ['title', 'slug', 'short_desc'];

    protected static array $globalSearchDetails = ['Slug' => 'slug', 'Starts at' => 'starting_price'];

    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Details')->columns(2)->schema([
                Forms\Components\TextInput::make('title')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set, string $operation) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('icon')->helperText('Icon key rendered on the frontend, e.g. scissors, layers, palette.'),
                Forms\Components\Select::make('work_sample_category_id')
                    ->label('Portfolio category')
                    ->helperText('Optional — shows that category\'s real "Work Samples" gallery on this service\'s page.')
                    ->options(fn () => WorkSampleCategory::query()->ordered()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('btn_label')->required()->default('More About'),
                Forms\Components\TextInput::make('btn_url')->helperText('Leave blank to link to /services/{slug}.'),
                Forms\Components\TextInput::make('starting_price')
                    ->helperText('e.g. $0.39 — add price items below to make this service appear on /pricing.'),
                Forms\Components\Textarea::make('short_desc')->rows(3)->columnSpanFull(),
                Forms\Components\RichEditor::make('long_desc')->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Before / After images')->columns(2)->schema([
                SpatieMediaLibraryFileUpload::make('before')->collection('before')->image()->imageEditor(),
                SpatieMediaLibraryFileUpload::make('after')->collection('after')->image()->imageEditor(),
                SpatieMediaLibraryFileUpload::make('gallery')->collection('gallery')->image()->multiple()->reorderable()->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Visibility & SEO')->columns(2)->schema([
                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\Toggle::make('is_featured')->default(true)->helperText('Show in the homepage services list.'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\TextInput::make('seo_title'),
                Forms\Components\Textarea::make('seo_description')->rows(2)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('after')->collection('after')->label('Preview')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('slug')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('points_count')->counts('points')->label('Bullets'),
                Tables\Columns\ToggleColumn::make('is_featured')->label('Homepage'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [PointsRelationManager::class, PriceItemsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
