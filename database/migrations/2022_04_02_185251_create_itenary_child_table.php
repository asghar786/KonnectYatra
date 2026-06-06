<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItenaryChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itenary_child', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pass_id')->constrained('itenary');
            $table->string('firstnamec')->nullable();
            $table->string('lastnamec')->nullable();
            $table->date('dobc')->nullable();
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
        Schema::dropIfExists('itenary_child');
    }
}
