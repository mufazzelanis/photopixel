<?php

namespace Database\Seeders;

use App\Models\FooterColumn;
use App\Models\FooterLink;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $columns = [
            'Top Service' => [
                ['Clipping Path', '/services/clipping-path'],
                ['Color Corrections', '/services/color-correction'],
                ['Ghost Mannequin', '/services/ghost-mannequin'],
                ['Photo Retouch', '/services/photo-retouching'],
                ['Shadow Creation', '/services/shadow-reflection'],
                ['Image Masking', '/services/image-masking'],
                ['Car Photo Editing', '/services/car-photo-editing'],
                ['Photo Restorations', '/services/photo-restorations'],
            ],
            'Company' => [
                ['About Us', '/about'],
                ['Contact Us', '/contact'],
                ['Image Portfolio', '/portfolio'],
                ['Our Blog', '/blog'],
                ['Terms of Service', '/terms-of-service'],
                ['Privacy Policies', '/privacy-policy'],
            ],
        ];

        foreach (array_values($columns) as $ci => $links) {
            $title = array_keys($columns)[$ci];
            $column = FooterColumn::updateOrCreate(['title' => $title], ['sort_order' => $ci + 1]);

            foreach ($links as $li => [$label, $url]) {
                FooterLink::updateOrCreate(
                    ['footer_column_id' => $column->id, 'label' => $label],
                    ['url' => $url, 'sort_order' => $li + 1],
                );
            }
        }
    }
}
