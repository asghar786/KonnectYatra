<?php

namespace App\Services\Analytics;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Resolves an IP to country / region (US state) / city, cached per-IP in the
 * geoip_cache table so each unique IP is only looked up once.
 *
 * Uses the free ip-api.com endpoint (no key, rate-limited). Swappable for a
 * keyed provider by changing lookupRemote(). Never throws — returns nulls on
 * failure so callers/dashboard degrade gracefully ("Unknown").
 */
class GeoLocator
{
    /** Resolve from cache only (fast; used in request path if ever needed). */
    public static function fromCache(string $ip): ?array
    {
        $row = DB::table('geoip_cache')->where('ip', $ip)->first();
        return $row ? ['country' => $row->country, 'region' => $row->region, 'city' => $row->city] : null;
    }

    /** Resolve with cache, falling back to a remote lookup and caching the result. */
    public static function resolve(string $ip): array
    {
        if (self::isPrivate($ip)) {
            return self::cacheAndReturn($ip, ['country' => 'Local', 'region' => null, 'city' => null]);
        }

        $cached = self::fromCache($ip);
        if ($cached !== null) {
            return $cached;
        }

        return self::cacheAndReturn($ip, self::lookupRemote($ip));
    }

    protected static function lookupRemote(string $ip): array
    {
        try {
            $resp = Http::timeout(4)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,country,regionName,city',
            ]);
            if ($resp->ok() && $resp->json('status') === 'success') {
                return [
                    'country' => $resp->json('country'),
                    'region'  => $resp->json('regionName'),
                    'city'    => $resp->json('city'),
                ];
            }
        } catch (\Throwable $e) {
            // ignore — return unknowns below
        }
        return ['country' => null, 'region' => null, 'city' => null];
    }

    protected static function cacheAndReturn(string $ip, array $geo): array
    {
        DB::table('geoip_cache')->updateOrInsert(
            ['ip' => $ip],
            [
                'country'     => $geo['country'] ?? null,
                'region'      => $geo['region'] ?? null,
                'city'        => $geo['city'] ?? null,
                'resolved_at' => now(),
            ]
        );
        return $geo;
    }

    protected static function isPrivate(string $ip): bool
    {
        return $ip === '127.0.0.1'
            || $ip === '::1'
            || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }
}
