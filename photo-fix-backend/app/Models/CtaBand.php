<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CtaBand extends Model implements HasMedia
{
    use ClearsSiteCache, InteractsWithMedia;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function getRouteKeyName(): string
    {
        return 'key';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('background')->singleFile();
    }

    public static function get(string $key): ?self
    {
        return static::query()->where('key', $key)->where('is_active', true)->first();
    }
}
