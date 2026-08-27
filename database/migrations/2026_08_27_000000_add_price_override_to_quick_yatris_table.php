<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A Quick Yatri's price is not always the price on the grid.
 *
 * The three grid prices (One-Way / Round Trip / Land Package) are now editable
 * defaults, but two yatris travelling on the same option can still be quoted
 * differently — a family booking six seats, someone flying from a cheaper
 * departure airport, a rate agreed at a gurdwara event. `custom_price` marks a
 * row whose `package_amount` was set by hand so re-saving the sheet never
 * recomputes it back to the default, and `price_note` records why.
 */
class AddPriceOverrideToQuickYatrisTable extends Migration
{
    public function up()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->boolean('custom_price')->default(false)->after('total_amount');
            $table->string('price_note')->nullable()->after('custom_price');
        });
    }

    public function down()
    {
        Schema::table('quick_yatris', function (Blueprint $table) {
            $table->dropColumn(['custom_price', 'price_note']);
        });
    }
}
