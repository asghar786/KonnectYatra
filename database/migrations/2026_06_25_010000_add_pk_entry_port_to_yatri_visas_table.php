<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('yatri_visas', 'pk_entry_port')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->string('pk_entry_port')->nullable()->after('pk_travel_history');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('yatri_visas', 'pk_entry_port')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->dropColumn('pk_entry_port');
            });
        }
    }
};
