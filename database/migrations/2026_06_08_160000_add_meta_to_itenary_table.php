<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaToItenaryTable extends Migration
{
    public function up()
    {
        Schema::table('itenary', function (Blueprint $table) {
            $table->string('ip')->nullable()->after('passengers');
            $table->string('city')->nullable()->after('ip');
            $table->string('country')->nullable()->after('city');
        });
    }

    public function down()
    {
        Schema::table('itenary', function (Blueprint $table) {
            $table->dropColumn(['ip', 'city', 'country']);
        });
    }
}
