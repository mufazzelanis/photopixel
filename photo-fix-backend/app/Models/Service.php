<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Sortable;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $service) {
            if (blank($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function points(): HasMany
    {
        return $this->hasMany(ServicePoint::class)->orderBy('sort_order');
    }

    /** Itemized "Basic Clipping Path — $0.39" rows on /pricing. A service
     *  only shows up there once it has at least one of these. */
    public function priceItems(): HasMany
    {
        return $this->hasMany(ServicePriceItem::class)->orderBy('sort_order');
    }

    /** The matching Portfolio category, so the detail page can show its
     *  real "Work Samples" gallery. Optional — not every service has one. */
    public function workSampleCategory(): BelongsTo
    {
        return $this->belongsTo(WorkSampleCategory::class);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('before')->singleFile();
        $this->addMediaCollection('after')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')->width(1000)->quality(82)->nonQueued();
    }
}
