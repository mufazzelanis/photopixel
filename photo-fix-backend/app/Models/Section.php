<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use ClearsSiteCache;

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
}
