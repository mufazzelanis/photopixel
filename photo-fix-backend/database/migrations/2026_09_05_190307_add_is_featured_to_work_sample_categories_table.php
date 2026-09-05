<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_sample_categories', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_active');
        });

        // Sensible default so the homepage "Satisfied Clients" spotlight isn't
        // empty on upgrade — admin can change the pick anytime.
        DB::table('work_sample_categories')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(3)
            ->update(['is_featured' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_sample_categories', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }
};
