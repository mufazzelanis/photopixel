<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    use GloballySearchable;

    protected static array $globalSearch = ['name', 'role', 'quote'];

    protected static array $globalSearchDetails = ['Role' => 'role', 'Rating' => 'rating'];


    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 12;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('role')->helperText('e.g. Business Owner, Photographer'),
            Forms\Components\Select::make('rating')->options(array_combine(range(1, 5), range(1, 5)))->default(5)->required(),
            Forms\Components\Textarea::make('quote')->rows(5)->required()->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('avatar')->collection('avatar')->image()->avatar()->maxSize(5120)->helperText('Max 5MB.'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('avatar')->collection('avatar')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('role')->toggleable(),
                Tables\Columns\TextColumn::make('rating')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('quote')->limit(50)->toggleable(),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
