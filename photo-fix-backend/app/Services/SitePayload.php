<?php

namespace App\Services;

use App\Models\AboutPage;
use App\Models\AboutSection;
use App\Models\BlogPost;
use App\Models\FreeTrialPage;
use App\Models\TrialOption;
use App\Models\ClientType;
use App\Models\Country;
use App\Models\CtaBand;
use App\Models\Faq;
use App\Models\FooterColumn;
use App\Models\Hero;
use App\Models\MenuItem;
use App\Models\PaymentMethod;
use App\Models\ProcessStep;
use App\Models\Section;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Theme;
use App\Models\UploadServer;
use App\Models\ValueCard;
use App\Models\WhyChooseSection;
use App\Models\WorkSample;
use App\Models\WorkSampleCategory;
use App\Support\Media;
use Illuminate\Support\Facades\Cache;

class SitePayload
{
    public function home(): array
    {
        return Cache::rememberForever('api.home', fn () => $this->plain([
            'theme' => Theme::activeTokens(),
            'settings' => $this->publicSettings(),
            'captcha' => $this->captcha(),
            'navigation' => $this->navigation(),
            'footer' => $this->footer(),
            'seo' => $this->seo('home'),
            'sections' => $this->sections(),
            'content' => [
                'hero' => $this->hero(),
                'value_cards' => $this->valueCards(),
                'about' => $this->about(),
                'countries' => $this->countries(),
                'services' => $this->services(),
                'cta_perfection' => $this->cta('cta_perfection'),
                'client_types' => $this->clientTypes(),
                'process_steps' => $this->processSteps(),
                'work_samples' => $this->workSamples(),
                'work_sample_categories' => $this->workSampleCategories(),
                'why_choose' => $this->whyChoose(),
                'testimonials' => $this->testimonials(),
                'stats' => $this->stats(),
                'upload_servers' => $this->uploadServers(),
                'faqs' => $this->faqs(),
                'blog_teasers' => $this->blogTeasers(),
            ],
        ]));
    }

    /** Force plain arrays/scalars so the (database) cache store round-trips cleanly. */
    private function plain(array $data): array
    {
        return json_decode(json_encode($data), true);
    }

    /** Site settings with secret-bearing groups removed. */
    private function publicSettings(): array
    {
        $settings = SiteSetting::map();
        unset($settings['recaptcha']); // secret_key must never reach the client

        return $settings;
    }

    /** Public captcha config (never the secret key). */
    private function captcha(): array
    {
        return [
            'provider' => 'recaptcha_v2',
            'enabled' => \App\Support\Recaptcha::enabled(),
            'site_key' => \App\Support\Recaptcha::siteKey(),
        ];
    }

    /** Copy, options and settings for the /free-trial page. */
    public function freeTrialPage(): array
    {
        return Cache::rememberForever('api.free_trial_page', function () {
            $p = FreeTrialPage::current();
            $opts = TrialOption::query()->visible()->get()->groupBy('group');

            return $this->plain([
                'seo' => $this->seo('free-trial'),
                'captcha' => $this->captcha(),
                'heading' => $p->heading,
                'highlight' => $p->highlight,
                'sub_text' => $p->sub_text,
                'form_title' => $p->form_title,
                'map_embed_url' => $p->map_embed_url,
                'instructions_limit' => $p->instructions_limit,
                'max_images' => $p->max_images,
                'options' => [
                    'service' => $opts->get('service', collect())->pluck('label')->values(),
                    'timeline' => $opts->get('timeline', collect())->pluck('label')->values(),
                    'file_format' => $opts->get('file_format', collect())->pluck('label')->values(),
                    'how_found' => $opts->get('how_found', collect())->pluck('label')->values(),
                ],
                'contact' => [
                    'address' => SiteSetting::value('contact', 'address'),
                    'email' => SiteSetting::value('contact', 'email'),
                    'phone' => SiteSetting::value('contact', 'phone'),
                ],
                'socials' => SocialLink::query()->visible()->get()
                    ->map(fn ($s) => ['platform' => $s->platform, 'url' => $s->url, 'icon' => $s->icon])->values(),
                'upload_servers' => $this->uploadServers(),
            ]);
        });
    }

