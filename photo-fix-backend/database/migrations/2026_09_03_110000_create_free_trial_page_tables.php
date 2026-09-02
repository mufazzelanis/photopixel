<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Singleton (row id = 1): the copy + settings for the /free-trial page.
        Schema::create('free_trial_pages', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('highlight')->nullable();
            $table->text('sub_text')->nullable();
            $table->string('form_title')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->unsignedInteger('instructions_limit')->default(180);
            $table->unsignedInteger('max_images')->default(10);
            $table->timestamps();
        });

        // Editable option lists for the form's selects & checkboxes.
        // group: service | timeline | file_format | how_found
        Schema::create('trial_options', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index();
            $table->string('label');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Extra fields captured by the richer free-trial form.
        Schema::table('free_trial_requests', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('phone');
            $table->string('delivery_timeline')->nullable()->after('country');
            $table->string('file_format')->nullable()->after('delivery_timeline');
            $table->json('services')->nullable()->after('file_format');
            $table->string('how_found')->nullable()->after('services');
            $table->string('trial_type')->default('photo')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('free_trial_requests', function (Blueprint $table) {
            $table->dropColumn(['phone', 'country', 'delivery_timeline', 'file_format', 'services', 'how_found', 'trial_type']);
        });
        Schema::dropIfExists('trial_options');
        Schema::dropIfExists('free_trial_pages');
    }
};
