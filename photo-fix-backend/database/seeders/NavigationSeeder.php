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
            // Order here is column-major (reads top-to-bottom within a
            // column, then moves to the next) to match the reference
            // "WHAT SERVICES WE OFFER" mega-menu grid.
            ['label' => 'Image Editing', 'url' => '/services', 'sort_order' => 3, 'children' => [
                ['label' => 'Clipping Path', 'url' => '/services/clipping-path', 'icon' => 'scissors'],
                ['label' => 'Image Masking', 'url' => '/services/image-masking', 'icon' => 'layers'],
                ['label' => 'Car Photo Editing', 'url' => '/services/car-photo-editing', 'icon' => 'car'],
                ['label' => 'Footwear Photo Editing', 'url' => '/services/footwear-photo-editing', 'icon' => 'shoe'],
                ['label' => 'Fashion Photo Editing', 'url' => '/services/fashion-photo-editing', 'icon' => 'shirt'],
                ['label' => 'Event Photo Editing', 'url' => '/services/event-photo-editing', 'icon' => 'calendar'],
                ['label' => 'Photo Retouching', 'url' => '/services/photo-retouching', 'icon' => 'sparkles'],
                ['label' => 'Shadow Creation', 'url' => '/services/shadow-reflection', 'icon' => 'contrast'],
                ['label' => 'Furniture Photo Editing', 'url' => '/services/furniture-photo-editing', 'icon' => 'sofa'],
                ['label' => 'Newborn Photo Edit', 'url' => '/services/newborn-photo-edit', 'icon' => 'baby'],
                ['label' => 'Apparel Photo Editing', 'url' => '/services/apparel-photo-editing', 'icon' => 'shirt'],
                ['label' => 'Color Correction', 'url' => '/services/color-correction', 'icon' => 'palette'],
                ['label' => 'Multi Clipping Path', 'url' => '/services/multi-clipping-path', 'icon' => 'layers'],
                ['label' => 'Ghost Mannequin', 'url' => '/services/ghost-mannequin', 'icon' => 'shirt'],
                ['label' => 'Background Removal', 'url' => '/services/background-removal', 'icon' => 'eraser'],
                ['label' => 'Jewelry Photo Retouch', 'url' => '/services/jewelry-photo-retouch', 'icon' => 'gem'],
            ]],
            ['label' => 'Portfolio', 'url' => '/portfolio', 'sort_order' => 4, 'children' => [
                ['label' => 'E-Commerce Product Photo Editing', 'url' => '/portfolio/e-commerce-product-photo-editing', 'icon' => 'gift'],
                ['label' => 'Shadow Creation Service', 'url' => '/portfolio/shadow-creation-service', 'icon' => 'contrast'],
                ['label' => 'Clipping Path Service', 'url' => '/portfolio/clipping-path-service', 'icon' => 'scissors'],
                ['label' => 'Color Correction Service', 'url' => '/portfolio/color-correction-service', 'icon' => 'palette'],
                ['label' => 'Ghost Mannequin Service', 'url' => '/portfolio/ghost-mannequin-service', 'icon' => 'shirt'],
                ['label' => 'Photo Retouching Services', 'url' => '/portfolio/photo-retouching-services', 'icon' => 'sparkles'],
                ['label' => 'Background Remove And Image Masking', 'url' => '/portfolio/background-remove-and-image-masking', 'icon' => 'eraser'],
                ['label' => 'Photo Retouching For Photographer', 'url' => '/portfolio/photo-retouching-for-photographer', 'icon' => 'camera'],
                ['label' => 'High-Quality Car Photo Editing', 'url' => '/portfolio/high-quality-car-photo-editing', 'icon' => 'car'],
                ['label' => 'Image Restoration Services', 'url' => '/portfolio/image-restoration-services', 'icon' => 'history'],
                ['label' => 'Multi Clipping Path Service', 'url' => '/portfolio/multi-clipping-path-service', 'icon' => 'layers'],
            ]],
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

            // Drop any child left over from an earlier seed run that's no
            // longer in the list above (e.g. a discontinued service) —
            // updateOrCreate() only adds/updates, it never removes stale rows.
            MenuItem::where('parent_id', $parent->id)
                ->whereNotIn('label', array_column($children, 'label'))
                ->delete();
        }

        // ---- Social links --------------------------------------------------
        // `widget` = also shown in the floating chat launcher (bottom-right).
        foreach ([
            ['platform' => 'WhatsApp', 'icon' => 'whatsapp', 'url' => 'https://wa.me/8801538210029', 'widget' => true],
            ['platform' => 'Telegram', 'icon' => 'telegram', 'url' => 'https://t.me/', 'widget' => true],
            ['platform' => 'Messenger', 'icon' => 'messenger', 'url' => 'https://m.me/', 'widget' => true],
            ['platform' => 'WeChat', 'icon' => 'wechat', 'url' => 'https://weixin.qq.com/', 'widget' => true],
            ['platform' => 'Facebook', 'icon' => 'facebook', 'url' => 'https://facebook.com/', 'widget' => true],
            ['platform' => 'LinkedIn', 'icon' => 'linkedin', 'url' => 'https://linkedin.com/', 'widget' => true],
            ['platform' => 'Instagram', 'icon' => 'instagram', 'url' => 'https://instagram.com/', 'widget' => true],
            ['platform' => 'X', 'icon' => 'x', 'url' => 'https://x.com/', 'widget' => false],
            ['platform' => 'YouTube', 'icon' => 'youtube', 'url' => 'https://youtube.com/', 'widget' => false],
            ['platform' => 'Trustpilot', 'icon' => 'star', 'url' => 'https://trustpilot.com/', 'widget' => false],
        ] as $i => $row) {
            SocialLink::updateOrCreate(
                ['platform' => $row['platform']],
                [
                    'icon' => $row['icon'],
                    'url' => $row['url'],
                    'show_in_widget' => $row['widget'],
                    'sort_order' => $i + 1,
                ],
            );
        }

        // ---- Payment methods (logos uploaded later in admin) --------------
        foreach (['Payoneer', 'PayPal', 'Bank Transfer'] as $i => $name) {
            PaymentMethod::updateOrCreate(['name' => $name], ['sort_order' => $i + 1]);
        }
    }
}
