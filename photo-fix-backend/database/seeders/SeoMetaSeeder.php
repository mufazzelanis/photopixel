<?php

namespace Database\Seeders;

use App\Models\SeoMeta;
use Illuminate\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['page_key' => 'home', 'title' => 'Photo Fix Zone — Professional Photo & Video Editing Services', 'description' => 'Get stunning & flawless photo editing services at Photo Fix Zone. Clipping path, retouching, masking, ghost mannequin, background removal, color correction and more.'],
            ['page_key' => 'about', 'title' => 'About Photo Fix Zone', 'description' => 'An outstanding team of passionate photo & video editing experts serving businesses and individuals internationally.'],
            ['page_key' => 'contact', 'title' => 'Contact Photo Fix Zone', 'description' => 'Get in touch for a free quote on photo and video editing. Fast turnaround, unlimited revisions.'],
            ['page_key' => 'services', 'title' => 'Photo Editing Services — Photo Fix Zone', 'description' => 'Our most popular photo editing services processed around the clock by 200+ Photoshop professionals.'],
            ['page_key' => 'blog', 'title' => 'Blogs & Articles — Photo Fix Zone', 'description' => 'Guides and articles about photo editing and why quality editing matters for your brand.'],
            ['page_key' => 'portfolio', 'title' => 'Portfolio — Photo Fix Zone', 'description' => 'Before/after work samples from our satisfied clients.'],
            ['page_key' => 'pricing', 'title' => 'Pricing — Photo Fix Zone', 'description' => 'Budget-friendly, competitive pricing for image and video editing.'],
            ['page_key' => 'free-trial', 'title' => 'Free Trial — Photo Fix Zone', 'description' => 'Submit 2-3 images for a free photo editing trial. See our quality before you order.'],
        ];

        foreach ($pages as $p) {
            SeoMeta::updateOrCreate(['page_key' => $p['page_key']], $p + ['robots' => 'index,follow']);
        }
    }
}
