<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMulticitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multicities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pass_id');
            $table->foreign('pass_id')->references('id')->on('itenary')->ondelete('cascade');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->date('depart')->nullable();
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
        Schema::dropIfExists('multicities');
    }
}
