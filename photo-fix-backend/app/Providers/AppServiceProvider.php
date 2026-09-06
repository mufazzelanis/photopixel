<?php

namespace App\Providers;

use App\Listeners\OptimizeUploadedImage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compress admin-uploaded images (dimensions kept, size reduced).
        Event::listen(MediaHasBeenAddedEvent::class, OptimizeUploadedImage::class);
    }
}
