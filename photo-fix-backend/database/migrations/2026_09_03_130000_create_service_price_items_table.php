<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // e.g. "$0.39" — shown next to the service title on /pricing.
            // A service only appears on /pricing once it has price items.
            $table->string('starting_price')->nullable()->after('btn_url');
        });

        // Itemized "Basic Clipping Path — $0.39" style rows under a service
        // on the /pricing page.
        Schema::create('service_price_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('price');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_price_items');
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('starting_price');
        });
    }
};
