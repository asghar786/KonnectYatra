<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfficeBearerFieldsToGurdwaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gurdwara', function (Blueprint $table) {
            // Per-office-bearer email addresses (names + phones already exist)
            if (!Schema::hasColumn('gurdwara', 'chairman_email')) {
                $table->string('chairman_email')->nullable()->after('chairman_phone_no');
            }
            if (!Schema::hasColumn('gurdwara', 'pardan_email')) {
                $table->string('pardan_email')->nullable()->after('phone_no');
            }
            if (!Schema::hasColumn('gurdwara', 'secretary_email')) {
                $table->string('secretary_email')->nullable()->after('secretary_phone_no');
            }
            if (!Schema::hasColumn('gurdwara', 'manager_email')) {
                $table->string('manager_email')->nullable()->after('manager_phone_no');
            }

            // Granthi (distinct from the existing Head Granthi)
            if (!Schema::hasColumn('gurdwara', 'granthi_name')) {
                $table->string('granthi_name')->nullable()->after('head_garanti_phone_no');
            }
            if (!Schema::hasColumn('gurdwara', 'granthi_email')) {
                $table->string('granthi_email')->nullable()->after('granthi_name');
            }

            // Additional roles / notes
            if (!Schema::hasColumn('gurdwara', 'ragi_name')) {
                $table->string('ragi_name')->nullable()->after('granthi_email');
            }
            if (!Schema::hasColumn('gurdwara', 'senior_board_member')) {
                $table->string('senior_board_member')->nullable()->after('ragi_name');
            }
            if (!Schema::hasColumn('gurdwara', 'notes')) {
                $table->text('notes')->nullable()->after('senior_board_member');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gurdwara', function (Blueprint $table) {
            $table->dropColumn([
                'chairman_email',
                'pardan_email',
                'secretary_email',
                'manager_email',
                'granthi_name',
                'granthi_email',
                'ragi_name',
                'senior_board_member',
                'notes',
            ]);
        });
    }
}
