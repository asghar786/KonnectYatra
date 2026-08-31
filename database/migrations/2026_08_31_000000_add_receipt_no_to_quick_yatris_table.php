<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The receipt number written against the money that was taken.
 *
 * It sits beside `amount_paid` because the two are one fact: a deposit handed
 * over in cash, by Zelle or by check is receipted, and the sheet has to say
 * which receipt, or the payment cannot be traced back to the book it was
 * written in.
 *
 * Six digits, because that is what the office's receipt book prints ("No.
 * 123454"). A char(6) string rather than an integer: the number is an
 * identifier, not a quantity — nothing adds it up — and a book that starts at
 * 000001 must keep its leading zeros, which an integer column would eat.
 *
 * Deliberately NOT the older `balance.raseed_no`: that column belongs to the
 * yatri_visas booking flow, where a booking has many payment rows. A Quick
 * Yatri sheet is one printed page with one money line on it, so the number
 * lives on the row, the way `amount_paid` does.
 */
class AddReceiptNoToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->char('receipt_no', 6)->nullable()->after('amount_paid');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn('receipt_no');
        });
    }
}
