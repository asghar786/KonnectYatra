<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PdfPackagesSeeder extends Seeder
{
    /**
     * Disable existing packages and create new ones from the
     * "AIRPORT TO TRAVEL" departure-airport pricing sheet.
     *
     * Each origin row from the PDF becomes one Gurpurab package => 19 packages.
     *
     * Price columns -> DB fields:
     *   RT 5*  => five_star_round_price     O/W 5* => five_star_single_price   5* Land => five_star_land_price
     *   RT 4*  => four_star_round_price      O/W 4* => four_star_single_price   4* Land => four_star_land_price
     */
    public function run(): void
    {
        // Idempotency guard: don't seed twice.
        if (DB::table('package')->where('state_code', 'JFK')->exists()) {
            $this->command->warn('PDF packages already seeded (found state_code=JFK) — skipping.');
            return;
        }

        // Reuse the standard "Package Included" + visa text from an existing package.
        $template = DB::table('package')
            ->whereNotNull('sdescription')
            ->where('sdescription', '<>', '')
            ->orderBy('id')
            ->first();
        $sdescription = $template->sdescription ?? '';
        $description  = $template->description ?? '';

        // Disable all currently-existing packages.
        $disabled = DB::table('package')->update(['status' => 0]);
        $this->command->info("Disabled {$disabled} existing package(s).");

        // city, state, code, rt5, ow5, land5, rt4, ow4, land4   (Philadelphia 4* land typo $130 -> $1350)
        $origins = [
            ['New York',          'New York',                 'JFK', 3050, 2350, 1650, 2750, 2050, 1350],
            ['Philadelphia',      'Pennsylvania',             'PHL', 3050, 2350, 1650, 2750, 2050, 1350],
            ['Boston',            'Massachusetts',            'BOS', 3050, 2350, 1650, 2750, 2050, 1350],
            ['Chicago',           'Illinois',                 'ORD', 3050, 2450, 1650, 2850, 2150, 1350],
            ['Miami',             'Florida',                  'MIA', 3050, 2550, 1650, 2750, 2250, 1350],
            ['Atlanta',           'Georgia',                  'ATL', 3050, 2350, 1650, 2750, 2250, 1350],
            ['Dallas',            'Texas',                    'DFW', 3050, 2500, 1650, 2750, 2250, 1350],
            ['Washington Dulles', 'Washington DC',            'IAD', 3150, 2450, 1650, 2850, 2150, 1350],
            ['Houston',           'Texas',                    'HOU', 3150, 2550, 1650, 2750, 2250, 1350],
            ['Los Angeles',       'California',               'LAX', 3150, 2550, 1650, 2750, 2150, 1350],
            ['San Francisco',     'California',               'SFO', 3150, 2550, 1650, 2750, 2250, 1350],
            ['Seattle',           'Washington',               'SEA', 3150, 2500, 1650, 2750, 2250, 1300],
            ['Toronto',           'Ontario, Canada',          'YYZ', 3050, 2350, 1650, 2750, 2150, 1350],
            ['Vancouver',         'British Columbia, Canada', 'YVR', 3150, 2500, 1650, 2750, 2150, 1350],
            ['Singapore',         'Singapore',                'SIN', 2800, 2250, 1650, 2500, 1950, 1350],
            ['Kuala Lumpur',      'Malaysia',                 'KUL', 2800, 2250, 1650, 2500, 1950, 1350],
            ['Munich',            'Germany',                  'MUN', 2800, 2250, 1650, 2500, 1950, 1350],
            ['Frankfurt',         'Germany',                  'FRA', 2700, 2150, 1650, 2400, 1900, 1350],
            ['Bangkok',           'Thailand',                 'BKK', 2700, 2150, 1650, 2400, 1800, 1340],
        ];

        $now = now();
        $rows = [];

        foreach ($origins as $o) {
            [$city, $state, $code, $rt5, $ow5, $land5, $rt4, $ow4, $land4] = $o;
            $name = "Package and Airline ticket {$city} ({$code}) to Islamabad \u{2013} Lahore to {$city}";

            $rows[] = [
                'name'                   => $name,
                'state'                  => $state,
                'state_code'             => $code,
                'package_type'           => 'Gurpurab',
                'status'                 => 1,
                'five_star_round_price'  => $rt5,
                'five_star_single_price' => $ow5,
                'five_star_land_price'   => $land5,
                'four_star_round_price'  => $rt4,
                'four_star_single_price' => $ow4,
                'four_star_land_price'   => $land4,
                'sdescription'           => $sdescription,
                'description'            => $description,
                'created_at'             => $now,
                'updated_at'             => $now,
            ];
        }

        DB::table('package')->insert($rows);
        $this->command->info('Inserted ' . count($rows) . ' new Gurpurab packages.');
    }
}
