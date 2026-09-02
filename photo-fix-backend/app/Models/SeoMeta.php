<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SeoMeta extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia;

    protected $table = 'seo_meta';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('og_image')->singleFile();
    }

    public static function for(string $pageKey): ?self
    {
        return static::query()->where('page_key', $pageKey)->first();
    }
}
