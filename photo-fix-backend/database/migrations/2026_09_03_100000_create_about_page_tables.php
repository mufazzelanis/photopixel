<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Singleton (row id = 1) holding every text block on the About page.
        // Images (hero, post-production, society) via Spatie MediaLibrary.
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_heading')->nullable();
            $table->string('hero_highlight')->nullable();
            $table->text('hero_sub_text')->nullable();
            $table->string('hero_primary_label')->nullable();
            $table->string('hero_primary_url')->nullable();
            $table->string('hero_secondary_label')->nullable();
            $table->string('hero_secondary_url')->nullable();

            // "Boost Your Business" cards section header
            $table->string('boost_heading')->nullable();
            $table->string('boost_highlight')->nullable();
            $table->text('boost_sub_text')->nullable();

            // Post-Production block
            $table->string('pp_heading')->nullable();
            $table->string('pp_highlight')->nullable();
            $table->longText('pp_body_1')->nullable();
            $table->longText('pp_body_2')->nullable();
            $table->string('pp_btn_label')->nullable();
            $table->string('pp_btn_url')->nullable();

            // Society block
            $table->string('society_heading')->nullable();
            $table->string('society_highlight')->nullable();
            $table->longText('society_body_1')->nullable();
            $table->longText('society_body_2')->nullable();
            $table->longText('society_body_3')->nullable();

            // Partnership (video + checklist) block header
            $table->string('partnership_heading')->nullable();
            $table->string('partnership_highlight')->nullable();
            $table->text('partnership_sub_text')->nullable();
            $table->string('partnership_video_url')->nullable();

            $table->timestamps();
        });

        // The 6 "Boost Your Business" feature cards.
        Schema::create('about_features', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('header_color')->default('#2F6BFF');
            $table->string('title');
            $table->text('body')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // The checklist next to the partnership video.
        Schema::create('about_partnership_points', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_partnership_points');
        Schema::dropIfExists('about_features');
        Schema::dropIfExists('about_pages');
    }
};
