<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->index(); // contact_inquiry|booking_request|special_booking
            $table->string('session_id', 64)->nullable()->index();
            $table->string('visitor_id', 64)->nullable();
            $table->string('source_type', 20)->nullable(); // captured from current visit for attribution
            $table->string('url', 2048)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversions');
    }
};
