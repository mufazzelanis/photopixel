<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Privacy Policy / Terms of Service — exactly 2 fixed rows (by `slug`),
 * each a full rich-text legal document with its own hero. Managed from
 * the admin like any other page; new rows are never created there.
 */
class LegalPage extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia;

    protected $guarded = [];

    public static function forSlug(string $slug): ?self
    {
        return static::query()->where('slug', $slug)->first();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')->width(1600)->quality(82)->nonQueued();
    }
}
