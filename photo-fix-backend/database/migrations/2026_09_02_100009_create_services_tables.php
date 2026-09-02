<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // "Our Most Popular Photo Editing Services" + individual service detail pages.
        // before_image / after_image handled by Spatie MediaLibrary collections.
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('short_desc')->nullable();
            $table->longText('long_desc')->nullable();
            $table->string('icon')->nullable();
            $table->string('btn_label')->default('More About');
            $table->string('btn_url')->nullable();       // null => /services/{slug}
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(true); // show on homepage list
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });

        Schema::create('service_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_points');
        Schema::dropIfExists('services');
    }
};
