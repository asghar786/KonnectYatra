<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa', function (Blueprint $table) {
            $table->id()->nullable();
            $table->text('user_id');
            $table->text('child_id')->nullable();
            $table->text('visa_type')->nullable();
            $table->text('visit_purpose')->nullable();
            $table->text('duration_stay')->nullable();
            $table->text('visa_require')->nullable();
            $table->text('visa_entry')->nullable();
            $table->text('entry_port')->nullable();
            $table->text('departure_port')->nullable();
            $table->text('visit_place1')->nullable();
            $table->text('visit_place2')->nullable();
            $table->text('visit_place3')->nullable();
            $table->text('visit_place4')->nullable();
            $table->text('p_first_name')->nullable();
            $table->text('p_middle_name')->nullable();
            $table->text('p_last_name')->nullable();
            $table->date('applicant_dob')->nullable();
            $table->text('sex_type')->nullable();
            $table->text('blood_group')->nullable();
            $table->text('applicant_city')->nullable();
            $table->text('applicant_state')->nullable();
            $table->text('applicant_country')->nullable();
            $table->text('martial_status')->nullable();
            $table->text('applicant_religion')->nullable();
            $table->text('identification_mark')->nullable();
            $table->text('native_language')->nullable();
            $table->text('pres_nationality')->nullable();
            $table->text('prev_nationality')->nullable();
            $table->text('dual_nationality')->nullable();
            $table->text('passport_type')->nullable();
            $table->text('issuing_authority')->nullable();
            $table->text('passport_number')->nullable();
            $table->text('place_issue')->nullable();
            $table->date('doi')->nullable();
            $table->date('doe')->nullable();
            $table->text('abroad_address')->nullable();
            $table->text('abroad_phone')->nullable();
            $table->text('abroad_Work')->nullable();
            $table->text('abroad_cell')->nullable();
            $table->text('pak_address')->nullable();
            $table->text('pak_home')->nullable();
            $table->text('pak_work')->nullable();
            $table->text('pak_cell')->nullable();
            $table->text('sponserd')->nullable();
            $table->text('sponser_name')->nullable();
            $table->text('sponser_address')->nullable();
            $table->text('sponser_contact')->nullable();
            $table->text('profession_name')->nullable();
            $table->text('profession_address')->nullable();
            $table->text('profession_contact')->nullable();
            $table->text('profession_email')->nullable();
            $table->text('designation_name')->nullable();
            $table->text('designation_department')->nullable();
            $table->text('designation_duration')->nullable();
            $table->text('designation_duties')->nullable();
            $table->text('designation_address')->nullable();
            $table->text('designation_phone')->nullable();
            $table->text('apply_FTC')->nullable();
            $table->text('img_residence')->nullable();
            $table->text('mother_name')->nullable();
            $table->text('mother_nationality')->nullable();
            $table->text('father_name')->nullable();
            $table->text('father_nationality')->nullable();
            $table->text('spous_name')->nullable();
            $table->text('spous_nationality')->nullable();
            $table->text('spous_dob')->nullable();
            $table->text('spous_pob')->nullable();
            $table->text('spous_profession')->nullable();
            $table->text('spous_contact')->nullable();
            $table->text('children')->nullable();
            // $table->text('child_name')->nullable();
            // $table->date('child_dob')->nullable();
            $table->text('travel_with')->nullable();
            // $table->text('TM_name')->nullable();
            // $table->date('TM_dob')->nullable();
            // $table->text('TM_passport')->nullable();
            // $table->text('TM_address')->nullable();
            $table->text('bank_account')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('bank_branch')->nullable();
            $table->text('ac_number')->nullable();
            $table->text('bank_Address')->nullable();
            $table->text('visited_pakistan')->nullable();
            // $table->date('visit_date')->nullable();
            // $table->text('visit_designation')->nullable();
            // $table->text('visited_purpose')->nullable();
            // $table->text('visit_duration')->nullable();
            $table->text('refusal')->nullable();
            $table->text('refuse_entry')->nullable();
            $table->text('refusal_message')->nullable();
            $table->text('deported')->nullable();
            $table->date('deport_date')->nullable();
            $table->text('deport_country')->nullable();
            $table->text('deport_reason')->nullable();
            $table->text('deport_ref_no')->nullable();
            $table->text('criminal_case')->nullable();
            $table->date('crime_date')->nullable();
            $table->text('crime_country')->nullable();
            $table->text('crime_offence')->nullable();
            $table->text('crime_Sentence')->nullable();
            $table->date('apply_date')->nullable();
            $table->text('signature')->nullable();
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
        Schema::dropIfExists('visa');
    }
}
