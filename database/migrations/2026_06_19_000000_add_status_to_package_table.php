<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('package', 'status')) {
            Schema::table('package', function (Blueprint $table) {
                // 1 = active (shown on site), 0 = inactive (hidden / disabled)
                $table->boolean('status')->default(1)->after('package_type');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('package', 'status')) {
            Schema::table('package', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
