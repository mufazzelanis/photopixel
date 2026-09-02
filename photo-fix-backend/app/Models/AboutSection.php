<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Singleton;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutSection extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Singleton;

    protected $table = 'about_sections';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')->singleFile();
    }
}
