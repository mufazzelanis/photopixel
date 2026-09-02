<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Links a service to its matching Portfolio category, so the service
        // detail page can show that category's real "Work Samples" gallery.
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('work_sample_category_id')->nullable()->after('icon')
                ->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('work_sample_category_id');
        });
    }
};
