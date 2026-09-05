<?php

namespace App\Filament\Pages;

use App\Models\AboutPage;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageAboutPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'About Page';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'About Page Content';

    protected static ?string $navigationLabel = 'Page Content';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutPage::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(AboutPage::current())
            ->statePath('data')
            ->schema([
                Tabs::make('about')->persistTabInQueryString()->tabs([
                    Tabs\Tab::make('Hero')->icon('heroicon-o-bolt')->schema([
                        TextInput::make('hero_heading')->columnSpanFull(),
                        TextInput::make('hero_highlight')->helperText('Part of the heading shown in the accent colour.'),
                        Textarea::make('hero_sub_text')->rows(3)->columnSpanFull(),
                        Section::make('Buttons')->columns(2)->schema([
                            TextInput::make('hero_primary_label'),
                            TextInput::make('hero_primary_url'),
                            TextInput::make('hero_secondary_label'),
                            TextInput::make('hero_secondary_url'),
                        ]),
                        SpatieMediaLibraryFileUpload::make('hero_image')->collection('hero_image')->image()->maxSize(20480)->helperText('Max 20MB.'),
                    ]),

                    Tabs\Tab::make('Boost Your Business')->icon('heroicon-o-squares-2x2')->schema([
                        TextInput::make('boost_heading')->columnSpanFull(),
                        TextInput::make('boost_highlight'),
                        Textarea::make('boost_sub_text')->rows(3)->columnSpanFull(),
                        \Filament\Forms\Components\Placeholder::make('note')
                            ->content('The 6 cards are managed under “About Page → Feature Cards”.'),
                    ]),

                    Tabs\Tab::make('Post-Production')->icon('heroicon-o-sparkles')->schema([
                        TextInput::make('pp_heading')->columnSpanFull(),
                        TextInput::make('pp_highlight'),
                        Textarea::make('pp_body_1')->rows(6)->columnSpanFull(),
                        Textarea::make('pp_body_2')->rows(6)->columnSpanFull(),
                        Section::make()->columns(2)->schema([
                            TextInput::make('pp_btn_label'),
                            TextInput::make('pp_btn_url'),
                        ]),
                        SpatieMediaLibraryFileUpload::make('post_production_image')->collection('post_production_image')->image()->maxSize(20480)->helperText('Max 20MB.'),
                    ]),

                    Tabs\Tab::make('Positive Impact')->icon('heroicon-o-heart')->schema([
                        TextInput::make('society_heading')->columnSpanFull(),
                        TextInput::make('society_highlight'),
                        Textarea::make('society_body_1')->rows(4)->columnSpanFull(),
                        Textarea::make('society_body_2')->rows(4)->columnSpanFull(),
                        Textarea::make('society_body_3')->rows(4)->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('society_image')->collection('society_image')->image()->maxSize(20480)->helperText('Max 20MB.'),
                    ]),

                    Tabs\Tab::make('Partnership + Video')->icon('heroicon-o-play-circle')->schema([
                        TextInput::make('partnership_heading')->columnSpanFull(),
                        TextInput::make('partnership_highlight'),
                        Textarea::make('partnership_sub_text')->rows(3)->columnSpanFull(),
                        TextInput::make('partnership_video_url')->helperText('YouTube URL — shown as an embedded player.')->columnSpanFull(),
                        \Filament\Forms\Components\Placeholder::make('note')
                            ->content('The checklist items are managed under “About Page → Partnership Points”.'),
                    ]),
                ]),
            ]);
    }

    public function save(): void
    {
        $page = AboutPage::current();
        $page->update($this->form->getState());
        $this->form->model($page)->saveRelationships();

        Notification::make()->title('About page saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
