<?php

namespace App\Filament\Pages;

use App\Models\Section;
use App\Models\Service;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section as FormSection;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

class ManagePricing extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Pricing';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Pricing Page';

    protected static ?string $navigationLabel = 'Page Content';

    protected static string $view = 'filament.pages.singleton-form';

    public ?array $data = [];

    protected function section(): Section
    {
        return Section::firstOrCreate(
            ['key' => 'pricing'],
            ['name' => 'Pricing', 'heading' => 'Our Pricing', 'is_active' => true, 'sort_order' => 999],
        );
    }

    public function mount(): void
    {
        $this->form->fill($this->section()->only(['heading', 'highlight_text', 'sub_heading', 'is_active']));
    }

    public function form(Form $form): Form
    {
        $services = Service::query()->has('priceItems')->withCount('priceItems')->orderBy('sort_order')->get();

        $rows = $services->isEmpty()
            ? '<em>No service has price rows yet.</em>'
            : '<ul style="margin:0;padding-left:1rem;list-style:disc">'
                .$services->map(fn ($s) => "<li><strong>{$s->title}</strong> — starts at ".e($s->starting_price ?: '—')." · {$s->price_items_count} rows</li>")->implode('')
                .'</ul>';

        return $form->statePath('data')->schema([
            FormSection::make('Heading')->schema([
                TextInput::make('heading')->required(),
                TextInput::make('highlight_text')->helperText('The part of the heading shown in the accent colour.'),
                Textarea::make('sub_heading')->rows(2)->label('Intro text'),
                Toggle::make('is_active')->label('Show the Pricing page')->default(true),
            ]),

            FormSection::make('Where the rest is edited')->schema([
                Placeholder::make('help')->hiddenLabel()->content(new HtmlString(
                    '<div style="line-height:1.7">'
                    .'<p><strong>Price tables</strong> — each service’s "Starts at" price and its rows (label + price) live under '
                    .'<em>Content → Services → open a service → "Pricing table" tab</em>. A service only appears on '
                    .'<code>/pricing</code> once it has at least one price row.</p>'
                    .'<p><strong>Pricing FAQs</strong> — <em>Content → FAQ</em>, set the <em>group</em> to <code>pricing</code>.</p>'
                    .'<p style="margin-top:.75rem"><strong>Currently on /pricing:</strong></p>'.$rows
                    .'</div>'
                )),
            ]),
        ]);
    }

    public function save(): void
    {
        $this->section()->update($this->form->getState());
        Notification::make()->title('Pricing page saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }
}