    /** Copy + itemized per-service pricing tables for the /pricing page.
     *  A service only appears here once it has at least one price item. */
    public function pricingPage(): array
    {
        return Cache::rememberForever('api.pricing_page', function () {
            $section = Section::where('key', 'pricing')->first();

            return $this->plain([
                'seo' => $this->seo('pricing'),
                'heading' => $section?->heading,
                'highlight' => $section?->highlight_text,
                'sub_text' => $section?->sub_heading,
                'services' => Service::query()->active()->ordered()->has('priceItems')
                    ->with('priceItems', 'workSampleCategory')->get()
                    ->map(fn (Service $s) => [
                        'slug' => $s->slug,
                        'title' => $s->title,
                        'starting_price' => $s->starting_price,
                        'before_image' => Media::url($s, 'before', 'web'),
                        'after_image' => Media::url($s, 'after', 'web'),
                        'items' => $s->priceItems->map(fn ($i) => ['label' => $i->label, 'price' => $i->price])->values(),
                        'samples_url' => $s->workSampleCategory ? "/portfolio/{$s->workSampleCategory->slug}" : "/services/{$s->slug}",
                    ])->values(),
                'faqs' => Faq::query()->where('group', 'pricing')->visible()->get()
                    ->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->values(),
            ]);
        });
    }

    /** Full payload for the dedicated /about page. */
    public function aboutPage(): array
    {
        return Cache::rememberForever('api.about_page', function () {
            $p = AboutPage::current();

            return $this->plain([
                'seo' => $this->seo('about'),
                'hero' => [
                    'heading' => $p->hero_heading,
                    'highlight' => $p->hero_highlight,
                    'sub_text' => $p->hero_sub_text,
                    'primary_btn' => ['label' => $p->hero_primary_label, 'url' => $p->hero_primary_url],
                    'secondary_btn' => ['label' => $p->hero_secondary_label, 'url' => $p->hero_secondary_url],
                    'image' => Media::url($p, 'hero_image', 'web'),
                ],
                'boost' => [
                    'heading' => $p->boost_heading,
                    'highlight' => $p->boost_highlight,
                    'sub_text' => $p->boost_sub_text,
                    'features' => $p->features()->map(fn ($f) => [
                        'icon' => $f->icon,
                        'header_color' => $f->header_color,
                        'title' => $f->title,
                        'body' => $f->body,
                    ])->values(),
                ],
                'post_production' => [
                    'heading' => $p->pp_heading,
                    'highlight' => $p->pp_highlight,
                    'body_1' => $p->pp_body_1,
                    'body_2' => $p->pp_body_2,
                    'btn' => ['label' => $p->pp_btn_label, 'url' => $p->pp_btn_url],
                    'image' => Media::url($p, 'post_production_image', 'web'),
                ],
                'society' => [
                    'heading' => $p->society_heading,
                    'highlight' => $p->society_highlight,
                    'body_1' => $p->society_body_1,
                    'body_2' => $p->society_body_2,
                    'body_3' => $p->society_body_3,
                    'image' => Media::url($p, 'society_image', 'web'),
                ],
                'partnership' => [
                    'heading' => $p->partnership_heading,
                    'highlight' => $p->partnership_highlight,
                    'sub_text' => $p->partnership_sub_text,
                    'video_url' => $p->partnership_video_url,
                    'points' => $p->partnershipPoints()->map(fn ($pt) => [
                        'icon' => $pt->icon,
                        'text' => $pt->text,
                    ])->values(),
                ],
            ]);
        });
    }

    public function navigation(): array
    {
        return Cache::rememberForever('api.navigation', function () {
            $branding = \App\Models\Branding::current();

            return $this->plain([
            'brand' => SiteSetting::value('general', 'logo_text', 'Pixel Graphic Studio'),
            'logo' => Media::url($branding, 'logo', 'web') ?: Media::url($branding, 'logo'),
            'logo_dark' => Media::url($branding, 'logo_dark', 'web') ?: Media::url($branding, 'logo_dark'),
            'favicon' => Media::url($branding, 'favicon'),
            'cta' => [
                'label' => SiteSetting::value('cta', 'header_button_label', 'GET A QUOTE'),
                'url' => SiteSetting::value('cta', 'header_button_url', '#quote'),
            ],
            'items' => MenuItem::query()->active()->topLevel()->with('children')->get()
                ->map(fn (MenuItem $item) => [
                    'label' => $item->label,
                    'url' => $item->url,
                    'target' => $item->target,
                    'is_button' => $item->is_button,
                    'children' => $item->children->where('is_active', true)->map(fn ($c) => [
                        'label' => $c->label,
                        'url' => $c->url,
                        'target' => $c->target,
                        'icon' => $c->icon,
                    ])->values(),
                ])->values(),
            ]);
        });
    }

