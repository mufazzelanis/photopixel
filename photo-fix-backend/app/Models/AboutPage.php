<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Singleton;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutPage extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Singleton;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')->singleFile();
        $this->addMediaCollection('post_production_image')->singleFile();
        $this->addMediaCollection('society_image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')->width(900)->quality(82)->nonQueued();
    }

    public function features()
    {
        return AboutFeature::query()->visible()->get();
    }

    public function partnershipPoints()
    {
        return AboutPartnershipPoint::query()->visible()->get();
    }
}
