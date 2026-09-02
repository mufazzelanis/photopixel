<?php

namespace App\Filament\Pages;

use App\Models\Hero;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageHero extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Hero Section';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Hero::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(Hero::current())
            ->statePath('data')
            ->schema([
                Section::make('Text')->columns(2)->schema([
                    TextInput::make('eyebrow'),
                    TextInput::make('heading')->required()->columnSpanFull(),
                    TextInput::make('highlight_text')->helperText('Part of the heading shown in the accent colour.'),
                    Textarea::make('sub_text')->rows(3)->columnSpanFull(),
                ]),
                Section::make('Buttons')->columns(2)->schema([
                    TextInput::make('primary_btn_label'),
                    TextInput::make('primary_btn_url'),
                    TextInput::make('secondary_btn_label'),
                    TextInput::make('secondary_btn_url'),
                ]),
                Section::make('Images')->schema([
                    SpatieMediaLibraryFileUpload::make('collage')->collection('collage')->image()->multiple()->reorderable()
                        ->helperText('Floating collage images on the right of the hero.'),
                    SpatieMediaLibraryFileUpload::make('background')->collection('background')->image()
                        ->helperText('Optional background image behind the hero.'),
                ]),
            ]);
    }

    public function save(): void
    {
        $hero = Hero::current();
        $hero->update($this->form->getState());
        $this->form->model($hero)->saveRelationships();

        Notification::make()->title('Hero saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
