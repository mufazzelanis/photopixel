<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Section extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    /** key => Section map for quick lookup when building the API payload. */
    public static function keyed(): \Illuminate\Support\Collection
    {
        return static::query()->get()->keyBy('key');
    }

    /** Optional photo a handful of sections show next to their intro copy
     *  (e.g. the person photo on the Contact page). Most sections leave it
     *  blank — the frontend falls back to a themed placeholder. */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')->width(900)->quality(82)->nonQueued();
    }
}
