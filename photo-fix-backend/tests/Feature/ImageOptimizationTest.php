<?php

namespace Tests\Feature;

use App\Models\FreeTrialRequest;
use App\Models\WorkSample;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageOptimizationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /** A noisy JPEG saved at quality 100 so it is genuinely re-compressible. */
    private function bigJpeg(int $px = 1400): UploadedFile
    {
        $im = imagecreatetruecolor($px, $px);
        for ($i = 0; $i < 3500; $i++) {
            imagefilledellipse(
                $im,
                random_int(0, $px), random_int(0, $px),
                random_int(10, 140), random_int(10, 140),
                imagecolorallocate($im, random_int(0, 255), random_int(0, 255), random_int(0, 255)),
            );
        }
        $path = tempnam(sys_get_temp_dir(), 'imgopt').'.jpg';
        imagejpeg($im, $path, 100);
        imagedestroy($im);

        return new UploadedFile($path, 'big.jpg', 'image/jpeg', null, true);
    }

    public function test_admin_upload_is_compressed_but_keeps_full_resolution(): void
    {
        Storage::fake('public');

        $file = $this->bigJpeg(1400);
        [$srcW, $srcH] = getimagesize($file->getPathname());
        $srcBytes = $file->getSize();

        $sample = WorkSample::query()->firstOrFail();
        $sample->addMedia($file)->toMediaCollection('before');

        $media = $sample->fresh()->getFirstMedia('before');
        $storedPath = $media->getPath();

        [$outW, $outH] = getimagesize($storedPath);

        // dimensions untouched
        $this->assertSame($srcW, $outW);
        $this->assertSame($srcH, $outH);

        // but noticeably smaller, and the size column matches the file on disk
        $this->assertLessThan($srcBytes, filesize($storedPath));
        $this->assertSame(filesize($storedPath), (int) $media->size);
    }

    public function test_customer_free_trial_samples_are_stored_untouched(): void
    {
        Storage::fake('public');

        $file = $this->bigJpeg(1200);
        $srcHash = md5_file($file->getPathname());

        $lead = FreeTrialRequest::create([
            'name' => 'Buyer', 'email' => 'b@x.com', 'file_link' => 'https://x.io/f',
            'status' => 'new', 'ip' => '127.0.0.1',
        ]);
        $lead->addMedia($file)->toMediaCollection('samples');

        $stored = $lead->fresh()->getFirstMedia('samples')->getPath();

        // byte-for-byte identical — nothing re-encoded
        $this->assertSame($srcHash, md5_file($stored));
    }
}
