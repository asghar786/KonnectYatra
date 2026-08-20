<?php

namespace App\Support;

use App\Models\SiteSetting;

/**
 * The surcharges on the Konnect.US Yatri Application form (paper form updated
 * 2026-08-17): wheelchair for the whole trip, the Indian-passport processing
 * fee, the Wagah two-suitcase baggage fee, and the late-application fee.
 *
 * Rates live in the existing site_settings table under `fee_*` keys so Rashad
 * can change a price without a deploy or a migration; the constants below are
 * the fallback and are the figures printed on the current paper form.
 *
 * Nothing here reads a stored booking — a booking keeps the fee_* amounts it
 * was quoted (see the 2026_08_20 migration), so changing a rate never rewrites
 * a total that a yatri already agreed to.
 */
class TravelFees
{
    /** Fallbacks, straight off the paper form. */
    public const DEFAULTS = [
        'wheelchair_full_trip' => 300,
        'indian_passport'      => 25,
        'baggage_wagah'        => 25,
        'late_application'     => 100,
    ];

    /** The window in which the late-application fee applies, as Y-m-d. */
    public const DEFAULT_LATE_FROM = '2026-09-11';
    public const DEFAULT_LATE_TO   = '2026-10-15';

    /** A rate in USD — admin-saved value, else the paper-form default. */
    public static function rate(string $key): float
    {
        $saved = SiteSetting::get('fee_' . $key);

        if ($saved === null || $saved === '' || !is_numeric($saved)) {
            return (float) (self::DEFAULTS[$key] ?? 0);
        }

        return (float) $saved;
    }

    /** @return array{from:string,to:string} */
    public static function lateWindow(): array
    {
        $from = SiteSetting::get('fee_late_from');
        $to   = SiteSetting::get('fee_late_to');

        return [
            'from' => $from ?: self::DEFAULT_LATE_FROM,
            'to'   => $to ?: self::DEFAULT_LATE_TO,
        ];
    }

    /**
     * Is an application submitted on $date inside the late-fee window?
     *
     * Both ends are inclusive — the form reads "from September 11 through
     * October 15", and a yatri applying on the 15th should not be told the
     * fee has expired.
     */
    public static function isLateApplication(string $date = null): bool
    {
        $window = self::lateWindow();
        $on     = $date ? strtotime($date) : strtotime('today');
        $from   = strtotime($window['from']);
        $to     = strtotime($window['to'] . ' 23:59:59');

        if ($on === false || $from === false || $to === false) {
            return false;
        }

        return $on >= $from && $on <= $to;
    }

    /**
     * Does the Indian-passport processing fee apply?
     *
     * Keyed on the travel document, not on where the yatri lives — the fee is
     * for the extra paperwork an Indian passport needs. Falls back to
     * nationality only when no passport country was captured.
     */
    public static function isIndianPassport(?string $passportCountry, ?string $nationality = null): bool
    {
        $value = trim((string) ($passportCountry ?: $nationality));

        if ($value === '') {
            return false;
        }

        return (bool) preg_match('/^(india|indian|in)$/i', $value);
    }

    /**
     * Every surcharge that applies to one submission.
     *
     * @param  array{wheelchair_full_trip?:mixed,two_suitcases_wagah?:mixed,passport_country?:?string,nationality?:?string,date?:?string}  $input
     * @return array{wheelchair:float,indian_passport:float,baggage:float,late:float,total:float}
     */
    public static function calculate(array $input): array
    {
        // Both of these belong to the applicant personally — one wheelchair for
        // one person, that person's own suitcases — so they are charged once and
        // do NOT scale with the companion count, even though companions sit on
        // the same booking here. The paper form assumes one form per traveller.
        // If a companion needs either, that is a separate line the form does not
        // yet collect.
        $wheelchair = !empty($input['wheelchair_full_trip'])
            ? self::rate('wheelchair_full_trip')
            : 0.0;

        $baggage = !empty($input['two_suitcases_wagah'])
            ? self::rate('baggage_wagah')
            : 0.0;

        // Keyed on the applicant's own document, so it does not scale.
        $indian = self::isIndianPassport($input['passport_country'] ?? null, $input['nationality'] ?? null)
            ? self::rate('indian_passport')
            : 0.0;

        // A property of when the application was made, not of who is on it.
        $late = self::isLateApplication($input['date'] ?? null)
            ? self::rate('late_application')
            : 0.0;

        return [
            'wheelchair'      => $wheelchair,
            'indian_passport' => $indian,
            'baggage'         => $baggage,
            'late'            => $late,
            'total'           => $wheelchair + $indian + $baggage + $late,
        ];
    }

    /** The rates the apply-form JavaScript needs to show a live total. */
    public static function forJavascript(): array
    {
        $window = self::lateWindow();

        return [
            'wheelchairFullTrip' => self::rate('wheelchair_full_trip'),
            'indianPassport'     => self::rate('indian_passport'),
            'baggageWagah'       => self::rate('baggage_wagah'),
            'lateApplication'    => self::rate('late_application'),
            'lateApplies'        => self::isLateApplication(),
            'lateFrom'           => $window['from'],
            'lateTo'             => $window['to'],
        ];
    }
}
