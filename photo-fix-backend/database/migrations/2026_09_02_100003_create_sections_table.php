<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // hero, value_cards, about, services, testimonials ...
            $table->string('name');            // human label in admin
            $table->string('eyebrow')->nullable();
            $table->string('heading')->nullable();
            $table->string('highlight_text')->nullable(); // coloured part of the heading
            $table->text('sub_heading')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('settings')->nullable(); // bg_color, text_color, padding_y, container, animation{...}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
