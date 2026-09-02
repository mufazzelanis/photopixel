<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Singleton;
use Illuminate\Database\Eloquent\Model;

class FreeTrialPage extends Model
{
    use ClearsSiteCache, Singleton;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'instructions_limit' => 'integer',
            'max_images' => 'integer',
        ];
    }
}
