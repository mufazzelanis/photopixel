<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

/**
 * Shrinks images uploaded through the admin panel — same pixel dimensions,
 * fewer megabytes. Customer-submitted files (free-trial samples etc.) are
 * excluded via config/media.php and kept exactly as they were sent.
 *
 * Runs synchronously right after the media row is created and before Spatie
 * builds its conversions, so every derived image also comes from the smaller
 * original.
 */
class OptimizeUploadedImage
{
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        if (! config('media.optimize_uploads', true)) {
            return;
        }

        $media = $event->media;

        if (in_array($media->model_type, config('media.never_optimize_models', []), true)) {
            return;
        }

        $ext = strtolower((string) $media->extension);
        if (! in_array($ext, config('media.optimize_extensions', []), true)) {
            return; // svg / gif / ico / pdf / …
        }

        if ((int) $media->size < (int) config('media.optimize_min_bytes', 307200)) {
            return;
        }

        $tmp = null;

        try {
            $path = $media->getPath();

            if (! is_file($path)) {
                return;
            }

            $originalBytes = (int) filesize($path);
            $tmp = $path.'.opt.'.$ext;

            // No resize call anywhere — dimensions stay at 100%.
            Image::load($path)
                ->quality((int) config('media.optimize_quality', 82))
                ->save($tmp);

            if (! is_file($tmp)) {
                return;
            }

            $newBytes = (int) filesize($tmp);

            if ($newBytes > 0 && $newBytes < $originalBytes) {
                @unlink($path);
                rename($tmp, $path);
                $tmp = null;

                $media->forceFill(['size' => $newBytes])->saveQuietly();
            } else {
                @unlink($tmp);
                $tmp = null;
            }
        } catch (\Throwable $e) {
            Log::warning('Upload image optimize skipped', [
                'media_id' => $media->id ?? null,
                'error' => $e->getMessage(),
            ]);

            if ($tmp && is_file($tmp)) {
                @unlink($tmp);
            }
        }
    }
}
