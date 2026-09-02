<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;

class TrialOption extends Model
{
    use ClearsSiteCache, Sortable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public const GROUPS = ['service', 'timeline', 'file_format', 'how_found'];
}
