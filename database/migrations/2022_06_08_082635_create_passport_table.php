<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('city');
            $table->string('address');
            $table->string('apt');
            $table->string('email');
            $table->string('phonenumber');
            $table->string('zipcode');
            $table->date('dob');
            $table->string('state');
            $table->string('gender');
            $table->string('notes');
            $table->string('passportnumber');
            $table->date('pdoi');
            $table->string('pdoe');
            $table->date('issuedate');
            $table->date('expiredate');
            $table->string('nicpnumber');
            $table->string('nicopnumber');
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
        Schema::dropIfExists('passport');
    }
}
