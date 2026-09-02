<?php

namespace Database\Seeders;

use App\Models\FreeTrialPage;
use App\Models\TrialOption;
use Illuminate\Database\Seeder;

class FreeTrialPageSeeder extends Seeder
{
    public function run(): void
    {
        FreeTrialPage::updateOrCreate(['id' => 1], [
            'heading' => 'Flawless Edits within budget and time',
            'highlight' => 'budget and time',
            'sub_text' => 'Please fill out the form and submit a free trial (2-3 Images) for your photo editing project.',
            'form_title' => 'Photo Editing Free Trial (2-3 Images)',
            'map_embed_url' => 'https://maps.google.com/maps?q=Middle%20Pirerbag%2C%20Mirpur%2C%20Dhaka&t=&z=15&ie=UTF8&iwloc=&output=embed',
            'instructions_limit' => 180,
            'max_images' => 10,
        ]);

        $groups = [
            'service' => [
                'Clipping Path', 'Image Masking', 'Photo Retouch', 'Color Correction',
                'Multi Clipping Path', 'Photo Restoration', 'Car Photo Editing', 'Shadow Creation',
                'Ghost Mannequin', 'Footwear Photo Editing', 'Furniture Photo Editing', 'Background Removal',
                'Fashion Photo Editing', 'Newborn Photo Edit', 'Jewelry Photo Retouch', 'Event Photo Editing',
                'Apparel Photo Editing',
            ],
            'timeline' => [
                'Within 12 hours', 'Within 24 hours', '1-2 days', '3-5 days', 'Flexible',
            ],
            'file_format' => [
                'JPG', 'PNG', 'TIFF', 'PSD', 'Same as source',
            ],
            'how_found' => [
                'Google Search', 'Social Media', 'Referral / Friend', 'Blog / Article', 'Other',
            ],
        ];

        foreach ($groups as $group => $labels) {
            foreach ($labels as $i => $label) {
                TrialOption::updateOrCreate(
                    ['group' => $group, 'label' => $label],
                    ['sort_order' => $i + 1, 'is_active' => true],
                );
            }
        }
    }
}
