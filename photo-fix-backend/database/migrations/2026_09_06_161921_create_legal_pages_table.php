<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // 'privacy-policy' | 'terms-of-service'
            $table->string('title'); // nav label / <title>, e.g. "Terms Of Service"
            $table->string('hero_heading');
            $table->string('hero_sub')->nullable();
            $table->string('hero_btn_label')->nullable();
            $table->string('hero_btn_url')->nullable();
            $table->longText('body'); // rich-text HTML, admin-editable
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_pages');
    }
};
