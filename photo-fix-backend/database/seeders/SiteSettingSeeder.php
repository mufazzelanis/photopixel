<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // group, key, value, type
            ['general', 'site_name', 'Photo Fix Zone', 'text'],
            ['general', 'logo_text', 'Photo Fix Zone', 'text'],
            ['general', 'tagline', 'All-In-One Image Editing Service', 'text'],
            ['general', 'footer_about', 'Photo Fix Zone is your All-In-One Image Editing Service Stoppage. Whatever the image editing services you need, we ensure high-quality results with expert professionals.', 'textarea'],
            ['general', 'copyright', 'Copyright © 2026 | Photo Fix Zone | All Rights Reserved', 'text'],

            ['contact', 'address', '348/P, 60 Feet Road, Middle Pirerbag, Mirpur, Dhaka – 1216', 'textarea'],
            ['contact', 'email', 'office@photofixzone.com', 'text'],
            ['contact', 'phone', '(+880) 1538210029', 'text'],
            ['contact', 'quote_notify_email', 'office@photofixzone.com', 'text'],
            ['contact', 'map_embed_url', 'https://www.google.com/maps?q=348%2FP%2C+60+Feet+Road%2C+Middle+Pirerbag%2C+Mirpur%2C+Dhaka-1216%2C+Bangladesh&output=embed', 'text'],

            ['newsletter', 'heading', 'Subscribe Now', 'text'],
            ['newsletter', 'placeholder', 'Email Us', 'text'],
            ['newsletter', 'button_label', 'Subscribe', 'text'],

            ['cta', 'header_button_label', 'GET A QUOTE', 'text'],
            ['cta', 'header_button_url', '#quote', 'text'],

            ['scripts', 'head_scripts', '', 'textarea'],
            ['scripts', 'body_scripts', '', 'textarea'],
            ['scripts', 'google_analytics_id', '', 'text'],

            ['seo', 'default_title', 'Photo Fix Zone — Professional Photo & Video Editing Services', 'text'],
            ['seo', 'default_description', 'Get stunning & flawless photo editing services at Photo Fix Zone. Clipping path, retouching, masking, ghost mannequin, background removal and more.', 'textarea'],

            ['recaptcha', 'enabled', '0', 'boolean'],
            ['recaptcha', 'site_key', '', 'text'],
            ['recaptcha', 'secret_key', '', 'text'],
        ];

        foreach ($rows as [$group, $key, $value, $type]) {
            SiteSetting::updateOrCreate(
                ['group' => $group, 'key' => $key],
                ['value' => $value, 'type' => $type],
            );
        }
    }
}
