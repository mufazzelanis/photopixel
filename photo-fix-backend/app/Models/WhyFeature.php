<?php

namespace App\Models;

use App\Models\Concerns\ClearsSiteCache;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;

class WhyFeature extends Model
{
    use ClearsSiteCache, Sortable;

    protected $guarded = [];
}
