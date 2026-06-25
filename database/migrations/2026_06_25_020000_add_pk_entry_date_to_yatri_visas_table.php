<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('yatri_visas', 'pk_entry_date')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->string('pk_entry_date')->nullable()->after('pk_entry_port');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('yatri_visas', 'pk_entry_date')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->dropColumn('pk_entry_date');
            });
        }
    }
};
