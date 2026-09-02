<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Singleton (row id = 1). Media (collage images) handled by Spatie MediaLibrary.
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('heading');
            $table->string('highlight_text')->nullable();
            $table->text('sub_text')->nullable();
            $table->string('primary_btn_label')->nullable();
            $table->string('primary_btn_url')->nullable();
            $table->string('secondary_btn_label')->nullable();
            $table->string('secondary_btn_url')->nullable();
            $table->timestamps();
        });

        // Singleton (row id = 1). "Accelerate Your Journey With PhotoFixZone"
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('heading')->nullable();
            $table->string('highlight_text')->nullable();
            $table->string('video_url')->nullable();
            $table->text('body_1')->nullable();
            $table->text('body_2')->nullable();
            $table->string('btn_label')->nullable();
            $table->string('btn_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
        Schema::dropIfExists('heroes');
    }
};
