<?php

namespace Tests\Feature;

use App\Models\QuickYatri;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Quick Yatri pricing (2026-08-27).
 *
 * Two things are being covered, and they pull in opposite directions on purpose:
 *
 *  - the grid (OW / RT / LP and the wheelchair surcharge) is one editable set of
 *    prices, kept in `site_settings` so the office can move a fare without a
 *    deploy — the toolbar, the modal and the printed sheet all read the same
 *    numbers;
 *  - a single applicant can still be quoted their own price, because two yatris
 *    on the same trip option are not always charged the same thing (group size,
 *    departure airport, a rate agreed at a gurdwara event). That price is
 *    flagged on the row and must survive both a re-save of the sheet and a
 *    later change to the grid.
 *
 * These run against the local database (there is no sqlite test connection
 * configured — see phpunit.xml), so DatabaseTransactions wraps every test in
 * a transaction rolled back on tearDown. This is load-bearing, not tidiness:
 * without it, test_applying_a_new_grid_reprices_standard_rows_but_never_an_agreed_price
 * posts apply_existing=1, which reprices *every* real row still on standard
 * pricing — not just the two rows the test creates — and that once silently
 * rewrote two real, already-quoted applications (2026-09-04) because the old
 * setUp/tearDown pair only snapshotted the `site_settings` grid, never the
 * individual rows the grid change swept along with it.
 */
class QuickYatriPricingTest extends TestCase
{
    use DatabaseTransactions;

    /** @var array<string,string|null> */
    private $originalPrices = [];

    protected function setUp(): void
    {
        parent::setUp();

        foreach ($this->settingKeys() as $key) {
            $this->originalPrices[$key] = SiteSetting::get($key);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->originalPrices as $key => $value) {
            SiteSetting::put($key, (string) $value);
        }

        parent::tearDown();
    }

    /** @return string[] */
    private function settingKeys(): array
    {
        return array_merge(array_values(QuickYatri::PRICE_KEYS), [
            QuickYatri::WHEELCHAIR_FEE_KEY,
            // The sheet's first printed condition rides in the same dialog, so
            // it is the same kind of live setting and needs the same put-back.
            QuickYatri::VALIDITY_NOTE_KEY,
        ]);
    }

    private function asAdmin()
    {
        // In-memory only — never persisted, so this never touches the real
        // admin user row (see people.md: id 1 is Rashad's actual login).
        $this->actingAs(new User(['role' => 'admin']));
    }

    /** Put the grid back on the model's constants for a predictable start. */
    private function standardGrid(): void
    {
        QuickYatri::putPrices([
            'one_way_5star'        => 2650,
            'round_trip_5star'     => 3150,
            'round_trip_land'      => 1650,
            'wheelchair_full_trip' => 300,
        ]);
    }

    public function test_the_list_toolbar_shows_the_grid_and_the_update_button()
    {
        $this->asAdmin();
        $this->standardGrid();

        $body = $this->get(route('quick-yatri'))->getContent();

        // The three pills the office reads at a glance, in the sheet's own
        // shorthand, plus the button that opens the modal.
        $this->assertStringContainsString('<em>OW</em><b>$2,650</b>', $body);
        $this->assertStringContainsString('<em>RT</em><b>$3,150</b>', $body);
        $this->assertStringContainsString('<em>LP</em><b>$1,650</b>', $body);
        $this->assertStringContainsString('id="qyPricesOpen"', $body);
        $this->assertStringContainsString('action="' . route('quick-yatri-prices') . '"', $body);
    }

