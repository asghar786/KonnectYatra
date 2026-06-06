<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use App\Services\Analytics\UserAgentParser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TrackVisit
{
    // Cookie lifetimes (minutes)
    const VISITOR_TTL = 60 * 24 * 730; // ~2 years
    const SESSION_TTL = 30;            // 30-minute sliding session

    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldTrack($request)) {
            try {
                $this->record($request);
            } catch (\Throwable $e) {
                \Log::warning('TrackVisit failed: ' . $e->getMessage());
            }
        }

        return $next($request);
    }

    protected function shouldTrack(Request $request): bool
    {
        if (!$request->isMethod('GET') || $request->ajax() || $request->wantsJson()) {
            return false;
        }
        // Only public pages — never the admin panel, auth, or API.
        if ($request->is('admin', 'admin/*', 'login', 'register', 'api/*', 'admin_login', 'admin_logout')) {
            return false;
        }
        // Skip static asset paths (normally served by Apache, but guard anyway).
        if (preg_match('/\.(css|js|png|jpe?g|gif|svg|ico|woff2?|ttf|map|webp|pdf|zip)$/i', $request->path())) {
            return false;
        }
        return true;
    }

    protected function record(Request $request): void
    {
        $ua = (string) $request->userAgent();
        $parsed = UserAgentParser::parse($ua);

        // Visitor cookie -> new vs returning (decided per session, see below).
        $visitorId = $request->cookie('kv_vid');
        $isKnownVisitor = !empty($visitorId);
        if (!$isKnownVisitor) {
            $visitorId = bin2hex(random_bytes(16));
            Cookie::queue('kv_vid', $visitorId, self::VISITOR_TTL);
        }

        $referrer = $request->headers->get('referer');
        $referrerHost = $referrer ? parse_url($referrer, PHP_URL_HOST) : null;
        $sourceType = $this->classifySource($referrerHost, $request->getHost(), $request);

        // Session cookie -> new session starts attribution + visitor_type.
        $sessionId = $request->cookie('kv_sid');
        $visitorType = $request->cookie('kv_vtype');
        if (empty($sessionId)) {
            $sessionId = bin2hex(random_bytes(16));
            // A brand-new session: returning if we already knew this visitor.
            $visitorType = $isKnownVisitor ? 'returning' : 'new';
            Cookie::queue('kv_vtype', $visitorType, self::SESSION_TTL);
            Cookie::queue('kv_src', $sourceType, self::SESSION_TTL);
        } else {
            $visitorType = $visitorType ?: 'returning';
        }
        // Slide the session window forward on every hit.
        Cookie::queue('kv_sid', $sessionId, self::SESSION_TTL);

        PageVisit::insert([
            'session_id'   => $sessionId,
            'visitor_id'   => $visitorId,
            'visitor_type' => $visitorType,
            'url'          => substr($request->path() === '/' ? '/' : '/' . ltrim($request->path(), '/'), 0, 2048),
            'referrer'     => $referrer ? substr($referrer, 0, 2048) : null,
            'referrer_host' => $referrerHost,
            'source_type'  => $sourceType,
            'utm_source'   => $request->query('utm_source'),
            'utm_medium'   => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'utm_term'     => $request->query('utm_term'),
            'utm_content'  => $request->query('utm_content'),
            'ip'           => $request->ip(),
            'country'      => null, // backfilled by analytics:resolve-geo
            'region'       => null,
            'city'         => null,
            'device_type'  => $parsed['device_type'],
            'browser'      => $parsed['browser'],
            'platform'     => $parsed['platform'],
            'is_bot'       => $parsed['is_bot'],
            'created_at'   => now(),
        ]);
    }

    protected function classifySource(?string $referrerHost, string $currentHost, Request $request): string
    {
        // Paid/campaign traffic via UTM takes precedence.
        if ($request->query('utm_medium')) {
            $m = strtolower($request->query('utm_medium'));
            if (in_array($m, ['cpc', 'ppc', 'paid', 'paidsearch'])) return 'paid';
            if ($m === 'social') return 'social';
            if (in_array($m, ['email', 'newsletter'])) return 'email';
        }
        if (empty($referrerHost)) {
            return 'direct';
        }
        if (stripos($referrerHost, $currentHost) !== false) {
            return 'direct'; // internal navigation
        }
        if (preg_match('/google|bing|yahoo|duckduckgo|baidu|yandex|ask\.com|ecosia/i', $referrerHost)) {
            return 'organic';
        }
        if (preg_match('/facebook|fb\.com|instagram|twitter|t\.co|linkedin|youtube|pinterest|reddit|whatsapp|tiktok|telegram/i', $referrerHost)) {
            return 'social';
        }
        return 'referral';
    }
}
