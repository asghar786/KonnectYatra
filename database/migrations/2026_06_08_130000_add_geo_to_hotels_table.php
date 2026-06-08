<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeoToHotelsTable extends Migration
{
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('zip');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->text('description')->nullable()->after('longitude');
        });
    }

    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'description']);
        });
    }
}
