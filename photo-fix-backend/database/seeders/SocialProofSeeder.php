<?php

namespace Database\Seeders;

use App\Models\ClientType;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class SocialProofSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Top-Tier client types -----------------------------------
        $clients = [
            ['title' => 'Photographers', 'body' => 'All photographers who have just begun or are highly professional should retouch their photos skilfully to attach maximum clients. On PhotoFixZone you will get everything that makes your image perfect and smooth!'],
            ['title' => 'Photo Studio & Agency', 'body' => 'Increasing your photo studio production with quality images! make your image more live and enhance your images to make them more powerful.'],
            ['title' => 'Ecommerce Business', 'body' => 'Need Photo Editing Services for Your E-commerce Business? You can get more value for just a small cost when you choose our team!'],
            ['title' => 'Digital Agency', 'body' => "A high-quality image is sometimes enough to increase sales! for social media to web feature images you need a unique image that photofixzone can assure you're essentials."],
        ];
        foreach ($clients as $i => $c) {
            ClientType::updateOrCreate(['title' => $c['title']], $c + ['link_label' => 'Learn more', 'link_url' => '/about', 'sort_order' => $i + 1]);
        }

        // ---- Testimonials -------------------------------------------------
        $testimonials = [
            ['name' => 'Mark', 'role' => 'Business Owner', 'rating' => 5, 'quote' => "I was amazed at how perfectly Pixel Graphic Studio handled my images. They removed the background with such precision, and the retouching looked so natural. I've tried many services before, but this is by far the best."],
            ['name' => 'Sarah', 'role' => 'Creative Director', 'rating' => 5, 'quote' => 'I sent in some complex images that needed detailed editing, and the results were flawless. The team at Pixel Graphic Studio is highly skilled, and their customer service is excellent. They truly understand what clients need.'],
            ['name' => 'David H', 'role' => 'Photographer', 'rating' => 5, 'quote' => "As a photographer, I'm very particular about my images. I needed some advanced retouching, and Pixel Graphic Studio did a fantastic job. They enhanced my photos while keeping them natural and realistic."],
        ];
        foreach ($testimonials as $i => $t) {
            Testimonial::updateOrCreate(['name' => $t['name'], 'role' => $t['role']], $t + ['sort_order' => $i + 1]);
        }
        // Work sample categories + samples now live in WorkSampleCategorySeeder,
        // since each category is its own admin-editable /portfolio/{slug} page.
    }
}
