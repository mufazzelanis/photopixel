<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // "Check Out Our Easiest Work Process" – zig-zag diamond steps.
        Schema::create('process_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('step_no')->default(1);
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('icon')->nullable();
            $table->string('accent_color')->default('#2F6BFF');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_steps');
    }
};
