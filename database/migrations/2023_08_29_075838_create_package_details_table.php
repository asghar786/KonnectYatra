<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_details', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->date('day_1')->nullable();
            $table->string('plan_1')->nullable();
            $table->integer('no_1')->nullable();
            $table->date('day_2')->nullable();
            $table->string('plan_2')->nullable();
            $table->integer('no_2')->nullable();
            $table->date('day_3')->nullable();
            $table->string('plan_3')->nullable();
            $table->integer('no_3')->nullable();
            $table->date('day_4')->nullable();
            $table->string('plan_4')->nullable();
            $table->integer('no_4')->nullable();
            $table->date('day_5')->nullable();
            $table->string('plan_5')->nullable();
            $table->integer('no_5')->nullable();
            $table->date('day_6')->nullable();
            $table->string('plan_6')->nullable();
            $table->integer('no_6')->nullable();
            $table->date('day_7')->nullable();
            $table->string('plan_7')->nullable();
            $table->integer('no_7')->nullable();
            $table->date('day_8')->nullable();
            $table->string('plan_8')->nullable();
            $table->integer('no_8')->nullable();
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
        Schema::dropIfExists('package_details');
    }
}
