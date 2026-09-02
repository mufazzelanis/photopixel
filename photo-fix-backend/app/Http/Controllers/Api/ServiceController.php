<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\Media;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Cache::rememberForever('api.services', fn () => Service::query()
            ->active()->ordered()->with('points')->get()
            ->map(fn (Service $s) => [
                'slug' => $s->slug,
                'title' => $s->title,
                'icon' => $s->icon,
                'short_desc' => $s->short_desc,
                'btn_label' => $s->btn_label,
                'points' => $s->points->pluck('text'),
                'before_image' => Media::url($s, 'before', 'web'),
                'after_image' => Media::url($s, 'after', 'web'),
            ]));

        return response()->json(['data' => $services]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);
        $service->load('points');

        return response()->json([
            'data' => [
                'slug' => $service->slug,
                'title' => $service->title,
                'icon' => $service->icon,
                'short_desc' => $service->short_desc,
                'long_desc' => $service->long_desc,
                'btn_label' => $service->btn_label,
                'points' => $service->points->pluck('text'),
                'before_image' => Media::url($service, 'before', 'web'),
                'after_image' => Media::url($service, 'after', 'web'),
                'gallery' => Media::collection($service, 'gallery'),
                'seo' => [
                    'title' => $service->seo_title ?: $service->title,
                    'description' => $service->seo_description ?: $service->short_desc,
                ],
            ],
        ]);
    }
}
