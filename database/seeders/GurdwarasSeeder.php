<?php

namespace Database\Seeders;

use App\Models\Gurdwara;
use Illuminate\Database\Seeder;

/**
 * Merges the client's master gurdwara list (database/data/gurdwaras.csv) into
 * the gurdwara table.
 *
 * Rules:
 *  - `match_name` names an existing row (matched when the CSV was built): update
 *    it in place, keeping its name, photo, sangat and colour.
 *  - Blank CSV cells never overwrite existing data — the sheet is patchy and a
 *    missing phone must not wipe a good one.
 *  - Rows with no `match_name` are inserted, unless a row with the same name and
 *    city already exists, which keeps re-runs idempotent.
 */
class GurdwarasSeeder extends Seeder
{
    /** CSV column -> gurdwara column. */
    private const FIELDS = [
        'address'            => 'address',
        'city'               => 'city',
        'state'              => 'state',
        'zip'                => 'zip',
        'phone_no'           => 'phone_no',
        'pardan_name'        => 'pardan_name',
        'secretary_name'     => 'secretary_name',
        'secretary_phone_no' => 'secretary_phone_no',
    ];

    public function run()
    {
        $path = database_path('data/gurdwaras.csv');
        if (!is_readable($path)) {
            $this->command->error("Missing gurdwara data file: {$path}");
            return;
        }

        $fh = fopen($path, 'r');
        $head = fgetcsv($fh);
        $updated = $inserted = $refreshed = $missing = 0;

        while (($row = fgetcsv($fh)) !== false) {
            if (count($row) < count($head)) {
                continue;
            }
            $r = array_combine($head, $row);
            $values = [];
            foreach (self::FIELDS as $from => $to) {
                if (trim((string) ($r[$from] ?? '')) !== '') {
                    $values[$to] = trim($r[$from]);
                }
            }

            if (trim((string) $r['match_name']) !== '') {
                $existing = Gurdwara::where('gurdwara_name', $r['match_name'])->first();
                if ($existing) {
                    $existing->update($values);   // name/photo/sangat/colour untouched
                    $updated++;
                    continue;
                }
                $missing++;   // not on this database — fall through and insert it
            }

            $dupe = Gurdwara::where('gurdwara_name', $r['name'])->where('city', $r['city'])->first();
            if ($dupe) {
                $dupe->update($values);
                $refreshed++;
                continue;
            }

            Gurdwara::create($values + [
                'gurdwara_name' => $r['name'],
                'country'       => 'United States',
            ]);
            $inserted++;
        }
        fclose($fh);

        $this->command->info("Gurdwaras — updated: {$updated}, inserted: {$inserted}, re-run refresh: {$refreshed}"
            . ($missing ? ", expected-but-absent: {$missing}" : '')
            . '. Total now: ' . Gurdwara::count());
    }
}
