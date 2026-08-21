<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickYatrisTable extends Migration
{
    /**
     * Quick Yatri — a standalone, one-page capture of the printed Konnect.US
     * Yatri Application. Deliberately its own table rather than another shape of
     * `yatri_visas`: this one is keyed straight off the paper form, column for
     * column, so the sheet and the screen can never drift apart.
     */
    public function up()
    {
        Schema::create('quick_yatris', function (Blueprint $table) {
            $table->id();

            // Reference boxes across the top of the sheet.
            $table->string('sr_no', 50)->nullable();
            $table->string('rt_no', 50)->nullable();
            $table->string('ow_no', 50)->nullable();
            $table->string('lp_no', 50)->nullable();

            // "Round Trip PHL-ISB/LHE-PHL (PA/DE/NJ-SO)"  /  "Land Package"
            $table->string('booking_type', 40)->nullable();

            // Price grid: round_trip_5star 3150 | one_way_5star 2650 | round_trip_land 1650
            $table->string('trip_option', 40)->nullable();
            $table->decimal('package_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();

            // The three blue option bars.
            $table->boolean('wheelchair_airport')->default(false);
            $table->boolean('wheelchair_full_trip')->default(false); // +$300
            $table->boolean('meal_vegetarian')->default(false);

            // Applicant grid, in sheet order.
            $table->string('applicant_name');
            $table->string('gender', 1)->nullable();               // M / F
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('cell_phone', 40)->nullable();
            $table->string('email')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('passport_no', 60)->nullable();
            $table->date('date_of_issue')->nullable();
            $table->date('date_of_expiry')->nullable();
            $table->string('first_visit_pakistan', 3)->nullable(); // Yes / No
            $table->string('port_of_entry', 40)->nullable();       // Wagah / Islamabad / Lahore
            $table->date('previous_visit_date')->nullable();
            $table->string('profession')->nullable();
            $table->string('family_traveling', 3)->nullable();     // Yes / No
            $table->string('family_members_count', 10)->nullable();
            $table->string('family_member_1')->nullable();
            $table->string('family_member_2')->nullable();
            $table->string('marital_status', 20)->nullable();      // Married / Single / Divorced / Widowed
            $table->text('home_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state_zip')->nullable();
            $table->string('nearest_gurdwara')->nullable();
            $table->string('gurdwara_city_state')->nullable();

            // Foot of the sheet.
            $table->string('photo')->nullable();                   // filename in public/quick_yatri_uploads
            $table->date('signature_date')->nullable();
            $table->boolean('upload_passport')->default(false);
            $table->boolean('upload_green_card')->default(false);
            $table->boolean('upload_id_license')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quick_yatris');
    }
}
