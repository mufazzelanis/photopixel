<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\Country;
use App\Models\CtaBand;
use App\Models\Hero;
use App\Models\ProcessStep;
use App\Models\Stat;
use App\Models\UploadServer;
use App\Models\ValueCard;
use App\Models\WhyChooseSection;
use App\Models\WhyFeature;
use App\Models\WhyPoint;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Hero (singleton) -------------------------------------------
        Hero::updateOrCreate(['id' => 1], [
            'eyebrow' => null,
            'heading' => 'Get Stunning & Flawless Photo Editing Services At Photo Fix Zone!',
            'highlight_text' => 'Photo Fix Zone',
            'sub_text' => 'We are the leading photo editing service provider working with result-oriented professionals who can lead with flawless images. Get in touch with us.',
            'primary_btn_label' => 'Try For Free',
            'primary_btn_url' => '/free-trial',
            'secondary_btn_label' => 'SEE SAMPLES',
            'secondary_btn_url' => '/portfolio',
        ]);

        // ---- About (singleton) ----------------------------------------
        AboutSection::updateOrCreate(['id' => 1], [
            'eyebrow' => null,
            'heading' => 'Accelerate Your Journey With PhotoFixZone',
            'highlight_text' => 'With PhotoFixZone',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'body_1' => 'Photo Fix Zone is an outstanding team with a pool of passionate experts who helps businesses and individuals internationally. With a team of expert professionals and providing on-demand photo editing & graphical support.',
            'body_2' => 'We provide affordable photo editing services that express high-quality results. Our highly skilled editor, designer and graphic artists know where you need to improve! and according to the requirements, our professional editors will make the service more exclusive so which will make you satisfied with the best result. Photo Fix Zone is always ready to provide excellent image editing services such as complex clipping path, high-end retouching, complex masking, raster to vector, jewellry retouch and much more!',
            'btn_label' => 'Ask For a Quote',
            'btn_url' => '#quote',
        ]);

        // ---- Value cards --------------------------------------------------
        $cards = [
            ['icon' => 'chart', 'header_color' => '#EC4899', 'title' => 'Daily Editing Capacity', 'body' => 'Photo Fix Zone will allow you to edit up to 5000 photos every day.'],
            ['icon' => 'truck', 'header_color' => '#2F6BFF', 'title' => 'Fastest Delivery', 'body' => "Wait too long to get the result? We won't take much longer than your expectation. We provide instant support that our client wants."],
            ['icon' => 'wallet', 'header_color' => '#14B8A6', 'title' => 'Budget Friendly Image Editing', 'body' => 'Once we know the necessities of your project, We make every effort to give you the most budget-friendly service you need. Also, we never compromise on quality!'],
            ['icon' => 'headset', 'header_color' => '#A855F7', 'title' => 'Unlimited Support And Modifications', 'body' => 'You will get unlimited support and guidance from us that can fulfil your needs. Our pricing will amaze you with quality in the competitive market.'],
        ];
        foreach ($cards as $i => $c) {
            ValueCard::updateOrCreate(['title' => $c['title']], $c + ['sort_order' => $i + 1]);
        }

        // ---- Serving Globally: countries --------------------------------
        foreach (['Canada' => 'ca', 'Germany' => 'de', 'United Kingdom' => 'gb', 'Australia' => 'au', 'Italy' => 'it'] as $name => $code) {
            Country::updateOrCreate(['name' => $name], ['code' => $code, 'sort_order' => 0]);
        }
        Country::query()->orderBy('id')->get()->each(fn ($c, $i) => $c->update(['sort_order' => $i + 1]));

        // ---- Work process steps ---------------------------------------
        $steps = [
            ['icon' => 'upload', 'accent_color' => '#111827', 'title' => 'Upload Files', 'body' => 'Find and tap the files you want to upload using a direct link'],
            ['icon' => 'gift', 'accent_color' => '#1D4ED8', 'title' => 'Ask For Free Trial', 'body' => 'You will get 5 free trials along with your requirements'],
            ['icon' => 'monitor', 'accent_color' => '#2563EB', 'title' => 'Get A Demo', 'body' => 'Send your requirements and get the initial demo'],
            ['icon' => 'file-check', 'accent_color' => '#16A34A', 'title' => 'Get Final Results', 'body' => 'Match everything meets your motive and then get the final result from our experts'],
            ['icon' => 'credit-card', 'accent_color' => '#15803D', 'title' => 'Make Payment', 'body' => 'After getting your revision we will finish the work process with direct payment'],
        ];
        foreach ($steps as $i => $s) {
            ProcessStep::updateOrCreate(['title' => $s['title']], $s + ['step_no' => $i + 1, 'sort_order' => $i + 1]);
        }

        // ---- Why choose (singleton) + points + features ---------------
        WhyChooseSection::updateOrCreate(['id' => 1], [
            'heading' => 'Why We Are Unique & First-Rated',
            'highlight_text' => 'Unique & First-Rated',
            'body_1' => 'We provide excellent service that does not stand just in service, Our special photo editing and video editing team helps people across the world through unique, excellent and effective videos and images that your business needs more. We believe that our expert team has got the power to change the visualized world and stand out uniquely with real-world experience.',
            'body_2' => "We bring the best for you and open up our service 24/7. Our each of services will meet your satisfaction and guarantee the best outcome. We don't consider the quality and make your life easier, and outstanding.",
        ]);
        $whyPoints = [
            'We help you increase brand recognition',
            'Make exclusive promotional visualization more engaged',
            'Put perfection on each image and video',
            'Quality video & image for any campaign',
            '100% Satisfaction Guarantee',
            'Bring professional looks and keep it clean & sharp',
            'Done by industry-expert',
        ];
        foreach ($whyPoints as $i => $t) {
            WhyPoint::updateOrCreate(['text' => $t], ['sort_order' => $i + 1]);
        }
        foreach ([
            ['title' => 'Extra Fast Delivery', 'icon' => 'bolt'],
            ['title' => 'Fulfilment Guarantee', 'icon' => 'badge-check'],
            ['title' => 'Unlimited Support', 'icon' => 'headset'],
        ] as $i => $f) {
            WhyFeature::updateOrCreate(['title' => $f['title']], $f + ['sort_order' => $i + 1]);
        }

        // ---- Stats ---------------------------------------------------------
        $stats = [
            ['label' => 'Successfully Deliver Projects', 'value_number' => 1476, 'value_suffix' => null, 'icon' => 'file-check'],
            ['label' => 'Ongoing Order process', 'value_number' => 1356, 'value_suffix' => null, 'icon' => 'layers'],
            ['label' => 'Delivered Files', 'value_number' => 2.4, 'value_suffix' => 'M', 'icon' => 'folder-check'],
            ['label' => 'Satisfied Clients', 'value_number' => 893, 'value_suffix' => null, 'icon' => 'users'],
        ];
        foreach ($stats as $i => $s) {
            Stat::updateOrCreate(['label' => $s['label']], $s + ['sort_order' => $i + 1]);
        }

        // ---- Upload servers ---------------------------------------------
        UploadServer::updateOrCreate(['name' => 'Upload Via WeTransfer'], [
            'url' => 'https://wetransfer.com/', 'icon' => 'wetransfer', 'button_style' => 'primary', 'sort_order' => 1,
        ]);
        UploadServer::updateOrCreate(['name' => 'Upload Via Dropbox'], [
            'url' => 'https://www.dropbox.com/requests', 'icon' => 'dropbox', 'button_style' => 'outline', 'sort_order' => 2,
        ]);

        // ---- CTA bands --------------------------------------------------
        CtaBand::updateOrCreate(['key' => 'cta_perfection'], [
            'heading' => "Let's Bring The Perfection Into Images",
            'sub_text' => 'We bring out the fastest way to edit images through our industry experts with quality, the lowest price that meets satisfaction and keeps brands growing every day.',
            'btn_label' => 'Get a Quote',
            'btn_url' => '#quote',
            'bg_style' => 'gradient',
        ]);
    }
}
