<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ---- Featured on the homepage teaser too --------------------
            [
                'slug' => 'clipping-path',
                'title' => 'Clipping Path',
                'icon' => 'scissors',
                'btn_label' => 'More About Clipping Path',
                'short_desc' => 'We are compelled to give first-rate Clipping Path service at an affordable cost for all categories including transparent background, background removal, image cut-out photo etching and more!',
                'points' => ['Pixel Perfect Clipping Path', '100% Manually created', 'Discount on Bulk Order', 'Excellent Prices'],
            ],
            [
                'slug' => 'photo-retouching',
                'title' => 'Photo Retouching',
                'icon' => 'sparkles',
                'btn_label' => 'More About Retouching',
                'short_desc' => 'Our Photo retouching experts can change any studio image into a publication-quality artwork. In addition, we clean the imperfections in photos in an exclusive way that have photography issues pertaining to exposure, color, blurriness, blemishes, and reflections.',
                'points' => ['High-End Retouching', 'Perfect for any Industry', 'Perfect Results Guaranteed', 'Unlimited Revisions with Low Prices'],
            ],
            [
                'slug' => 'image-masking',
                'title' => 'Image Masking',
                'icon' => 'layers',
                'btn_label' => 'More About Image Masking',
                'short_desc' => "Outsource Photo Fix Zone's photo masking with advance level of masking, get it quickly done through great manipulation technique of our special team.",
                'points' => ['Smooth and Flawless Results', 'Free Trial Opportunity', 'Excellent Prices with Quick Turnaround', '100% Satisfaction Guaranteed'],
            ],
            [
                'slug' => 'ghost-mannequin',
                'title' => 'Ghost Mannequin',
                'icon' => 'shirt',
                'btn_label' => 'More About Ghost Mannequin',
                'short_desc' => 'Outsource your ghost mannequin project and get it quickly done and delivered remotely online. With our ghost mannequin service, your product will be photographed on a mannequin that is completely invisible.',
                'points' => ['Perfect for E-commerce Products', 'Mannequin Removing and Replacement', 'Perfect Results Guaranteed', 'Unlimited Revisions with Low Prices'],
            ],
            [
                'slug' => 'shadow-reflection',
                'title' => 'Shadow Creation',
                'icon' => 'contrast',
                'btn_label' => 'More About Shadow Creation',
                'short_desc' => 'Reflection shadow makes an image look as if your product or object was photographed on a reflective surface, like a glass mirror. Our Reflection shadow service allows you to make your image more realistic.',
                'points' => ['Realistic Shadows', 'Bulk Production Facility', '3 Step Quality Check', 'Affordable Pricing'],
            ],
            [
                'slug' => 'color-correction',
                'title' => 'Color Correction',
                'icon' => 'palette',
                'btn_label' => 'More About Color Correction',
                'short_desc' => 'We provide professional color correction for businesses at the most competitive price. You can get the professional touch of sharpening, color correction, shadow and tint edit & noise reduction in the image.',
                'points' => ['Perfect Color Match and Fixing', 'Accurate Color Tone Adjusting', 'Color Balancing', 'Pattern Changing'],
            ],
            [
                'slug' => 'background-removal',
                'title' => 'Background Removal',
                'icon' => 'eraser',
                'btn_label' => 'More About Background Removal',
                'short_desc' => 'Outsource your background removal project and get it quickly done! Utilize our cost-effective image background removal service for your marketing agency, e-commerce, or photography business.',
                'points' => ['Accurate Photo Cut Out', 'Bulk Production Facility', 'Competitive Pricing', 'Quickest Delivery within 24 hours'],
            ],

            // ---- Full catalogue (services page + "Image Editing" nav menu),
            // not featured on the homepage teaser so it stays concise --------
            [
                'slug' => 'car-photo-editing',
                'title' => 'Car Photo Editing',
                'icon' => 'car',
                'btn_label' => 'More About Car Photo Editing',
                'short_desc' => 'Give your automotive photos a showroom-ready shine. We retouch reflections, remove background clutter, and enhance every angle so your cars sell faster.',
                'points' => ['Reflection & Glare Cleanup', 'Background Replacement', 'Color & Shine Enhancement', 'Bulk Order Discounts'],
                'is_featured' => false,
            ],
            [
                'slug' => 'footwear-photo-editing',
                'title' => 'Footwear Photo Editing',
                'icon' => 'shoe',
                'btn_label' => 'More About Footwear Photo Editing',
                'short_desc' => 'From sneakers to heels, we retouch and clean up your footwear photos so every stitch, texture and color pops on your store shelf.',
                'points' => ['Crisp Product Detailing', 'Consistent White Background', 'True-to-Life Color', 'Fast Turnaround'],
                'is_featured' => false,
            ],
            [
                'slug' => 'fashion-photo-editing',
                'title' => 'Fashion Photo Editing',
                'icon' => 'shirt',
                'btn_label' => 'More About Fashion Photo Editing',
                'short_desc' => 'Our fashion retouching team polishes skin, fabric and lighting so your apparel shoots look editorial-grade and ready to publish.',
                'points' => ['Skin & Fabric Retouching', 'Color Consistency Across Sets', 'Editorial-Grade Finish', 'Quick Bulk Delivery'],
                'is_featured' => false,
            ],
            [
                'slug' => 'event-photo-editing',
                'title' => 'Event Photo Editing',
                'icon' => 'calendar',
                'btn_label' => 'More About Event Photo Editing',
                'short_desc' => 'Weddings, concerts, corporate events — we clean up crowds, lighting and color so every memory looks as good as it felt.',
                'points' => ['Skin & Color Correction', 'Distraction Removal', 'Consistent Album Look', 'Fast Bulk Editing'],
                'is_featured' => false,
            ],
            [
                'slug' => 'photo-restoration',
                'title' => 'Photo Restoration',
                'icon' => 'history',
                'btn_label' => 'More About Photo Restoration',
                'short_desc' => "Torn, faded or damaged photos brought back to life — pixel by pixel — so your family's memories are never lost.",
                'points' => ['Scratch & Tear Repair', 'Color & Fade Correction', 'Missing Detail Reconstruction', 'Archival-Quality Output'],
                'is_featured' => false,
            ],
            [
                'slug' => 'furniture-photo-editing',
                'title' => 'Furniture Photo Editing',
                'icon' => 'sofa',
                'btn_label' => 'More About Furniture Photo Editing',
                'short_desc' => 'We clean up texture, shadow and background on furniture photography so every piece looks catalog-ready.',
                'points' => ['Texture & Grain Enhancement', 'Clean Shadow & Reflection', 'Consistent Studio Background', 'Bulk Catalog Ready'],
                'is_featured' => false,
            ],
            [
                'slug' => 'newborn-photo-edit',
                'title' => 'Newborn Photo Edit',
                'icon' => 'baby',
                'btn_label' => 'More About Newborn Photo Editing',
                'short_desc' => 'Gentle, careful retouching for newborn and maternity photography — soft skin tones, clean backgrounds, nothing overdone.',
                'points' => ['Soft Skin Retouching', 'Gentle Color Grading', 'Clean, Distraction-Free Background', 'Careful, Natural Results'],
                'is_featured' => false,
            ],
            [
                'slug' => 'apparel-photo-editing',
                'title' => 'Apparel Photo Editing',
                'icon' => 'shirt',
                'btn_label' => 'More About Apparel Photo Editing',
                'short_desc' => "Ghost mannequin, wrinkle removal and color-true edits for apparel photography that's ready for your storefront.",
                'points' => ['Wrinkle & Lint Removal', 'True-to-Life Fabric Color', 'Ghost Mannequin Ready', 'Bulk Order Support'],
                'is_featured' => false,
            ],
            [
                'slug' => 'multi-clipping-path',
                'title' => 'Multi Clipping Path',
                'icon' => 'layers',
                'btn_label' => 'More About Multi Clipping Path',
                'short_desc' => 'Complex products with multiple parts and colors? Our multi clipping path service isolates every element for full editing control.',
                'points' => ['Element-by-Element Paths', 'Independent Color Editing', 'Pixel-Perfect Precision', 'Complex Product Ready'],
                'is_featured' => false,
            ],
            [
                'slug' => 'jewelry-photo-retouch',
                'title' => 'Jewelry Photo Retouch',
                'icon' => 'gem',
                'btn_label' => 'More About Jewelry Photo Retouching',
                'short_desc' => 'Diamonds, metal and gemstones deserve flawless sparkle. We retouch reflections, dust and imperfections for luxury-grade jewelry photos.',
                'points' => ['Sparkle & Reflection Enhancement', 'Dust & Scratch Removal', 'True Metal & Stone Color', 'Luxury-Grade Finish'],
                'is_featured' => false,
            ],
        ];

        foreach ($services as $i => $data) {
            $points = $data['points'];
            $featured = $data['is_featured'] ?? true;
            unset($data['points'], $data['is_featured']);

            $service = Service::updateOrCreate(
                ['slug' => $data['slug']],
                $data + [
                    'sort_order' => $i + 1,
                    'is_active' => true,
                    'is_featured' => $featured,
                    'long_desc' => '<p>'.$data['short_desc'].'</p>',
                    'seo_title' => $data['title'].' Service | Photo Fix Zone',
                    'seo_description' => $data['short_desc'],
                ],
            );

            $service->points()->delete();
            foreach ($points as $pi => $text) {
                $service->points()->create(['text' => $text, 'sort_order' => $pi + 1]);
            }
        }
    }
}
