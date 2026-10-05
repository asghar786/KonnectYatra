<?php

namespace Tests\Feature;

use App\Models\QuickYatri;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Form 'C' on Quick Yatri (2026-10-05).
 *
 * A yatri travelling on an Indian passport has to carry Pakistan's Temporary
 * Certificate of Registration. The Yatri Bookings flow could already download
 * one; Quick Yatri could not. The button is offered only where the sheet's
 * Citizenship / Nationality box says Indian.
 *
 * DatabaseTransactions because these run against the real local database.
 */
class QuickYatriFormCTest extends TestCase
{
    use DatabaseTransactions;

    private function asAdmin()
    {
        // In-memory only, never persisted — see QuickYatriSheetTest.
        $this->actingAs(new User(['role' => 'admin']));
    }

    public function test_only_an_indian_passport_needs_form_c()
    {
        foreach (['INDIAN', 'India', ' ind '] as $written) {
            $this->assertTrue((new QuickYatri(['citizenship' => $written]))->needsFormC(), $written);
        }
        foreach (['AMERICAN', 'US', 'CANADIAN', '', null] as $written) {
            $this->assertFalse((new QuickYatri(['citizenship' => $written]))->needsFormC(), (string) $written);
        }
    }

    public function test_the_list_offers_form_c_to_the_indian_passport_holder_only()
    {
        $this->asAdmin();

        $indian   = QuickYatri::create(['applicant_name' => 'QA FORMC INDIAN', 'citizenship' => 'INDIAN']);
        $american = QuickYatri::create(['applicant_name' => 'QA FORMC AMERICAN', 'citizenship' => 'AMERICAN']);

        $this->get(route('quick-yatri'))
            ->assertOk()
            ->assertSee(route('quick-yatri-form-c', $indian->id), false)
            ->assertDontSee(route('quick-yatri-form-c', $american->id), false);

        $this->get(route('quick-yatri-edit', $indian->id))
            ->assertOk()
            ->assertSee(route('quick-yatri-form-c', $indian->id), false);

        $this->get(route('quick-yatri-edit', $american->id))
            ->assertOk()
            ->assertDontSee('Download Form C');
    }

    public function test_form_c_downloads_as_a_pdf_named_for_the_yatri()
    {
        $this->asAdmin();

        $row = QuickYatri::create([
            'applicant_name' => 'QA FORMC SINGH',
            'citizenship'    => 'INDIAN',
            'passport_no'    => 'Z1234567',
        ]);

        $response = $this->get(route('quick-yatri-form-c', $row->id));

        $response->assertOk()->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('Form-C-QA-FORMC-SINGH.pdf', $response->headers->get('Content-Disposition'));
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_the_certificate_carries_the_sheets_own_answers()
    {
        // The PDF itself is compressed, so read the template it is made from.
        $html = view('pdf.form_c', ['yatri' => (object) [
            'yatri_id' => 'QY-1', 'first_name' => 'QA FORMC SINGH', 'middle_name' => '', 'last_name' => '',
            'nationality' => 'INDIAN', 'passport_country' => '', 'passport' => 'Z1234567',
            'issuing_authority' => '', 'hotel' => (object) ['name' => 'QA HOTEL', 'address' => ''],
            'gurdwara' => null, 'gurdwara_name' => '', 'city' => '', 'state' => '',
        ]])->render();

        foreach (['QA FORMC SINGH', 'INDIAN', 'Z1234567', 'QA HOTEL'] as $expected) {
            $this->assertStringContainsString($expected, $html);
        }
    }
}
