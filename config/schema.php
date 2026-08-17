<?php

/*
|--------------------------------------------------------------------------
| Structured data (Schema.org / JSON-LD)
|--------------------------------------------------------------------------
|
| Single source of truth for the business facts that App\Support\Schema
| bakes into the sitewide Organization / TravelAgency node. Everything here
| must match, character for character, what is printed on the Contact page
| and in the site header — inconsistent NAP (Name/Address/Phone) is the
| fastest way to lose a Google Business Profile match.
|
| No migration is needed to change these; after editing on the server run:
|     php artisan config:clear
|
*/

return [

    // ---------------------------------------------------------------------
    // Identity
    // ---------------------------------------------------------------------
    'name'        => 'Konnect Yatra',
    'legal_name'  => 'Konnect Yatra',
    'alternate'   => ['KonnectYatra', 'Konnect-Yatra'],

    'description' => 'Konnect Yatra organises Sikh pilgrimage (yatra) tours from the United '
                   . 'States and Canada to Nankana Sahib, Panja Sahib, Kartarpur Sahib and the '
                   . 'other historic Gurdwaras of Pakistan, including pilgrim visa processing, '
                   . 'airline tickets, hotels, transport and security throughout the tour.',

    // Path relative to public/. Google wants a logo it can crop to a square.
    'logo'        => 'assets/images2/newlogo11.png',

    // ---------------------------------------------------------------------
    // Contact — must match resources/views/layouts/header.blade.php and
    // resources/views/contactus.blade.php exactly.
    // ---------------------------------------------------------------------
    'telephone'   => '+1-718-908-9464',
    'email'       => 'rm@konnectyatra.org',

    /*
     | Confirmed by the owner on 2026-08-17 as the correct and final address,
     | and written exactly as it appears in the site header and on the Contact
     | page. Keep all three byte-identical — NAP consistency is what lets Google
     | match this site to the Google Business Profile, so do not "tidy" the
     | punctuation here without changing the other two at the same time.
     */
    'address' => [
        'street'   => '148-36 Guy R Brewers Blvd. Suit #202A',
        'locality' => 'Jamaica',
        'region'   => 'NY',
        'postal'   => '11434',
        'country'  => 'US',
    ],

    /*
     | Latitude/longitude of the office. LEFT NULL ON PURPOSE — publishing
     | guessed coordinates is worse than publishing none, because Google will
     | happily plot the business in the wrong place. Fill both in from the
     | Google Maps pin for the address above and the `geo` property starts
     | being emitted automatically.
     */
    'geo' => [
        'lat' => null,
        'lng' => null,
    ],

    // Free-form, Google's documented values are $ / $$ / $$$ / $$$$.
    'price_range' => '$$$',

    /*
     | Office hours, in Schema.org OpeningHoursSpecification shorthand:
     |     ['days' => ['Monday', ...], 'opens' => '09:00', 'closes' => '18:00']
     | Left empty until confirmed with Rashad — inventing hours would put a
     | wrong "Open now" badge in front of pilgrims.
     */
    'opening_hours' => [],

    // ---------------------------------------------------------------------
    // People & reach
    // ---------------------------------------------------------------------
    'founder' => 'Rashad Mahmood',

    // ISO 3166 codes for the markets served.
    'areas_served' => ['US', 'CA'],

    'knows_about' => [
        'Sikh pilgrimage',
        'Nankana Sahib yatra',
        'Kartarpur Sahib corridor',
        'Panja Sahib',
        'Pakistan pilgrim visa',
        'Gurpurab tours',
        'Vaisakhi tours',
    ],

    /*
     | Extra sameAs profiles that have no SiteSetting of their own (Google
     | Business Profile, Wikidata, Yelp, TripAdvisor, YouTube ...). The four
     | social URLs from Admin > Settings are merged in automatically.
     */
    'same_as' => [],

];
