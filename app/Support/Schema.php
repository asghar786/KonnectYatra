<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Schema.org / JSON-LD builder.
 *
 * Every public page emits ONE <script type="application/ld+json"> holding a
 * single @graph. Nodes inside the graph are linked by @id rather than nested,
 * so the Organization and WebSite are described once and referenced everywhere
 * — that is what lets a search engine (or an LLM) collapse 200+ URLs into one
 * business entity instead of 200 unrelated pages.
 *
 * Usage from a Blade view:
 *
 *     @section('schema')
 *         {!! \App\Support\Schema::graph([
 *             \App\Support\Schema::webPage(['name' => 'About Us', 'type' => 'AboutPage']),
 *             \App\Support\Schema::breadcrumb([['Home', url('/')], ['About Us', null]]),
 *         ]) !!}
 *     @endsection
 *
 * The sitewide Organization + WebSite nodes are prepended by graph() itself, so
 * a view never has to repeat them.
 */
class Schema
{
    /** Build a stable, absolute @id from a fragment. */
    public static function id(string $fragment): string
    {
        return rtrim(url('/'), '/') . '/#' . ltrim($fragment, '#');
    }

    public static function orgId(): string
    {
        return self::id('organization');
    }

    public static function siteId(): string
    {
        return self::id('website');
    }

    /** @id of the WebPage node for the URL currently being rendered. */
    public static function pageId(?string $url = null): string
    {
        return ($url ?: self::canonical()) . '#webpage';
    }

    /** Explicit canonical set by a view via setCanonical(). */
    protected static ?string $canonicalOverride = null;

    /**
     * Point this request's canonical somewhere other than its own URL.
     *
     * Needed for the routes that serve the same content twice: /home duplicates
     * / , and the legacy /packages/{id} duplicates /all-packages/{id}.
     */
    public static function setCanonical(string $url): string
    {
        return self::$canonicalOverride = $url;
    }

    /**
     * Canonical URL for the current request: scheme + host + path, with the
     * query string dropped. Sorting/filter params must never fork a canonical
     * (e.g. /gurdwaras?zip=11434 canonicalises to /gurdwaras).
     */
    public static function canonical(): string
    {
        if (self::$canonicalOverride !== null) {
            return self::$canonicalOverride;
        }

        $path = trim(request()->path(), '/');

        return $path === '' ? rtrim(url('/'), '/') . '/' : url($path);
    }

    // -----------------------------------------------------------------
    // Sitewide nodes
    // -----------------------------------------------------------------

