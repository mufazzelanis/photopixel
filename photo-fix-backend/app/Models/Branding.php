<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Singleton;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * The one row that holds the site logo and favicon. Uploaded from the
 * admin (Design → Logo & Favicon) and surfaced to the React app via
 * SitePayload::navigation().
 */
class Branding extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Singleton;

    protected $table = 'branding';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('logo_dark')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // Raster logos get a tidy header-height version; SVGs pass through
        // untouched (Media::url() falls back to the original automatically).
        $this->addMediaConversion('web')
            ->height(96)
            ->quality(90)
            ->nonQueued()
            ->performOnCollections('logo', 'logo_dark');
    }
}
