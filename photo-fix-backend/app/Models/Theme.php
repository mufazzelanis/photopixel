<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Theme extends Model
{
    use ClearsSiteCache;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tokens' => 'array',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    /** The tokens of the currently active theme (falls back to the default preset). */
    public static function activeTokens(): array
    {
        return Cache::rememberForever('api.theme', function () {
            $theme = static::query()->where('is_active', true)->first()
                ?? static::query()->where('is_default', true)->first()
                ?? static::query()->first();

            return $theme?->tokens ?? [];
        });
    }

    /** Make this the only active theme. */
    public function activate(): void
    {
        static::query()->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('api.theme'));
    }
}
