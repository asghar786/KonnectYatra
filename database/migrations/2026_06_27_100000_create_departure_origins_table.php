<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDepartureOriginsTable extends Migration
{
    /**
     * Departure origins powering the cascading Country -> State/City -> Airport
     * selector on the public /all-packages (Gurpurab) page. One row per airport.
     */
    public function up()
    {
        Schema::create('departure_origins', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('state');          // State / City label
            $table->string('airport_name');
            $table->string('airport_code', 16); // IATA-ish code; matches Package.state_code
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1); // 1 = active/shown
            $table->timestamps();
        });

        // Seed with the data previously hard-coded in the all_package view.
        $now  = now();
        $rows = [
            ['USA', 'New York (NY · NJ · CT)', 'John F. Kennedy Intl', 'JFK'],
            ['USA', 'Pennsylvania', 'Philadelphia Intl', 'PHL'],
            ['USA', 'Massachusetts', 'Boston Logan Intl', 'BOS'],
            ['USA', 'Illinois (IN · OH)', "Chicago O'Hare Intl", 'ORD'],
            ['USA', 'Florida', 'Miami Intl', 'MIA'],
            ['USA', 'Georgia', 'Hartsfield–Jackson Atlanta', 'ATL'],
            ['USA', 'Texas', 'Dallas/Fort Worth Intl', 'DFW'],
            ['USA', 'Texas', 'Houston (Hobby)', 'HOU'],
            ['USA', 'Washington DC (DE · MD · VA)', 'Washington Dulles Intl', 'IAD'],
            ['USA', 'California', 'Los Angeles Intl', 'LAX'],
            ['USA', 'California', 'San Francisco Intl', 'SFO'],
            ['USA', 'Washington', 'Seattle–Tacoma Intl', 'SEA'],
            ['Canada', 'Ontario', 'Toronto Pearson Intl', 'YYZ'],
            ['Canada', 'British Columbia', 'Vancouver Intl', 'YVR'],
            ['Singapore', 'Singapore', 'Singapore Changi', 'SIN'],
            ['Malaysia', 'Kuala Lumpur', 'Kuala Lumpur Intl', 'KUL'],
            ['Germany', 'Munich', 'Munich Airport', 'MUN'],
            ['Germany', 'Frankfurt', 'Frankfurt Airport', 'FRA'],
            ['Thailand', 'Bangkok', 'Suvarnabhumi (Bangkok)', 'BKK'],
        ];

        $insert = [];
        foreach ($rows as $i => $r) {
            $insert[] = [
                'country'      => $r[0],
                'state'        => $r[1],
                'airport_name' => $r[2],
                'airport_code' => $r[3],
                'sort_order'   => $i,
                'status'       => 1,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        DB::table('departure_origins')->insert($insert);
    }

    public function down()
    {
        Schema::dropIfExists('departure_origins');
    }
}