    public function footer(): array
    {
        return Cache::rememberForever('api.footer', fn () => $this->plain([
            'about' => SiteSetting::value('general', 'footer_about'),
            'copyright' => SiteSetting::value('general', 'copyright'),
            'contact' => [
                'address' => SiteSetting::value('contact', 'address'),
                'email' => SiteSetting::value('contact', 'email'),
                'phone' => SiteSetting::value('contact', 'phone'),
                'map_embed_url' => SiteSetting::value('contact', 'map_embed_url'),
            ],
            'newsletter' => [
                'heading' => SiteSetting::value('newsletter', 'heading', 'Subscribe Now'),
                'placeholder' => SiteSetting::value('newsletter', 'placeholder', 'Email Us'),
                'button_label' => SiteSetting::value('newsletter', 'button_label', 'Subscribe'),
            ],
            'columns' => FooterColumn::query()->visible()->with('links')->get()
                ->map(fn ($col) => [
                    'title' => $col->title,
                    'links' => $col->links->where('is_active', true)
                        ->map(fn ($l) => ['label' => $l->label, 'url' => $l->url, 'target' => $l->target])
                        ->values(),
                ])->values(),
            'payment_methods' => PaymentMethod::query()->visible()->get()
                ->map(fn ($p) => ['name' => $p->name, 'logo' => Media::url($p, 'logo')])->values(),
            'socials' => SocialLink::query()->visible()->get()
                ->map(fn ($s) => ['platform' => $s->platform, 'url' => $s->url, 'icon' => $s->icon])->values(),
        ]));
    }

    public function sections(): array
    {
        return Section::query()->active()->ordered()->get()->map(fn (Section $s) => [
            'key' => $s->key,
            'eyebrow' => $s->eyebrow,
            'heading' => $s->heading,
            'highlight_text' => $s->highlight_text,
            'sub_heading' => $s->sub_heading,
            'body' => $s->body,
            'image' => Media::url($s, 'image', 'web'),
            'settings' => $s->settings ?? [],
        ])->values()->all();
    }

    public function seo(string $pageKey): array
    {
        $meta = SeoMeta::for($pageKey);

        return [
            'title' => $meta?->title ?? SiteSetting::value('seo', 'default_title'),
            'description' => $meta?->description ?? SiteSetting::value('seo', 'default_description'),
            'keywords' => $meta?->keywords,
            'robots' => $meta?->robots ?? 'index,follow',
            'og_image' => Media::url($meta, 'og_image'),
        ];
    }

    private function hero(): array
    {
        $hero = Hero::current();

        return [
            'eyebrow' => $hero->eyebrow,
            'heading' => $hero->heading,
            'highlight_text' => $hero->highlight_text,
            'sub_text' => $hero->sub_text,
            'primary_btn' => ['label' => $hero->primary_btn_label, 'url' => $hero->primary_btn_url],
            'secondary_btn' => ['label' => $hero->secondary_btn_label, 'url' => $hero->secondary_btn_url],
            'collage' => Media::collection($hero, 'collage'),
            'background' => Media::url($hero, 'background', 'web'),
        ];
    }

    private function valueCards(): array
    {
        return ValueCard::query()->visible()->get()->map(fn ($c) => [
            'icon' => $c->icon,
            'header_color' => $c->header_color,
            'title' => $c->title,
            'body' => $c->body,
        ])->all();
    }

    private function about(): array
    {
        $about = AboutSection::current();

        return [
            'eyebrow' => $about->eyebrow,
            'heading' => $about->heading,
            'highlight_text' => $about->highlight_text,
            'video_url' => $about->video_url,
            'body_1' => $about->body_1,
            'body_2' => $about->body_2,
            'btn' => ['label' => $about->btn_label, 'url' => $about->btn_url],
            'thumbnail' => Media::url($about, 'thumbnail'),
        ];
    }

    private function countries(): array
    {
        return Country::query()->visible()->get()->map(fn ($c) => [
            'name' => $c->name,
            'code' => $c->code,
            'flag' => Media::url($c, 'flag'),
        ])->all();
    }

    private function services(): array
    {
        return Service::query()->active()->featured()->ordered()->with('points')->get()
            ->map(fn (Service $s) => [
                'slug' => $s->slug,
                'title' => $s->title,
                'icon' => $s->icon,
                'short_desc' => $s->short_desc,
                'btn_label' => $s->btn_label,
                'btn_url' => $s->btn_url ?: "/services/{$s->slug}",
                'points' => $s->points->pluck('text'),
                'before_image' => Media::url($s, 'before', 'web'),
                'after_image' => Media::url($s, 'after', 'web'),
            ])->all();
    }

    private function cta(string $key): ?array
    {
        $band = CtaBand::get($key);

        return $band ? [
            'heading' => $band->heading,
            'sub_text' => $band->sub_text,
            'btn' => ['label' => $band->btn_label, 'url' => $band->btn_url],
            'bg_style' => $band->bg_style,
            'background' => Media::url($band, 'background'),
        ] : null;
    }

