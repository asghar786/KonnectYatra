<?php

namespace Tests\Feature;

use App\Models\QuickYatri;
use App\Models\User;
use App\Support\UsAirports;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * The Group Manifest (2026-09-05).
 *
 * Yatris fly in from different US cities on the same two dates so they can be
 * met and toured together once they land, so the office needs the applications
 * split by the city each traveller leaves from. That grouping is entirely
 * derived — same departure_date + return_date + departure_airport_code is the
 * same group — so these tests are mostly about the buckets forming (and
 * re-forming) on their own, with nobody assigned by hand.
 *
 * DatabaseTransactions for the same reason as QuickYatriPricingTest: these run
 * against the real local database, and both the rows and the `site_settings`
 * key written here would otherwise outlive the run.
 */
class QuickYatriGroupsTest extends TestCase
{
    use DatabaseTransactions;

    private function asAdmin()
    {
        // In-memory only, never persisted — see QuickYatriSheetTest.
        $this->actingAs(new User(['role' => 'admin']));
    }

    /** A saved application, travel details and all. */
    private function traveller(array $attributes = []): QuickYatri
    {
        return QuickYatri::create(array_merge([
            'applicant_name'         => 'QA GROUP TRAVELLER',
            'departure_airport_code' => 'PHL',
            'departure_date'         => '2026-11-19',
            'return_date'            => '2026-12-01',
            'citizenship'            => 'US',
            'passport_no'            => 'A12345678',
            'date_of_birth'          => '1961-04-05',
        ], $attributes));
    }

    public function test_the_sheet_stores_both_travel_dates_typed_in_the_house_format()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA TRAVEL DATES',
            'departure_date' => '19-NOV-2026',
            'return_date'    => '01-DEC-2026',
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA TRAVEL DATES')->first();

