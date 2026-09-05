<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * When an applicant is actually flying — filled in once a ticket is booked,
 * the same way SR#/RT#/OW#/LP# already are. Nothing on the sheet answered
 * "when" before this: every other date column is about the applicant
 * (birth, passport, a past visit), not the trip itself.
 *
 * This is what the Group Manifest report (see QuickYatriController::groups())
 * keys its city-by-city grouping on, alongside `departure_airport_code`.
 */
class AddTravelDatesToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->date('departure_date')->nullable()->after('lp_no');
            $table->date('return_date')->nullable()->after('departure_date');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn(['departure_date', 'return_date']);
        });
    }
}
