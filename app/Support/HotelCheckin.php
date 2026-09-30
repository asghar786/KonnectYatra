<?php

namespace App\Support;

use App\Models\QuickYatri;
use App\Models\SiteSetting;
use Carbon\Carbon;

/**
 * The two hotel check-in lists of a trip (Islamabad, then Lahore), built from
 * the Quick Yatri applications.
 *
 * Each list is one JSON value in `site_settings` (`hotel_checkin_<key>`), so it
 * needed no migration:
 *
 *   { "hotel": "...", "check_in": "2026-11-20", "check_out": "2026-11-23",
 *     "rows": [ { "id": 12, "join": false, "bed": "double", "hotel_room": "" }, ... ] }
 *
 * `rows` is the printed order. A row with `join` true shares the room of the row
 * above it — that is how a husband and wife (or a family of three) end up in
 * one room — so the Room numbers 1, 1, 2, 2, 3, 3, 3 are worked out from the
 * order and never typed. The bed type and the hotel's own room number belong
 * to the room, and are read from its first row.
 */
class HotelCheckin
{
    /** Defaults are the office's own sheets for the November 2026 trip. */
    const HOTELS = [
        'islamabad' => [
            'city'      => 'Islamabad',
            'hotel'     => 'Best Western Premier Hotel, Islamabad',
            'check_in'  => '2026-11-20',
            'check_out' => '2026-11-23',
        ],
        'lahore' => [
            'city'      => 'Lahore',
            'hotel'     => 'Royal Swiss Hotel, Lahore',
            'check_in'  => '2026-11-23',
            'check_out' => '2026-11-30',
        ],
    ];

    /** Stored key => label, in the order the office's dropdown offers them. */
    const BEDS = [
        'double' => 'Double Bed',
        'twin'   => 'Twin Bed',
        'triple' => 'Triple',
    ];

    public static function has(string $key): bool
    {
        return isset(self::HOTELS[$key]);
    }

    /** The other hotel of the pair — the one a list can be copied from. */
    public static function other(string $key): string
    {
        return $key === 'islamabad' ? 'lahore' : 'islamabad';
    }

    /** The raw saved list, or null if this hotel has never been saved. */
    public static function stored(string $key): ?array
    {
        $raw  = SiteSetting::get('hotel_checkin_' . $key);
        $data = $raw ? json_decode($raw, true) : null;

        return is_array($data) ? $data : null;
    }

    public static function put(string $key, array $data): void
    {
        SiteSetting::put('hotel_checkin_' . $key, json_encode($data));
    }

    public static function forget(string $key): void
    {
        SiteSetting::where('key', 'hotel_checkin_' . $key)->delete();
        \Illuminate\Support\Facades\Cache::forget('site_settings_all');
    }

    /**
     * Everything a page or the PDF needs for one hotel: the header fields, the
     * resolved rows (each with its QuickYatri and room number), and the
     * applications not on this list.
     *
     * A hotel never saved starts as a copy of the other hotel's list if that
     * one is saved (the two lists are nearly always the same people in the same
     * rooms), otherwise as every application, oldest first — the same order the
     * Quick Yatri list opens on.
     */
    public static function load(string $key): array
    {
        $defaults = self::HOTELS[$key];
        $data     = self::stored($key);
        $saved    = $data !== null;

        if (!$saved) {
            $from = self::stored(self::other($key));
            $data = [
                'rows' => $from ? self::copyRows($from['rows'] ?? []) : null,
            ];
        }

        $yatris = QuickYatri::orderBy('created_at', 'asc')->orderBy('id', 'asc')->get()->keyBy('id');

        $rowsIn = $data['rows'] ?? null;
        if ($rowsIn === null) {
            $rowsIn = $yatris->keys()->map(function ($id) {
                return ['id' => $id, 'join' => false, 'bed' => '', 'hotel_room' => ''];
            })->all();
        }

        // Resolve against the applications that still exist; a deleted one
        // simply drops out of the list.
        $rows   = [];
        $listed = [];
        foreach ($rowsIn as $r) {
            $id = (int) ($r['id'] ?? 0);
            if (!$yatris->has($id) || isset($listed[$id])) {
                continue;
            }
            $listed[$id] = true;
            $rows[] = [
                'id'         => $id,
                'yatri'      => $yatris[$id],
                'join'       => !empty($r['join']) && count($rows) > 0,
                'bed'        => isset(self::BEDS[$r['bed'] ?? '']) ? $r['bed'] : '',
                'hotel_room' => (string) ($r['hotel_room'] ?? ''),
            ];
        }

        return [
            'key'       => $key,
            'city'      => $defaults['city'],
            'hotel'     => ($data['hotel'] ?? '') !== '' ? $data['hotel'] : $defaults['hotel'],
            'check_in'  => $data['check_in'] ?? $defaults['check_in'],
            'check_out' => $data['check_out'] ?? $defaults['check_out'],
            'saved'     => $saved,
            'rows'      => self::numberRooms($rows),
            'unlisted'  => $yatris->reject(function ($y) use ($listed) {
                return isset($listed[$y->id]);
            })->values(),
        ];
    }

