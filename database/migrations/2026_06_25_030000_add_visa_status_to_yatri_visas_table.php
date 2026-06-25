<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('yatri_visas', 'visa_status')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->string('visa_status')->default('Pending')->after('payment_status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('yatri_visas', 'visa_status')) {
            Schema::table('yatri_visas', function (Blueprint $table) {
                $table->dropColumn('visa_status');
            });
        }
    }
};
