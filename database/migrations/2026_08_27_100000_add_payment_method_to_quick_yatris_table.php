<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * How the applicant is paying — Cash, Zelle or Check.
 *
 * Three booleans rather than one column because they are tick boxes on the
 * paper sheet, and a deposit paid one way with the balance paid another is an
 * ordinary thing to record. They sit beside the Date at the foot of page 1, on
 * the same line, because page 1 has no spare height for another row.
 */
class AddPaymentMethodToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->boolean('pay_cash')->default(false)->after('price_note');
            $table->boolean('pay_zelle')->default(false)->after('pay_cash');
            $table->boolean('pay_check')->default(false)->after('pay_zelle');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn(['pay_cash', 'pay_zelle', 'pay_check']);
        });
    }
}
