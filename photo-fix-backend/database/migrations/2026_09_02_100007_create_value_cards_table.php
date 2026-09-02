<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // "The Range Of Value We Provide" – 4 cards with a coloured header strip.
        Schema::create('value_cards', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();          // icon key rendered on the frontend
            $table->string('header_color')->default('#EC4899');
            $table->string('title');
            $table->text('body')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('value_cards');
    }
};
