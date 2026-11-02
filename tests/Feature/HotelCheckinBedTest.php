<?php

namespace Tests\Feature;

use App\Models\QuickYatri;
use App\Models\User;
use App\Support\HotelCheckin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Bed types on the hotel check-in lists — Single Room added 2026-11-02.
 *
 * DatabaseTransactions: runs on the real local database, and the
 * `hotel_checkin_lahore` setting written here must not outlive the run.
 */
class HotelCheckinBedTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_room_can_be_saved_as_single_and_prints_as_single()
    {
        $this->actingAs(new User(['role' => 'admin']));
        $y = QuickYatri::create(['applicant_name' => 'QA SINGLE ROOM', 'citizenship' => 'US', 'passport_no' => 'A11111111']);

        $this->get(route('hotel-checkin', 'lahore'))->assertOk()->assertSee('Single Room');

        $this->post(route('hotel-checkin-save', 'lahore'), [
            'hotel' => 'QA Hotel',
            'rows'  => [['id' => $y->id, 'join' => 0, 'bed' => 'single', 'hotel_room' => '']],
        ])->assertRedirect(route('hotel-checkin', 'lahore'));

        $row = HotelCheckin::load('lahore')['rows'][0];
        $this->assertSame('single', $row['bed']);
        $this->assertSame('Single', HotelCheckin::bedShort($row['bed']));

        $this->get(route('hotel-checkin-pdf', 'lahore'))->assertOk()->assertHeader('content-type', 'application/pdf');
    }

    public function test_an_unknown_bed_type_is_not_stored()
    {
        $this->actingAs(new User(['role' => 'admin']));
        $y = QuickYatri::create(['applicant_name' => 'QA ODD BED']);

        $this->post(route('hotel-checkin-save', 'lahore'), [
            'rows' => [['id' => $y->id, 'bed' => 'quad']],
        ]);

        $this->assertSame('', HotelCheckin::stored('lahore')['rows'][0]['bed']);
    }
}
