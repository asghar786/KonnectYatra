<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('geoip_cache', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45)->unique();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('resolved_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('geoip_cache');
    }
};
