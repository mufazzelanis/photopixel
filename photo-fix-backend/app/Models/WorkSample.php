<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WorkSample extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia, Sortable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkSampleCategory::class, 'work_sample_category_id');
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
