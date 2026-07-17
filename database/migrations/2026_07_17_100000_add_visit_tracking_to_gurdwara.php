<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurdwara', function (Blueprint $table) {
            // Field visits (admin Address Book): when the details were last
            // confirmed in person, by whom, and anything noted on site.
            if (!Schema::hasColumn('gurdwara', 'visited_at')) {
                $table->timestamp('visited_at')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('gurdwara', 'visited_by')) {
                $table->string('visited_by', 191)->nullable()->after('visited_at');
            }
            if (!Schema::hasColumn('gurdwara', 'visit_notes')) {
                $table->text('visit_notes')->nullable()->after('visited_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gurdwara', function (Blueprint $table) {
            foreach (['visited_at', 'visited_by', 'visit_notes'] as $col) {
                if (Schema::hasColumn('gurdwara', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
