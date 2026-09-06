<?php

use App\Models\ContactMessage;
use App\Models\FreeTrialRequest;
use App\Models\QuoteRequest;

return [

    /*
    |--------------------------------------------------------------------------
    | Optimise images the admin uploads
    |--------------------------------------------------------------------------
    |
    | When the site owner uploads an image through the admin panel we re-encode
    | it at a lower quality to shrink the file — the pixel dimensions are kept
    | exactly as-is (100% resolution), only the megabytes go down. The original
    | is only replaced when the re-encoded copy is actually smaller.
    |
    | Files submitted by customers (free-trial / sample uploads) are listed in
    | `never_optimize_models` and are stored byte-for-byte as they were sent.
    |
    */

    'optimize_uploads' => (bool) env('OPTIMIZE_UPLOADS', true),

    // JPEG/WebP quality (1–100). 80–85 is visually lossless for photos.
    'optimize_quality' => (int) env('OPTIMIZE_QUALITY', 82),

    // Skip anything already smaller than this (bytes) — not worth re-encoding.
    'optimize_min_bytes' => 300 * 1024,

    // Only these raster formats are touched.
    'optimize_extensions' => ['jpg', 'jpeg', 'png', 'webp'],

    // Media attached to these models is left exactly as uploaded.
    'never_optimize_models' => [
        FreeTrialRequest::class,
        QuoteRequest::class,
        ContactMessage::class,
    ],

];
