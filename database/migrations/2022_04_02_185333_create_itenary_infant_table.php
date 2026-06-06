<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItenaryInfantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itenary_infant', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('pass_id');
            // $table->foreign('pass_id')->references('id')->on('itenary')->onDelete('cascade');
            $table->foreignId('pass_id')->constrained('itenary');
            $table->string('firstnamei')->nullable();
            $table->string('lastnamei')->nullable();
            $table->date('dobi')->nullable();
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
        Schema::dropIfExists('itenary_infant');
    }
}
