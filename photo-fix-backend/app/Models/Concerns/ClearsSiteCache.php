<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Cache;

/**
 * Any model editable from the admin panel uses this so a save/delete
 * invalidates the public API response caches immediately.
 */
trait ClearsSiteCache
{
    public static array $siteCacheKeys = [
        'api.home',
        'api.theme',
        'api.navigation',
        'api.footer',
        'api.services',
        'api.blog.index',
        'api.about_page',
        'api.free_trial_page',
        'site_settings.all',
    ];

    protected static function bootClearsSiteCache(): void
    {
        $flush = function () {
            foreach (static::$siteCacheKeys as $key) {
                Cache::forget($key);
            }
        };

        static::saved($flush);
        static::deleted($flush);
    }
}
