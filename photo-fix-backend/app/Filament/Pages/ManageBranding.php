<?php

namespace App\Filament\Pages;

use App\Models\Branding;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageBranding extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Design';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Logo & Favicon';

    protected static ?string $navigationLabel = 'Logo & Favicon';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(Branding::current())
            ->statePath('data')
            ->schema([
                Section::make('Logo')
                    ->description('Used in the site header and footer. Leave empty to keep the built-in text logo.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('logo')
                            ->label('Main logo')
                            ->image()
                            ->imageEditor()
                            ->helperText('Transparent PNG or SVG, roughly 200 × 48 px.'),
                        SpatieMediaLibraryFileUpload::make('logo_dark')
                            ->collection('logo_dark')
                            ->label('Logo for dark background (optional)')
                            ->image()
                            ->imageEditor()
                            ->helperText('A light / white version shown in the dark footer. Falls back to the main logo.'),
                    ]),

                Section::make('Favicon')
                    ->description('The little icon in the browser tab, and the app icon when the site is installed.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('favicon')
                            ->collection('favicon')
                            ->label('Browser tab / app icon')
                            ->acceptedFileTypes([
                                'image/png',
                                'image/svg+xml',
                                'image/x-icon',
                                'image/vnd.microsoft.icon',
                            ])
                            ->helperText('Square image — SVG or PNG (512 × 512 recommended).'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $model = Branding::current();
        $this->form->model($model)->saveRelationships();
        $model->touch(); // fires "saved" → clears the public API caches

        Notification::make()->title('Branding saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
