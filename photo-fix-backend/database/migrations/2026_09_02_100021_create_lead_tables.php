<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->json('service_ids')->nullable();
            $table->string('file_link')->nullable();
            $table->string('budget')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // new | contacted | won | lost
            $table->text('admin_note')->nullable();
            $table->string('source')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('status')->default('new'); // new | read | replied
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('free_trial_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('file_link')->nullable();
            $table->string('num_images')->nullable();
            $table->text('requirements')->nullable();
            $table->string('status')->default('new');
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_confirmed')->default(false);
            $table->string('token')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('free_trial_requests');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('quote_requests');
    }
};
