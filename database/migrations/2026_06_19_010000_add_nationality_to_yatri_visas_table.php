<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('yatri_visas', 'nationality')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->string('nationality')->nullable()->after('passport_country');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('yatri_visas', 'nationality')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->dropColumn('nationality');
            });
        }
    }
};
