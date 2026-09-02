<?php

namespace App\Filament\Pages;

use App\Models\WhyChooseSection;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageWhyChoose extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 9;

    protected static ?string $title = 'Why We Are Unique';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(WhyChooseSection::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(WhyChooseSection::current())
            ->statePath('data')
            ->schema([
                Section::make('Text')->columns(2)->schema([
                    TextInput::make('eyebrow'),
                    TextInput::make('heading')->columnSpanFull(),
                    TextInput::make('highlight_text'),
                    Textarea::make('body_1')->rows(4)->columnSpanFull(),
                    Textarea::make('body_2')->rows(4)->columnSpanFull(),
                ]),
                Section::make('Image')->schema([
                    SpatieMediaLibraryFileUpload::make('image')->collection('image')->image(),
                ]),
                Section::make()->schema([
                    \Filament\Forms\Components\Placeholder::make('note')
                        ->content('Numbered points and the 3 icon-features are managed under “Why Us — Points” and “Why Us — Features”.'),
                ]),
            ]);
    }

    public function save(): void
    {
        $model = WhyChooseSection::current();
        $model->update($this->form->getState());
        $this->form->model($model)->saveRelationships();

        Notification::make()->title('Section saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