    public function test_a_saved_price_reaches_the_toolbar_and_the_printed_blank_sheet()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-prices'), [
            'one_way_5star'        => 2800,
            'round_trip_5star'     => 3300,
            'round_trip_land'      => 1750,
            'wheelchair_full_trip' => 350,
        ])->assertRedirect(route('quick-yatri'));

        $this->assertSame(3300.0, QuickYatri::amountFor('round_trip_5star'));
        $this->assertSame(350.0, QuickYatri::wheelchairFee());

        // The blank sheet handed out at an event has to carry today's price —
        // that is the whole reason these moved out of the template.
        $sheet = $this->get(route('quick-yatri-blank'))->getContent();
        $this->assertStringContainsString('$3,300', $sheet);
        $this->assertStringContainsString('$2,800', $sheet);
        $this->assertStringContainsString('$1,750', $sheet);
        $this->assertStringContainsString('Wheelchair throughout the trip (+$350)', $sheet);
        $this->assertStringNotContainsString('$3,150', $sheet);
    }

    public function test_a_blanked_price_falls_back_to_the_model_default_rather_than_zero()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-prices'), ['round_trip_5star' => 3400]);
        $this->assertSame(3400.0, QuickYatri::amountFor('round_trip_5star'));

        // Clearing the field must not price the trip at $0 — it goes back to
        // the constant, so the sheet always prices something.
        $this->post(route('quick-yatri-prices'), ['round_trip_5star' => '']);
        $this->assertSame(
            (float) QuickYatri::TRIP_OPTIONS['round_trip_5star']['amount'],
            QuickYatri::amountFor('round_trip_5star')
        );
    }

    public function test_applying_a_new_grid_reprices_standard_rows_but_never_an_agreed_price()
    {
        $this->asAdmin();
        $this->standardGrid();

        $standard = QuickYatri::create([
            'applicant_name' => 'QA Pricing Standard',
            'trip_option'    => 'round_trip_5star',
            'package_amount' => 3150,
            'total_amount'   => 3150,
        ]);
        $agreed = QuickYatri::create([
            'applicant_name' => 'QA Pricing Agreed',
            'trip_option'    => 'round_trip_5star',
            'custom_price'   => true,
            'package_amount' => 2900,
            'total_amount'   => 2900,
            'price_note'     => 'Group of 6 — family rate',
        ]);

        try {
            $this->post(route('quick-yatri-prices'), [
                'round_trip_5star' => 3400,
                'apply_existing'   => 1,
            ]);

            $this->assertSame(3400.0, (float) $standard->fresh()->total_amount);
            // The negotiated price is exactly what must not move.
            $this->assertSame(2900.0, (float) $agreed->fresh()->total_amount);
        } finally {
            $standard->delete();
            $agreed->delete();
        }
    }

    public function test_leaving_apply_existing_unticked_leaves_saved_rows_alone()
    {
        $this->asAdmin();
        $this->standardGrid();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Pricing Untouched',
            'trip_option'    => 'round_trip_land',
            'package_amount' => 1650,
            'total_amount'   => 1650,
        ]);

        try {
            $this->post(route('quick-yatri-prices'), ['round_trip_land' => 1900]);

            // The row keeps the price it was quoted at; only the grid moved.
            $this->assertSame(1650.0, (float) $row->fresh()->total_amount);
            $this->assertSame(1900.0, QuickYatri::amountFor('round_trip_land'));
        } finally {
            $row->delete();
        }
    }

    public function test_one_applicant_can_be_given_their_own_price_and_a_reason()
    {
        $this->asAdmin();
        $this->standardGrid();

        $row = QuickYatri::create([
            'applicant_name'       => 'QA Pricing Custom',
            'trip_option'          => 'round_trip_5star',
            'wheelchair_full_trip' => true,
            'package_amount'       => 3150,
            'total_amount'         => 3450,
        ]);

        try {
            $this->post(route('quick-yatri-row-price', $row->id), [
                'package_amount' => 2900,
                'price_note'     => 'Group of 6 — departing MIA',
            ])->assertRedirect(route('quick-yatri'));

            $row->refresh();
            $this->assertTrue($row->custom_price);
            $this->assertSame(2900.0, (float) $row->package_amount);
            // The one surcharge on the sheet still stacks on the agreed price.
            $this->assertSame(3200.0, (float) $row->total_amount);
            $this->assertSame('Group of 6 — departing MIA', $row->price_note);

            // Both the list and this applicant's own sheet say why.
            $list = $this->get(route('quick-yatri'))->getContent();
            $this->assertStringContainsString('Group of 6 — departing MIA', $list);

            // Page 1 of the printed sheet is a fixed 11in box that already
            // measures 11in exactly, so the agreed price goes *inside* the cell
            // their option is ticked in — grid price struck through, theirs in
            // bold — rather than on a line of its own.
            $sheet = $this->get(route('quick-yatri-print', $row->id))->getContent();
            $this->assertStringContainsString('<s style="color:#777; font-weight:400">$3,150</s> <b>$2,900</b>', $sheet);
            $this->assertStringNotContainsString('Agreed price for this applicant', $sheet);

            // The entry screen is not height-capped, so it carries the reason.
            $entry = $this->get(route('quick-yatri-edit', $row->id))->getContent();
            $this->assertStringContainsString('Agreed price for this applicant:', $entry);
            $this->assertStringContainsString('Group of 6 — departing MIA', $entry);
        } finally {
            $row->delete();
        }
    }

    public function test_a_standard_priced_sheet_shows_the_grid_price_unstruck()
    {
        $this->asAdmin();
        $this->standardGrid();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Pricing Plain Sheet',
            'trip_option'    => 'round_trip_5star',
            'package_amount' => 3150,
            'total_amount'   => 3150,
        ]);

        try {
            $sheet = $this->get(route('quick-yatri-print', $row->id))->getContent();
            $this->assertStringContainsString('$3,150', $sheet);
            $this->assertStringNotContainsString('<s style=', $sheet);
        } finally {
            $row->delete();
        }
    }

    public function test_the_blank_sheet_never_carries_an_agreed_price_line()
    {
        $this->asAdmin();

        // The blank form is printed and handed out — it belongs to nobody, so
        // it must never show one applicant's negotiated price.
        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $this->assertStringNotContainsString('Agreed price for this applicant', $body);
        $this->assertStringNotContainsString('<s style=', $body);
    }

    public function test_resaving_the_sheet_does_not_put_the_grid_price_back()
    {
        $this->asAdmin();
        $this->standardGrid();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Pricing Resave',
            'trip_option'    => 'round_trip_5star',
            'custom_price'   => true,
            'package_amount' => 2900,
            'total_amount'   => 2900,
            'price_note'     => 'Agreed at the Fresno event',
        ]);

        try {
            // An ordinary edit of the sheet — nothing to do with pricing.
            $this->post(route('quick-yatri-update', $row->id), [
                'applicant_name' => 'QA Pricing Resave',
                'trip_option'    => 'round_trip_5star',
                'city'           => 'FRESNO',
            ]);

            $row->refresh();
            $this->assertTrue($row->custom_price);
            $this->assertSame(2900.0, (float) $row->total_amount);
            $this->assertSame('Agreed at the Fresno event', $row->price_note);
        } finally {
            $row->delete();
        }
    }

    public function test_reset_puts_an_applicant_back_on_the_standard_price()
    {
        $this->asAdmin();
        $this->standardGrid();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Pricing Reset',
            'trip_option'    => 'round_trip_land',
            'custom_price'   => true,
            'package_amount' => 1400,
            'total_amount'   => 1400,
            'price_note'     => 'Repeat yatri',
        ]);

        try {
            $this->post(route('quick-yatri-row-price', $row->id), [
                'reset'          => 1,
                'package_amount' => 1400,
                'price_note'     => 'Repeat yatri',
            ]);

            $row->refresh();
            $this->assertFalse($row->custom_price);
            $this->assertNull($row->price_note);
            $this->assertSame(1650.0, (float) $row->total_amount);
        } finally {
            $row->delete();
        }
    }

    public function test_clearing_the_amount_is_the_same_as_resetting()
    {
        $this->asAdmin();
        $this->standardGrid();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Pricing Cleared',
            'trip_option'    => 'one_way_5star',
            'custom_price'   => true,
            'package_amount' => 2400,
            'total_amount'   => 2400,
        ]);

        try {
            $this->post(route('quick-yatri-row-price', $row->id), ['package_amount' => '']);

            $row->refresh();
            $this->assertFalse($row->custom_price);
            $this->assertSame(2650.0, (float) $row->total_amount);
        } finally {
            $row->delete();
        }
    }

    public function test_a_new_application_is_priced_from_the_current_grid()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-prices'), [
            'round_trip_5star'     => 3400,
            'wheelchair_full_trip' => 400,
        ]);

        $this->post(route('quick-yatri-store'), [
            'applicant_name'       => 'QA Pricing New',
            'trip_option'          => 'round_trip_5star',
            'wheelchair_full_trip' => 1,
        ]);

        $row = QuickYatri::where('applicant_name', 'QA Pricing New')->first();

        try {
            $this->assertNotNull($row);
            $this->assertFalse($row->custom_price);
            $this->assertSame(3400.0, (float) $row->package_amount);
            $this->assertSame(3800.0, (float) $row->total_amount);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    /* ---- the sheet's first printed condition, edited in the same dialog ---- */

    public function test_the_price_dialog_carries_the_sheets_first_condition()
    {
        $this->asAdmin();
        SiteSetting::put(QuickYatri::VALIDITY_NOTE_KEY, '');

        $body = $this->get(route('quick-yatri'))->getContent();

        // Pre-filled with the sentence in force, not the raw setting, so a date
        // can be edited in place rather than retyped from memory.
        $this->assertStringContainsString('name="validity_note"', $body);
        $this->assertStringContainsString(e(QuickYatri::VALIDITY_NOTE) . '</textarea>', $body);
        $this->assertStringContainsString('maxlength="' . QuickYatri::VALIDITY_NOTE_MAX . '"', $body);
    }

    public function test_the_first_condition_can_be_rewritten_from_the_price_dialog()
    {
        $this->asAdmin();

        $new = 'This application is valid through 30-NOV-2026. Add $150 after that date.';

        $this->post(route('quick-yatri-prices'), [
            'one_way_5star' => 2650,
            'validity_note' => $new,
        ])->assertRedirect(route('quick-yatri'));

        $this->assertSame($new, QuickYatri::validityNote());

        // It is printed copy, so the sheet is what actually has to change.
        $sheet = $this->get(route('quick-yatri-blank'))->getContent();
        $this->assertStringContainsString(e($new), $sheet);
        $this->assertStringNotContainsString('valid through September 15, 2026', $sheet);
    }

    public function test_a_blank_first_condition_falls_back_to_the_standard_wording()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-prices'), ['validity_note' => 'Something temporary.']);
        $this->post(route('quick-yatri-prices'), ['validity_note' => '']);

        // Same rule the prices follow: cleared means "back to the default",
        // never "print an empty bullet".
        $this->assertSame(QuickYatri::VALIDITY_NOTE, QuickYatri::validityNote());
        $this->assertStringContainsString(
            e(QuickYatri::VALIDITY_NOTE),
            $this->get(route('quick-yatri-blank'))->getContent()
        );
    }

    public function test_a_condition_longer_than_the_page_allows_is_rejected()
    {
        $this->asAdmin();

        $kept = 'The wording that must survive a rejected edit.';
        $this->post(route('quick-yatri-prices'), ['validity_note' => $kept]);

        // Page 1 is a fixed 11in box: past this length the footer row grows
        // past the QR square and the sheet spills onto a third printed page.
        $this->post(route('quick-yatri-prices'), [
            'validity_note' => str_repeat('a', QuickYatri::VALIDITY_NOTE_MAX + 1),
        ])->assertSessionHasErrors('validity_note');

        $this->assertSame($kept, QuickYatri::validityNote());
    }

    public function test_saving_prices_alone_never_wipes_the_condition()
    {
        $this->asAdmin();

        $mine = 'Valid through 01-DEC-2026. Add $100 from 05-DEC-2026.';
        $this->post(route('quick-yatri-prices'), ['validity_note' => $mine]);

        // A post without the field at all — the sentence is not that caller's
        // to clear, so an absent key must leave it exactly where it was.
        $this->post(route('quick-yatri-prices'), ['round_trip_5star' => 3200]);

        $this->assertSame($mine, QuickYatri::validityNote());
        $this->assertSame(3200.0, QuickYatri::amountFor('round_trip_5star'));
    }
}
