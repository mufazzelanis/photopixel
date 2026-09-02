<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SectionResource extends Resource
{
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
                ->columnSpanFull(),
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
}
