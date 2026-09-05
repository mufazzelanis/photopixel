<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SectionResource extends Resource
{
    use GloballySearchable;

    protected static array $globalSearch = ['name', 'key', 'heading', 'sub_heading'];

    protected static array $globalSearchDetails = ['Key' => 'key', 'Heading' => 'heading'];


    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationLabel = 'Section Manager';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->helperText('Internal label shown here in the admin.'),
            Forms\Components\TextInput::make('key')
                ->required()
                ->disabledOn('edit')
                ->helperText('Stable identifier the frontend renders against. Do not change on an existing section.'),
            Forms\Components\TextInput::make('eyebrow')
                ->helperText('Small label above the heading (optional).'),
            Forms\Components\TextInput::make('heading'),
            Forms\Components\TextInput::make('highlight_text')
                ->helperText('The part of the heading that gets the accent colour.'),
            Forms\Components\Textarea::make('sub_heading')
                ->rows(3)
                ->columnSpanFull()
                ->helperText('Intro paragraph. For link-style sub-headings use "Label|/url".'),
            Forms\Components\Textarea::make('body')
                ->rows(5)
                ->columnSpanFull()
                ->helperText('Used by a few sections (e.g. "The Range Of Value We Provide") as several paragraphs — leave one fully blank line between paragraphs to split them.'),
            SpatieMediaLibraryFileUpload::make('image')->collection('image')->image()->maxSize(20480)
                ->helperText('Optional — only a few pages use this (e.g. the person photo on Contact). Leave blank otherwise. Max 20MB.'),
            Forms\Components\KeyValue::make('settings')
                ->keyLabel('Setting')
                ->valueLabel('Value')
                ->columnSpanFull()
                ->helperText('e.g. bg = gradient-hero | bg-alt | bg-soft | bg-dark | gradient-cta | gradient-brand; padding_y = 80px'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('key')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('heading')->limit(40)->toggleable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }

    /**
     * One-click shortcut other "Homepage" list pages (Value Cards, Services,
     * FAQ, ...) drop into their header actions so an admin never has to hunt
     * for where a section's heading/intro text lives — it jumps straight to
     * that section's row here.
     */
    public static function editHeadingAction(string $key, string $label = 'Edit Heading & Intro Text'): Action
    {
        $section = Section::where('key', $key)->first();

        return Action::make('editSectionHeading')
            ->label($label)
            ->icon('heroicon-o-pencil-square')
            ->color('gray')
            ->url(fn () => static::getUrl('edit', ['record' => $section ?? Section::where('key', $key)->firstOrFail()]))
            ->visible((bool) $section);
    }
}
