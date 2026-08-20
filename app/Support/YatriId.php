<?php

namespace App\Support;

use App\Models\YatriVisa;

/**
 * Allocates the booking reference shown to yatris and staff: KY-RT-001.
 *
 * The trip code is part of the reference because it is the first thing anyone
 * asks about a booking, so a round trip and a one-way run in separate series.
 * Bookings arrive from three places — the public apply form, the logged-in user
 * form and (since 2026-08-20) an admin typing in a paper application — and all
 * three must draw from the same series, which is why this does not live in a
 * controller.
 */
class YatriId
{
    /** Next free reference for a ticket type, e.g. KY-RT-001. */
    public static function generate(?string $ticketType = null): string
    {
        $code = self::tripCode($ticketType);
        $seq  = YatriVisa::where('yatri_id', 'like', 'KY-' . $code . '-%')->count() + 1;

        do {
            $id = 'KY-' . $code . '-' . str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
            $seq++;
        } while (YatriVisa::where('yatri_id', $id)->exists());

        return $id;
    }

    /** Map a raw ticket_type to a short trip code: RT / OW / LT. */
    public static function tripCode(?string $ticketType): string
    {
        switch ($ticketType) {
            case 'one_way':      return 'OW'; // One Way
            case 'land_package': return 'LT'; // Land Travel/Trip
            default:             return 'RT'; // round_way / round_trip → Return Trip
        }
    }
}
