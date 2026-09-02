<?php

namespace App\Filament\Pages;

use App\Filament\Resources\SectionResource;
use App\Models\SiteSetting;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'General Settings';

    protected static string $view = 'filament.pages.singleton-form';

    /** group.key => [label, type, helper?] — type: text | textarea | toggle | password */
    protected array $fields = [
        'general.site_name' => ['Site name', 'text'],
        'general.logo_text' => ['Logo text', 'text'],
        'general.tagline' => ['Tagline', 'text'],
        'general.footer_about' => ['Footer about text', 'textarea'],
        'general.copyright' => ['Copyright line', 'text'],
        'contact.address' => ['Address', 'textarea'],
        'contact.email' => ['Public email', 'text'],
        'contact.phone' => ['Phone', 'text'],
        'contact.quote_notify_email' => ['Send lead notifications to', 'text'],
        'contact.map_embed_url' => ['Google Maps embed URL', 'text'],
        'newsletter.heading' => ['Newsletter heading', 'text'],
        'newsletter.placeholder' => ['Newsletter input placeholder', 'text'],
        'newsletter.button_label' => ['Newsletter button label', 'text'],
        'cta.header_button_label' => ['Header CTA label', 'text'],
        'cta.header_button_url' => ['Header CTA url', 'text'],
        'seo.default_title' => ['Default SEO title', 'text'],
        'seo.default_description' => ['Default SEO description', 'textarea'],
        'scripts.google_analytics_id' => ['Google Analytics ID', 'text'],
        'scripts.head_scripts' => ['Custom <head> scripts', 'textarea'],
        'scripts.body_scripts' => ['Custom end-of-body scripts', 'textarea'],
        'recaptcha.enabled' => ['Enable Google reCAPTCHA v2 on lead forms', 'toggle', 'Protects the Quote, Contact and Free Trial forms. Needs both keys below.'],
        'recaptcha.site_key' => ['reCAPTCHA site key', 'text', 'From google.com/recaptcha/admin — the public key.'],
        'recaptcha.secret_key' => ['reCAPTCHA secret key', 'password', 'Kept server-side, never exposed to the browser.'],
    ];

    public ?array $data = [];

    public function mount(): void
    {
        $map = SiteSetting::map();
        $state = [];
        foreach ($this->fields as $path => [$label, $type]) {
            [$group, $key] = explode('.', $path);
            $value = $map[$group][$key] ?? null;
            $state[$group][$key] = $type === 'toggle' ? (bool) $value : $value;
        }
        $this->form->fill($state);
    }

    public function form(Form $form): Form
    {
        $labels = ['recaptcha' => 'Security'];
        $tabs = [];

        foreach ($this->fields as $path => $meta) {
            [$label, $type] = $meta;
            $helper = $meta[2] ?? null;
            [$group, $key] = explode('.', $path);
            $name = "{$group}.{$key}";

            $component = match ($type) {
                'textarea' => Textarea::make($name)->rows(3)->label($label),
                'toggle' => Toggle::make($name)->label($label),
                'password' => TextInput::make($name)->label($label)->password()->revealable(),
                default => TextInput::make($name)->label($label),
            };
            if ($helper) {
                $component->helperText($helper);
            }
            $tabs[$group][] = $component;
        }

        return $form->statePath('data')->schema([
            Tabs::make('groups')->tabs(
                collect($tabs)->map(function ($fields, $group) use ($labels) {
                    $schema = [];
                    if ($group === 'contact') {
                        $schema[] = Placeholder::make('contact_photo_note')
                            ->label('')
                            ->content('Looking for the Contact page photo? That\'s uploaded separately — go to Homepage → Section Manager → "Contact — Page Heading" → Image field.');
                    }
                    $schema[] = Section::make()->schema($fields);

                    return Tabs\Tab::make($labels[$group] ?? ucfirst($group))->schema($schema);
                })->values()->all()
            )->persistTabInQueryString(),
        ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        foreach ($this->fields as $path => [$label, $type]) {
            [$group, $key] = explode('.', $path);
            $value = $state[$group][$key] ?? null;
            SiteSetting::updateOrCreate(
                ['group' => $group, 'key' => $key],
                [
                    'value' => $type === 'toggle' ? ($value ? '1' : '0') : $value,
                    'type' => $type === 'toggle' ? 'boolean' : ($type === 'password' ? 'text' : $type),
                ],
            );
        }

        Notification::make()->title('Settings saved.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [\Filament\Actions\Action::make('save')->label('Save')->submit('save')];
    }

    protected function getHeaderActions(): array
    {
        return [SectionResource::editHeadingAction('contact', 'Upload Contact Page Photo')];
    }
}
