<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Singleton;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WhyChooseSection extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Singleton;

    protected $guarded = [];

    public function points()
    {
        return WhyPoint::query()->ordered()->get();
    }

    public function features()
    {
        return WhyFeature::query()->ordered()->get();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
