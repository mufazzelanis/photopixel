<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // "Some Magnificent Numbers" – animated counters (e.g. 2.4M).
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->decimal('value_number', 12, 2)->default(0); // 2.40
            $table->string('value_prefix')->nullable();
            $table->string('value_suffix')->nullable();          // "M", "+", "K"
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
