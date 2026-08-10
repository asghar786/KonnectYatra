<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToGurdwaraLeadsTable extends Migration
{
    /**
     * Extra fields the homepage popup now collects: middle name, father's
     * name, email, and how many Yatris the visitor is enquiring for.
     * Nullable so the rows captured before this change stay valid.
     */
    public function up()
    {
        Schema::table('gurdwara_leads', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('father_name')->nullable()->after('last_name');
            $table->string('email')->nullable()->after('phone');
            $table->unsignedSmallInteger('yatri_count')->nullable()->after('zip_code');
        });
    }

    public function down()
    {
        Schema::table('gurdwara_leads', function (Blueprint $table) {
            $table->dropColumn(['middle_name', 'father_name', 'email', 'yatri_count']);
        });
    }
}
