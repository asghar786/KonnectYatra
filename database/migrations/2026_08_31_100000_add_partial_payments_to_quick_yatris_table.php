<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Room for a payment taken in parts — up to three amounts, each with the
 * receipt written for it.
 *
 * Three, because that is what was asked for and what the page can print: the
 * deposit, a second instalment and the balance. A yatri who pays in more parts
 * than that is rare enough to be worth a phone call rather than a fourth column
 * nobody can fit on the sheet.
 *
 * `amount_paid` / `receipt_no` stay as they are and become slot **1**, rather
 * than being renamed to `..._1` for symmetry. Renaming would mean moving live
 * production data, and the only thing it would buy is tidier column names —
 * `QuickYatri::payments()` hands the three slots back as a list, so nothing
 * outside the model has to know about the asymmetry.
 *
 * With these, `Paid` on the sheet stops being a typed figure and becomes the
 * sum of what was actually taken, the same way Amount and Balance are already
 * derived. Three parts that add up cannot disagree with their own total.
 */
class AddPartialPaymentsToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->decimal('amount_paid_2', 10, 2)->nullable()->after('receipt_no');
            $table->char('receipt_no_2', 6)->nullable()->after('amount_paid_2');
            $table->decimal('amount_paid_3', 10, 2)->nullable()->after('receipt_no_2');
            $table->char('receipt_no_3', 6)->nullable()->after('amount_paid_3');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn(['amount_paid_2', 'receipt_no_2', 'amount_paid_3', 'receipt_no_3']);
        });
    }
}