    private function clientTypes(): array
    {
        return ClientType::query()->visible()->get()->map(fn ($c) => [
            'title' => $c->title,
            'body' => $c->body,
            'link' => ['label' => $c->link_label, 'url' => $c->link_url],
            'image' => Media::url($c, 'image'),
        ])->all();
    }

    private function processSteps(): array
    {
        return ProcessStep::query()->visible()->get()->map(fn ($s) => [
            'step_no' => $s->step_no,
            'title' => $s->title,
            'body' => $s->body,
            'icon' => $s->icon,
            'accent_color' => $s->accent_color,
        ])->all();
    }

    /** Homepage "Satisfied Clients" spotlight — the admin's chosen 3 (or so)
     *  most-popular categories, each represented by its own cover / a real
     *  sample photo (never the seeder's placeholder graphic). Links straight
     *  to /portfolio/{slug}; "See More Samples" always goes to /portfolio. */
    private function workSamples(): array
    {
        return WorkSampleCategory::query()->visible()->featured()->ordered()
            ->with(['samples' => fn ($q) => $q->visible()->withRealPhotos()])
            ->get()
            ->map(fn (WorkSampleCategory $cat) => [
                'name' => $cat->name,
                'slug' => $cat->slug,
                'icon' => $cat->icon,
                'cover' => $cat->realCoverUrl() ?? Media::url($cat->samples->first(), 'after', 'web'),
                'samples_count' => $cat->samples->count(),
            ])->all();
    }

    /** Grouped by category, each with its own copy/buttons — powers /portfolio and /portfolio/{slug}. */
    private function workSampleCategories(): array
    {
        return WorkSampleCategory::query()->visible()
            ->with(['samples' => fn ($q) => $q->visible()->withRealPhotos()])
            ->get()
            ->map(fn (WorkSampleCategory $cat) => [
                'name' => $cat->name,
                'slug' => $cat->slug,
                'icon' => $cat->icon,
                'description' => $cat->description,
                'cover' => $cat->realCoverUrl(),
                'read_more' => ['label' => $cat->read_more_label, 'url' => $cat->read_more_url ?: '/services'],
                'try_free' => ['label' => $cat->try_free_label, 'url' => $cat->try_free_url ?: '/free-trial'],
                'samples' => $cat->samples->map(fn ($s) => [
                    'title' => $s->title,
                    'before_image' => Media::url($s, 'before', 'web'),
                    'after_image' => Media::url($s, 'after', 'web'),
                ])->values(),
            ])->values()->all();
    }

    private function whyChoose(): array
    {
        $w = WhyChooseSection::current();

        return [
            'eyebrow' => $w->eyebrow,
            'heading' => $w->heading,
            'highlight_text' => $w->highlight_text,
            'body_1' => $w->body_1,
            'body_2' => $w->body_2,
            'points' => $w->points()->pluck('text'),
            'features' => $w->features()->map(fn ($f) => ['title' => $f->title, 'icon' => $f->icon])->values(),
            'image' => Media::url($w, 'image'),
        ];
    }

    private function testimonials(): array
    {
        return Testimonial::query()->visible()->get()->map(fn ($t) => [
            'name' => $t->name,
            'role' => $t->role,
            'rating' => $t->rating,
            'quote' => $t->quote,
            'avatar' => Media::url($t, 'avatar'),
        ])->all();
    }

    private function stats(): array
    {
        return Stat::query()->visible()->get()->map(fn ($s) => [
            'label' => $s->label,
            'value' => (float) $s->value_number,
            'prefix' => $s->value_prefix,
            'suffix' => $s->value_suffix,
            'icon' => $s->icon,
        ])->all();
    }

    private function uploadServers(): array
    {
        return UploadServer::query()->visible()->get()->map(fn ($u) => [
            'name' => $u->name,
            'url' => $u->url,
            'icon' => $u->icon,
            'button_style' => $u->button_style,
        ])->all();
    }

    private function faqs(): array
    {
        return Faq::query()->where('group', 'home')->visible()->get()
            ->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->all();
    }

    private function blogTeasers(): array
    {
        return BlogPost::query()->published()->limit(3)->get()->map(fn (BlogPost $p) => [
            'title' => $p->title,
            'slug' => $p->slug,
            'excerpt' => $p->excerpt,
            'published_at' => $p->published_at?->toIso8601String(),
            'read_time' => $p->read_time,
            'cover' => Media::url($p, 'cover', 'thumb'),
        ])->all();
    }
}
