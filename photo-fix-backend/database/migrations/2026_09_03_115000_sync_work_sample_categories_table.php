<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Backfill for databases created before work_sample_categories was introduced.
 * Idempotent: a no-op on fresh installs where 100013 already built everything.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('work_sample_categories')) {
            Schema::create('work_sample_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable();
                $table->text('description')->nullable();
                $table->string('read_more_label')->default('Read More');
                $table->string('read_more_url')->nullable();
                $table->string('try_free_label')->default('Try For Free');
                $table->string('try_free_url')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasColumn('work_samples', 'work_sample_category_id')) {
            Schema::table('work_samples', function (Blueprint $table) {
                $table->foreignId('work_sample_category_id')->nullable()->after('id')
                    ->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Irreversible backfill — the create migration owns the schema.
    }
};
