<?php

namespace App\Filament\Pages;

use App\Models\AboutSection;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageAbout extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'About / Accelerate Your Journey';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutSection::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(AboutSection::current())
            ->statePath('data')
            ->schema([
                Section::make('Text')->columns(2)->schema([
                    TextInput::make('eyebrow'),
                    TextInput::make('heading')->columnSpanFull(),
                    TextInput::make('highlight_text'),
                    TextInput::make('video_url')->helperText('YouTube URL shown as an embedded player.')->columnSpanFull(),
                    Textarea::make('body_1')->rows(4)->columnSpanFull(),
                    Textarea::make('body_2')->rows(4)->columnSpanFull(),
                ]),
                Section::make('Button & media')->columns(2)->schema([
                    TextInput::make('btn_label'),
                    TextInput::make('btn_url'),
                    SpatieMediaLibraryFileUpload::make('thumbnail')->collection('thumbnail')->image()->columnSpanFull(),
                ]),
            ]);
    }

    public function save(): void
    {
        $about = AboutSection::current();
        $about->update($this->form->getState());
        $this->form->model($about)->saveRelationships();

        Notification::make()->title('About section saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
