<?php

namespace App\Support;

use App\Models\ZipCode;
use Illuminate\Support\Collection;

/**
 * Where each gurdwara is. Shared by the public ZIP search (/gurdwaras) and the
 * admin Address Book, so both rank by the same coordinates.
 *
 * The gurdwara table has no lat/lng of its own, so a location is derived from
 * its ZIP when that ZIP is a real one, otherwise from its city centroid. Some
 * stored ZIPs are wrong (a few point at other states), hence the city fallback.
 */
class GurdwaraGeo
{
    /** @return array<int, array{0: float, 1: float}> id => [lat, lng] */
    public static function coords(Collection $gurdwaras): array
    {
        $stamp = $gurdwaras->count() . ':' . (string) $gurdwaras->max('updated_at');

        return \Cache::remember('gurdwara_coords_' . md5($stamp), now()->addDay(), function () use ($gurdwaras) {
            $byZip = ZipCode::whereIn('zip', $gurdwaras->pluck('zip')
                ->map(fn($z) => self::normaliseZip($z))
                ->filter()->unique()->values())
                ->get()->keyBy('zip');

            $codes = array_flip(self::usStates());   // "New York" => "NY"
            $cityKeys = $gurdwaras->pluck('city')->filter()
                ->map(fn($c) => strtolower(trim($c)))->unique()->values();

            $cities = $cityKeys->isEmpty() ? collect() : ZipCode::whereIn(\DB::raw('LOWER(city)'), $cityKeys)
                ->selectRaw('LOWER(city) c, state, AVG(lat) lat, AVG(lng) lng')
                ->groupBy('c', 'state')->get()->keyBy(fn($r) => $r->c . '|' . $r->state);

            $out = [];
            foreach ($gurdwaras as $g) {
                $zip = self::normaliseZip($g->zip);
                if ($zip && isset($byZip[$zip])) {
                    $out[$g->id] = [(float) $byZip[$zip]->lat, (float) $byZip[$zip]->lng];
                    continue;
                }
                $key = strtolower(trim((string) $g->city)) . '|' . ($codes[self::canonicalState($g->state)] ?? '');
                if (isset($cities[$key])) {
                    $out[$g->id] = [(float) $cities[$key]->lat, (float) $cities[$key]->lng];
                }
            }
            return $out;
        });
    }

    /** A 5-digit ZIP, or null if there isn't one. */
    public static function normaliseZip($raw): ?string
    {
        $z = preg_replace('/\D/', '', (string) $raw);
        if ($z === '' || strlen($z) > 5) {
            return null;
        }
        return str_pad($z, 5, '0', STR_PAD_LEFT);
    }

    /** Normalise a raw state value (code or name) to a canonical full state name. */
    public static function canonicalState($raw): string
    {
        $raw = trim((string) $raw);
        if ($raw === '') return '';
        $states = self::usStates();
        $upper = strtoupper($raw);
        if (isset($states[$upper])) return $states[$upper];              // "NY" -> "New York"
        $lowerToProper = array_change_key_case(array_flip($states), CASE_LOWER);
        $lower = strtolower($raw);
        if (isset($lowerToProper[$lower])) return $states[$lowerToProper[$lower]];
        return $raw;                                                     // unknown — keep as entered
    }

    /**
     * A state label down to its primary state's 2-letter code: "Florida" -> "FL",
     * "New York (NY · NJ · CT)" -> "NY", "Washington DC (DE · MD · VA)" -> "DC".
     * Falls back to the label itself when it isn't a recognised state name, so an
     * unexpected value stays visible rather than silently disappearing.
     */
    public static function stateAbbreviation($label): string
    {
        $label = trim((string) $label);
        if ($label === '') {
            return '';
        }

        $primary = trim(preg_replace('/\s*\(.*$/', '', $label));

        if (strcasecmp($primary, 'Washington DC') === 0) {
            return 'DC';
        }

        $codesByLowerName = array_change_key_case(array_flip(self::usStates()), CASE_LOWER);

        return $codesByLowerName[strtolower($primary)] ?? $label;
    }

    /** CODE => Full Name */
    public static function usStates(): array
    {
        return [
            'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
            'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
            'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
            'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
            'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
            'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
            'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
            'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
            'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
            'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
            'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
            'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
            'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'DC' => 'District of Columbia',
        ];
    }
}
