<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Events;
use App\Models\Gurdwara;
use App\Models\Hotels;
use App\Models\Locations;
use App\Models\News;
use App\Models\Package;

/**
 * XML sitemap for search engines — served at /sitemap.xml.
 *
 * Only public, indexable pages go in. Deliberately excluded: admin/* and user/*
 * (auth-walled), login/register/logout, and the transactional booking steps
 * (apply, payment, agreement, thank-you) which are per-booking, not content.
 */
class SitemapController extends Controller
{
    /** Public static pages: path => [changefreq, priority] */
    private const STATIC_PAGES = [
        ''                  => ['weekly',  '1.0'],
        'all-packages'      => ['weekly',  '0.9'],
        'special-package'   => ['monthly', '0.8'],
        'visa'              => ['monthly', '0.8'],
        'gurdwaras'         => ['weekly',  '0.8'],
        'aboutus'           => ['monthly', '0.7'],
        'contactus'         => ['monthly', '0.7'],
        'blogs'             => ['weekly',  '0.7'],
        'pakistan-hotels'   => ['monthly', '0.7'],
        'popular-locations' => ['monthly', '0.7'],
        'our-info'          => ['monthly', '0.6'],
        'visa-form'         => ['monthly', '0.6'],
        'itinerary'         => ['monthly', '0.6'],
        'tour-gallery'      => ['monthly', '0.5'],
    ];

    public function index()
    {
        $urls = [];

        foreach (self::STATIC_PAGES as $path => [$freq, $priority]) {
            $urls[] = $this->entry($path, null, $freq, $priority);
        }

        // Packages — same visibility gate as the public /all-packages listing.
        foreach (Package::where('status', 1)->get(['id', 'updated_at']) as $row) {
            $urls[] = $this->entry('all-packages/' . $row->id, $row->updated_at, 'weekly', '0.8');
        }

        // Gurdwara directory entries — the local-search long tail.
        foreach (Gurdwara::get(['id', 'updated_at']) as $row) {
            $urls[] = $this->entry('gurdwaras/' . $row->id, $row->updated_at, 'monthly', '0.6');
        }

        // Blog posts — published only, matching BlogController::show().
        foreach (Blog::where('status', 'published')->get(['slug', 'updated_at']) as $row) {
            $urls[] = $this->entry('blog/' . $row->slug, $row->updated_at, 'monthly', '0.6');
        }

        foreach (Hotels::get(['id', 'updated_at']) as $row) {
            $urls[] = $this->entry('hotel-detail/' . $row->id, $row->updated_at, 'monthly', '0.5');
        }

        foreach (Locations::get(['id', 'updated_at']) as $row) {
            $urls[] = $this->entry('location-detail/' . $row->id, $row->updated_at, 'monthly', '0.5');
        }

        foreach (Events::get(['id', 'updated_at']) as $row) {
            $urls[] = $this->entry('event-detail/' . $row->id, $row->updated_at, 'monthly', '0.4');
        }

        foreach (News::get(['id', 'updated_at']) as $row) {
            $urls[] = $this->entry('news-detail/' . $row->id, $row->updated_at, 'monthly', '0.4');
        }

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= implode('', $urls);
        $xml .= '</urlset>' . "\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    private function entry($path, $lastmod, $changefreq, $priority)
    {
        $loc = $path === '' ? rtrim(url('/'), '/') . '/' : url($path);

        $out  = "  <url>\n";
        $out .= '    <loc>' . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        if (!empty($lastmod)) {
            $out .= '    <lastmod>' . $lastmod->toAtomString() . "</lastmod>\n";
        }
        $out .= '    <changefreq>' . $changefreq . "</changefreq>\n";
        $out .= '    <priority>' . $priority . "</priority>\n";
        $out .= "  </url>\n";

        return $out;
    }
}
