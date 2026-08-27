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
}
