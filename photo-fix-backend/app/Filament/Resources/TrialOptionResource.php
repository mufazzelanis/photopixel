<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrialOptionResource\Pages;
use App\Models\TrialOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrialOptionResource extends Resource
{
    protected static ?string $model = TrialOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Free Trial';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Form Options';

    protected static ?string $recordTitleAttribute = 'label';

    private const GROUP_LABELS = [
        'service' => 'Service (checkboxes)',
        'timeline' => 'Delivery timeline (dropdown)',
        'file_format' => 'Required file format (dropdown)',
        'how_found' => 'How did you find us (dropdown)',
    ];

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('group')
                ->options(self::GROUP_LABELS)
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->groups([
                Tables\Grouping\Group::make('group')
                    ->getTitleFromRecordUsing(fn (TrialOption $r) => self::GROUP_LABELS[$r->group] ?? $r->group),
            ])
            ->defaultGroup('group')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#'),
                Tables\Columns\TextColumn::make('label')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->formatStateUsing(fn ($state) => self::GROUP_LABELS[$state] ?? $state),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')->options(self::GROUP_LABELS),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrialOptions::route('/'),
            'create' => Pages\CreateTrialOption::route('/create'),
            'edit' => Pages\EditTrialOption::route('/{record}/edit'),
        ];
    }
}
