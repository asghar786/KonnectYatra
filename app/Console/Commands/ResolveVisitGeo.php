<?php

namespace App\Console\Commands;

use App\Services\Analytics\GeoLocator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResolveVisitGeo extends Command
{
    protected $signature = 'analytics:resolve-geo {--limit=200 : Max distinct IPs to resolve per run}';
    protected $description = 'Backfill country/region/city on visits using cached IP geolocation';

    public function handle()
    {
        $limit = (int) $this->option('limit');

        // Distinct IPs that still need resolving.
        $ips = DB::table('visits')
            ->whereNull('country')
            ->whereNotNull('ip')
            ->select('ip')
            ->distinct()
            ->limit($limit)
            ->pluck('ip');

        if ($ips->isEmpty()) {
            $this->info('No visits pending geo resolution.');
            return self::SUCCESS;
        }

        $resolved = 0;
        foreach ($ips as $ip) {
            $geo = GeoLocator::resolve($ip);
            DB::table('visits')
                ->where('ip', $ip)
                ->whereNull('country')
                ->update([
                    'country'      => $geo['country'] ?? 'Unknown',
                    'country_code' => $geo['country_code'] ?? null,
                    'region'       => $geo['region'],
                    'city'         => $geo['city'],
                ]);
            $resolved++;
            // Respect ip-api free-tier rate limit (45/min) for public IPs.
            if (!in_array($ip, ['127.0.0.1', '::1'])) {
                usleep(1500000); // 1.5s between remote lookups
            }
        }

        $this->info("Resolved geo for {$resolved} IP(s).");
        return self::SUCCESS;
    }
}
