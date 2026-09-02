<?php

namespace Database\Seeders;

use App\Models\AboutFeature;
use App\Models\AboutPage;
use App\Models\AboutPartnershipPoint;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        AboutPage::updateOrCreate(['id' => 1], [
            'hero_heading' => 'PhotoFixZone, Your Smart One-Stop Photo Editing Solution',
            'hero_highlight' => 'One-Stop Photo Editing Solution',
            'hero_sub_text' => 'We have our most experienced photo editing experts to make your ordinary photo looks professional. Our editors will do any editing, retouching, or restoration work in your required time. Click the Try For Free button, and we will be there for you anytime.',
            'hero_primary_label' => 'Try For Free',
            'hero_primary_url' => '/free-trial',
            'hero_secondary_label' => 'SEE SAMPLES',
            'hero_secondary_url' => '/portfolio',

            'boost_heading' => 'Boost Your Business By Partnering With PhotoFixZone',
            'boost_highlight' => 'Partnering With PhotoFixZone',
            'boost_sub_text' => 'By partnering with us, you will associate with a team of our creative people as your extension. Just upload raw pictures with your requirement. Our visionary professionals will handle the rest.',

            'pp_heading' => 'We Deliver Premium Quality Photo Post-Production Service',
            'pp_highlight' => 'Post-Production Service',
            'pp_body_1' => 'Our journey as PhotoFixZone began in 2019 with only four designers. The following year, a pandemic struck humanity all over the planet, affecting everything. Our growth is also affected by this incident. Even so, we decided to expand and include more photo editors in our family. This decision benefits us in two ways. First, we became more capable of assisting our clients in scaling up their businesses during this pandemic. Second, we were able to provide a payable job to our community to support their family in this challenging situation. Consequently, we grow as a big family of 45 designers and 15 other employees.',
            'pp_body_2' => 'Our designers are continually learning new design techniques and technologies. As a result, they can handle your wide range of design requirements, including Portrait Retouching, Wedding Photo Editing, Background Removal, Body Retouching, Photo Restoration, Jewelry Photo Retouching, Graphic Designing, Real Estate Photo Editing, Infographic, Social Media Banner design, and lot more. We are generating impressive results for our existing customers, including professional photographers, e-commerce brands, real estate developers, agencies, web design firms, a few clothing companies, and many others. Our team can deliver 2500 edited photos daily and provide 24/7 customer support.',
            'pp_btn_label' => 'Get Started',
            'pp_btn_url' => '#quote',

            'society_heading' => 'Your Action Can Have A Positive Impact On Society',
            'society_highlight' => 'On Society',
            'society_body_1' => "Children and the environment are the two most important things that can determine humanity's future. That's why we spend 5% of our net profit on child care, children's education, and tree plantations in our local community.",
            'society_body_2' => 'Our dedicated volunteers train rural women to care for their children properly. Our activities essentially intend to teach them the fundamentals of hygiene and nutrition. Aside from this training, we also provide sanitizer, surgical masks, and dry foods to those in need throughout the pandemic.',
            'society_body_3' => 'Our education programs are designed to teach rural children engagingly. We also closely monitor them to identify the root of their early dropout and take the necessary precautions to avoid it. Besides that, we have a photo editing training program for those who want to learn this skill. Following the program, we also provide them with the opportunity for a paid internship to help them pay for their education.',

            'partnership_heading' => 'Why Should You Work In Partnership With PhotoFixZone?',
            'partnership_highlight' => 'Partnership With PhotoFixZone?',
            'partnership_sub_text' => 'PhotoFixZone offers every benefit a client should expect from an outsourcing company. Let us have a look at why we stand out.',
            'partnership_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $features = [
            ['icon' => 'users', 'title' => 'Our Creative Professionals', 'body' => 'With the help of our highly creative professionals, you can create a powerful impact in your niche. Our deep knowledge of your industry will help us to produce an incredible picture for your audience.'],
            ['icon' => 'bolt', 'title' => 'Efficient & Effective Work Power', 'body' => 'You may not have time for editing as a professional photographer or business owner. Our creative team will take care of your editing job most effectively and efficiently. So you can focus on other important factors.'],
            ['icon' => 'badge-check', 'title' => 'Solutions That Works', 'body' => "As your photo editing partner, we will provide high-quality pictures that can grab your audience's interest and convert them into your loyal customers."],
            ['icon' => 'truck', 'title' => '24-Hours Delivery Time', 'body' => 'You will have an outstanding photo within 24 hours with all your conditions to be done.'],
            ['icon' => 'star', 'title' => 'Ensured Quality Service', 'body' => 'Quality service is the essence of our business. We will maintain all your requirements and brand tone that can skyrocket your sales.'],
            ['icon' => 'headset', 'title' => '24/7 Online Support', 'body' => "Do you need any modifications? Our online support team is available 24/7 for your help. It doesn't matter what time zone you are in."],
        ];
        foreach ($features as $i => $f) {
            AboutFeature::updateOrCreate(['title' => $f['title']], $f + ['header_color' => '#2F6BFF', 'sort_order' => $i + 1]);
        }

        $points = [
            ['icon' => 'badge-check', 'text' => 'Years Of Experience'],
            ['icon' => 'globe', 'text' => 'Top Country Serve'],
            ['icon' => 'truck', 'text' => 'Delivered in 24 Hours'],
            ['icon' => 'credit-card', 'text' => 'Payment & Invoicing'],
            ['icon' => 'chart', 'text' => 'Higher Production Capacity'],
        ];
        foreach ($points as $i => $p) {
            AboutPartnershipPoint::updateOrCreate(['text' => $p['text']], $p + ['sort_order' => $i + 1]);
        }
    }
}
