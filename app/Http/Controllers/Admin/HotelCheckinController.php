<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HotelCheckin;
use App\Support\YatriDate;
use Illuminate\Http\Request;

/**
 * Hotel Check-In lists — one per hotel of the trip (Islamabad, then Lahore),
 * arranged from the Quick Yatri applications and printed as the sheet the
 * hotel desk and the staff fill in at check-in. See App\Support\HotelCheckin
 * for how a list is stored and how rooms are worked out.
 */
class HotelCheckinController extends Controller
{
    public function show($hotel = 'islamabad')
    {
        abort_unless(HotelCheckin::has($hotel), 404);

        return view('admin.hotel-checkin.index', [
            'list'   => HotelCheckin::load($hotel),
            'hotels' => HotelCheckin::HOTELS,
            'beds'   => HotelCheckin::BEDS,
            'other'  => HotelCheckin::other($hotel),
            'otherSaved' => HotelCheckin::stored(HotelCheckin::other($hotel)) !== null,
        ]);
    }

    /**
     * One form carries the whole list in its on-screen order, plus any ticked
     * applications to add at the foot. "Save & Download PDF" saves first, so
     * the sheet always prints what the screen shows.
     */
    public function save(Request $request, $hotel)
    {
        abort_unless(HotelCheckin::has($hotel), 404);

        $request->validate([
            'hotel'            => 'nullable|string|max:120',
            'check_in'         => 'nullable|string|max:30',
            'check_out'        => 'nullable|string|max:30',
            'rows'             => 'array',
            'rows.*.id'        => 'required|integer',
            'rows.*.hotel_room'=> 'nullable|string|max:20',
            'add'              => 'array',
            'add.*'            => 'integer',
        ]);

        $checkIn  = $this->ymd($request->input('check_in'));
        $checkOut = $this->ymd($request->input('check_out'));
        if ($request->filled('check_in') && !$checkIn) {
            return back()->withErrors(['check_in' => 'Check-in date not recognised — type it like 20-NOV-2026.']);
        }
        if ($request->filled('check_out') && !$checkOut) {
            return back()->withErrors(['check_out' => 'Check-out date not recognised — type it like 23-NOV-2026.']);
        }

        $rows = [];
        $seen = [];
        foreach ((array) $request->input('rows', []) as $r) {
            $id = (int) ($r['id'] ?? 0);
            if (!$id || isset($seen[$id])) {
                continue;
            }
            $seen[$id] = true;
            $bed = (string) ($r['bed'] ?? '');
            $rows[] = [
                'id'         => $id,
                'join'       => !empty($r['join']) && count($rows) > 0,
                'bed'        => isset(HotelCheckin::BEDS[$bed]) ? $bed : '',
                'hotel_room' => trim((string) ($r['hotel_room'] ?? '')),
            ];
        }
        foreach ((array) $request->input('add', []) as $id) {
            $id = (int) $id;
            if ($id && !isset($seen[$id])) {
                $seen[$id] = true;
                $rows[] = ['id' => $id, 'join' => false, 'bed' => '', 'hotel_room' => ''];
            }
        }

        HotelCheckin::put($hotel, [
            'hotel'     => trim((string) $request->input('hotel')),
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'rows'      => $rows,
        ]);

        if ($request->input('then') === 'pdf') {
            return $this->pdf($hotel);
        }

        return redirect()->route('hotel-checkin', $hotel)->with('success', HotelCheckin::HOTELS[$hotel]['city'] . ' check-in list saved.');
    }

    /** Take the other hotel's order, rooms and beds. Hotel room numbers are not copied. */
    public function copy($hotel)
    {
        abort_unless(HotelCheckin::has($hotel), 404);

        $from = HotelCheckin::stored(HotelCheckin::other($hotel));
        if (!$from) {
            return back()->with('error', 'Save the ' . HotelCheckin::HOTELS[HotelCheckin::other($hotel)]['city'] . ' list first.');
        }

        $mine = HotelCheckin::stored($hotel) ?? [];
        $mine['rows'] = HotelCheckin::copyRows($from['rows'] ?? []);
        HotelCheckin::put($hotel, $mine);

        return redirect()->route('hotel-checkin', $hotel)->with('success', 'Copied the ' . HotelCheckin::HOTELS[HotelCheckin::other($hotel)]['city'] . ' order and rooms. Check the list and save.');
    }

    /** Forget this hotel's list — for the next trip. The applications are untouched. */
    public function reset($hotel)
    {
        abort_unless(HotelCheckin::has($hotel), 404);
        HotelCheckin::forget($hotel);

        return redirect()->route('hotel-checkin', $hotel)->with('success', 'The ' . HotelCheckin::HOTELS[$hotel]['city'] . ' list has been reset.');
    }

    /**
     * The printable sheet. A plain table, so dompdf lays it out as-is (unlike
     * the Quick Yatri sheet, which is flex/grid and prints from the browser).
     */
    public function pdf($hotel)
    {
        abort_unless(HotelCheckin::has($hotel), 404);
        $list = HotelCheckin::load($hotel);

        $pdf = \PDF::loadView('pdf.hotel_checkin', ['list' => $list])->setPaper('letter', 'landscape');

        return $pdf->download($list['city'] . ' Hotel Check-In List.pdf');
    }

    /** DD-MMM-YYYY (or any YatriDate spelling) -> Y-m-d; null if blank or not a real day. */
    private function ymd($raw): ?string
    {
        $raw = trim((string) $raw);
        if ($raw === '') {
            return null;
        }
        $date   = \DateTime::createFromFormat('!d-M-Y', YatriDate::format($raw));
        $errors = \DateTime::getLastErrors();
        if (!$date || (is_array($errors) && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            return null;
        }

        return $date->format('Y-m-d');
    }
}
