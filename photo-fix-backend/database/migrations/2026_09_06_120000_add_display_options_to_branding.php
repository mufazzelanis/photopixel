<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branding', function (Blueprint $table) {
            if (! Schema::hasColumn('branding', 'logo_bg')) {
                $table->string('logo_bg', 20)->default('none'); // none | light | dark
            }
            if (! Schema::hasColumn('branding', 'logo_height')) {
                $table->unsignedSmallInteger('logo_height')->default(36); // px, header logo
            }
        });
    }

    public function down(): void
    {
        Schema::table('branding', function (Blueprint $table) {
            $table->dropColumn(['logo_bg', 'logo_height']);
        });
    }
};
