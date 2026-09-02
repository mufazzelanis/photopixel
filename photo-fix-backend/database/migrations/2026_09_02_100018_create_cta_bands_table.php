<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Reusable full-width call-to-action bands
        // ("Let's Bring The Perfection Into Images", etc.)
        Schema::create('cta_bands', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('heading');
            $table->text('sub_text')->nullable();
            $table->string('btn_label')->nullable();
            $table->string('btn_url')->nullable();
            $table->string('bg_style')->default('gradient'); // gradient | solid | image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cta_bands');
    }
};
