<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Loads the US ZIP -> city/state + centroid table used by the gurdwara ZIP
 * search. Idempotent: truncates and reloads from database/data/us_zip_codes.csv.
 */
class ZipCodesSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('data/us_zip_codes.csv');
        if (!is_readable($path)) {
            $this->command->error("Missing ZIP data file: {$path}");
            return;
        }

        DB::table('zip_codes')->truncate();

        $fh = fopen($path, 'r');
        fgetcsv($fh); // header

        $batch = [];
        $total = 0;
        while (($row = fgetcsv($fh)) !== false) {
            if (count($row) < 5 || $row[0] === '') {
                continue;
            }
            $batch[] = [
                'zip'   => str_pad(trim($row[0]), 5, '0', STR_PAD_LEFT),
                'city'  => trim($row[1]),
                'state' => strtoupper(trim($row[2])),
                'lat'   => (float) $row[3],
                'lng'   => (float) $row[4],
            ];
            if (count($batch) >= 2000) {
                DB::table('zip_codes')->insert($batch);
                $total += count($batch);
                $batch = [];
            }
        }
        if ($batch) {
            DB::table('zip_codes')->insert($batch);
            $total += count($batch);
        }
        fclose($fh);

        $this->command->info("Seeded {$total} US ZIP codes.");
    }
}
