<?php

namespace App\Support;

use App\Models\SiteSetting;

/**
 * The business facts, resolved once for the whole site.
 *
 * Order of precedence: what an admin saved under Admin > SEO Settings, then the
 * default in config/schema.php. Everything that prints the address, phone or
 * email — the header strip, the footer, the Contact page, the homepage panel
 * and the JSON-LD — reads from here, so those five can no longer drift apart.
 * Consistent NAP (Name/Address/Phone) is what a Google Business Profile match
 * keys on, so this is a correctness concern, not tidiness.
 *
 * Settings are stored as `biz_*` keys in the existing site_settings table —
 * no migration.
 */
class Business
{
    /** Days in the order Schema.org and the admin form both use. */
    public const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    /**
     * A saved setting, or null when it was never set or was cleared.
     *
     * SiteSetting::get() returns '' for a key saved empty, which is not the
     * same as "fall back to the config default" — hence the explicit check.
     */
    public static function raw(string $key)
    {
        $value = SiteSetting::get('biz_' . $key);

        return ($value === null || $value === '') ? null : $value;
    }

    /** A saved setting, falling back to config/schema.php. */
    public static function get(string $key, string $configKey = null, $default = null)
    {
        return self::raw($key) ?? config('schema.' . ($configKey ?: $key), $default);
    }

    public static function phone(): ?string
    {
        return self::get('telephone');
    }

    public static function email(): ?string
    {
        return self::get('email');
    }

    /** Digits only — for tel: hrefs and wa.me links. */
    public static function phoneDigits(): string
    {
        return preg_replace('/[^0-9+]/', '', (string) self::phone());
    }

    /** @return array{street:string,locality:string,region:string,postal:string,country:string} */
    public static function address(): array
    {
        $cfg = (array) config('schema.address', []);

        return [
            'street'   => self::raw('street')   ?? ($cfg['street']   ?? ''),
            'locality' => self::raw('locality') ?? ($cfg['locality'] ?? ''),
            'region'   => self::raw('region')   ?? ($cfg['region']   ?? ''),
            'postal'   => self::raw('postal')   ?? ($cfg['postal']   ?? ''),
            'country'  => self::raw('country')  ?? ($cfg['country']  ?? 'US'),
        ];
    }

    /**
     * The address as one display line.
     *
     * Assembles to exactly the string that used to be hard-coded in the header
     * and Contact page: "<street>, <locality>, <region> <postal>, USA".
     */
    public static function addressLine(): string
    {
        $a = self::address();

        $cityState = trim(trim($a['locality'] . ', ' . $a['region'], ' ,') . ' ' . $a['postal']);
        $country   = $a['country'] === 'US' ? 'USA' : $a['country'];

        return implode(', ', array_filter([$a['street'], $cityState, $country]));
    }

    /** @return array{lat:float,lng:float}|null — null until both are set. */
    public static function geo(): ?array
    {
        $lat = self::raw('lat') ?? config('schema.geo.lat');
        $lng = self::raw('lng') ?? config('schema.geo.lng');

        if ($lat === null || $lng === null || !is_numeric($lat) || !is_numeric($lng)) {
            return null;
        }

        // 0,0 is in the Atlantic — almost always an empty field, not a location.
        if ((float) $lat === 0.0 && (float) $lng === 0.0) {
            return null;
        }

        return ['lat' => (float) $lat, 'lng' => (float) $lng];
    }

    /**
     * Opening hours as saved by the admin form.
     *
     * @return array<int,array{day:string,open:string,close:string,closed:bool}>
     *         Empty when nothing has been set — the schema then omits
     *         openingHoursSpecification rather than inventing hours.
     */
    public static function hours(): array
    {
        $saved = self::raw('hours');

        if (!$saved) {
            return [];
        }

        $rows = json_decode($saved, true);

        return is_array($rows) ? $rows : [];
    }

    /**
     * Opening hours grouped into Schema.org OpeningHoursSpecification nodes.
     *
     * Consecutive days sharing the same times collapse into one entry, which is
     * how Google's examples are written. Days marked closed are dropped.
     */
    public static function hoursSpecification(): array
    {
        $open = array_values(array_filter(self::hours(), function ($row) {
            return empty($row['closed']) && !empty($row['open']) && !empty($row['close']);
        }));

        $groups = [];

        foreach ($open as $row) {
            $key = $row['open'] . '-' . $row['close'];
            $groups[$key][] = $row['day'];
        }

        $out = [];

        foreach ($groups as $times => $days) {
            [$opens, $closes] = explode('-', $times, 2);

            $out[] = [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => $days,
                'opens'     => $opens,
                'closes'    => $closes,
            ];
        }

        return $out;
    }

    /**
     * Profile URLs for sameAs: the four social settings, plus anything added in
     * the extra box (Google Business Profile, YouTube, TripAdvisor, Wikidata…).
     */
    public static function sameAs(): array
    {
        $urls = [
            SiteSetting::get('facebook_url'),
            SiteSetting::get('twitter_url'),
            SiteSetting::get('instagram_url'),
            SiteSetting::get('linkedin_url'),
        ];

        $extra = self::raw('sameas_extra');

        if ($extra) {
            $urls = array_merge($urls, preg_split('/[\r\n,]+/', $extra));
        }

        $urls = array_merge($urls, (array) config('schema.same_as', []));

        $clean = [];

        foreach ($urls as $url) {
            $url = trim((string) $url);

            // '#' is the placeholder the theme uses for an unset social link.
            if ($url === '' || $url === '#' || !preg_match('#^https?://#i', $url)) {
                continue;
            }

            $clean[$url] = $url;
        }

        return array_values($clean);
    }

    public static function priceRange(): ?string
    {
        return self::get('price_range');
    }
}
