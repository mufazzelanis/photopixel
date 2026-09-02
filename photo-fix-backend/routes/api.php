<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ThemeController;
use Illuminate\Support\Facades\Route;

/*
| Public content API for the React SPA. Prefix "api/v1" (see bootstrap/app.php).
*/

// ---- Content (GET, cached) --------------------------------------------------
Route::get('/home', HomeController::class);
Route::get('/theme', ThemeController::class);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{post}', [BlogController::class, 'show']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/free-trial', [PageController::class, 'freeTrial']);
Route::get('/pricing', [PageController::class, 'pricing']);
Route::get('/page/{key}/seo', [PageController::class, 'seo']);

// ---- Lead capture (POST, throttled + honeypot) ---------------------------
Route::middleware('throttle:12,1')->group(function () {
    Route::post('/quote', [LeadController::class, 'quote']);
    Route::post('/contact', [LeadController::class, 'contact']);
    Route::post('/free-trial', [LeadController::class, 'freeTrial']);
    Route::post('/subscribe', [LeadController::class, 'subscribe']);
});
