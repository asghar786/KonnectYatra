<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItenaryAdultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itenary_adult', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pass_id')->constrained('itenary');
            $table->string('firstnamea')->nullable();
            $table->string('lastnamea')->nullable();
            $table->date('doba')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itenary_adult');
    }
}
