<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\SeoMetaResource\Pages;
use App\Models\SeoMeta;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoMetaResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = SeoMeta::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'SEO Meta';

    protected static ?string $recordTitleAttribute = 'page_key';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('page_key')->required()->disabledOn('edit')
                ->helperText('Page identifier: home, about, contact, blog, services, or service:{slug}.'),
            Forms\Components\TextInput::make('title')->maxLength(255),
            Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('keywords')->columnSpanFull(),
            Forms\Components\Select::make('robots')->options([
                'index,follow' => 'index, follow',
                'noindex,follow' => 'noindex, follow',
                'noindex,nofollow' => 'noindex, nofollow',
            ])->default('index,follow'),
            SpatieMediaLibraryFileUpload::make('og_image')->collection('og_image')->image(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_key')->badge()->searchable(),
                Tables\Columns\TextColumn::make('title')->limit(50)->searchable(),
                Tables\Columns\TextColumn::make('robots')->badge()->color('gray'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeoMetas::route('/'),
            'create' => Pages\CreateSeoMeta::route('/create'),
            'edit' => Pages\EditSeoMeta::route('/{record}/edit'),
        ];
    }
}
