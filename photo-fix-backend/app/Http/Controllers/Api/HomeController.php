<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SitePayload;

class HomeController extends Controller
{
    public function __invoke(SitePayload $payload)
    {
        return response()->json($payload->home());
    }
}
