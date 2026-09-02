<?php

namespace Database\Seeders;

use App\Models\WorkSample;
use App\Models\WorkSampleCategory;
use Illuminate\Database\Seeder;

class WorkSampleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'E-Commerce Product Photo Editing',
                'icon' => 'gift',
                'description' => "Are you expanding your online store? Your eCommerce products will be edited by our talented photo editors so that buyers will love them and click to purchase them.",
                'samples' => ['Smartwatch — Product Edit', 'Headphones — Product Edit', 'Handbag — Product Edit', 'Baby Stroller — Product Edit'],
            ],
            [
                'name' => 'Shadow Creation Service',
                'icon' => 'contrast',
                'description' => "A perfect shadow can give your photos the necessary depth and dimension to look their best. A high-quality realistic image can increase your product's reliability and attract more customers.",
                'samples' => ['Sunglasses — Drop Shadow', 'Bicycle — Drop Shadow', 'Earrings — Reflection Shadow', 'Belt — Natural Shadow'],
            ],
            [
                'name' => 'Clipping Path Service',
                'icon' => 'scissors',
                'description' => "An aesthetic product photo can instantly grab your prospect's attention and skyrocket your conversion rate. Our pixel-perfect hand-drawn clipping path solutions will give you a clean product image on your desired background. A clean and relatable product photo can engage your customers and convert more sales.",
                'samples' => ['Necklace — Clipping Path', 'Pressure Washer — Clipping Path', 'Motorcycle — Clipping Path', 'Flower Bouquet — Clipping Path'],
            ],
            [
                'name' => 'Color Correction Service',
                'icon' => 'palette',
                'description' => "Color correction is more than just a photo editing skill. It needs vision. Just place your order, and our creative photo editors will give your images the perfect realistic color tone that conveys your message.",
                'samples' => ['Handbag — Color Correction', 'Ice Cream Tub — Color Correction', 'Dog Collar — Color Correction', 'Backpack — Color Correction'],
            ],
            [
                'name' => 'Ghost Mannequin Service',
                'icon' => 'shirt',
                'description' => "Are you scaling up your apparel business? Our highly decorated photo editors will mannequin your products so that customers can imagine wearing these items and clicking to buy them.",
                'samples' => ['Sweater — Ghost Mannequin', 'Hoodie — Ghost Mannequin', 'Dress — Ghost Mannequin', 'Top — Ghost Mannequin'],
            ],
            [
                'name' => 'Photo Retouching Services',
                'icon' => 'sparkles',
                'description' => "Don't have time or expertise to edit photos for personal or business purposes? Are you a professional photographer or a freelancer agency with tons of due edits to be done, or are you an eCommerce retailer who prefers to invest your time in business? If you are anyone of them, then Photo Fix Zone can leverage your valuable time & help expand your business.",
                'samples' => ['Swimwear — Retouch', 'Pants — Retouch', 'Camera Clamp — Retouch', 'Soda Can — Retouch'],
            ],
            [
                'name' => 'Background Remove And Image Masking',
                'icon' => 'eraser',
                'description' => "Do you need an image masking service for a photo containing hairs, furs, or countless undefined edges? Our experienced image masking team will do this job for you to save your time and brainpower for more creative work.",
                'samples' => ['Portrait — Background Removal', 'Curly Hair — Fine-Edge Masking', 'Legs — Silhouette Masking', 'Smiling Portrait — Background Removal'],
            ],
            [
                'name' => 'Photo Retouching For Photographer',
                'icon' => 'camera',
                'description' => "Are you a photographer and trying to expand your business? Outsource our experienced photo editor to retouch and edit your captures professionally to attract & satisfy more clients.",
                'samples' => ['Portrait — Skin Retouch', 'Studio Portrait — Retouch', 'Streetwear — Retouch', 'Portrait — Retouch'],
            ],
            [
                'name' => 'High-Quality Car Photo Editing',
                'icon' => 'car',
                'description' => "Want to boost your car sales with a gorgeous-looking car photo? Our expert image editor will give your car photos an elegant look and expand your business.",
                'samples' => ['Electric Hatchback — Car Edit', 'SUV — Car Edit', 'Crossover — Car Edit', 'Hatchback — Car Edit'],
            ],
            [
                'name' => 'Image Restoration Services',
                'icon' => 'history',
                'description' => "Are your memorable photos becoming blurry and getting damaged? Don't let your sweet memories be lost. Give it to us, and our skilled team will restore it pixel-by-pixel.",
                'samples' => ['Vintage Portrait — Restoration', 'Family Photo — Restoration', 'Military Portrait — Restoration', 'Old ID Photo — Restoration'],
            ],
            [
                'name' => 'Multi Clipping Path Service',
                'icon' => 'layers',
                'description' => "Want your products ready before launching? Our experienced photo editing team will take care of your images and place every element perfectly to look right. So, you can focus your time and energy on more critical jobs.",
                'samples' => ['Dress — Multi Clipping Path', 'Hoodie — Multi Clipping Path', 'Wheelchair — Multi Clipping Path', 'Ring — Multi Clipping Path'],
            ],
        ];

        foreach ($categories as $i => $cat) {
            $category = WorkSampleCategory::updateOrCreate(
                ['name' => $cat['name']],
                [
                    'icon' => $cat['icon'],
                    'description' => $cat['description'],
                    'sort_order' => $i + 1,
                ],
            );

            foreach ($cat['samples'] as $j => $title) {
                WorkSample::updateOrCreate(
                    ['work_sample_category_id' => $category->id, 'title' => $title],
                    ['sort_order' => $j + 1],
                );
            }
        }
    }
}
