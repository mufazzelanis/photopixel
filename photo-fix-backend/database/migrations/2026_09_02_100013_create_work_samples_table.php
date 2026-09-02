<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A category is its own /portfolio/{slug} page: heading, description,
        // cover image and the two CTA buttons are all admin-editable.
        Schema::create('work_sample_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('read_more_label')->default('Read More');
            $table->string('read_more_url')->nullable();
            $table->string('try_free_label')->default('Try For Free');
            $table->string('try_free_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // "Work Sample of Our Satisfied Clients" – before/after gallery slider.
        // before_image / after_image handled by Spatie MediaLibrary.
        Schema::create('work_samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_sample_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_samples');
        Schema::dropIfExists('work_sample_categories');
    }
};