    /**
     * The business itself.
     *
     * Typed as TravelAgency — a subtype of both Organization and
     * LocalBusiness, so one node satisfies the Organization knowledge-panel
     * signals and the LocalBusiness/NAP signals at the same time. Emitting a
     * separate bare Organization alongside it would split the entity.
     */
    public static function organization(): array
    {
        $cfg = config('schema');

        $sameAs = array_values(array_filter(array_merge(
            [
                SiteSetting::get('facebook_url'),
                SiteSetting::get('twitter_url'),
                SiteSetting::get('instagram_url'),
                SiteSetting::get('linkedin_url'),
            ],
            (array) ($cfg['same_as'] ?? [])
        ), fn ($u) => !empty($u) && $u !== '#' && Str::startsWith($u, ['http://', 'https://'])));

        $node = [
            '@type'         => ['TravelAgency', 'Organization'],
            '@id'           => self::orgId(),
            'name'          => $cfg['name'],
            'legalName'     => $cfg['legal_name'] ?? null,
            'alternateName' => $cfg['alternate'] ?? null,
            'url'           => rtrim(url('/'), '/') . '/',
            'description'   => $cfg['description'] ?? null,
            // The ImageObject itself is a sibling node in the graph (see
            // logoImage()), referenced here by @id so it is defined once.
            'logo'        => ['@id' => self::id('logo')],
            'image'       => ['@id' => self::id('logo')],
            'telephone'   => $cfg['telephone'] ?? null,
            'email'       => $cfg['email'] ?? null,
            'priceRange'  => $cfg['price_range'] ?? null,
            'currenciesAccepted' => 'USD',
            'address'     => self::postalAddress($cfg['address'] ?? []),
            'geo'         => self::geo($cfg['geo']['lat'] ?? null, $cfg['geo']['lng'] ?? null),
            'sameAs'      => $sameAs ?: null,
            'knowsAbout'  => $cfg['knows_about'] ?? null,
            'founder'     => !empty($cfg['founder'])
                ? ['@type' => 'Person', 'name' => $cfg['founder']]
                : null,
            'areaServed'  => array_map(
                fn ($c) => ['@type' => 'Country', 'name' => $c],
                (array) ($cfg['areas_served'] ?? [])
            ) ?: null,
            'contactPoint' => [
                [
                    '@type'             => 'ContactPoint',
                    'contactType'       => 'customer service',
                    'telephone'         => $cfg['telephone'] ?? null,
                    'email'             => $cfg['email'] ?? null,
                    'areaServed'        => $cfg['areas_served'] ?? null,
                    'availableLanguage' => ['English', 'Punjabi', 'Hindi', 'Urdu'],
                ],
            ],
        ];

        if (!empty($cfg['opening_hours'])) {
            $node['openingHoursSpecification'] = array_map(fn ($h) => [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => $h['days'],
                'opens'     => $h['opens'],
                'closes'    => $h['closes'],
            ], $cfg['opening_hours']);
        }

        return $node;
    }

    /**
     * The logo, as its own top-level graph node.
     *
     * Kept unnested so that every `{"@id": ".../#logo"}` reference resolves to
     * a sibling in the graph — some consumers (and most validators) will not
     * follow a reference into another node's sub-object.
     */
    public static function logoImage(): array
    {
        return [
            '@type'   => 'ImageObject',
            '@id'     => self::id('logo'),
            'url'     => asset(config('schema.logo')),
            'contentUrl' => asset(config('schema.logo')),
            'caption' => config('schema.name'),
        ];
    }

    /**
     * The site as a publication.
     *
     * Deliberately NO potentialAction/SearchAction: the header search form has
     * no action and no results route, so advertising a search endpoint would
     * point Google at a URL that returns the homepage. Add it back only if a
     * real /search?q= route ships.
     */
    public static function website(): array
    {
        return [
            '@type'           => 'WebSite',
            '@id'             => self::siteId(),
            'url'             => rtrim(url('/'), '/') . '/',
            'name'            => config('schema.name'),
            'description'     => SiteSetting::get('seo_description') ?: config('schema.description'),
            'publisher'       => ['@id' => self::orgId()],
            'inLanguage'      => 'en-US',
        ];
    }

    // -----------------------------------------------------------------
    // Per-page nodes
    // -----------------------------------------------------------------

    /**
     * The current page.
     *
     * @param array $o name, description, type (WebPage|CollectionPage|ItemPage|
     *                 AboutPage|ContactPage|...), image, url, datePublished,
     *                 dateModified, primaryEntity (@id of the thing this page is about)
     */
    public static function webPage(array $o = []): array
    {
        $url = $o['url'] ?? self::canonical();

        return [
            '@type'            => $o['type'] ?? 'WebPage',
            '@id'              => $url . '#webpage',
            'url'              => $url,
            'name'             => $o['name'] ?? null,
            'description'      => isset($o['description']) ? self::text($o['description'], 300) : null,
            'isPartOf'         => ['@id' => self::siteId()],
            'about'            => isset($o['primaryEntity']) ? ['@id' => $o['primaryEntity']] : ['@id' => self::orgId()],
            'mainEntity'       => isset($o['primaryEntity']) ? ['@id' => $o['primaryEntity']] : null,
            'primaryImageOfPage' => isset($o['image']) ? ['@type' => 'ImageObject', 'url' => $o['image']] : null,
            'datePublished'    => self::date($o['datePublished'] ?? null),
            'dateModified'     => self::date($o['dateModified'] ?? null),
            'inLanguage'       => 'en-US',
            'breadcrumb'       => isset($o['breadcrumb']) ? ['@id' => $o['breadcrumb']] : null,
        ];
    }

