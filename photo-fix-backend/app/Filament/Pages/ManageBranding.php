<?php

namespace App\Filament\Pages;

use App\Models\Branding;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

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
        $b = Branding::current();

        $this->form->fill([
            'logo_bg' => $b->logo_bg ?? 'none',
            'logo_height' => $b->logo_height ?? 36,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(Branding::current())
            ->statePath('data')
            ->schema([
                Section::make('Logo')
                    ->description('Shown in the site header and footer, and in this admin panel. Leave the image empty to use the styled text logo instead.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('logo')
                            ->label('Main logo')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->helperText('Best results: a PNG with a transparent background, or an SVG. Wide shape (~4:1), e.g. 240 × 60 px. If your file has its own colour behind it, set a matching "Logo background" below so it sits cleanly.'),

                        SpatieMediaLibraryFileUpload::make('logo_dark')
                            ->collection('logo_dark')
                            ->label('Logo for dark backgrounds (optional)')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->helperText('A light / white version used in the dark footer and the dark admin sidebar. Falls back to the main logo.'),

                        Select::make('logo_bg')
                            ->label('Logo background')
                            ->options([
                                'none' => 'None — logo has its own transparent background',
                                'light' => 'Light card — sit the logo on a white rounded chip',
                                'dark' => 'Dark card — sit the logo on a dark rounded chip',
                            ])
                            ->default('none')
                            ->native(false)
                            ->helperText('Pick a card if the uploaded image is not transparent, so it never looks like a stray box in the header.'),

                        TextInput::make('logo_height')
                            ->label('Logo height (px)')
                            ->numeric()
                            ->minValue(20)
                            ->maxValue(72)
                            ->default(36)
                            ->helperText('How tall the logo renders in the header. 28–44 works for most.'),

                        Placeholder::make('preview')
                            ->label('Preview')
                            ->content(function () {
                                $b = Branding::current();
                                $url = $b->getFirstMediaUrl('logo') ?: null;
                                $dark = $b->getFirstMediaUrl('logo_dark') ?: $url;
                                $h = (int) ($this->data['logo_height'] ?? $b->logo_height ?? 36);
                                $bg = $this->data['logo_bg'] ?? $b->logo_bg ?? 'none';

                                if (! $url) {
                                    return new HtmlString('<span style="color:#71717a">No image uploaded — the text logo is used.</span>');
                                }

                                $chip = fn (string $bgCss, string $imgUrl) => '<div style="display:inline-flex;align-items:center;padding:'
                                    .($bg === 'none' ? '0' : '6px 10px')
                                    .';border-radius:12px;background:'.($bg === 'light' ? '#fff' : ($bg === 'dark' ? '#1d1d1f' : 'transparent'))
                                    .';'.($bg === 'light' ? 'box-shadow:0 1px 3px rgba(0,0,0,.15);' : '').'">'
                                    .'<img src="'.e($imgUrl).'" style="height:'.$h.'px;width:auto;object-fit:contain" /></div>';

                                return new HtmlString(
                                    '<div style="display:flex;gap:1rem;flex-wrap:wrap">'
                                    .'<div style="padding:16px;border-radius:12px;background:#ffffff;border:1px solid #e5e7eb">'.$chip('#fff', $url).'</div>'
                                    .'<div style="padding:16px;border-radius:12px;background:#1d1d1f;border:1px solid #000">'.$chip('#1d1d1f', $dark).'</div>'
                                    .'</div>'
                                );
                            }),
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

        $model->update([
            'logo_bg' => $this->data['logo_bg'] ?? 'none',
            'logo_height' => (int) ($this->data['logo_height'] ?? 36),
        ]);

        $this->form->model($model)->saveRelationships();
        $model->touch(); // fires "saved" → clears the public API caches

        Notification::make()->title('Branding saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
