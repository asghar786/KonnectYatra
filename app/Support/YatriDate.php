<?php

namespace App\Support;

use DateTime;

/**
 * Reads and writes the yatri date fields in one house format: DD-MMM-YYYY.
 *
 * `dob`, `issue_date`, `expiry_date`, `green_card_expiry_date` and
 * `pk_entry_date` are all varchar columns, and four different forms have
 * written to them over the years, each with its own idea of a date:
 *
 *   14-AUG-1947   the public apply form (jQuery UI 'dd-M-yy')  <- the house format
 *   1960-07-25    anything that used <input type="date">
 *   06-18-2026    the generic '.datepicker' (jQuery UI 'mm-dd-yy')
 *   1 Apr 2025    older and seeded rows
 *
 * So a stored value cannot be trusted to be in any one format, and the admin
 * form has to be able to show whatever it finds. `format()` recognises each of
 * the above and returns DD-MMM-YYYY; anything it cannot read confidently it
 * returns untouched, because showing what is actually stored is safer than
 * showing a guess that an admin might then save.
 *
 * The one genuinely ambiguous case is an all-numeric NN-NN-YYYY: 09-12-2000 is
 * September 12th if the generic datepicker wrote it and December 9th if a human
 * typed it, and nothing in the row says which. The app's own pickers wrote
 * month-first, so month-first is the assumption, except where the first number
 * is above 12 and can only be a day.
 */
class YatriDate
{
    /** Formats that are unambiguous, tried in order. */
    private const FORMATS = [
        'd-M-Y',    // 14-AUG-1947, 04-Feb-1980
        'j-M-Y',    // 4-Feb-1980
        'Y-m-d',    // 1960-07-25
        'Y/m/d',    // 1960/07/25
        'j M Y',    // 1 Apr 2025, 29 Feb 1984
        'j F Y',    // 1 April 2025
        'M j, Y',   // Apr 1, 2025
        'F j, Y',   // April 1, 2025
    ];

    private const MONTHS = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

    /**
     * Render a stored value as DD-MMM-YYYY, or hand back the raw string if it
     * is not a date this recognises (empty stays empty).
     */
    public static function format($raw): string
    {
        $value = trim((string) $raw);

        if ($value === '') {
            return '';
        }

        foreach (self::FORMATS as $format) {
            $date = self::strict($value, $format);
            if ($date) {
                return self::stamp($date);
            }
        }

        // All-numeric, e.g. 06-18-2026 or 06/18/2026. Month-first unless the
        // first number is too big to be a month.
        if (preg_match('~^(\d{1,2})([-/.])(\d{1,2})\2(\d{4})$~', $value, $m)) {
            $sep   = $m[2];
            $order = ((int) $m[1] > 12)
                ? 'd' . $sep . 'm' . $sep . 'Y'
                : 'm' . $sep . 'd' . $sep . 'Y';

            $date = self::strict($value, $order);
            if ($date) {
                return self::stamp($date);
            }
        }

        return $value;
    }

    /**
     * Parse only if the string matches the format exactly — createFromFormat is
     * otherwise happy to read "31-FEB-2026" as the 3rd of March.
     */
    private static function strict(string $value, string $format): ?DateTime
    {
        $date   = DateTime::createFromFormat('!' . $format, $value);
        $errors = DateTime::getLastErrors();

        if (!$date) {
            return null;
        }

        if (is_array($errors) && ($errors['warning_count'] > 0 || $errors['error_count'] > 0)) {
            return null;
        }

        return $date;
    }

    /** DD-MMM-YYYY with the month upper-cased, e.g. 20-AUG-2026. */
    private static function stamp(DateTime $date): string
    {
        return $date->format('d') . '-' . self::MONTHS[(int) $date->format('n') - 1] . '-' . $date->format('Y');
    }
}
