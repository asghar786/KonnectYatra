<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_details', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->integer('single_ticket')->default("0");
            $table->integer('double_ticket')->default("0");
            $table->integer('triple_ticket')->default("0");
            $table->integer('single_isb_to_lhr')->default("0");
            $table->integer('double_isb_to_lhr')->default("0");
            $table->integer('triple_isb_to_lhr')->default("0");
            $table->integer('single_tolls')->default("0");
            $table->integer('double_tolls')->default("0");
            $table->integer('triple_tolls')->default("0");
            $table->integer('single_isb_hotel')->default("0");
            $table->integer('double_isb_hotel')->default("0");
            $table->integer('triple_isb_hotel')->default("0");
            $table->integer('single_transport')->default("0");
            $table->integer('double_transport')->default("0");
            $table->integer('triple_transport')->default("0");
            $table->integer('single_lhr_hotel')->default("0");
            $table->integer('double_lhr_hotel')->default("0");
            $table->integer('triple_lhr_hotel')->default("0");
            $table->integer('single_food')->default("0");
            $table->integer('double_food')->default("0");
            $table->integer('triple_food')->default("0");
            $table->integer('single_visa')->default("0");
            $table->integer('double_visa')->default("0");
            $table->integer('triple_visa')->default("0");
            $table->integer('single_misc')->default("0");
            $table->integer('double_misc')->default("0");
            $table->integer('triple_misc')->default("0");
            $table->integer('single_margin')->default("0");
            $table->integer('double_margin')->default("0");
            $table->integer('triple_margin')->default("0");
            $table->integer('single_local_tour')->default("0");
            $table->integer('double_local_tour')->default("0");
            $table->integer('triple_local_tour')->default("0");
            $table->integer('single_crew')->default("0");
            $table->integer('double_crew')->default("0");
            $table->integer('triple_crew')->default("0");
            $table->integer('single_kartarpur')->default("0");
            $table->integer('double_kartarpur')->default("0");
            $table->integer('triple_kartarpur')->default("0");
            $table->integer('single_nanakana')->default("0");
            $table->integer('double_nanakana')->default("0");
            $table->integer('triple_nanakana')->default("0");
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
        Schema::dropIfExists('price_details');
    }
}
