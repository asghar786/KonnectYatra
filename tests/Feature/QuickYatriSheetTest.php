<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\PaymentSettingController;
use App\Models\QuickYatri;
use App\Models\SiteSetting;
use App\Models\User;
use App\Support\UsAirports;
use Tests\TestCase;

/**
 * The Quick Yatri sheet: the "Travelling from" airport dropdown, the merged
 * instructions, the option-bar checkboxes (2026-08-24), and the CAPS/email/
 * phone reading rules (2026-08-25).
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
        $this->assertStringContainsString('Travelling from</span><span class="qy-rule"', $body);
    }

    public function test_entry_screen_lists_every_us_airport_grouped_by_state()
    {
        $this->asAdmin();

        $response = $this->get(route('quick-yatri-create'));

        $response->assertStatus(200);
        $response->assertSee('name="departure_airport_code"', false);

        $body = $response->getContent();

        // Every airport in the bundled list, in a per-state optgroup.
        $groups = UsAirports::grouped();
        $this->assertSame(count($groups), substr_count($body, '<optgroup label='));
        foreach ($groups as $state => $airports) {
            $this->assertStringContainsString('<optgroup label="' . $state . '">', $body);
        }
        foreach (array_keys(UsAirports::flat()) as $code) {
            $this->assertStringContainsString('value="' . $code . '"', $body);
        }

        // Airports the curated departure_origins list never carried - the whole
        // point of the switch - plus one from a territory.
        foreach (['ANC', 'BZN', 'PVD', 'SJU'] as $code) {
            $this->assertStringContainsString('value="' . $code . '"', $body);
        }
    }

    /**
     * The bar asks one plain question now. The Round Trip / Land Package
     * radios, the hard-coded ISB/LHE destination, and the booking_type field
     * they fed were all removed from it on 2026-08-25.
     */
    public function test_the_top_bar_is_a_single_travelling_from_question()
    {
        $this->asAdmin();

        foreach ([route('quick-yatri-create'), route('quick-yatri-blank')] as $url) {
            $body = $this->get($url)->getContent();

            $this->assertStringContainsString('Travelling from', $body);
            $this->assertStringNotContainsString('ISB/LHE', $body);
            $this->assertStringNotContainsString('booking_type', $body);
            $this->assertStringNotContainsString('round_trip_phl', $body);
        }
    }

    public function test_store_saves_the_selected_departure_airport()
    {
        $this->asAdmin();

        $response = $this->post(route('quick-yatri-store'), [
            'applicant_name'          => 'QA Test Applicant',
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
            'departure_airport_code' => 'PHL',
        ]);

        $response = $this->get(route('quick-yatri-print', $row->id));

        $response->assertStatus(200);
        // "PHL — Philadelphia, PA": code, city, and state abbreviation.
        $response->assertSee('PHL — Philadelphia, PA', false);

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

    public function test_blank_form_can_be_prefilled_with_a_departure_airport()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank', ['airport' => 'MIA']))->getContent();

        // Pre-filled text, not the hand-writing line, and in the CODE/ST form
        // Rashad asked for.
        $this->assertStringContainsString('<span class="qy-val qy-caps">MIA/FL</span>', $body);
        $this->assertStringNotContainsString('Travelling from</span><span class="qy-rule"', $body);
    }

    public function test_blank_form_ignores_an_unknown_airport_code()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank', ['airport' => 'ZZZ']))->getContent();

        // Falls back to the writing line rather than printing a made-up code.
        $this->assertStringContainsString('Travelling from</span><span class="qy-rule"', $body);
        $this->assertStringNotContainsString('ZZZ', $body);
    }

    public function test_quick_yatri_list_offers_the_airport_picker_for_the_blank_form()
    {
        $this->asAdmin();

        $response = $this->get(route('quick-yatri'));

        $response->assertStatus(200);
        $response->assertSee('id="qyBlankAirport"', false);
        $response->assertSee('id="qyBlankLink"', false);

        $body = $response->getContent();
        $this->assertSame(count(UsAirports::grouped()), substr_count($body, '<optgroup label='));
        foreach (['PHL', 'ANC', 'BZN', 'SJU'] as $code) {
            $this->assertStringContainsString('value="' . $code . '"', $body);
        }
    }

    public function test_the_two_removed_notes_are_gone_and_the_footer_is_redesigned()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $this->assertStringNotContainsString('Price is guaranteed when booking is made', $body);
        $this->assertStringNotContainsString('Please send a $1 test payment first', $body);

        // Still present, unaffected by the removal of the two bullets above it.
        // Pinned to whatever the office has the sentence set to rather than to
        // a date or a phrase: since 2026-08-27 it is edited in the admin, so
        // this asserts the bullet is printed, not what season it names.
        $this->assertStringContainsString(e(QuickYatri::validityNote()), $body);

        // Uploads was retired on 2026-08-27 with the rest of that row; Signature
        // still exists but has moved to page 2 (asserted below).
        $this->assertStringNotContainsString('>Uploads<', $body);
        $this->assertStringContainsString('>Signature<', $body);
        $this->assertStringContainsString('Scan Me', $body);
    }

    /**
     * "A separate application form is required for each traveler" came out of
     * the page-1 box on 2026-08-27 at Rashad's request. It is only that box —
     * the public apply form carries its own version of the line, and this test
     * is not about that one.
     */
    public function test_the_per_traveller_note_is_gone_from_the_page_one_box()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $this->assertStringNotContainsString('separate application form is required', $body);

        // The bullets either side of it are untouched, so this reads as one
        // line removed rather than the list being rebuilt.
        $this->assertStringContainsString('You must follow all group rules and regulations.', $body);
        $this->assertStringContainsString('Minimum deposit of <strong>$500</strong> accepted.', $body);
    }

    /**
     * The page-1 footer, redesigned 2026-08-27: one 60/40 row — the conditions
     * and the Date on the left, a square panel holding the Zelle QR on the
     * right. The Uploads tick boxes are gone and the signature moved to page 2.
     */
    public function test_the_page_one_footer_is_a_sixty_forty_split_with_a_square_qr_panel()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        // The square is declared once as $qyPanelSide and used for both axes,
        // so width and height cannot drift apart into a rectangle.
        $this->assertMatchesRegularExpression(
            '/width:(\d+)pt; height:\1pt;[^"]*padding:9pt[^"]*"[^>]*>\s*<span[^>]*>Scan Me<\/span>/',
            $body,
            'The QR panel should be a square with the caption inside it.'
        );

        // The three upload tick boxes went with the panel they lived in.
        foreach (['upload_passport', 'upload_green_card', 'upload_id_license'] as $flag) {
            $this->assertStringNotContainsString($flag, $body);
        }
        $this->assertStringNotContainsString('Green Card</span>', $body);

        // The Date stayed behind on page 1, in the left panel with the notes.
        // Asserted as the printed label, not the field name: blank mode renders
        // a writing rule with no `name` at all — signature_date only appears as
        // an attribute in entry and print mode.
        $this->assertStringContainsString('This application is valid through', $body);
        $this->assertStringContainsString('Date:', $body);
        $this->assertStringContainsString('Minimum deposit of <strong>$500</strong> accepted.', $body);
    }

    /**
     * The applicant signs *after* the terms, not above them — so the signature
     * line lives at the foot of page 2 now, and nowhere on page 1.
     */
    public function test_the_signature_line_is_on_page_two_and_not_on_page_one()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $split = strpos($body, 'qy-page qy-page-2');
        $this->assertNotFalse($split, 'Page 2 should render on the blank sheet.');

        $pageOne = substr($body, 0, $split);
        $pageTwo = substr($body, $split);

        // Pinned to the rendered label, not the bare word: _sheet-css still
        // carries the word in a comment about where that height went.
        $this->assertStringNotContainsString('>Signature<', $pageOne);
        $this->assertStringContainsString('>Signature<', $pageTwo);

        // Pinned to the foot, which is also what puts the page's spare height
        // above the line as clear space to sign into.
        $this->assertStringContainsString('margin-top:auto', $pageTwo);
    }

    /**
     * The upload flags stopped being posted when their tick boxes were removed.
     * They must therefore stop being *read* too — otherwise re-saving any older
     * record silently writes false over what it already carries. Same trap, and
     * same fix, as booking_type on 2026-08-25.
     */
    public function test_resaving_a_sheet_preserves_the_retired_upload_flags()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name'    => 'QA Upload Flags',
            'upload_passport'   => true,
            'upload_green_card' => true,
            'upload_id_license' => true,
        ]);

        try {
            $this->post(route('quick-yatri-update', $row->id), [
                'applicant_name' => 'QA Upload Flags',
                'city'           => 'FRESNO',
            ]);

            $row->refresh();
            $this->assertTrue((bool) $row->upload_passport);
            $this->assertTrue((bool) $row->upload_green_card);
            $this->assertTrue((bool) $row->upload_id_license);
        } finally {
            $row->delete();
        }
    }

    /**
     * Both branches of the QR block, driving pay_zelle_qr directly rather than
     * trusting whatever is actually uploaded in the shared dev DB right now —
     * and restoring it afterward either way, since Payment Settings is real
     * data (Rashad's banking QR), not test fixture.
     */
    public function test_qr_block_shows_the_uploaded_zelle_qr_or_a_placeholder_when_none_is_set()
    {
        $this->asAdmin();

        $original = SiteSetting::get(PaymentSettingController::QR_KEY);

        try {
            SiteSetting::put(PaymentSettingController::QR_KEY, '');
            $body = $this->get(route('quick-yatri-blank'))->getContent();
            $this->assertStringContainsString('QR not set', $body);
            $this->assertStringNotContainsString('<img src=', $body);

            SiteSetting::put(PaymentSettingController::QR_KEY, 'unit-test-qr.png');
            $body = $this->get(route('quick-yatri-blank'))->getContent();
            $this->assertStringContainsString(
                'src="' . asset(PaymentSettingController::QR_DIRECTORY . '/unit-test-qr.png') . '"',
                $body
            );
        } finally {
            SiteSetting::put(PaymentSettingController::QR_KEY, (string) $original);
        }
    }

    /**
     * Every free-text answer reads in CAPS, email stays lowercase, and the cell
     * number takes the house shape (2026-08-25). The capitals are a
     * text-transform, so these assert the class the value carries rather than a
     * re-cased string - the stored value is deliberately left untouched.
     */
    public function test_print_mode_caps_every_answer_except_email_and_formats_the_phone()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name'  => 'BANTA SINGH',
            'father_name'     => 'santa singh',
            'mother_name'     => 'Santi Kaur',
            'family_member_1' => 'hasnat',
            'city'            => 'philadelphia',
            'email'           => 'Banta.Singh@Gmail.COM',
            'cell_phone'      => '17189089464', // 11 digits, leading 1
        ]);

        $body = $this->get(route('quick-yatri-print', $row->id))->getContent();

        // Stored exactly as typed; the class does the capitalising.
        foreach (['BANTA SINGH', 'santa singh', 'Santi Kaur', 'hasnat', 'philadelphia'] as $value) {
            $this->assertStringContainsString('<span class="qy-val qy-caps">' . $value . '</span>', $body);
        }

        // Names are no longer singled out for Title Case - they are text like
        // everything else, and all text is CAPS.
        $this->assertStringNotContainsString('>Santa Singh<', $body);
        $this->assertStringNotContainsString('>Hasnat<', $body);

        // Email is the one field held the other way.
        $this->assertStringContainsString(
            '<span class="qy-val qy-lower">Banta.Singh@Gmail.COM</span>',
            $body
        );

        // Spaces, not a hyphen, in the last two groups. Pinned to the whole
        // formatted value: a bare '908-9464' also matches the footer's static
        // contact line for Rashad, which is design copy and not this field.
        $this->assertStringContainsString('>+1 (718) 908 9464<', $body);
        $this->assertStringNotContainsString('>+1 (718) 908-9464<', $body);

        $row->delete();
    }

    /** The two transform classes every mode hangs the reading rules on. */
    public function test_the_sheet_stylesheet_defines_the_caps_and_lowercase_rules()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $this->assertStringContainsString('.qy-caps{text-transform:uppercase}', $body);
        $this->assertStringContainsString('.qy-lower{text-transform:lowercase}', $body);
    }

    /**
     * The entry form shows the tidied number too, not only the printed sheet,
     * so re-saving a record stores it back in the house shape.
     */
    public function test_entry_form_shows_the_phone_in_the_house_format()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Phone Test',
            'cell_phone'     => '7865162525',
        ]);

        $body = $this->get(route('quick-yatri-edit', $row->id))->getContent();

        $this->assertStringContainsString('name="cell_phone" value="+1 (786) 516 2525"', $body);

        // Server-side shaping only runs at render time, so the field also
        // carries the hook for the live mask that shapes it while it is typed.
        // Behaviour of the mask itself is covered by the CDP script, not here.
        $this->assertStringContainsString('class="qy-in qy-phone" name="cell_phone"', $body);
        $this->assertStringContainsString(".querySelector('.qy-phone')", $body);

        $row->delete();
    }

    public function test_print_mode_leaves_an_unrecognisable_phone_number_untouched()
    {
        $this->asAdmin();

        // 11 digits but no leading 1 — doesn't fit the US shape, so it must
        // print exactly as typed rather than being forced into one.
        $row = QuickYatri::create([
            'applicant_name' => 'Test Applicant',
            'cell_phone'     => '07182583690',
        ]);

        $body = $this->get(route('quick-yatri-print', $row->id))->getContent();

        $this->assertStringContainsString('>07182583690<', $body);

        $row->delete();
    }

    public function test_email_is_lowercased_on_save()
    {
        $this->asAdmin();

        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Email Test',
            'email'          => 'Asghar@BlueVisionAdv.COM',
        ]);

        $saved = QuickYatri::where('applicant_name', 'QA Email Test')->first();
        $this->assertSame('asghar@bluevisionadv.com', $saved->email);

        $saved->delete();
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

    /**
     * How the applicant is paying — Cash / Zelle / Check, ticked at the foot of
     * page 1. They share the Date's line rather than taking one of their own:
     * page 1 is a fixed 11in box and a second row costs height the first bullet
     * is already allowed to grow into.
     */
    public function test_the_footer_offers_three_payment_boxes_on_the_date_line()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $this->assertStringContainsString('Payment:', $body);
        $this->assertStringContainsString('></span>Cash', $body);
        $this->assertStringContainsString('></span>Zelle', $body);
        $this->assertStringContainsString('></span>Check', $body);

        // Same line, in the asked-for order: the boxes come before the Date and
        // nothing closes the row between them.
        $payment = strpos($body, 'Payment:');
        $date    = strpos($body, 'Date:', $payment);
        $this->assertNotFalse($payment);
        $this->assertNotFalse($date);
        $this->assertStringNotContainsString('</ul>', substr($body, $payment, $date - $payment));
    }

    public function test_a_saved_sheet_records_and_prints_the_payment_method()
    {
        $this->asAdmin();

        // Three tick boxes, not one choice: a deposit paid one way and the
        // balance another has to be recordable.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Payment Test',
            'pay_cash'       => 1,
            'pay_check'      => 1,
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Payment Test')->first();

        try {
            $this->assertNotNull($row);
            $this->assertTrue($row->pay_cash);
            $this->assertFalse($row->pay_zelle);
            $this->assertTrue($row->pay_check);

            $printed = $this->get(route('quick-yatri-print', $row->id))->getContent();
            $this->assertStringContainsString('&#10003;</span>Cash', $printed);
            $this->assertStringContainsString('></span>Zelle', $printed);
            $this->assertStringContainsString('&#10003;</span>Check', $printed);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    /* ------------------- the receipt number for a payment ------------------- */

    /**
     * The totals line carries Amount / Paid / Balance, and the Receipts row
     * under it carries the payments those totals are made of.
     *
     * On a row of the panel's own rather than anywhere else on page 1: the page
     * measures 11in exactly, and the row was paid for by tightening the bullets
     * and taking 14pt off the QR square (see the $qyPanelSide note).
     */
    public function test_the_footer_carries_a_receipts_row_under_the_totals()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        // Amount, Paid and Balance keep their order, and the Receipts row
        // follows them — the parts read under the totals they add up to.
        $amount   = strpos($body, 'Amount:');
        $paid     = strpos($body, 'Paid:', $amount);
        $balance  = strpos($body, 'Balance:', $paid);
        $receipts = strpos($body, 'Receipts:', $balance);
        $payment  = strpos($body, 'Payment:', $receipts);

        $this->assertNotFalse($balance);
        $this->assertNotFalse($receipts, 'The Receipts row must follow the totals line.');
        $this->assertNotFalse($payment, 'The Cash/Zelle/Check line must follow the Receipts row.');

        // Three slots, each marked "R#" for the receipt and "$" for the money —
        // a bare "#" beside a figure could be anything.
        $row = substr($body, $receipts, $payment - $receipts);
        $this->assertSame(3, substr_count($row, 'R#'));

        // And within every slot the receipt LEADS: it is what a payment gets
        // looked up by, and the money it covers follows.
        $at = 0;
        for ($slot = 1; $slot <= 3; $slot++) {
            $receipt = strpos($row, 'R#', $at);
            $amount  = strpos($row, '>$', $receipt);
            $this->assertNotFalse($receipt, "Slot {$slot} must carry an R# marker.");
            $this->assertNotFalse($amount, "Slot {$slot}'s amount must follow its R#.");
            $at = $amount;
        }
    }

    public function test_the_entry_screen_offers_three_payment_slots()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-create'))->getContent();

        // An amount and a receipt for each of the three, so a payment taken in
        // parts is recorded as parts.
        foreach (['amount_paid', 'receipt_no', 'amount_paid_2', 'receipt_no_2', 'amount_paid_3', 'receipt_no_3'] as $field) {
            $this->assertStringContainsString('name="' . $field . '"', $body);
        }

        // The receipt book prints six digits, so the field will not take a
        // seventh and offers a number pad on a phone.
        $this->assertSame(3, substr_count($body, 'maxlength="6"'));
        $this->assertSame(3, substr_count($body, 'inputmode="numeric"'));

        // Paid is no longer typed — it is the sum of the slots, computed both
        // here (qyPaidLine, live) and server-side by paidAmount().
        $this->assertStringContainsString('id="qyPaidLine"', $body);
        $this->assertStringNotContainsString('name="amount_paid" placeholder="0"', $body);
    }

    public function test_a_receipt_number_is_stored_and_printed_with_the_payment()
    {
        $this->asAdmin();

        // "No. 123454" is what the book prints and what gets copied out, label
        // and all — the digits are the receipt.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Receipt Test',
            'amount_paid'    => '$1,200',
            'receipt_no'     => 'No. 123454',
            'pay_cash'       => 1,
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Receipt Test')->first();

        try {
            $this->assertNotNull($row);
            $this->assertSame('123454', $row->receipt_no);
            $this->assertSame(1200.0, (float) $row->amount_paid);

            $printed = $this->get(route('quick-yatri-print', $row->id))->getContent();
            $this->assertStringContainsString('123454', $printed);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    public function test_a_leading_zero_survives_the_round_trip()
    {
        $this->asAdmin();

        // Why the column is a char(6) string and not an integer: a book that
        // starts at 000001 must keep its zeros.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Receipt Zeros',
            'receipt_no'     => '000123',
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Receipt Zeros')->first();

        try {
            $this->assertNotNull($row);
            $this->assertSame('000123', $row->receipt_no);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    public function test_a_number_that_is_not_six_digits_is_refused_rather_than_padded()
    {
        $this->asAdmin();

        // Guessing that "1234" meant "001234" would invent a receipt nobody
        // wrote. The office is told instead.
        $this->from(route('quick-yatri-create'))
            ->post(route('quick-yatri-store'), [
                'applicant_name' => 'QA Receipt Short',
                'receipt_no'     => '1234',
            ])
            ->assertSessionHasErrors('receipt_no');

        $this->assertNull(QuickYatri::where('applicant_name', 'QA Receipt Short')->first());
    }

    public function test_a_blank_receipt_stores_nothing_at_all()
    {
        $this->asAdmin();

        // Not "000000" and not an empty string — a sheet where no money has
        // been taken yet prints an empty writing line.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Receipt Blank',
            'receipt_no'     => '',
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Receipt Blank')->first();

        try {
            $this->assertNotNull($row);
            $this->assertNull($row->receipt_no);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    public function test_paid_is_the_sum_of_the_parts_and_balance_follows_it()
    {
        $this->asAdmin();
        SiteSetting::put(QuickYatri::PRICE_KEYS['round_trip_land'], 1650);
        SiteSetting::put(QuickYatri::WHEELCHAIR_FEE_KEY, 300);

        // A deposit at an event, an instalment, and the rest nearer departure.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Partial Sum',
            'trip_option'    => 'round_trip_land',
            'amount_paid'    => '$500',   'receipt_no'    => '123454',
            'amount_paid_2'  => '400',    'receipt_no_2'  => '123455',
            'amount_paid_3'  => '250',    'receipt_no_3'  => '123456',
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Partial Sum')->first();

        try {
            $this->assertNotNull($row);
            $this->assertSame(1150.0, $row->paidAmount());
            $this->assertSame(500.0, $row->balanceAmount());

            // And the sheet prints the totals, not three figures to add up.
            $printed = $this->get(route('quick-yatri-print', $row->id))->getContent();
            $this->assertStringContainsString('$1,150', $printed);
            $this->assertStringContainsString('$500', $printed);
            foreach (['123454', '123455', '123456'] as $receipt) {
                $this->assertStringContainsString($receipt, $printed);
            }
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    /**
     * The workflow that was asked for: take a deposit now, come back to the
     * same record later and add the next receipt.
     */
    public function test_a_later_edit_adds_a_second_receipt_without_disturbing_the_first()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name' => 'QA Partial Later',
            'amount_paid'    => 500,
            'receipt_no'     => '123454',
        ]);

        try {
            $this->post(route('quick-yatri-update', $row->id), [
                'applicant_name' => 'QA Partial Later',
                'amount_paid'    => '500', 'receipt_no'   => '123454',
                'amount_paid_2'  => '750', 'receipt_no_2' => '123455',
            ])->assertRedirect(route('quick-yatri'));

            $row->refresh();
            $this->assertSame(500.0, (float) $row->amount_paid);
            $this->assertSame('123454', $row->receipt_no);
            $this->assertSame(750.0, (float) $row->amount_paid_2);
            $this->assertSame('123455', $row->receipt_no_2);
            // Untouched slot 3 stays empty rather than becoming 0.00.
            $this->assertNull($row->amount_paid_3);
            $this->assertNull($row->receipt_no_3);
            $this->assertSame(1250.0, $row->paidAmount());
        } finally {
            $row->delete();
        }
    }

    public function test_a_sheet_with_no_payment_yet_shows_an_empty_paid_line()
    {
        $this->asAdmin();

        // Null, not 0.0 — "$0" reads as "paid nothing" where the office means
        // "not asked yet", and the printed sheet wants a line to write on.
        $row = new QuickYatri(['applicant_name' => 'QA Partial None']);

        $this->assertNull($row->paidAmount());
    }

    public function test_a_bad_receipt_in_the_second_slot_names_that_slot()
    {
        $this->asAdmin();

        $this->from(route('quick-yatri-create'))
            ->post(route('quick-yatri-store'), [
                'applicant_name' => 'QA Partial Bad',
                'amount_paid'    => '500', 'receipt_no'   => '123454',
                'amount_paid_2'  => '750', 'receipt_no_2' => '12345',
            ])
            ->assertSessionHasErrors(['receipt_no_2' => 'Receipt # 2 must be the 6-digit number printed on the receipt, e.g. 123454.']);

        $this->assertNull(QuickYatri::where('applicant_name', 'QA Partial Bad')->first());
    }

    /* ----------------- the check a payment came in on ----------------- */

    /**
     * Check # sits between the tick boxes and the Date, in the space the Date
     * was not using: at 8.6pt a date prints 70.7px on a rule that was 154.
     */
    public function test_the_payment_line_carries_a_check_number_before_the_date()
    {
        $this->asAdmin();

        $body = $this->get(route('quick-yatri-blank'))->getContent();

        $payment = strpos($body, 'Payment:');
        $check   = strpos($body, 'Check #:', $payment);
        $date    = strpos($body, 'Date:', $check);

        $this->assertNotFalse($check, 'The payment line must offer a Check # line.');
        $this->assertNotFalse($date, 'Check # comes before the Date, beside the box it belongs to.');

        // One row, and it stays one row. Both cells hang off the single
        // .qy-payline flex row, and both labels are nowrap — without that the
        // cells squeeze until "Check #:" breaks over two lines and the row
        // grows 14.1px page 1 has not got. (That it *renders* on one line is a
        // measurement, not a string match — see the decisions entry.)
        $this->assertSame(1, substr_count($body, 'class="qy-payline"'));
        $this->assertStringContainsString('white-space:nowrap">Check #:</span>', $body);
        $this->assertStringContainsString('white-space:nowrap">Date:</span>', $body);

        // A writing line in blank mode too — $txt would have rendered a
        // borderless qy-fill here and left nothing to write on.
        $this->assertStringContainsString('<span class="qy-rule qy-caps"></span>', $body);
    }

    public function test_a_check_number_is_stored_and_printed()
    {
        $this->asAdmin();

        // Copied off the check the way a receipt number is copied off a
        // receipt — "#104287" and "104287" are the one check.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Check Test',
            'pay_check'      => 1,
            'check_no'       => '#104287',
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Check Test')->first();

        try {
            $this->assertNotNull($row);
            $this->assertSame('104287', $row->check_no);
            $this->assertTrue($row->pay_check);

            $printed = $this->get(route('quick-yatri-print', $row->id))->getContent();
            $this->assertStringContainsString('104287', $printed);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }

    public function test_a_check_number_is_not_held_to_the_receipt_books_six_digits()
    {
        $this->asAdmin();

        // The receipt book is the office's own and prints six digits; a check
        // is the payer's and carries whatever their bank printed on it.
        $this->post(route('quick-yatri-store'), [
            'applicant_name' => 'QA Check Short',
            'check_no'       => '1042',
        ])->assertRedirect(route('quick-yatri'));

        $row = QuickYatri::where('applicant_name', 'QA Check Short')->first();

        try {
            $this->assertNotNull($row);
            $this->assertSame('1042', $row->check_no);
        } finally {
            if ($row) {
                $row->delete();
            }
        }
    }
}
