<?php

namespace App\Services\Analytics;

/**
 * Lightweight regex-based User-Agent parser (no Composer dependency).
 * Good enough for analytics breakdowns of device / browser / OS / bots.
 */
class UserAgentParser
{
    public static function parse(?string $ua): array
    {
        $ua = $ua ?: '';
        return [
            'is_bot'      => self::isBot($ua),
            'device_type' => self::deviceType($ua),
            'browser'     => self::browser($ua),
            'platform'    => self::platform($ua),
        ];
    }

    public static function isBot(string $ua): bool
    {
        return (bool) preg_match(
            '/bot|crawl|slurp|spider|mediapartners|facebookexternalhit|bingpreview|whatsapp|telegram|headless|lighthouse|pingdom|uptime|curl|wget|python-requests|axios|go-http/i',
            $ua
        );
    }

    public static function deviceType(string $ua): string
    {
        if (preg_match('/iPad|Tablet|PlayBook|Silk|(Android(?!.*Mobile))/i', $ua)) {
            return 'tablet';
        }
        if (preg_match('/Mobile|iP(hone|od)|Android.*Mobile|BlackBerry|IEMobile|Opera Mini/i', $ua)) {
            return 'mobile';
        }
        return 'desktop';
    }

    public static function browser(string $ua): string
    {
        $map = [
            'Edg'      => 'Edge',
            'OPR'      => 'Opera',
            'Opera'    => 'Opera',
            'SamsungBrowser' => 'Samsung Internet',
            'Chrome'   => 'Chrome',
            'CriOS'    => 'Chrome',
            'Firefox'  => 'Firefox',
            'FxiOS'    => 'Firefox',
            'Version/' => 'Safari', // Safari reports Version/x ... Safari
            'MSIE'     => 'Internet Explorer',
            'Trident'  => 'Internet Explorer',
        ];
        foreach ($map as $needle => $name) {
            if (stripos($ua, $needle) !== false) {
                // Chrome UA also contains "Safari"; the order above handles that.
                if ($name === 'Safari' && stripos($ua, 'Chrome') !== false) {
                    continue;
                }
                return $name;
            }
        }
        if (stripos($ua, 'Safari') !== false) {
            return 'Safari';
        }
        return 'Other';
    }

    public static function platform(string $ua): string
    {
        $checks = [
            'Windows'    => '/Windows NT/i',
            'iOS'        => '/iPhone|iPad|iPod/i',
            'Android'    => '/Android/i',
            'macOS'      => '/Macintosh|Mac OS X/i',
            'Linux'      => '/Linux/i',
            'Chrome OS'  => '/CrOS/i',
        ];
        foreach ($checks as $name => $pattern) {
            if (preg_match($pattern, $ua)) {
                return $name;
            }
        }
        return 'Other';
    }
}
