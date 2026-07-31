<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurdwaraLeadsTable extends Migration
{
    /**
     * Submissions from the homepage "Near Gurdwara Sahib" popup — visitors
     * share their contact details and the gurdwara nearest to them.
     */
    public function up()
    {
        Schema::create('gurdwara_leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 40);
            $table->string('city');
            $table->string('state');
            $table->string('zip_code', 20);
            $table->string('near_gurdwara');
            $table->string('heard_from')->nullable(); // Facebook / Friends / Gurdwara Sahib
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gurdwara_leads');
    }
}
