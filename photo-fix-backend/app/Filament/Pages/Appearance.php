<?php

namespace App\Filament\Pages;

use App\Models\Theme;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

/**
 * One screen where the admin re-skins the whole public site:
 * colours, gradients, fonts, radius, shadows, button style and animation.
 * Saving writes the active Theme's `tokens` JSON, which the React app
 * pulls from /api/v1/theme and applies as CSS variables on :root.
 */
class Appearance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Design';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.appearance';

    public ?array $data = [];

    public ?int $themeId = null;

    public function mount(): void
    {
        $theme = Theme::query()->where('is_active', true)->first()
            ?? Theme::query()->firstOrFail();

        $this->themeId = $theme->id;
        $this->form->fill(['tokens' => $theme->tokens]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Select::make('themeId')
                    ->label('Editing preset')
                    ->options(fn () => Theme::query()->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $theme = Theme::find($state);
                        if ($theme) {
                            $this->themeId = $theme->id;
                            $this->form->fill(['tokens' => $theme->tokens]);
                        }
                    })
                    ->helperText('Switch which saved preset you are editing. Use “Activate” to make it live.'),

                Tabs::make('tokens')->tabs([
                    Tabs\Tab::make('Colours')->icon('heroicon-o-paint-brush')->schema([
                        Section::make('Brand')->schema([
                            Grid::make(3)->schema([
                                ColorPicker::make('tokens.color.primary')->label('Primary'),
                                ColorPicker::make('tokens.color.primary-600')->label('Primary (hover)'),
                                ColorPicker::make('tokens.color.secondary')->label('Secondary'),
                                ColorPicker::make('tokens.color.accent')->label('Accent'),
                                ColorPicker::make('tokens.color.on-primary')->label('Text on primary'),
                                ColorPicker::make('tokens.color.star')->label('Rating star'),
                            ]),
                        ]),
                        Section::make('Surfaces & text')->schema([
                            Grid::make(3)->schema([
                                ColorPicker::make('tokens.color.bg')->label('Background'),
                                ColorPicker::make('tokens.color.bg-alt')->label('Background alt'),
                                ColorPicker::make('tokens.color.bg-soft')->label('Background soft'),
                                ColorPicker::make('tokens.color.bg-dark')->label('Dark band'),
                                ColorPicker::make('tokens.color.heading')->label('Headings'),
                                ColorPicker::make('tokens.color.text')->label('Body text'),
                                ColorPicker::make('tokens.color.text-muted')->label('Muted text'),
                                ColorPicker::make('tokens.color.border')->label('Borders'),
                                ColorPicker::make('tokens.color.success')->label('Success'),
                            ]),
                        ]),
                        Section::make('Gradients (CSS)')->schema([
                            TextInput::make('tokens.gradient.brand')->label('Brand gradient'),
                            TextInput::make('tokens.gradient.cta')->label('CTA gradient'),
                            TextInput::make('tokens.gradient.hero')->label('Hero background'),
                            TextInput::make('tokens.gradient.dark')->label('Dark gradient'),
                        ]),
                    ]),

                    Tabs\Tab::make('Typography')->icon('heroicon-o-language')->schema([
                        TextInput::make('tokens.font.body')->label('Body font stack'),
                        TextInput::make('tokens.font.heading')->label('Heading font stack'),
                        TextInput::make('tokens.font.base-size')->label('Base font size')->placeholder('16px'),
                        TextInput::make('tokens.font.google')
                            ->label('Google Fonts family param')
                            ->helperText('e.g. Poppins:wght@300;400;500;600;700;800 — leave blank to skip Google Fonts.'),
                    ]),

                    Tabs\Tab::make('Shape & depth')->icon('heroicon-o-cube')->schema([
                        Grid::make(4)->schema([
                            TextInput::make('tokens.radius.sm')->label('Radius S'),
                            TextInput::make('tokens.radius.md')->label('Radius M'),
                            TextInput::make('tokens.radius.lg')->label('Radius L'),
                            TextInput::make('tokens.radius.pill')->label('Radius pill'),
                        ]),
                        TextInput::make('tokens.shadow.card')->label('Card shadow'),
                        TextInput::make('tokens.shadow.soft')->label('Soft shadow'),
                        TextInput::make('tokens.shadow.glow')->label('Glow shadow'),
                        Grid::make(3)->schema([
                            Select::make('tokens.button.style')->label('Button style')
                                ->options(['gradient' => 'Gradient', 'solid' => 'Solid', 'outline' => 'Outline']),
                            Select::make('tokens.button.radius')->label('Button radius')
                                ->options(['pill' => 'Pill', 'md' => 'Medium', 'sm' => 'Small']),
                            Select::make('tokens.button.hover')->label('Button hover')
                                ->options(['lift' => 'Lift', 'glow' => 'Glow', 'none' => 'None']),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('tokens.section.padding-y')->label('Section padding (desktop)'),
                            TextInput::make('tokens.section.padding-y-mobile')->label('Section padding (mobile)'),
                            TextInput::make('tokens.section.container')->label('Container width'),
                        ]),
                    ]),

                    Tabs\Tab::make('Animation')->icon('heroicon-o-sparkles')->schema([
                        Toggle::make('tokens.animation.enabled')->label('Enable animations site-wide'),
                        Toggle::make('tokens.animation.respect_reduced_motion')->label('Respect “reduce motion” OS setting'),
                        Section::make('Scroll reveal')->schema([
                            Grid::make(3)->schema([
                                Select::make('tokens.animation.reveal.type')->label('Type')
                                    ->options([
                                        'fade-up' => 'Fade up', 'fade' => 'Fade', 'zoom' => 'Zoom',
                                        'slide-left' => 'Slide left', 'slide-right' => 'Slide right',
                                    ]),
                                TextInput::make('tokens.animation.reveal.duration')->numeric()->label('Duration (s)'),
                                TextInput::make('tokens.animation.reveal.distance')->numeric()->label('Distance (px)'),
                                TextInput::make('tokens.animation.reveal.stagger')->numeric()->label('Stagger (s)'),
                                Toggle::make('tokens.animation.reveal.once')->label('Animate once'),
                            ]),
                        ]),
                        Section::make('Hero')->schema([
                            Grid::make(2)->schema([
                                Toggle::make('tokens.animation.hero.animated_gradient')->label('Animated gradient background'),
                                Toggle::make('tokens.animation.hero.float')->label('Floating collage images'),
                                Toggle::make('tokens.animation.hero.parallax')->label('Mouse parallax'),
                                Toggle::make('tokens.animation.hero.heading_stagger')->label('Stagger heading words'),
                            ]),
                        ]),
                        Section::make('Components')->schema([
                            Grid::make(2)->schema([
                                Toggle::make('tokens.animation.counters')->label('Animated number counters'),
                                Toggle::make('tokens.animation.carousel_autoplay')->label('Carousel autoplay'),
                                TextInput::make('tokens.animation.autoplay_delay')->numeric()->label('Autoplay delay (ms)'),
                                Toggle::make('tokens.animation.page_transition')->label('Page transitions'),
                                Toggle::make('tokens.animation.hover_lift')->label('Card hover lift'),
                            ]),
                        ]),
                    ]),
                ])->persistTabInQueryString(),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->submit('save'),

            Action::make('activate')
                ->label('Activate this preset')
                ->color('success')
                ->icon('heroicon-o-bolt')
                ->action(function () {
                    $theme = Theme::findOrFail($this->themeId);
                    $theme->activate();
                    Notification::make()->title("“{$theme->name}” is now live.")->success()->send();
                }),

            Action::make('duplicate')
                ->label('Duplicate')
                ->color('gray')
                ->icon('heroicon-o-document-duplicate')
                ->form([TextInput::make('name')->required()->default(fn () => 'Copy of preset')])
                ->action(function (array $data) {
                    $source = Theme::findOrFail($this->themeId);
                    $copy = $source->replicate(['is_active', 'is_default']);
                    $copy->name = $data['name'];
                    $copy->slug = \Illuminate\Support\Str::slug($data['name']).'-'.now()->timestamp;
                    $copy->is_active = false;
                    $copy->is_default = false;
                    $copy->tokens = $this->data['tokens'];
                    $copy->save();
                    $this->themeId = $copy->id;
                    Notification::make()->title('Preset duplicated.')->success()->send();
                }),

            Action::make('reset')
                ->label('Reset to default')
                ->color('danger')
                ->icon('heroicon-o-arrow-uturn-left')
                ->requiresConfirmation()
                ->action(function () {
                    $default = Theme::query()->where('is_default', true)->firstOrFail();
                    $this->form->fill(['tokens' => $default->tokens]);
                    Notification::make()->title('Loaded the default palette. Save to apply.')->send();
                }),
        ];
    }

    public function save(): void
    {
        $theme = Theme::findOrFail($this->themeId);
        $theme->update(['tokens' => $this->data['tokens']]);

        Notification::make()
            ->title('Appearance saved.')
            ->body($theme->is_active ? 'Live on the site now.' : 'Saved to this preset (not active).')
            ->success()
            ->send();
    }

    public function getPreviewUrl(): ?string
    {
        return env('FRONTEND_URL', 'http://localhost:5173');
    }
}
