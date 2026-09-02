<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use ClearsSiteCache;

    protected $guarded = [];

    /**
     * All settings as ['group' => ['key' => castedValue]], cached forever.
     */
    public static function map(): array
    {
        return Cache::rememberForever('site_settings.all', function () {
            return static::query()->get()
                ->groupBy('group')
                ->map(fn ($rows) => $rows
                    ->mapWithKeys(fn ($row) => [$row->key => static::castValue($row)])
                    ->all())
                ->all();
        });
    }

    /** Flat key => value map for a single group. */
    public static function group(string $group): array
    {
        return static::map()[$group] ?? [];
    }

    public static function value(string $group, string $key, mixed $default = null): mixed
    {
        return static::group($group)[$key] ?? $default;
    }

    protected static function castValue(self $row): mixed
    {
        return match ($row->type) {
            'boolean' => filter_var($row->value, FILTER_VALIDATE_BOOL),
            'json' => json_decode((string) $row->value, true),
            default => $row->value,
        };
    }
}
