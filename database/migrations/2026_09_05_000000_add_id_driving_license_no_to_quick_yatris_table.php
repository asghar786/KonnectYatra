<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "ID / Driving Lic#" — a state ID card or driver's licence number, now asked
 * for on the sheet itself where Profession used to sit (Profession moved up
 * beside Gender on 2026-09-05).
 *
 * Not the same thing as `upload_id_license` (a retired tick box that only ever
 * meant "a copy of this document was attached") — this is the number printed
 * on the card, alongside `passport_no`.
 */
class AddIdDrivingLicenseNoToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->string('id_driving_license_no', 60)->nullable()->after('profession');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn('id_driving_license_no');
        });
    }
}
