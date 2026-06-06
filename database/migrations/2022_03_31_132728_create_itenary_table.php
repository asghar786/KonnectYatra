<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItenaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itenary', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->date('depart')->nullable();
            $table->date('return')->nullable();
            $table->string('class')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('passengers')->nullable();
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
        Schema::dropIfExists('itenary');
    }
}
