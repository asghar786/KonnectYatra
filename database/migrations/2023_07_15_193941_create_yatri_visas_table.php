<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYatriVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yatri_visas', function (Blueprint $table) {
            $table->id();
            $table->string('package_month')->nullable();
            $table->string('package_type')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('place_birth')->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport')->nullable();
            $table->string('gender')->nullable();
            $table->string('first_visit')->nullable();
            $table->date('pre_visit_date')->nullable();
            $table->string('port_of_entry')->nullable();
            $table->string('profession')->nullable();
            $table->string('traveling_members')->nullable();
            $table->string('family_1')->nullable();
            $table->string('family_2')->nullable();
            $table->string('gurdwara_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('pardan_name')->nullable();
            $table->string('secetary_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('us_passport')->nullable();
            $table->string('green_card')->nullable();
            $table->string('driving_license')->nullable();
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
        Schema::dropIfExists('yatri_visas');
    }
}
