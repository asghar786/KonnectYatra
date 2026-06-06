<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit', function (Blueprint $table) {
            $table->id();
            $table->string('visa_id')->nullable();
            $table->string('visit_date')->nullable();
            $table->string('visit_designation')->nullable();
            $table->string('visited_purpose')->nullable();
            $table->string('visit_duration')->nullable();
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
        Schema::dropIfExists('visit');
    }
}
