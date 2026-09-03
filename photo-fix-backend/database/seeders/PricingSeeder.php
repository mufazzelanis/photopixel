<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    public function run(): void
    {
        // ---- /pricing page heading ---------------------------------------
        Section::updateOrCreate(['key' => 'pricing'], [
            'name' => 'Pricing',
            'heading' => 'Simply Continue With Our Affordable And Flexible Plans',
            'highlight_text' => 'Affordable And Flexible Plans',
            'sub_heading' => 'Transparent, per-image pricing for every service. Volume discounts apply — send us your batch for an exact quote.',
            'is_active' => true,
        ]);

        // ---- Itemized price lists, per service ---------------------------
        $tables = [
            'clipping-path' => [
                'starting_price' => '$0.39',
                'items' => [
                    ['Basic Clipping Path Service', '$0.39'],
                    ['Clipping Path With Shadows', '$0.79'],
                    ['Simple Clipping Path', '$0.49'],
                    ['Medium Clipping Path', '$1.25'],
                    ['Complex Clipping Path', '$2.50'],
                    ['Super Complex Clipping Path', '$5.50'],
                    ['Clipping Path Flatness', '$0.50'],
                    ['Extra Super Complex Clipping Path', '$9.50'],
                    ['Remove Unwanted Objects', '$1.00'],
                ],
            ],
            'photo-retouching' => [
                'starting_price' => '$0.30',
                'items' => [
                    ['Product Photo Background Remove', '$0.59'],
                    ['Product Photo Background Remove & Shadow Effect', '$0.89'],
                    ['Product Photo Cleaning And Background Remove', '$1.00'],
                    ['Product Photo Retouching & Enhancement', '$2.00'],
                    ['Product Photo Cropping & Resizing', '$0.30'],
                    ['Headshots or Portraits Retouching', '$1.50'],
                    ['Body Retouching And Reshaping', '$3.50'],
                    ['Beauty Retouching', '$3.00'],
                    ['Skin Retouching', '$2.00'],
                    ['Dust, Spot Removal', '$0.59'],
                    ['Dust, Spot And Scratch Removal', '$1.49'],
                    ['Camera Reflection Removal', '$0.69'],
                ],
            ],
            'ghost-mannequin' => [
                'starting_price' => '$0.80',
                'items' => [
                    ['Neck Joint on Ghost Mannequin', '$0.80'],
                    ['Neck Joint & Wrinkles Remove', '$1.50'],
                    ['Neck Joint Wrinkles Remove & Liquify', '$2.25'],
                    ['Neck & Bottom Joints', '$1.50'],
                    ['Neck & Bottom Joints + Wrinkles Remove', '$2.25'],
                    ['Neck & Bottom Joints Wrinkles Remove & Liquify', '$2.50'],
                    ['Neck & Sleeves Joints on Ghost Mannequin', '$1.50'],
                    ['Neck & Sleeves Joints & Wrinkles Remove', '$2.50'],
                    ['Neck & Sleeves Joints & Wrinkles Remove & Liquify', '$3.00'],
                ],
            ],
            'color-correction' => [
                'starting_price' => '$0.99',
                'items' => [
                    ['Color Corrections', '$0.99'],
                    ['Color Conversion / Editing', '$1.49'],
                    ['Product Photography Color Editing', '$2.00'],
                    ['Color Restoration', '$2.00'],
                    ['Multi Path & Color Editing', '$2.50'],
                    ['Exposure Corrections', '$1.00'],
                ],
            ],
            'image-masking' => [
                'starting_price' => '$1.25',
                'items' => [
                    ['Layer Masking', '$1.25'],
                    ['Hair And Fur Masking', '$2.00'],
                    ['Transparent Image Masking', '$2.49'],
                    ['Alpha Channel Masking', '$2.00'],
                    ['Refine Edge Masking', '$2.50'],
                    ['Product or Object Masking', '$2.50'],
                ],
            ],
            'jewelry-photo-retouch' => [
                'starting_price' => '$0.89',
                'items' => [
                    ['Jewelry Photo Background Remove', '$0.89'],
                    ['Jewelry Photo Background Remove (Complex)', '$2.00'],
                    ['Jewelry Photo Editing Services', '$5.50'],
                    ['Jewelry Photo Background Remove & Shadow Effect', '$1.50'],
                    ['Jewelry Photo Cleaning And Background Remove', '$1.50'],
                    ['Jewelry Photo Retouching & Enhancement', '$3.50'],
                ],
            ],
            'shadow-reflection' => [
                'starting_price' => '$1.50',
                'items' => [
                    ['Clipping Path With Drop Shadows', '$1.50'],
                    ['Clipping Path With Reflections Creation', '$2.00'],
                    ['Retain Original Shadow', '$2.50'],
                    ['Shadow Removal', '$2.00'],
                ],
            ],
            'photo-restoration' => [
                'starting_price' => '$9.50',
                'items' => [
                    ['Black & White Photo Restoration', '$9.50'],
                    ['Damaged Photo Restoration', '$12.00'],
                    ['Image Color Restore', '$15.50'],
                    ['Blurred Photo Restoration', '$12.00'],
                ],
            ],
            'car-photo-editing' => [
                'starting_price' => '$1.50',
                'items' => [
                    ['Background Remove And Shadow', '$1.50'],
                    ['Background Remove, Basic Retouch And Shadow', '$2.50'],
                    ['BG Remove, Basic Retouch, Shadow & Color Correction', '$3.50'],
                    ['BG Remove, Complex Retouch, Shadow & Color Correction', '$8.00'],
                ],
            ],
        ];

        foreach ($tables as $slug => $table) {
            $service = Service::where('slug', $slug)->first();
            if (! $service) {
                continue;
            }

            $service->update(['starting_price' => $table['starting_price']]);
            $service->priceItems()->delete();
            foreach ($table['items'] as $i => [$label, $price]) {
                $service->priceItems()->create(['label' => $label, 'price' => $price, 'sort_order' => $i + 1]);
            }
        }

        // ---- /pricing page FAQ -------------------------------------------
        foreach ([
            ['question' => 'How To Get A Free Trial?', 'answer' => 'Just head to our Free Trial page, upload up to 5 sample images and tell us which service you need — we\'ll edit and return them within 24 hours, no cost and no obligation.'],
            ['question' => 'What Kind Of File Types Do You Accept?', 'answer' => 'We work with JPG, PNG, TIFF, PSD, RAW and most common camera formats. If you have a specific format in mind, just ask — we can almost always accommodate it.'],
            ['question' => 'Do You Offer Discount?', 'answer' => 'Yes — the more images you send in a single order, the lower your per-image price. Get in touch with your volume and we\'ll put together a custom quote.'],
            ['question' => 'How To Share Files With You?', 'answer' => 'You can upload directly through our WeTransfer or Dropbox links (see the "Upload Files" section), or attach them to your quote/free-trial request.'],
        ] as $i => $f) {
            Faq::updateOrCreate(
                ['question' => $f['question']],
                $f + ['group' => 'pricing', 'sort_order' => $i + 1, 'is_active' => true],
            );
        }
    }
}
