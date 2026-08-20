<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Travel options and surcharges from the Konnect.US Yatri Application form
 * (paper form updated 2026-08-17): the two wheelchair options, the Wagah
 * two-suitcase declaration, the vegetarian-meal acknowledgement, and the
 * signature block.
 *
 * The fee_* columns store the amount that was actually charged on this
 * booking rather than recomputing it later — the rates are admin-editable
 * (see App\Support\TravelFees), so a rate change must not silently rewrite
 * the total on a booking that was already quoted and paid.
 */
return new class extends Migration
{
    /** column => definition */
    private function columns(): array
    {
        return [
            // Travel options — 'yes' or null.
            'wheelchair_airport'    => fn (Blueprint $t) => $t->string('wheelchair_airport', 10)->nullable(),
            'wheelchair_full_trip'  => fn (Blueprint $t) => $t->string('wheelchair_full_trip', 10)->nullable(),
            'two_suitcases_wagah'   => fn (Blueprint $t) => $t->string('two_suitcases_wagah', 10)->nullable(),
            'meal_ack'              => fn (Blueprint $t) => $t->string('meal_ack', 10)->nullable(),

            // Surcharges applied at submission, in USD.
            'fee_wheelchair'        => fn (Blueprint $t) => $t->decimal('fee_wheelchair', 10, 2)->default(0),
            'fee_indian_passport'   => fn (Blueprint $t) => $t->decimal('fee_indian_passport', 10, 2)->default(0),
            'fee_baggage'           => fn (Blueprint $t) => $t->decimal('fee_baggage', 10, 2)->default(0),
            'fee_late_application'  => fn (Blueprint $t) => $t->decimal('fee_late_application', 10, 2)->default(0),

            // Signature block at the foot of the paper form.
            'signature'             => fn (Blueprint $t) => $t->string('signature')->nullable(),
            'signature_date'        => fn (Blueprint $t) => $t->string('signature_date')->nullable(),
        ];
    }

    public function up(): void
    {
        foreach ($this->columns() as $name => $define) {
            if (!Schema::hasColumn('yatri_visas', $name)) {
                Schema::table('yatri_visas', function (Blueprint $table) use ($define) {
                    $define($table);
                });
            }
        }
    }

    public function down(): void
    {
        foreach (array_keys($this->columns()) as $name) {
            if (Schema::hasColumn('yatri_visas', $name)) {
                Schema::table('yatri_visas', function (Blueprint $table) use ($name) {
                    $table->dropColumn($name);
                });
            }
        }
    }
};
