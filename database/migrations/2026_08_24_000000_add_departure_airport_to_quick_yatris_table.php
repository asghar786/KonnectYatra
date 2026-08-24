<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The Round Trip box on the sheet used to be locked to one hard-coded route,
 * "PHL-ISB/LHE-PHL (PA/DE/NJ-SO)". This lets it carry any active USA
 * departure airport from departure_origins, the same table the public
 * packages selector already reads.
 */
class AddDepartureAirportToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->string('departure_airport_code', 10)->nullable()->after('booking_type');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn('departure_airport_code');
        });
    }
}
