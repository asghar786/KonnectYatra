<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        [$start, $end, $rangeLabel] = $this->dateWindow($request);
        $data = $this->buildMetrics($start, $end);
        $data['range']       = $request->input('range', '30');
        $data['from']        = $start->toDateString();
        $data['to']          = $end->toDateString();
        $data['range_label'] = $rangeLabel;
        return view('admin.analytics.index', $data);
    }

    public function export(Request $request)
    {
        [$start, $end, $rangeLabel] = $this->dateWindow($request);
        $data = $this->buildMetrics($start, $end);
        $data['range_label'] = $rangeLabel;
        $format = $request->input('format', 'csv');

        if ($format === 'pdf') {
            $pdf = \PDF::loadView('admin.analytics.pdf', $data);
            return $pdf->download('analytics-' . now()->format('Ymd_His') . '.pdf');
        }

        return $this->csv($data);
    }

    /* ---------------------------------------------------------------------
     | Date window
     * ------------------------------------------------------------------- */
    private function dateWindow(Request $request): array
    {
        $range = $request->input('range', '30');
        $end = Carbon::now()->endOfDay();

        switch ($range) {
            case 'today':
                return [Carbon::today(), $end, 'Today'];
            case '60':
                return [Carbon::now()->subDays(60)->startOfDay(), $end, 'Last 60 Days'];
            case '90':
                return [Carbon::now()->subDays(90)->startOfDay(), $end, 'Last 90 Days'];
            case 'custom':
                $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
                $to   = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : $end;
                return [$from, $to, $from->toDateString() . ' to ' . $to->toDateString()];
            case '30':
            default:
                return [Carbon::now()->subDays(30)->startOfDay(), $end, 'Last 30 Days'];
        }
    }

    /* ---------------------------------------------------------------------
     | Metrics
     * ------------------------------------------------------------------- */
    private function base($start, $end)
    {
        return DB::table('visits')
            ->where('is_bot', 0)
            ->whereBetween('created_at', [$start, $end]);
    }

    private function buildMetrics($start, $end): array
    {
        $b = fn() => $this->base($start, $end);

        $pageViews      = $b()->count();
        $sessions       = $b()->distinct('session_id')->count('session_id');
        $uniqueVisitors = $b()->distinct('visitor_id')->count('visitor_id');

        // New vs returning (by session)
        $vt = $b()->select('visitor_type', DB::raw('COUNT(DISTINCT session_id) c'))
            ->groupBy('visitor_type')->pluck('c', 'visitor_type');
        $newVisitors       = (int) ($vt['new'] ?? 0);
        $returningVisitors = (int) ($vt['returning'] ?? 0);

        // Bounce rate + avg duration via per-session aggregation
        $sessionStats = DB::table(DB::raw('(SELECT session_id, COUNT(*) pv, TIMESTAMPDIFF(SECOND, MIN(created_at), MAX(created_at)) dur FROM visits WHERE is_bot=0 AND created_at BETWEEN ? AND ? GROUP BY session_id) t'))
            ->setBindings([$start, $end])
            ->selectRaw('COUNT(*) sess, SUM(CASE WHEN pv=1 THEN 1 ELSE 0 END) bounces, AVG(dur) avg_dur')
            ->first();
        $bounceRate = ($sessionStats && $sessionStats->sess > 0)
            ? round(($sessionStats->bounces / $sessionStats->sess) * 100, 1) : 0;
        $avgDuration = $sessionStats ? (int) round($sessionStats->avg_dur ?? 0) : 0;

        // Daily trend (sessions + pageviews per day)
        $daily = $b()->selectRaw('DATE(created_at) d, COUNT(*) views, COUNT(DISTINCT session_id) sessions')
            ->groupBy('d')->orderBy('d')->get();

        // Hourly distribution
        $hourlyRaw = $b()->selectRaw('HOUR(created_at) h, COUNT(*) c')->groupBy('h')->pluck('c', 'h');
        $hourly = [];
        for ($h = 0; $h < 24; $h++) { $hourly[$h] = (int) ($hourlyRaw[$h] ?? 0); }

        $devices  = $b()->select('device_type', DB::raw('COUNT(*) c'))->groupBy('device_type')->pluck('c', 'device_type');
        $browsers = $b()->select('browser', DB::raw('COUNT(*) c'))->groupBy('browser')->orderByDesc('c')->limit(8)->pluck('c', 'browser');
        $platforms = $b()->select('platform', DB::raw('COUNT(*) c'))->groupBy('platform')->orderByDesc('c')->limit(8)->pluck('c', 'platform');

        $sources = $b()->select('source_type', DB::raw('COUNT(DISTINCT session_id) c'))->groupBy('source_type')->pluck('c', 'source_type');

        $topReferrers = $b()->whereNotNull('referrer_host')->where('referrer_host', '<>', '')
            ->select('referrer_host', DB::raw('COUNT(*) c'))->groupBy('referrer_host')->orderByDesc('c')->limit(10)->get();

        $campaigns = $b()->whereNotNull('utm_campaign')->where('utm_campaign', '<>', '')
            ->select('utm_campaign', DB::raw('COUNT(*) c'))->groupBy('utm_campaign')->orderByDesc('c')->limit(10)->get();

        $topPages = $b()->select('url', DB::raw('COUNT(*) c'))->groupBy('url')->orderByDesc('c')->limit(10)->get();
        $leastPages = $b()->select('url', DB::raw('COUNT(*) c'))->groupBy('url')->orderBy('c')->limit(10)->get();

        $entryPages = $this->edgePages($start, $end, 'MIN');
        $exitPages  = $this->edgePages($start, $end, 'MAX');

        $countries = $b()->whereNotNull('country')->select('country', DB::raw('COUNT(DISTINCT session_id) c'))
            ->groupBy('country')->orderByDesc('c')->limit(12)->get();
        $states = $b()->where('country', 'United States')->whereNotNull('region')
            ->select('region', DB::raw('COUNT(DISTINCT session_id) c'))->groupBy('region')->orderByDesc('c')->limit(15)->get();

        // Conversions
        $convByType = DB::table('conversions')->whereBetween('created_at', [$start, $end])
            ->select('type', DB::raw('COUNT(*) c'))->groupBy('type')->pluck('c', 'type');
        $totalConversions = (int) array_sum($convByType->toArray());
        $conversionRate = $sessions > 0 ? round(($totalConversions / $sessions) * 100, 2) : 0;
        $convBySource = DB::table('conversions')->whereBetween('created_at', [$start, $end])
            ->whereNotNull('source_type')->select('source_type', DB::raw('COUNT(*) c'))
            ->groupBy('source_type')->orderByDesc('c')->get();

        return compact(
            'pageViews', 'sessions', 'uniqueVisitors', 'newVisitors', 'returningVisitors',
            'bounceRate', 'avgDuration', 'daily', 'hourly', 'devices', 'browsers', 'platforms',
            'sources', 'topReferrers', 'campaigns', 'topPages', 'leastPages', 'entryPages',
            'exitPages', 'countries', 'states', 'convByType', 'totalConversions',
            'conversionRate', 'convBySource'
        );
    }

    /** Entry (MIN id) or Exit (MAX id) pages per session. */
    private function edgePages($start, $end, string $agg)
    {
        $sql = "SELECT v.url, COUNT(*) c
                FROM visits v
                INNER JOIN (
                    SELECT session_id, {$agg}(id) eid
                    FROM visits
                    WHERE is_bot = 0 AND created_at BETWEEN ? AND ?
                    GROUP BY session_id
                ) e ON v.id = e.eid
                GROUP BY v.url ORDER BY c DESC LIMIT 10";
        return collect(DB::select($sql, [$start, $end]));
    }

    /* ---------------------------------------------------------------------
     | CSV export
     * ------------------------------------------------------------------- */
    private function csv(array $d)
    {
        $filename = 'analytics-' . now()->format('Ymd_His') . '.csv';

        // Build in memory (not a StreamedResponse) so downstream middleware that
        // calls $response->header() keeps working.
        $out = fopen('php://temp', 'r+');
        fputcsv($out, ['KonnectYatra Analytics', $d['range_label']]);
        fputcsv($out, []);
        fputcsv($out, ['KPI', 'Value']);
        fputcsv($out, ['Page Views', $d['pageViews']]);
        fputcsv($out, ['Sessions', $d['sessions']]);
        fputcsv($out, ['Unique Visitors', $d['uniqueVisitors']]);
        fputcsv($out, ['New Visitors', $d['newVisitors']]);
        fputcsv($out, ['Returning Visitors', $d['returningVisitors']]);
        fputcsv($out, ['Avg Session Duration (s)', $d['avgDuration']]);
        fputcsv($out, ['Bounce Rate (%)', $d['bounceRate']]);
        fputcsv($out, ['Total Conversions', $d['totalConversions']]);
        fputcsv($out, ['Conversion Rate (%)', $d['conversionRate']]);
        fputcsv($out, []);
        fputcsv($out, ['Top Pages', 'Views']);
        foreach ($d['topPages'] as $p) { fputcsv($out, [$p->url, $p->c]); }
        fputcsv($out, []);
        fputcsv($out, ['Country', 'Sessions']);
        foreach ($d['countries'] as $c) { fputcsv($out, [$c->country, $c->c]); }
        fputcsv($out, []);
        fputcsv($out, ['US State', 'Sessions']);
        foreach ($d['states'] as $s) { fputcsv($out, [$s->region, $s->c]); }
        rewind($out);
        $content = stream_get_contents($out);
        fclose($out);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
