<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->string('country_code', 2)->nullable()->after('country');
        });
        Schema::table('geoip_cache', function (Blueprint $table) {
            $table->string('country_code', 2)->nullable()->after('country');
        });
    }

    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });
        Schema::table('geoip_cache', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });
    }
};
