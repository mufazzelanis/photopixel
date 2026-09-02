<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;

class ValueCard extends Model
{
    use ClearsSiteCache, Sortable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
