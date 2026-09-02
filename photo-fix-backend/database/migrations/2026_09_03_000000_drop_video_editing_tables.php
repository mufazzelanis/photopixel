<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Video editing was removed from the site — drop its tables from existing installs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('video_editing_items');
        Schema::dropIfExists('video_editing_sections');
    }

    public function down(): void
    {
        // Intentionally irreversible — the feature was removed.
    }
};