        $this->assertNotNull($row);
        $this->assertSame('2026-11-19', $row->departure_date->format('Y-m-d'));
        $this->assertSame('2026-12-01', $row->return_date->format('Y-m-d'));
        // Read back on the sheet in the same shape they were typed.
        $this->assertSame('19-NOV-2026', $row->stamp('departure_date'));
    }

    /**
     * The rule the whole report hangs on: a date that is not a real date is
     * refused rather than stored as a guess, the same as every other date on
     * the sheet.
     */
    public function test_an_impossible_travel_date_is_refused_rather_than_rolled_over()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA BAD DATE',
            'departure_date' => '31-FEB-2026',
        ])->assertSessionHasErrors('departure_date');

        $this->assertNull(QuickYatri::where('applicant_name', 'QA BAD DATE')->first());
    }

    public function test_the_sectors_read_islamabad_out_and_lahore_back()
    {
        $row = $this->traveller();

        // Day without a leading zero, month in caps — "19 NOV", not "19-NOV".
        $this->assertSame('PHL-ISB 19 NOV', $row->outboundSector());
        $this->assertSame('LHE-PHL 1 DEC', $row->returnSector());
    }

    /**
     * The date is the optional half of a sector: the route is known as soon as
     * the city is, and the day is added when the flight is booked. Only a
     * missing airport leaves nothing to print.
     */
    public function test_a_sector_prints_its_route_before_the_flight_is_booked()
    {
        $noAirport = $this->traveller(['departure_airport_code' => null]);
        $noReturn  = $this->traveller(['return_date' => null]);
        $noDates   = $this->traveller(['departure_date' => null, 'return_date' => null]);

        $this->assertNull($noAirport->outboundSector());
        $this->assertNull($noAirport->returnSector());

        $this->assertSame('PHL-ISB 19 NOV', $noReturn->outboundSector());
        $this->assertSame('LHE-PHL', $noReturn->returnSector());

        $this->assertSame('PHL-ISB', $noDates->outboundSector());
        $this->assertSame('LHE-PHL', $noDates->returnSector());
    }

    /**
     * The whole point of the 2026-09-05 revision: applications arrive and pay
     * deposits for months before a flight is booked, so a city's group has to
     * exist without dates. Requiring them left the report empty all season.
     */
    public function test_a_city_forms_a_group_before_any_flight_is_booked()
    {
        $this->asAdmin();

        $this->traveller(['applicant_name' => 'QA UNBOOKED ONE', 'departure_date' => null, 'return_date' => null]);
        $this->traveller(['applicant_name' => 'QA UNBOOKED TWO', 'departure_date' => null, 'return_date' => null]);

        $body = $this->get(route('quick-yatri-groups'))->assertStatus(200)->getContent();

        $this->assertStringContainsString('Philadelphia (PHL) Group', $body);
        $this->assertStringContainsString('flight not booked yet', $body);
        // The route still prints, just without a day against it.
        $this->assertStringContainsString('PHL-ISB', $body);
        $this->assertStringContainsString('LHE-PHL', $body);
        // And they are travellers in a group, not a data-entry warning.
        $this->assertStringNotContainsString('QA UNBOOKED ONE</a>', $body);
    }

    /**
     * Dates describe a group, they do not split it — but two genuinely
     * different dates out of one city must not have either one printed over
     * the other on a manifest somebody flies on.
     */
    public function test_a_city_travelling_on_two_different_dates_states_no_single_date()
    {
        $this->asAdmin();

        $this->traveller(['applicant_name' => 'QA NOV FLIGHT']);
        $this->traveller([
            'applicant_name' => 'QA JAN FLIGHT',
            'departure_date' => '2027-01-10',
            'return_date'    => '2027-01-24',
        ]);

        $body = $this->get(route('quick-yatri-groups'))->getContent();

        // One city, one block.
        $this->assertSame(1, substr_count($body, 'Philadelphia (PHL) Group'));
        $this->assertStringContainsString('travelling on more than one date', $body);
        // Each traveller still carries their own dates in their sectors.
        $this->assertStringContainsString('PHL-ISB 19 NOV', $body);
        $this->assertStringContainsString('PHL-ISB 10 JAN', $body);
    }

    /**
     * The manifest prints First / Middle / Last, but Quick Yatri stores one
     * `applicant_name` — the paper sheet has one box for it. The split is
     * read-only, done at print time.
     */
    public function test_a_stored_name_splits_into_first_middle_and_last()
    {
        $cases = [
            'JAGWINDER SINGH'        => ['JAGWINDER', '', 'SINGH'],
            'ARJUN DEEP SINGH'       => ['ARJUN', 'DEEP', 'SINGH'],
            'MANJEET KAUR TAKHAR'    => ['MANJEET', 'KAUR', 'TAKHAR'],
            'AMAN KAUR SARAI EXTRA'  => ['AMAN', 'KAUR SARAI', 'EXTRA'],
            'PRINCE'                 => ['PRINCE', '', ''],
            '  SPACED   OUT  NAME  ' => ['SPACED', 'OUT', 'NAME'],
        ];

        foreach ($cases as $stored => $expected) {
            $parts = (new QuickYatri(['applicant_name' => $stored]))->nameParts();

            $this->assertSame($expected[0], $parts['first'], 'first of ' . $stored);
            $this->assertSame($expected[1], $parts['middle'], 'middle of ' . $stored);
            $this->assertSame($expected[2], $parts['last'], 'last of ' . $stored);
        }
    }

    public function test_travellers_are_grouped_by_the_city_they_fly_from()
    {
        $this->asAdmin();

        // Two out of Philadelphia...
        $this->traveller(['applicant_name' => 'QA PHL ONE']);
        $this->traveller(['applicant_name' => 'QA PHL TWO']);
        // ...and one out of New York — a different city, a different group.
        $this->traveller(['applicant_name' => 'QA JFK ONE', 'departure_airport_code' => 'JFK']);

        $body = $this->get(route('quick-yatri-groups'))->assertStatus(200)->getContent();

        $this->assertStringContainsString('Philadelphia (PHL) Group', $body);
        $this->assertStringContainsString('New York (JFK) Group', $body);
        $this->assertStringContainsString('leaving 19 November', $body);
        $this->assertStringContainsString('and returning 1 December', $body);

        // The sectors each group flies.
        $this->assertStringContainsString('PHL-ISB 19 NOV', $body);
        $this->assertStringContainsString('LHE-PHL 1 DEC', $body);
        $this->assertStringContainsString('JFK-ISB 19 NOV', $body);
        $this->assertStringContainsString('LHE-JFK 1 DEC', $body);

        // Everyone is on it.
        foreach (['QA PHL ONE', 'QA PHL TWO', 'QA JFK ONE'] as $name) {
            $parts = (new QuickYatri(['applicant_name' => $name]))->nameParts();
            $this->assertStringContainsString($parts['last'], $body);
        }
    }

    /** The block of HTML for one city's group, so a test can read it alone. */
    private function groupBlock(string $body, string $heading): string
    {
        $blocks = array_slice(explode('<div class="gm-group">', $body), 1);

        foreach ($blocks as $block) {
            if (strpos($block, $heading) !== false) {
                return $block;
            }
        }

        $this->fail('No group block found for ' . $heading);
    }

    /**
     * SR# numbers the travellers on one flight, not the rows of the report, so
     * it has to start again in each block. With two in the first group and one
     * in the second, the report must print 1, 2, then 1 — never 1, 2, 3.
     */
    public function test_the_sr_number_restarts_in_every_group()
    {
        $this->asAdmin();

        // Two airports no real application uses, so these blocks hold only the
        // rows this test made — these run against the real local database, and
        // any city already in it forms a group of its own now.
        $this->traveller(['applicant_name' => 'QA ALPHA ONE', 'departure_airport_code' => 'BFF']);
        $this->traveller(['applicant_name' => 'QA ALPHA TWO', 'departure_airport_code' => 'BFF']);
        $this->traveller(['applicant_name' => 'QA BRAVO ONE', 'departure_airport_code' => 'CDR']);

        $body = $this->get(route('quick-yatri-groups'))->getContent();

        $counts = [];
        foreach (['Scottsbluff (BFF)' => 2, 'Chadron (CDR)' => 1] as $heading => $expected) {
            preg_match_all('/<td class="gm-sr">(\d+)<\/td>/', $this->groupBlock($body, $heading), $m);

            // Each block counts 1..n from its own first traveller, rather than
            // continuing the numbering of the block above it.
            $this->assertSame(range(1, $expected), array_map('intval', $m[1]), $heading);
            $counts[] = count($m[1]);
        }

        // And nobody was dropped in the name of restarting the count.
        $this->assertSame(3, array_sum($counts));
    }

    public function test_only_an_application_without_a_departure_city_is_listed_as_ungrouped()
    {
        $this->asAdmin();

        // The panel is alphabetical and capped, and these run against the real
        // local database — which already holds ungroupable applications. Names
        // that sort ahead of any real one keep this test about the panel
        // rather than about whatever else happens to be in the table.
        $this->traveller(['applicant_name' => 'AAA QA IN A GROUP']);
        $this->traveller(['applicant_name' => 'AAA QA NO DATES', 'departure_date' => null, 'return_date' => null]);
        $this->traveller(['applicant_name' => 'AAA QA NO AIRPORT', 'departure_airport_code' => null]);

        $body = $this->get(route('quick-yatri-groups'))->getContent();

        $this->assertStringContainsString('no departure city', $body);
        $this->assertStringContainsString('AAA QA NO AIRPORT', $body);
        $this->assertStringContainsString('needs a departure airport', $body);

        // Having no dates is NOT a reason to be listed here any more — that
        // application is in its city's group, waiting on a booking.
        $this->assertStringNotContainsString('AAA QA NO DATES</a>', $body);

        // The ones that do have a city are on the manifest.
        $this->assertStringContainsString('Philadelphia (PHL) Group', $body);
    }

    /**
     * That panel is a nudge to finish the data entry, not a second copy of the
     * applications list — and before a season's tickets are booked, every row
     * in the table is ungroupable. It names a handful and counts the rest.
     */
    public function test_the_ungrouped_panel_names_a_handful_and_counts_the_rest()
    {
        $this->asAdmin();

        $named = \App\Http\Controllers\Admin\QuickYatriController::MISSING_NAMED;
        $extra = 3;

        // "AAA" so these sort ahead of the real ungroupable rows the local
        // database already holds — the panel is alphabetical, so without that
        // the cap would be spent on data this test did not create.
        for ($i = 0; $i < $named + $extra; $i++) {
            $this->traveller([
                'applicant_name'         => sprintf('AAA UNGROUPED %02d', $i),
                'departure_airport_code' => null,
            ]);
        }

        $body = $this->get(route('quick-yatri-groups'))->getContent();

        $this->assertSame($named, substr_count($body, 'AAA UNGROUPED '), 'named more than the cap');
        // The rest are still accounted for, just not listed one by one.
        $this->assertMatchesRegularExpression('/and \d+ more/', $body);
    }

    public function test_the_pakistan_number_defaults_to_the_constant_and_can_be_rewritten()
    {
        $this->asAdmin();
        $this->traveller();

        // Default: the constant, printed on the group's header.
        $body = $this->get(route('quick-yatri-groups'))->getContent();
        $this->assertStringContainsString(QuickYatri::PAKISTAN_CONTACT, $body);
        $this->assertStringContainsString(QuickYatri::CONTACT_EMAIL, $body);
        $this->assertStringContainsString(QuickYatri::CONTACT_PHONE, $body);

        // Rewritten from the same dialog the prices live in.
        $this->post(route('quick-yatri-prices'), ['pakistan_contact' => '+92-300-111-2222'])
            ->assertRedirect(route('quick-yatri'));

        $this->assertSame('+92-300-111-2222', QuickYatri::pakistanContact());
        $this->assertStringContainsString('+92-300-111-2222', $this->get(route('quick-yatri-groups'))->getContent());

        // Blanked, it falls back to the constant rather than printing nothing.
        $this->post(route('quick-yatri-prices'), ['pakistan_contact' => '']);
        $this->assertSame(QuickYatri::PAKISTAN_CONTACT, QuickYatri::pakistanContact());
    }

    /** Posting prices alone must not wipe the number, same guard as the note. */
    public function test_saving_prices_alone_never_wipes_the_pakistan_number()
    {
        $this->asAdmin();

        QuickYatri::putPakistanContact('+92-300-999-8888');

        $this->post(route('quick-yatri-prices'), ['round_trip_5star' => 3200]);

        $this->assertSame('+92-300-999-8888', QuickYatri::pakistanContact());
    }

    public function test_the_dashboard_counts_applications_and_previews_the_next_groups()
    {
        $this->asAdmin();

        $this->traveller(['applicant_name' => 'QA DASH ONE']);
        $this->traveller(['applicant_name' => 'QA DASH UNGROUPED', 'departure_date' => null]);

        $body = $this->get(route('quick-yatri-dashboard'))->assertStatus(200)->getContent();

        // The nearest group, with its route and headcount.
        $this->assertStringContainsString('Philadelphia (PHL)', $body);
        $this->assertStringContainsString('PHL-ISB 19 NOV', $body);

        // And the way in to everything else in the module.
        $this->assertStringContainsString(route('quick-yatri'), $body);
        $this->assertStringContainsString(route('quick-yatri-groups'), $body);
        $this->assertStringContainsString(route('quick-yatri-create'), $body);
        $this->assertStringContainsString(route('quick-yatri-blank'), $body);
    }

    /**
     * The applications list keeps its own URL and its own redirects — the
     * dashboard is a new page beside it, not a replacement (2026-09-05).
     */
    public function test_the_applications_list_is_still_its_own_page()
    {
        $this->asAdmin();

        $this->get(route('quick-yatri'))->assertStatus(200);
        $this->assertNotSame(route('quick-yatri'), route('quick-yatri-dashboard'));

        // Saving still returns to the list, not the dashboard.
        $this->post(route('quick-yatri-store'), ['applicant_name' => 'QA STILL LISTS'])
            ->assertRedirect(route('quick-yatri'));
    }

    /**
     * The list's Options column became Travelling From on 2026-09-05 — the
     * options were empty on nearly every application, and where a traveller
     * flies from is what the office now works by. The options moved under the
     * Trip pill rather than being dropped.
     */
    public function test_the_list_shows_where_and_when_each_applicant_flies()
    {
        $this->asAdmin();

        $row = $this->traveller([
            'applicant_name'       => 'QA LIST COLUMN',
            'trip_option'          => 'round_trip_5star',
            'wheelchair_full_trip' => true,
            'meal_vegetarian'      => true,
        ]);

        $body = $this->get(route('quick-yatri'))->getContent();

        $this->assertStringContainsString('>Travelling From<', $body);
        $this->assertStringNotContainsString('>Options<', $body);

        // The airport, its city and the dates.
        $this->assertStringContainsString('<span class="qy-from">PHL</span>', $body);
        $this->assertStringContainsString('Philadelphia', $body);
        $this->assertStringContainsString('19 Nov', $body);

        // Sorted by airport then departure date, so the list clusters into the
        // same groups the manifest prints.
        $this->assertStringContainsString('data-sort="PHL 2026-11-19"', $body);

        // The options did not go away, they moved under the trip pill.
        $this->assertStringContainsString('Wheelchair &mdash; full trip', $body);
        $this->assertStringContainsString('Vegetarian', $body);

        // And the airport is searchable, so "PHL" finds everyone on that flight.
        $this->assertStringContainsString('phl philadelphia', $body);

        $row->delete();
    }

    /** A row with an airport but no dates says so — it cannot be grouped yet. */
    public function test_the_list_flags_an_applicant_with_no_travel_dates()
    {
        $this->asAdmin();

        $row = $this->traveller([
            'applicant_name' => 'QA NO DATES YET',
            'departure_date' => null,
            'return_date'    => null,
        ]);

        $this->assertStringContainsString('no travel dates', $this->get(route('quick-yatri'))->getContent());

        $row->delete();
    }

    public function test_an_airport_code_resolves_to_its_city()
    {
        $this->assertSame('Philadelphia', UsAirports::city('PHL'));
        $this->assertSame('New York', UsAirports::city('JFK'));
        $this->assertSame('Washington Dulles', UsAirports::city('IAD'));
        // Lower case in, city out — the column is not case-guarded.
        $this->assertSame('Miami', UsAirports::city('mia'));
        // An unknown code is echoed rather than blanked, like label().
        $this->assertSame('ZZZ', UsAirports::city('ZZZ'));
    }
}