    /**
     * BreadcrumbList.
     *
     * @param array $trail list of [label, url|null]; the last item is the
     *                     current page and should pass null for the url.
     */
    public static function breadcrumb(array $trail): array
    {
        $items = [];
        $position = 1;

        foreach ($trail as $crumb) {
            [$label, $url] = array_pad((array) $crumb, 2, null);

            if ($label === null || $label === '') {
                continue;
            }

            $item = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => self::text($label, 120),
            ];

            // Google drops the last crumb's item; including it is harmless but
            // only when it is a real URL.
            if (!empty($url)) {
                $item['item'] = $url;
            }

            $items[] = $item;
        }

        return [
            '@type'           => 'BreadcrumbList',
            '@id'             => self::canonical() . '#breadcrumb',
            'itemListElement' => $items,
        ];
    }

    /**
     * ItemList for listing pages (all-packages, gurdwaras, blogs, hotels ...).
     *
     * @param array $urls ordered list of absolute URLs, or of ['url' => ..., 'name' => ...]
     */
    public static function itemList(array $urls, ?string $name = null): array
    {
        $items = [];
        $position = 1;

        foreach ($urls as $entry) {
            $url  = is_array($entry) ? ($entry['url'] ?? null) : $entry;
            $text = is_array($entry) ? ($entry['name'] ?? null) : null;

            if (empty($url)) {
                continue;
            }

            $items[] = array_filter([
                '@type'    => 'ListItem',
                'position' => $position++,
                'url'      => $url,
                'name'     => $text ? self::text($text, 150) : null,
            ], fn ($v) => $v !== null);
        }

        return [
            '@type'           => 'ItemList',
            '@id'             => self::canonical() . '#itemlist',
            'name'            => $name,
            'numberOfItems'   => count($items),
            'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
            'itemListElement' => $items,
        ];
    }

    /**
     * FAQPage.
     *
     * IMPORTANT: only call this on a page where the same questions and answers
     * are visible to a human. Marking up hidden Q&A is a structured-data
     * violation and can earn a manual action.
     *
     * @param array $qa list of ['question' => ..., 'answer' => ...] (answer may be HTML)
     */
    public static function faq(array $qa): array
    {
        return [
            '@type'      => 'FAQPage',
            '@id'        => self::canonical() . '#faq',
            'mainEntity' => array_values(array_map(fn ($row) => [
                '@type'          => 'Question',
                'name'           => self::text($row['question'], 300),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => trim($row['answer']),
                ],
            ], $qa)),
        ];
    }

    // -----------------------------------------------------------------
    // Value objects
    // -----------------------------------------------------------------

    public static function postalAddress(array $a): ?array
    {
        $node = array_filter([
            '@type'           => 'PostalAddress',
            'streetAddress'   => $a['street']   ?? null,
            'addressLocality' => $a['locality'] ?? null,
            'addressRegion'   => $a['region']   ?? null,
            'postalCode'      => $a['postal']   ?? null,
            'addressCountry'  => $a['country']  ?? null,
        ], fn ($v) => $v !== null && $v !== '');

        // A lone @type is not an address.
        return count($node) > 1 ? $node : null;
    }

    public static function geo($lat, $lng): ?array
    {
        if ($lat === null || $lng === null || $lat === '' || $lng === '' || (float) $lat === 0.0) {
            return null;
        }

        return [
            '@type'     => 'GeoCoordinates',
            'latitude'  => (float) $lat,
            'longitude' => (float) $lng,
        ];
    }

    /**
     * A single price point.
     *
     * @param string|null $validThrough ISO-8601; Google warns on Offers with no
     *                                  priceValidUntil, but a wrong date is worse
     *                                  than none, so it is only set when known.
     */
    public static function offer($price, string $name, string $url, ?string $validThrough = null): ?array
    {
        if ($price === null || $price === '' || (float) $price <= 0) {
            return null;
        }

        return array_filter([
            '@type'            => 'Offer',
            'name'             => $name,
            'price'            => (string) (float) $price,
            'priceCurrency'    => 'USD',
            'availability'     => 'https://schema.org/InStock',
            'url'              => $url,
            'priceValidUntil'  => $validThrough,
            'seller'           => ['@id' => self::orgId()],
        ], fn ($v) => $v !== null);
    }

    /**
     * Roll a set of offers up into an AggregateOffer.
     *
     * @param array $offers output of offer(), nulls allowed and skipped
     */
    public static function aggregateOffer(array $offers, string $url): ?array
    {
        $offers = array_values(array_filter($offers));

        if (empty($offers)) {
            return null;
        }

        $prices = array_map(fn ($o) => (float) $o['price'], $offers);

        return [
            '@type'         => 'AggregateOffer',
            'priceCurrency' => 'USD',
            'lowPrice'      => (string) min($prices),
            'highPrice'     => (string) max($prices),
            'offerCount'    => count($offers),
            'availability'  => 'https://schema.org/InStock',
            'url'           => $url,
            'offers'        => $offers,
        ];
    }

    // -----------------------------------------------------------------
    // Rendering
    // -----------------------------------------------------------------

    /**
     * Render the page's nodes as one <script type="application/ld+json">.
     *
     * The sitewide Organization and WebSite nodes are prepended automatically;
     * pass $withSitewide = false only when embedding a fragment somewhere that
     * already has them.
     */
    public static function graph(array $nodes, bool $withSitewide = true): HtmlString
    {
        if ($withSitewide) {
            $nodes = array_merge([self::organization(), self::logoImage(), self::website()], $nodes);
        }

        $graph = array_values(array_filter(array_map([self::class, 'prune'], $nodes)));

        $json = json_encode(
            ['@context' => 'https://schema.org', '@graph' => $graph],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_PRETTY_PRINT
        );

        return new HtmlString(
            '<script type="application/ld+json">' . $json . '</script>'
        );
    }

    // -----------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------

    /**
     * Drop nulls, empty strings and empty arrays, recursively.
     *
     * Structured data with `"description": null` is worse than no description:
     * validators flag it and Google may discard the whole node.
     */
    public static function prune($value)
    {
        if (!is_array($value)) {
            return $value;
        }

        $out = [];

        foreach ($value as $key => $item) {
            $item = self::prune($item);

            if ($item === null || $item === '' || $item === []) {
                continue;
            }

            $out[$key] = $item;
        }

        // An object that is nothing but a @type carries no information.
        if (count($out) === 1 && array_key_exists('@type', $out)) {
            return null;
        }

        return $out === [] ? null : $out;
    }

    /**
     * HTML/rich-text to a clean single-line string for a schema text property.
     */
    public static function text($html, ?int $limit = null): ?string
    {
        if ($html === null || $html === '') {
            return null;
        }

        $text = html_entity_decode(strip_tags((string) $html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/u', ' ', $text));

        if ($text === '') {
            return null;
        }

        return $limit ? Str::limit($text, $limit) : $text;
    }

    /** Anything date-ish to ISO-8601, or null if it cannot be parsed. */
    public static function date($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format(\DateTime::ATOM);
        }

        $ts = strtotime((string) $value);

        return $ts ? date(\DateTime::ATOM, $ts) : null;
    }

    /** Absolute URL for an image that may be missing. */
    public static function image(?string $path, string $dir, ?string $fallback = null): ?string
    {
        if (!empty($path)) {
            return asset(rtrim($dir, '/') . '/' . ltrim($path, '/'));
        }

        return $fallback ? asset($fallback) : null;
    }
}
