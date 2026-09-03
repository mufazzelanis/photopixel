<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $tokens = [
            'color' => [
                'primary' => '#6C4CF1',
                'primary-600' => '#5A3FD6',
                'primary-700' => '#4A32B8',
                'secondary' => '#2F6BFF',
                'accent' => '#EC4899',
                'bg' => '#FFFFFF',
                'bg-alt' => '#F4F5F7',
                'bg-soft' => '#F7F1FB',
                'bg-dark' => '#1F2430',
                'text' => '#1B2431',
                'text-muted' => '#4B5563',
                'heading' => '#0F1420',
                'border' => '#E5E7EB',
                'star' => '#F5A623',
                'success' => '#16A34A',
                'on-primary' => '#FFFFFF',
            ],
            'gradient' => [
                'brand' => 'linear-gradient(90deg, #6C4CF1 0%, #2F6BFF 100%)',
                'cta' => 'linear-gradient(120deg, #7C3AED 0%, #DB2777 100%)',
                'hero' => 'linear-gradient(160deg, #F7F1FB 0%, #FDEEF5 40%, #EEF3FF 100%)',
                'dark' => 'linear-gradient(120deg, #1F2430 0%, #2A2140 100%)',
            ],
            'font' => [
                'body' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
                'heading' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
                'base-size' => '17px',
                'google' => 'Poppins:wght@300;400;500;600;700;800',
            ],
            'radius' => [
                'sm' => '8px',
                'md' => '14px',
                'lg' => '24px',
                'pill' => '999px',
            ],
            'shadow' => [
                'card' => '0 12px 34px rgba(20, 24, 33, 0.10)',
                'soft' => '0 8px 24px rgba(20, 24, 33, 0.06)',
                'glow' => '0 10px 40px rgba(108, 76, 241, 0.35)',
            ],
            'button' => [
                'style' => 'gradient',   // gradient | solid | outline
                'radius' => 'pill',
                'hover' => 'lift',       // lift | glow | none
            ],
            'section' => [
                'padding-y' => '96px',
                'padding-y-mobile' => '56px',
                'container' => '1200px',
            ],
            'animation' => [
                'enabled' => true,
                'reveal' => [
                    'type' => 'fade-up',   // fade-up | fade | zoom | slide-left | slide-right
                    'duration' => 0.6,
                    'distance' => 32,
                    'stagger' => 0.08,
                    'once' => true,
                ],
                'hero' => [
                    'animated_gradient' => true,
                    'float' => true,
                    'parallax' => true,
                    'heading_stagger' => true,
                ],
                'counters' => true,
                'carousel_autoplay' => true,
                'autoplay_delay' => 4000,
                'page_transition' => true,
                'hover_lift' => true,
                'respect_reduced_motion' => true,
            ],
        ];

        Theme::updateOrCreate(
            ['slug' => 'photo-fix-zone-default'],
            [
                'name' => 'Photo Fix Zone — Default',
                'is_active' => true,
                'is_default' => true,
                'tokens' => $tokens,
            ],
        );

        // A ready-made dark alternative the admin can activate/duplicate.
        $dark = $tokens;
        $dark['color']['bg'] = '#12141C';
        $dark['color']['bg-alt'] = '#171A24';
        $dark['color']['bg-soft'] = '#1B1730';
        $dark['color']['text'] = '#D9DEE9';
        $dark['color']['text-muted'] = '#9AA3B2';
        $dark['color']['heading'] = '#F5F7FA';
        $dark['color']['border'] = '#2A2F3C';
        $dark['gradient']['hero'] = 'linear-gradient(160deg, #171326 0%, #1A1422 45%, #121826 100%)';

        Theme::updateOrCreate(
            ['slug' => 'photo-fix-zone-dark'],
            [
                'name' => 'Photo Fix Zone — Dark',
                'is_active' => false,
                'is_default' => false,
                'tokens' => $dark,
            ],
        );
    }
}
