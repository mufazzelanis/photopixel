<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\WorkSampleCategory;
use Illuminate\Database\Seeder;

/**
 * Links each service to its matching Portfolio category (by slug) so the
 * service detail page can show that category's real "Work Samples" gallery.
 * Must run after both ServiceSeeder and WorkSampleCategorySeeder.
 */
class ServicePortfolioLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            'clipping-path' => 'clipping-path-service',
            'photo-retouching' => 'photo-retouching-services',
            'image-masking' => 'background-remove-and-image-masking',
            'ghost-mannequin' => 'ghost-mannequin-service',
            'shadow-reflection' => 'shadow-creation-service',
            'color-correction' => 'color-correction-service',
            'background-removal' => 'background-remove-and-image-masking',
            'car-photo-editing' => 'high-quality-car-photo-editing',
            'photo-restoration' => 'image-restoration-services',
            'multi-clipping-path' => 'multi-clipping-path-service',
        ];

        foreach ($links as $serviceSlug => $categorySlug) {
            $service = Service::where('slug', $serviceSlug)->first();
            $category = WorkSampleCategory::where('slug', $categorySlug)->first();

            if ($service && $category) {
                $service->update(['work_sample_category_id' => $category->id]);
            }
        }
    }
}
