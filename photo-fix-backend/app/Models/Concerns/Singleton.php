<?php

namespace App\Models\Concerns;

/**
 * Content blocks that only ever have one row (Hero, About, etc.).
 */
trait Singleton
{
    public static function current(): static
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