    /**
     * Give every row its room number and carry the room's bed type and hotel
     * room number (held on the room's first row) onto each occupant. A room of
     * three with no bed chosen reads Triple — there is no other way to sleep
     * three.
     */
    public static function numberRooms(array $rows): array
    {
        $room  = 0;
        $first = null;
        foreach ($rows as $i => &$row) {
            if (!$row['join'] || $first === null) {
                $room++;
                $first = $i;
            }
            $row['room']       = $room;
            $row['room_first'] = $first === $i;
        }
        unset($row);

        // Room sizes, then the per-room values.
        $sizes = [];
        foreach ($rows as $row) {
            $sizes[$row['room']] = ($sizes[$row['room']] ?? 0) + 1;
        }
        $lead = [];
        foreach ($rows as $row) {
            if ($row['room_first']) {
                $bed = $row['bed'] ?: ($sizes[$row['room']] >= 3 ? 'triple' : '');
                $lead[$row['room']] = ['bed' => $bed, 'hotel_room' => $row['hotel_room']];
            }
        }
        foreach ($rows as &$row) {
            $row['room_size']  = $sizes[$row['room']];
            $row['bed']        = $lead[$row['room']]['bed'];
            $row['hotel_room'] = $lead[$row['room']]['hotel_room'];
        }
        unset($row);

        return $rows;
    }

    /** Order, rooms and beds carry over; the hotel's own room numbers do not. */
    public static function copyRows(array $rows): array
    {
        return array_map(function ($r) {
            return [
                'id'         => (int) ($r['id'] ?? 0),
                'join'       => !empty($r['join']),
                'bed'        => $r['bed'] ?? '',
                'hotel_room' => '',
            ];
        }, $rows);
    }

    /** "Double Bed" on screen; the printed sheet uses the short word. */
    public static function bedShort(string $bed): string
    {
        return ['double' => 'Double', 'twin' => 'Twin', 'triple' => 'Triple'][$bed] ?? '';
    }

    /**
     * The sheet's nationality column reads US / IND. Quick Yatri stores
     * whatever was written on the paper ("USA", "American", "INDIAN"), so the
     * common spellings are folded to the code and anything else prints as
     * written.
     */
    public static function nationality(?string $raw): string
    {
        $v = strtoupper(trim((string) $raw));
        $map = [
            'US' => 'US', 'USA' => 'US', 'U.S.' => 'US', 'U.S.A.' => 'US', 'U.S.A' => 'US', 'AMERICAN' => 'US',
            'UNITED STATES' => 'US', 'UNITED STATES OF AMERICA' => 'US',
            'IND' => 'IND', 'INDIA' => 'IND', 'INDIAN' => 'IND',
            'CAN' => 'CAN', 'CANADA' => 'CAN', 'CANADIAN' => 'CAN',
            'UK' => 'UK', 'BRITISH' => 'UK', 'UNITED KINGDOM' => 'UK',
        ];

        return $map[$v] ?? $v;
    }

    /** "20-NOV-2026" from a stored Y-m-d, or '' when unset. */
    public static function stamp(?string $ymd): string
    {
        return $ymd ? YatriDate::format($ymd) : '';
    }

    public static function nights(?string $in, ?string $out): ?int
    {
        if (!$in || !$out) {
            return null;
        }
        try {
            $n = Carbon::parse($in)->diffInDays(Carbon::parse($out), false);
        } catch (\Throwable $e) {
            return null;
        }

        return $n > 0 ? $n : null;
    }

    /** The printed date line: "20-NOV-2026 to 23-NOV-2026 (3 Nights)". */
    public static function dateLine(array $list): string
    {
        $in  = self::stamp($list['check_in']);
        $out = self::stamp($list['check_out']);
        $n   = self::nights($list['check_in'], $list['check_out']);

        if (!$in) {
            return '';
        }

        return $in . ($out ? ' to ' . $out : '') . ($n ? ' (' . $n . ' Night' . ($n > 1 ? 's' : '') . ')' : '');
    }
}
