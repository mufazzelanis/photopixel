<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $general = BlogCategory::updateOrCreate(['slug' => 'photo-editing'], ['name' => 'Photo Editing', 'sort_order' => 1]);
        BlogCategory::updateOrCreate(['slug' => 'guides'], ['name' => 'Guides', 'sort_order' => 2]);

        $posts = [
            [
                'title' => 'Why Pros Never Use A Photoshop Crack?',
                'slug' => 'why-pros-never-use-a-photoshop-crack',
                'excerpt' => 'Cracked software looks free until it costs you your files, your clients and your reputation. Here is why every serious editor pays for a licence.',
                'read_time' => '5 min read',
                'published_at' => now()->subDays(4)->setTime(10, 59),
            ],
            [
                'title' => 'Why Manual Clipping Path Is Essential For Perfect Background Removal?',
                'slug' => 'why-manual-clipping-path-is-essential-for-perfect-background-removal',
                'excerpt' => 'Automatic tools miss the hard edges — hair, glass, fur. A hand-drawn path is still the gold standard for a clean cut-out.',
                'read_time' => '6 min read',
                'published_at' => now()->subDays(3)->setTime(12, 32),
            ],
            [
                'title' => 'How Big Is A 5×7 Photo | What You Should Know Before Printing',
                'slug' => 'how-big-is-a-5x7-photo-what-you-should-know-before-printing',
                'excerpt' => 'Pixel dimensions, DPI and bleed — everything you need to prep a 5×7 so it prints sharp and full-frame.',
                'read_time' => '4 min read',
                'published_at' => now()->subDays(2)->setTime(13, 3),
            ],
        ];

        foreach ($posts as $p) {
            BlogPost::updateOrCreate(['slug' => $p['slug']], array_merge($p, [
                'blog_category_id' => $general->id,
                'author_name' => 'Photo Fix Zone',
                'is_published' => true,
                'body' => '<p>'.$p['excerpt'].'</p><p>Full article content is editable from the admin panel.</p>',
                'seo_title' => $p['title'],
                'seo_description' => $p['excerpt'],
            ]));
        }
    }
}
