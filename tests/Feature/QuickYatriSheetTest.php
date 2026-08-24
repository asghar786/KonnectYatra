<?php

namespace Tests\Feature;

use App\Models\DepartureOrigin;
use App\Models\QuickYatri;
use App\Models\User;
use Tests\TestCase;

/**
 * The Round Trip departure-airport dropdown, the merged instructions, and the
 * option-bar checkboxes added to the Quick Yatri sheet (2026-08-24).
 */
class QuickYatriSheetTest extends TestCase
{
    private function asAdmin()
    {
        // In-memory only — never persisted, so this never touches the real
        // admin user row (see people.md: id 1 is Rashad's actual login).
        $this->actingAs(new User(['role' => 'admin']));
    }

    public function test_blank_sheet_offers_a_box_on_each_option_bar_and_a_merged_instruction()
    {
        $this->asAdmin();

        $response = $this->get(route('quick-yatri-blank'));

        $response->assertStatus(200);

        $body = $response->getContent();

        // The three option bars now carry a real tick box in every mode,
        // including blank — a candidate filling the printed sheet by pen has
        // something to mark. Previously blank mode rendered none of these.
        $this->assertSame(3, substr_count($body, 'qy-box qy-box-light'));

        // Instruction 3 ("2 Pages of Indian Passport") moved onto the end of
        // instruction 2, so it must not appear as its own <li> any more.
        $this->assertStringNotContainsString('<li>2 Pages of Indian Passport</li>', $body);
        $this->assertStringContainsString(
            'copy of Green Card if you are not a U.S. citizen. 2 Pages of Indian Passport.',
            $body
        );

        // Blank mode can't offer a dropdown on paper — a line to write on instead.
        $this->assertStringContainsString('Round Trip <span class="qy-rule"', $body);
    }

    public function test_entry_screen_lists_active_usa_departure_airports()
    {
        $this->asAdmin();

        $response = $this->get(route('quick-yatri-create'));

        $response->assertStatus(200);
        $response->assertSee('name="departure_airport_code"', false);

        foreach (DepartureOrigin::where('country', 'USA')->where('status', 1)->pluck('airport_code') as $code) {
            $response->assertSee('value="' . $code . '"', false);
        }
    }

    public function test_store_saves_the_selected_departure_airport()
    {
        $this->asAdmin();

        $response = $this->post(route('quick-yatri-store'), [
            'applicant_name'          => 'QA Test Applicant',
            'booking_type'            => 'round_trip_phl',
            'departure_airport_code'  => 'JFK',
        ]);

        $response->assertRedirect(route('quick-yatri'));

        $saved = QuickYatri::where('applicant_name', 'QA Test Applicant')->first();
        $this->assertNotNull($saved);
        $this->assertSame('JFK', $saved->departure_airport_code);

        $saved->delete();
    }

    public function test_print_view_shows_the_airport_and_its_state()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name'         => 'QA Print Test',
            'booking_type'           => 'round_trip_phl',
            'departure_airport_code' => 'PHL',
        ]);

        $response = $this->get(route('quick-yatri-print', $row->id));

        $response->assertStatus(200);
        $response->assertSee('PHL', false);
        $response->assertSee('Pennsylvania', false);

        $row->delete();
    }

    public function test_page_2_carries_the_2026_08_24_wording_corrections()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $this->assertStringContainsString(
            'Green Card, 2 Pages of passport, and Driver&rsquo;s License or State ID',
            $body
        );

        // The heading dropped "Two-" since the fee now applies at one suitcase too.
        $this->assertStringContainsString('<strong>Suitcase Baggage Handling:</strong>', $body);
        $this->assertStringNotContainsString('Two-Suitcase Baggage Handling', $body);
        $this->assertStringContainsString('carrying one or two suitcases', $body);

        $this->assertStringContainsString('Approval is not guaranteed, due to security reasons.', $body);

        $this->assertStringContainsString(
            'may be changed, amended, canceled, or rescheduled when necessary',
            $body
        );
    }

    public function test_a_since_deactivated_airport_is_preserved_as_current_rather_than_dropped()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name'         => 'QA Stale Airport Test',
            'booking_type'           => 'round_trip_phl',
            'departure_airport_code' => 'ZZZ', // not a real departure_origins row
        ]);

        $response = $this->get(route('quick-yatri-edit', $row->id));

        $response->assertStatus(200);
        $response->assertSee('value="ZZZ" selected>ZZZ (current)', false);

        $row->delete();
    }
}
