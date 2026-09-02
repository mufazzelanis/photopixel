<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Per-page SEO. og_image via Spatie MediaLibrary.
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique(); // home, about, contact, blog, service:{slug} ...
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('robots')->default('index,follow');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_meta');
    }
};
