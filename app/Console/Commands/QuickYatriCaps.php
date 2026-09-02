<?php

namespace App\Console\Commands;

use App\Models\QuickYatri;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Bring applications saved before 2026-09-02 up to the sheet's own reading.
 *
 * The Quick Yatri sheet has always shown every free-text answer in capitals,
 * but until 2026-09-02 that was `.qy-caps` — a text-transform. The posted value
 * went into the table as typed, so a form reading "JAGWINDER SINGH" could be
 * stored as "Kanwaljit singh", depending on nothing more than what Caps Lock
 * was doing. The admin list prints the stored value, which is where the mix
 * shows.
 *
 * Saving through the form now upper-cases on the way in, so this only ever has
 * the older rows to catch up. It is idempotent — a second run reports nothing
 * to do — and safe to leave in place.
 */
class QuickYatriCaps extends Command
{
    protected $signature = 'quick-yatri:caps {--dry-run : Show what would change without writing anything}';

    protected $description = "Upper-case the Quick Yatri free-text answers on applications saved before the form did it";

    public function handle()
    {
        $dry = (bool) $this->option('dry-run');

        // Straight through the query builder rather than the model: this is a
        // re-casing of what is already there, not an edit anybody made, so
        // `updated_at` must not move and no model event should fire.
        $rows = DB::table('quick_yatris')
            ->select(array_merge(['id'], QuickYatri::CAPS_FIELDS))
            ->orderBy('id')
            ->get();

        $rowsChanged   = 0;
        $fieldsChanged = 0;

        foreach ($rows as $row) {
            $changes = [];

            foreach (QuickYatri::CAPS_FIELDS as $field) {
                $was = $row->{$field};
                if ($was === null || $was === '') {
                    continue;
                }

                $now = mb_strtoupper((string) $was, 'UTF-8');
                if ($now !== $was) {
                    $changes[$field] = $now;
                }
            }

            if (!$changes) {
                continue;
            }

            $rowsChanged++;
            $fieldsChanged += count($changes);

            if ($this->getOutput()->isVerbose()) {
                $this->line(sprintf(
                    '  #%d  %s',
                    $row->id,
                    implode(', ', array_map(
                        function ($field) use ($row, $changes) {
                            return $field . ': "' . $row->{$field} . '" -> "' . $changes[$field] . '"';
                        },
                        array_keys($changes)
                    ))
                ));
            }

            if (!$dry) {
                DB::table('quick_yatris')->where('id', $row->id)->update($changes);
            }
        }

        if ($rowsChanged === 0) {
            $this->info('Nothing to do — every application already reads in CAPS.');

            return self::SUCCESS;
        }

        $this->info(sprintf(
            '%s %d field%s across %d of %d application%s.',
            $dry ? 'Would upper-case' : 'Upper-cased',
            $fieldsChanged,
            $fieldsChanged === 1 ? '' : 's',
            $rowsChanged,
            count($rows),
            count($rows) === 1 ? '' : 's'
        ));

        if ($dry) {
            $this->comment('Dry run — nothing was written. Run again without --dry-run to apply.');
        }

        return self::SUCCESS;
    }
}
