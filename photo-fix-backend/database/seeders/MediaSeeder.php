<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\ClientType;
use App\Models\Country;
use App\Models\Hero;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\WorkSample;
use App\Models\WorkSampleCategory;
use Illuminate\Database\Seeder;

/**
 * Generates lightweight branded placeholder images with GD and attaches them so
 * a fresh `migrate:fresh --seed` renders a complete-looking site. Replace any of
 * these by uploading a real asset in the admin panel.
 */
class MediaSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests()) {
            return; // placeholder images add ~30s and aren't needed for tests
        }

        if (! extension_loaded('gd')) {
            $this->command?->warn('GD extension not available — skipping placeholder images.');

            return;
        }

        $this->hero();
        $this->services();
        $this->workSampleCategories();
        $this->workSamples();
        $this->testimonials();
        $this->countries();
        $this->blog();
        $this->clientTypes();
        $this->aboutPage();
        // Payment methods intentionally left without a placeholder logo — the
        // footer renders clean text badges until a real logo is uploaded.
    }

    private function hero(): void
    {
        $hero = Hero::current();
        $hero->clearMediaCollection('collage');
        $pairs = [['#6C4CF1', '#2F6BFF'], ['#EC4899', '#8B5CF6'], ['#2F6BFF', '#22D3EE'], ['#F59E0B', '#EC4899']];
        foreach ($pairs as $i => [$a, $b]) {
            $hero->addMediaFromString($this->gradient(700, 700, $a, $b, 'SAMPLE '.($i + 1)))
                ->usingFileName("hero-{$i}.png")
                ->toMediaCollection('collage');
        }
    }

    private function services(): void
    {
        foreach (Service::all() as $service) {
            $service->clearMediaCollection('before');
            $service->clearMediaCollection('after');
            $service->addMediaFromString($this->gradient(900, 900, '#9AA3B2', '#6B7280', 'BEFORE'))
                ->usingFileName('before.png')->toMediaCollection('before');
            $service->addMediaFromString($this->gradient(900, 900, '#6C4CF1', '#2F6BFF', 'AFTER'))
                ->usingFileName('after.png')->toMediaCollection('after');
        }
    }

    private function workSampleCategories(): void
    {
        $palettes = [
            ['#6C4CF1', '#2F6BFF'], ['#EC4899', '#8B5CF6'], ['#0EA5E9', '#22D3EE'], ['#F59E0B', '#EF4444'],
            ['#10B981', '#2F6BFF'], ['#8B5CF6', '#EC4899'], ['#64748B', '#334155'], ['#DB2777', '#7C3AED'],
        ];
        foreach (WorkSampleCategory::all()->values() as $i => $cat) {
            $cat->clearMediaCollection('cover');
            [$a, $b] = $palettes[$i % count($palettes)];
            $cat->addMediaFromString($this->gradient(900, 700, $a, $b, mb_strtoupper($cat->name)))
                ->usingFileName('cover.png')->toMediaCollection('cover');
        }
    }

    private function workSamples(): void
    {
        foreach (WorkSample::all() as $i => $sample) {
            $sample->clearMediaCollection('before');
            $sample->clearMediaCollection('after');
            $sample->addMediaFromString($this->gradient(800, 800, '#94A3B8', '#64748B', 'BEFORE'))
                ->usingFileName('before.png')->toMediaCollection('before');
            $sample->addMediaFromString($this->gradient(800, 800, '#7C3AED', '#DB2777', 'AFTER'))
                ->usingFileName('after.png')->toMediaCollection('after');
        }
    }

    private function testimonials(): void
    {
        $bg = ['#6C4CF1', '#2F6BFF', '#EC4899'];
        foreach (Testimonial::all()->values() as $i => $t) {
            $t->clearMediaCollection('avatar');
            $initials = collect(explode(' ', $t->name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
            $t->addMediaFromString($this->avatar($initials, $bg[$i % 3]))
                ->usingFileName('avatar.png')->toMediaCollection('avatar');
        }
    }

    private function countries(): void
    {
        $flags = [
            'ca' => [['#FF0000', '#FFFFFF', '#FF0000'], 'v'],
            'de' => [['#000000', '#DD0000', '#FFCE00'], 'h'],
            'gb' => [['#012169', '#FFFFFF', '#C8102E'], 'h'],
            'au' => [['#012169', '#012169', '#012169'], 'h'],
            'it' => [['#009246', '#FFFFFF', '#CE2B37'], 'v'],
        ];
        foreach (Country::all() as $country) {
            $spec = $flags[$country->code] ?? [['#6C4CF1', '#2F6BFF', '#EC4899'], 'v'];
            $country->clearMediaCollection('flag');
            $country->addMediaFromString($this->flag(120, 80, $spec[0], $spec[1]))
                ->usingFileName("{$country->code}.png")->toMediaCollection('flag');
        }
    }

    private function paymentMethods(): void
    {
        foreach (PaymentMethod::all() as $pm) {
            $pm->clearMediaCollection('logo');
            $pm->addMediaFromString($this->label(220, 90, $pm->name))
                ->usingFileName('logo.png')->toMediaCollection('logo');
        }
    }

    private function blog(): void
    {
        $palettes = [['#6C4CF1', '#2F6BFF'], ['#0EA5E9', '#22C55E'], ['#F59E0B', '#EF4444']];
        foreach (BlogPost::all()->values() as $i => $post) {
            $post->clearMediaCollection('cover');
            [$a, $b] = $palettes[$i % 3];
            $post->addMediaFromString($this->gradient(1200, 750, $a, $b, mb_strtoupper(mb_substr($post->title, 0, 22))))
                ->usingFileName('cover.png')->toMediaCollection('cover');
        }
    }

    private function aboutPage(): void
    {
        $page = \App\Models\AboutPage::current();
        foreach ([
            ['hero_image', '#6C4CF1', '#2F6BFF', 900, 700],
            ['post_production_image', '#EC4899', '#8B5CF6', 900, 700],
            ['society_image', '#10B981', '#2F6BFF', 900, 700],
        ] as [$collection, $a, $b, $w, $h]) {
            $page->clearMediaCollection($collection);
            $page->addMediaFromString($this->gradient($w, $h, $a, $b, ''))
                ->usingFileName("{$collection}.png")
                ->toMediaCollection($collection);
        }
    }

    private function clientTypes(): void
    {
        $palettes = [['#EC4899', '#8B5CF6'], ['#2F6BFF', '#22D3EE'], ['#F59E0B', '#EC4899'], ['#10B981', '#2F6BFF']];
        foreach (ClientType::all()->values() as $i => $ct) {
            $ct->clearMediaCollection('image');
            [$a, $b] = $palettes[$i % 4];
            $ct->addMediaFromString($this->gradient(400, 400, $a, $b, ''))
                ->usingFileName('image.png')->toMediaCollection('image');
        }
    }

    // ---- GD helpers ------------------------------------------------------

    private function rgb($img, string $hex): int
    {
        $hex = ltrim($hex, '#');
        return imagecolorallocate($img, hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    }

    private function gradient(int $w, int $h, string $c1, string $c2, string $text = ''): string
    {
        $img = imagecreatetruecolor($w, $h);
        [$r1, $g1, $b1] = sscanf(ltrim($c1, '#'), '%02x%02x%02x');
        [$r2, $g2, $b2] = sscanf(ltrim($c2, '#'), '%02x%02x%02x');
        for ($y = 0; $y < $h; $y++) {
            $t = $y / max($h - 1, 1);
            $col = imagecolorallocate(
                $img,
                (int) ($r1 + ($r2 - $r1) * $t),
                (int) ($g1 + ($g2 - $g1) * $t),
                (int) ($b1 + ($b2 - $b1) * $t),
            );
            imageline($img, 0, $y, $w, $y, $col);
        }
        if ($text !== '') {
            $this->centerText($img, $w, $h, $text, imagecolorallocatealpha($img, 255, 255, 255, 20));
        }

        return $this->png($img);
    }

    private function avatar(string $initials, string $bg): string
    {
        $size = 200;
        $img = imagecreatetruecolor($size, $size);
        imagefill($img, 0, 0, $this->rgb($img, $bg));
        $this->centerText($img, $size, $size, $initials ?: '?', imagecolorallocate($img, 255, 255, 255), 5);

        return $this->png($img);
    }

    private function flag(int $w, int $h, array $bands, string $dir): string
    {
        $img = imagecreatetruecolor($w, $h);
        $n = count($bands);
        foreach ($bands as $i => $hex) {
            $col = $this->rgb($img, $hex);
            if ($dir === 'v') {
                imagefilledrectangle($img, (int) ($w / $n * $i), 0, (int) ($w / $n * ($i + 1)), $h, $col);
            } else {
                imagefilledrectangle($img, 0, (int) ($h / $n * $i), $w, (int) ($h / $n * ($i + 1)), $col);
            }
        }

        return $this->png($img);
    }

    private function label(int $w, int $h, string $text): string
    {
        $img = imagecreatetruecolor($w, $h);
        imagefill($img, 0, 0, imagecolorallocate($img, 255, 255, 255));
        $this->centerText($img, $w, $h, $text, imagecolorallocate($img, 60, 60, 70), 4);

        return $this->png($img);
    }

    private function centerText($img, int $w, int $h, string $text, int $color, int $font = 5): void
    {
        $fw = imagefontwidth($font) * strlen($text);
        $fh = imagefontheight($font);
        imagestring($img, $font, (int) (($w - $fw) / 2), (int) (($h - $fh) / 2), $text, $color);
    }

    private function png($img): string
    {
        ob_start();
        imagepng($img);
        imagedestroy($img);

        return (string) ob_get_clean();
    }
}
