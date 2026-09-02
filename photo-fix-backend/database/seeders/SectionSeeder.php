<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key' => 'hero',
                'name' => 'Hero',
                'heading' => 'Get Stunning & Flawless Photo Editing Services At Photo Fix Zone!',
                'highlight_text' => 'Photo Fix Zone',
                'sub_heading' => 'We are the leading photo editing service provider working with result-oriented professionals who can lead with flawless images. Get in touch with us.',
                'settings' => ['bg' => 'gradient-hero', 'padding_y' => '72px'],
            ],
            [
                'key' => 'value_cards',
                'name' => 'The Range Of Value We Provide',
                'heading' => 'The Range Of Value We Provide',
                'highlight_text' => 'Value We Provide',
                'body' => "We stand out to provide the best quality video and image editing out of the box!\n\nWe deliver affordable and high-quality photo edits on time. We take the best photo editing process for any business, including photographers, marketing agencies, e-commerce businesses, photo studios, etc. For quality images, get in touch with our industry-standard service that helps you extend more professionally.\n\nWe believe in professionalism, talent, and cutting out excessive marketing costs for the image!",
                'sub_heading' => 'Learn More About Us|#about',
                'settings' => ['bg' => 'bg-alt'],
            ],
            [
                'key' => 'about',
                'name' => 'Accelerate Your Journey',
                'heading' => 'Accelerate Your Journey With PhotoFixZone',
                'highlight_text' => 'With PhotoFixZone',
                'settings' => ['bg' => 'bg-soft'],
            ],
            [
                'key' => 'serving_globally',
                'name' => 'Serving Globally',
                'heading' => 'Serving Globally',
                'sub_heading' => 'Find Out More|/about',
                'settings' => ['bg' => 'bg-soft'],
            ],
            [
                'key' => 'services',
                'name' => 'Most Popular Photo Editing Services',
                'heading' => 'Our Most Popular Photo Editing Services',
                'highlight_text' => 'Photo Editing Services',
                'sub_heading' => 'Do you require professional photos to sell your goods or services? For eCommerce owners and sellers, product photographers, and marketing agencies all around the world, our team of 200+ Photoshop professionals has been processing massive amounts of orders around the clock.',
                'settings' => ['bg' => 'bg-alt'],
            ],
            [
                'key' => 'cta_perfection',
                'name' => 'CTA — Bring The Perfection',
                'settings' => ['bg' => 'gradient-cta'],
            ],
            [
                'key' => 'client_types',
                'name' => 'Top-Tier Clients',
                'heading' => 'Top-Tier Client Of Photo Fix Zone',
                'highlight_text' => 'Photo Fix Zone',
                'sub_heading' => 'We try to help certain businesses who need huge amounts of image editing services. These clients include-',
            ],
            [
                'key' => 'work_process',
                'name' => 'Easiest Work Process',
                'heading' => 'Check Out Our Easiest Work Process',
                'highlight_text' => 'Our Easiest Work Process',
                'sub_heading' => "PhotoFixZone provides excellent eCommerce image editing services such as clipping, retouching, masking, and many more. We're here to help you save time and money in any way we can.",
                'settings' => ['bg' => 'bg-soft'],
            ],
            [
                'key' => 'work_samples',
                'name' => 'Work Samples',
                'heading' => 'Work Sample of Our Satisfied Clients',
                'highlight_text' => 'Our Satisfied Clients',
                'sub_heading' => 'Our potential clients are always glad to meet photo fix zone and the experts are responsible for making their images more special, help them to save time with extraordinary services.',
            ],
            [
                'key' => 'why_choose',
                'name' => 'Why We Are Unique & First-Rated',
                'heading' => 'Why We Are Unique & First-Rated',
                'highlight_text' => 'Unique & First-Rated',
                'settings' => ['bg' => 'bg-alt'],
            ],
            [
                'key' => 'testimonials',
                'name' => 'Testimonials',
                'eyebrow' => 'Clients Feedback',
                'heading' => 'Testimonials',
                'body' => "Check out our satisfied client's feedback. Top-rated Photographers, business owners, and brands around the world.",
                'settings' => ['bg' => 'gradient-brand'],
            ],
            [
                'key' => 'stats',
                'name' => 'Some Magnificent Numbers',
                'heading' => 'Some Magnificent Numbers',
                'highlight_text' => 'Numbers',
                'sub_heading' => 'Get a quick insight into our day-to-day work done by our experts and how they help businesses grow with quality images and videos!',
                'settings' => ['bg' => 'bg-soft'],
            ],
            [
                'key' => 'upload_servers',
                'name' => 'Upload Files To Our Servers',
                'heading' => 'Upload Files To Our WeTransfer & Dropbox Server',
                'highlight_text' => 'WeTransfer & Dropbox Server',
                'sub_heading' => 'We discovered the best platform for sharing large files around the world. So, this is how we receive and deliver you pictures and videos.',
                'settings' => ['bg' => 'bg-dark'],
            ],
            [
                'key' => 'faq',
                'name' => 'FAQ',
                'heading' => 'Questions Our Clients Ask Frequently',
                'highlight_text' => 'Ask Frequently',
                'sub_heading' => "We provide the best possible service that fulfill your necessities and our specialist team works with full focus to make things easier for our potential clients. Here are our clients' most frequently asked questions that help you before starting with PhotoFixZone!",
                'settings' => ['bg' => 'bg-alt'],
            ],
            [
                'key' => 'blog',
                'name' => 'Blogs & Articles',
                'heading' => 'Blogs & Articles',
                'highlight_text' => 'Articles',
                'sub_heading' => 'Get the best blog and article to know more about photo editing and why you need to stick with the best editing service.',
            ],
            [
                'key' => 'contact',
                'name' => 'Contact — Page Heading',
                'heading' => 'All Great Things Start With A Conversation',
                'highlight_text' => 'Conversation',
                'sub_heading' => "For any inquiries, simply send us a message here and we'll reply back instantly. In some cases it usually takes up to 24 hours.",
                'settings' => ['bg' => 'gradient-hero'],
            ],
        ];

        foreach ($sections as $i => $data) {
            Section::updateOrCreate(
                ['key' => $data['key']],
                array_merge($data, ['sort_order' => ($i + 1) * 10, 'is_active' => true]),
            );
        }
    }
}
