<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * What the applicant has actually handed over.
 *
 * The Amount / Paid / Balance line at the foot of page 1 stores only this one
 * number: Amount is the trip's price (the ticked row of the grid, or their own
 * agreed price, plus the wheelchair surcharge) and Balance is the difference,
 * so the three figures on the sheet can never disagree with each other.
 */
class AddAmountPaidToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->decimal('amount_paid', 10, 2)->nullable()->after('pay_check');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn('amount_paid');
        });
    }
}
