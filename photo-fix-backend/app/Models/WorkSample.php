<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WorkSample extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Sortable;

    protected $guarded = [];

    /** File names the demo seeder always uses for its generated placeholder graphics. */
    public const PLACEHOLDER_FILES = ['before.png', 'after.png'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkSampleCategory::class, 'work_sample_category_id');
    }

    /**
     * Only samples where BOTH before/after were replaced with a real upload —
     * excludes the seeder's generated "BEFORE"/"AFTER" gradient graphics so a
     * fresh, not-yet-populated sample never shows up on the public site.
     */
    public function scopeWithRealPhotos(Builder $query): Builder
    {
        return $query->whereDoesntHave('media', fn ($q) => $q
            ->whereIn('collection_name', ['before', 'after'])
            ->whereIn('file_name', self::PLACEHOLDER_FILES));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('before')->singleFile();
        $this->addMediaCollection('after')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')->width(900)->quality(80)->nonQueued();
    }
}
