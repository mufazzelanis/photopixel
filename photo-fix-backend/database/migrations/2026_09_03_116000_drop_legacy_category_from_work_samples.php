<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The old free-text `category` column on work_samples was replaced by the
 * `work_sample_category_id` relationship. Left behind, it shadows the
 * `category()` relation ($sample->category returns the string). Drop it.
 * Idempotent for fresh installs where the column never existed.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('work_samples', 'category')) {
            Schema::table('work_samples', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('work_samples', 'category')) {
            Schema::table('work_samples', function (Blueprint $table) {
                $table->string('category')->nullable();
            });
        }
    }
};
