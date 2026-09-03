<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    #[DataProvider('adminUrls')]
    public function test_admin_pages_render(string $url): void
    {
        $admin = User::where('email', 'admin@photofixzone.com')->firstOrFail();

        $this->actingAs($admin)->get($url)->assertSuccessful();
    }

    public function test_public_home_api_returns_full_payload(): void
    {
        $this->getJson('/api/v1/home')
            ->assertOk()
            ->assertJsonStructure([
                'theme', 'settings', 'navigation', 'footer', 'seo', 'sections',
                'content' => ['hero', 'services', 'value_cards', 'testimonials', 'stats', 'faqs'],
            ]);
    }

    public static function adminUrls(): array
    {
        return array_map(fn ($u) => [$u], [
            '/admin',
            '/admin/appearance',
            '/admin/manage-hero',
            '/admin/manage-about',
            '/admin/manage-why-choose',
            '/admin/manage-settings',
            '/admin/manage-pricing',
            '/admin/service-price-items',
            '/admin/service-price-items/create',
            '/admin/manage-about-page',
            '/admin/about-features',
            '/admin/about-features/create',
            '/admin/about-partnership-points',
            '/admin/about-partnership-points/create',
            '/admin/manage-free-trial-page',
            '/admin/trial-options',
            '/admin/trial-options/create',
            '/admin/sections',
            '/admin/services',
            '/admin/services/create',
            '/admin/value-cards',
            '/admin/process-steps',
            '/admin/testimonials',
            '/admin/stats',
            '/admin/faqs',
            '/admin/client-types',
            '/admin/work-samples',
            '/admin/countries',
            '/admin/cta-bands',
            '/admin/upload-servers',
            '/admin/menu-items',
            '/admin/social-links',
            '/admin/payment-methods',
            '/admin/footer-columns',
            '/admin/seo-metas',
            '/admin/blog-posts',
            '/admin/blog-categories',
            '/admin/why-points',
            '/admin/why-features',
            '/admin/quote-requests',
            '/admin/contact-messages',
            '/admin/free-trial-requests',
            '/admin/newsletter-subscribers',
        ]);
    }
}
