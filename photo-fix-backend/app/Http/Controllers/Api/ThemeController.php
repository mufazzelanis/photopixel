<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function __invoke()
    {
        return response()->json(['tokens' => Theme::activeTokens()]);
    }
}
