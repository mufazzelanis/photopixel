<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Singleton;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Hero extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Singleton;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        // Floating collage images shown on the right of the hero.
        $this->addMediaCollection('collage');
        $this->addMediaCollection('background')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')
            ->width(900)
            ->quality(82)
            ->nonQueued();
    }
}
