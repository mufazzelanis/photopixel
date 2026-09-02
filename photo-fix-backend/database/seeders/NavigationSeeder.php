<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\PaymentMethod;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Header menu ------------------------------------------------
        $menu = [
            ['label' => 'Home', 'url' => '/', 'sort_order' => 1],
            ['label' => 'About', 'url' => '/about', 'sort_order' => 2],
            ['label' => 'Image Editing', 'url' => '/services', 'sort_order' => 3, 'children' => [
                ['label' => 'Clipping Path', 'url' => '/services/clipping-path'],
                ['label' => 'Photo Retouching', 'url' => '/services/photo-retouching'],
                ['label' => 'Image Masking', 'url' => '/services/image-masking'],
                ['label' => 'Ghost Mannequin', 'url' => '/services/ghost-mannequin'],
                ['label' => 'Shadow & Reflection', 'url' => '/services/shadow-reflection'],
                ['label' => 'Color Correction', 'url' => '/services/color-correction'],
                ['label' => 'Background Removal', 'url' => '/services/background-removal'],
            ]],
            ['label' => 'Portfolio', 'url' => '/portfolio', 'sort_order' => 4],
            ['label' => 'Pricing', 'url' => '/pricing', 'sort_order' => 5],
            ['label' => 'Contact', 'url' => '/contact', 'sort_order' => 6],
            ['label' => 'GET A QUOTE', 'url' => '#quote', 'sort_order' => 7, 'is_button' => true],
        ];

        foreach ($menu as $item) {
            $children = $item['children'] ?? [];
            unset($item['children']);
            $parent = MenuItem::updateOrCreate(
                ['label' => $item['label'], 'parent_id' => null],
                $item,
            );

            foreach ($children as $i => $child) {
                MenuItem::updateOrCreate(
                    ['label' => $child['label'], 'parent_id' => $parent->id],
                    $child + ['sort_order' => $i + 1],
                );
            }
        }

        // ---- Social links --------------------------------------------------
        foreach ([
            ['platform' => 'Facebook', 'icon' => 'facebook', 'url' => 'https://facebook.com/'],
            ['platform' => 'LinkedIn', 'icon' => 'linkedin', 'url' => 'https://linkedin.com/'],
            ['platform' => 'X', 'icon' => 'x', 'url' => 'https://x.com/'],
            ['platform' => 'Instagram', 'icon' => 'instagram', 'url' => 'https://instagram.com/'],
            ['platform' => 'YouTube', 'icon' => 'youtube', 'url' => 'https://youtube.com/'],
            ['platform' => 'Trustpilot', 'icon' => 'star', 'url' => 'https://trustpilot.com/'],
        ] as $i => $row) {
            SocialLink::updateOrCreate(
                ['platform' => $row['platform']],
                $row + ['sort_order' => $i + 1],
            );
        }

        // ---- Payment methods (logos uploaded later in admin) --------------
        foreach (['Payoneer', 'PayPal', 'Bank Transfer'] as $i => $name) {
            PaymentMethod::updateOrCreate(['name' => $name], ['sort_order' => $i + 1]);
        }
    }
}
