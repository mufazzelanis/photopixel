<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * One "{Category} Work Samples" gallery — its own /portfolio/{slug} page.
 * Heading, description, cover image and both CTA buttons are all editable
 * from the admin; adding/removing categories reshapes the Portfolio pages
 * without touching any frontend code.
 */
class WorkSampleCategory extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Sortable;

    protected $guarded = [];

    /** File name the demo seeder always uses for its generated cover graphic. */
    public const PLACEHOLDER_COVER = 'cover.png';

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'is_featured' => 'boolean'];
    }

    /** The 3 (or so) categories spotlighted in the homepage "Satisfied Clients" section. */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /** Cover image, but never the seeder's placeholder graphic — null lets the frontend fall back gracefully. */
    public function realCoverUrl(): ?string
    {
        $media = $this->getFirstMedia('cover');
        if (! $media || $media->file_name === self::PLACEHOLDER_COVER) {
            return null;
        }

        return $media->getUrl('web');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saving(function (self $cat) {
            if (blank($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }

    public function samples(): HasMany
    {
        return $this->hasMany(WorkSample::class)->orderBy('sort_order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')->width(900)->quality(80)->nonQueued();
    }
}
