<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYatriCompanionsTable extends Migration
{
    /**
     * Co-travellers (spouse / family) booked together with a primary Yatri.
     * Captured so the group is kept together for hotel room allotment, and so the
     * total is the package price × number of people travelling.
     */
    public function up()
    {
        Schema::create('yatri_companions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yatri_visa_id')->index();
            $table->string('relation')->nullable();      // Wife, Husband, Son, Daughter, ...
            $table->string('full_name');
            $table->string('birth_country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('passport_file')->nullable();  // uploaded passport scan
            $table->timestamps();
        });

        // Booking-level totals so the recorded amount reflects the whole group.
        Schema::table('yatri_visas', function (Blueprint $table) {
            if (!Schema::hasColumn('yatri_visas', 'travellers_count')) {
                $table->integer('travellers_count')->default(1)->after('package_type');
            }
            if (!Schema::hasColumn('yatri_visas', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->nullable()->after('travellers_count');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('yatri_companions');
        Schema::table('yatri_visas', function (Blueprint $table) {
            if (Schema::hasColumn('yatri_visas', 'travellers_count')) {
                $table->dropColumn('travellers_count');
            }
            if (Schema::hasColumn('yatri_visas', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
        });
    }
}
