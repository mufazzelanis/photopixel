<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalPageResource\Pages;
use App\Models\LegalPage;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Legal Pages';

    protected static ?string $navigationLabel = 'Privacy & Terms';

    protected static ?string $recordTitleAttribute = 'title';

    // Exactly 2 fixed rows (Privacy Policy, Terms of Service), seeded once —
    // never created or deleted from the admin, only edited.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Page')->columns(2)->schema([
                Forms\Components\TextInput::make('title')->required()
                    ->helperText('Browser tab title and the label used elsewhere on the site.'),
                Forms\Components\TextInput::make('slug')->disabled()->dehydrated(false)
                    ->helperText('Fixed — this is what the page lives at (/'.'{slug}).'),
            ]),

            Forms\Components\Section::make('Hero')
                ->description('The banner at the top of the page.')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('hero_heading')->required()->columnSpanFull(),
                    Forms\Components\TextInput::make('hero_sub')
                        ->label('Hero sub-text')
                        ->helperText('Optional line under the heading.')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('hero_btn_label')
                        ->label('Hero button label')
                        ->helperText('Leave blank for no button in the hero.'),
                    Forms\Components\TextInput::make('hero_btn_url')
                        ->label('Hero button link')
                        ->helperText('e.g. #quote, /contact. Defaults to #quote if left blank.'),
                    SpatieMediaLibraryFileUpload::make('hero_image')
                        ->collection('hero_image')->image()->maxSize(20480)
                        ->helperText('Optional background photo behind the hero. Max 20MB. Leave blank for a plain gradient banner.')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Document')->schema([
                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('The full legal text. Use headings (H2/H3) for each section — they\'re styled automatically on the page.'),
            ]),

            Forms\Components\Section::make('SEO')->columns(2)->schema([
                Forms\Components\TextInput::make('seo_title')->helperText('Defaults to the title above.'),
                Forms\Components\Textarea::make('seo_description')->rows(2),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->weight('bold'),
                Tables\Columns\TextColumn::make('slug')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('updated_at')->since()->label('Last updated'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegalPages::route('/'),
            'edit' => Pages\EditLegalPage::route('/{record}/edit'),
        ];
    }
}
