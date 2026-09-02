<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Singleton: "Why We Are Unique & First-Rated". image via Spatie MediaLibrary.
        Schema::create('why_choose_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('heading')->nullable();
            $table->string('highlight_text')->nullable();
            $table->text('body_1')->nullable();
            $table->text('body_2')->nullable();
            $table->timestamps();
        });

        // Numbered list (1..n)
        Schema::create('why_points', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Icon features: Extra Fast Delivery / Fulfilment Guarantee / Unlimited Support
        Schema::create('why_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_features');
        Schema::dropIfExists('why_points');
        Schema::dropIfExists('why_choose_sections');
    }
};
