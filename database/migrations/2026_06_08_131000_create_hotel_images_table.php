<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelImagesTable extends Migration
{
    public function up()
    {
        Schema::create('hotel_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->index();
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotel_images');
    }
}
