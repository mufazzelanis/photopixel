<?php

namespace App\Filament\Pages;

use App\Models\FreeTrialPage;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageFreeTrialPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Free Trial';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Free Trial Page Content';

    protected static ?string $navigationLabel = 'Page Content';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(FreeTrialPage::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form->statePath('data')->schema([
            Section::make('Left column copy')->columns(2)->schema([
                TextInput::make('heading')->columnSpanFull(),
                TextInput::make('highlight')->helperText('Part of the heading shown in the accent colour.'),
                Textarea::make('sub_text')->rows(3)->columnSpanFull(),
            ]),
            Section::make('Form')->columns(2)->schema([
                TextInput::make('form_title')->helperText('e.g. “Photo Editing Free Trial (2-3 Images)”')->columnSpanFull(),
                TextInput::make('max_images')->numeric()->minValue(1)->maxValue(20)->helperText('Max sample images a visitor can upload.'),
                TextInput::make('instructions_limit')->numeric()->minValue(50)->helperText('Character limit for the instructions box.'),
            ]),
            Section::make('Map')->schema([
                Textarea::make('map_embed_url')->rows(2)
                    ->helperText('Google Maps embed URL (the src of the iframe). Leave blank to hide the map.'),
            ]),
        ]);
    }

    public function save(): void
    {
        FreeTrialPage::current()->update($this->form->getState());
        Notification::make()->title('Free trial page saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
