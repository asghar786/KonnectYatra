<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->index();
            $table->string('visitor_id', 64)->index();
            $table->string('visitor_type', 10)->default('new'); // new | returning
            $table->string('url', 2048);
            $table->string('referrer', 2048)->nullable();
            $table->string('referrer_host')->nullable();
            $table->string('source_type', 20)->default('direct'); // direct|organic|social|referral
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable(); // US state
            $table->string('city')->nullable();
            $table->string('device_type', 10)->nullable(); // desktop|mobile|tablet
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamp('created_at')->nullable()->index();
        });

        // Helpful composite/lookup indexes for the dashboard aggregations.
        Schema::table('visits', function (Blueprint $table) {
            $table->index('country');
            $table->index('source_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
};
