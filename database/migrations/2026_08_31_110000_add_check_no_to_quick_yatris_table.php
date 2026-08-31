<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The number of the check a payment came in on.
 *
 * The Check tick box says *how* the money arrived; this says which check, so a
 * payment can be matched against the bank statement. It sits on the payment
 * line beside the box it belongs to, in the space the Date was not using.
 *
 * A short string with no digit rule, unlike `receipt_no`: the receipt book is
 * the office's own and prints exactly six digits, but a check is the payer's
 * and its number is whatever their bank printed on it. Copying it exactly
 * matters more than holding it to a shape.
 */
class AddCheckNoToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->string('check_no', 20)->nullable()->after('receipt_no_3');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn('check_no');
        });
    }
}
