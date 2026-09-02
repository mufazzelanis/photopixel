<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('title')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set, string $operation) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('blog_category_id')->relationship('category', 'name')->searchable()->preload()->label('Category'),
                Forms\Components\TextInput::make('author_name')->default('Photo Fix Zone'),
                Forms\Components\TextInput::make('read_time')->placeholder('5 min read'),
                Forms\Components\DateTimePicker::make('published_at'),
                Forms\Components\Textarea::make('excerpt')->rows(2)->columnSpanFull(),
                Forms\Components\RichEditor::make('body')->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Media & SEO')->columns(2)->schema([
                SpatieMediaLibraryFileUpload::make('cover')->collection('cover')->image()->imageEditor()->columnSpanFull(),
                Forms\Components\TextInput::make('seo_title'),
                Forms\Components\Textarea::make('seo_description')->rows(2),
                Forms\Components\Toggle::make('is_published')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')->collection('cover')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->weight('bold')->limit(50),
                Tables\Columns\TextColumn::make('category.name')->badge(),
                Tables\Columns\TextColumn::make('published_at')->dateTime('M j, Y g:i a')->sortable(),
                Tables\Columns\TextColumn::make('views')->sortable(),
                Tables\Columns\ToggleColumn::make('is_published'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
