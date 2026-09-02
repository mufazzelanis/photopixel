<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
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
                'title' => 'Shadow & Reflection',
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
        ];

        foreach ($services as $i => $data) {
            $points = $data['points'];
            unset($data['points']);

            $service = Service::updateOrCreate(
                ['slug' => $data['slug']],
                $data + [
                    'sort_order' => $i + 1,
                    'is_active' => true,
                    'is_featured' => true,
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
