<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\WorkSampleCategoryResource\Pages;
use App\Filament\Resources\WorkSampleCategoryResource\RelationManagers\SamplesRelationManager;
use App\Models\WorkSampleCategory;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkSampleCategoryResource extends Resource
{
    use GloballySearchable;

    protected static array $globalSearch = ['name', 'slug', 'description'];

    protected static array $globalSearchDetails = ['Slug' => 'slug'];


    protected static ?string $model = WorkSampleCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Details')->columns(2)->schema([
                Forms\Components\TextInput::make('name')->required()->live(onBlur: true)
                    ->helperText('Shown as "{Name} Work Samples" on the portfolio page.')
                    ->afterStateUpdated(fn ($state, Forms\Set $set, string $operation) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)
                    ->helperText('Page lives at /portfolio/{slug}.'),
                Forms\Components\TextInput::make('icon')->helperText('Icon key, e.g. scissors, layers, palette, shirt, sparkles.'),
                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull()
                    ->helperText('Intro paragraph shown under the heading on this category\'s page.'),
            ]),
            Forms\Components\Section::make('Cover image')->schema([
                SpatieMediaLibraryFileUpload::make('cover')->collection('cover')->image()->imageEditor()
                    ->helperText('Used as the thumbnail on the Portfolio listing page. Falls back to the first sample\'s "after" image if left blank.'),
            ]),
            Forms\Components\Section::make('Buttons')->columns(2)->schema([
                Forms\Components\TextInput::make('read_more_label')->required()->default('Read More'),
                Forms\Components\TextInput::make('read_more_url')->helperText('e.g. /services/clipping-path. Defaults to /services.'),
                Forms\Components\TextInput::make('try_free_label')->required()->default('Try For Free'),
                Forms\Components\TextInput::make('try_free_url')->helperText('Defaults to /free-trial.'),
            ]),
            Forms\Components\Section::make('Visibility')->columns(2)->schema([
                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')->collection('cover')->label('Cover')->square(),
                Tables\Columns\TextColumn::make('name')->weight('bold')->searchable(),
                Tables\Columns\TextColumn::make('slug')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('samples_count')->counts('samples')->label('Samples'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [SamplesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkSampleCategories::route('/'),
            'create' => Pages\CreateWorkSampleCategory::route('/create'),
            'edit' => Pages\EditWorkSampleCategory::route('/{record}/edit'),
        ];
    }
}
