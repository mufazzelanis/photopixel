<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Shared scopes for the many "sort_order + is_active" content list models.
 */
trait Sortable
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->active()->ordered();
    }
}
