<?php

namespace App\Support;

use App\Mail\AdminBookingNotificationMail;
use App\Mail\BookingConfirmationMail;
use App\Mail\StatusUpdateMail;
use App\Models\YatriVisa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Centralises all booking-related notifications so the public booking flow and
 * the admin panel send identical, well-formatted emails. All sends are wrapped
 * in try/catch — a mail failure must never break the booking/update request.
 */
class BookingMailer
{
    /** Office address that receives every booking + status notification. */
    const ADMIN_EMAIL = 'rm@konnectyatra.org';

    /**
     * New booking completed at the payment step:
     *  - confirmation (with payment info) to the traveller's primary email
     *  - "new submission received" to the admin office.
     */
    public static function sendNewBooking(YatriVisa $yatri, $amount = null, bool $isPayLater = false, ?string $validUntil = null, array $pay = []): void
    {
        try {
            $d = self::bookingData($yatri, $amount, $isPayLater, $validUntil, $pay);

            if (!empty($yatri->email)) {
                Mail::to($yatri->email)->send(new BookingConfirmationMail($d));
            }
            Mail::to(self::ADMIN_EMAIL)->send(new AdminBookingNotificationMail($d));
        } catch (\Throwable $e) {
            Log::error('Booking confirmation email failed: ' . $e->getMessage());
        }
    }

    /**
     * A status changed in the admin panel (Payment Status / Visa Status):
     * notify the traveller and send a copy to the admin office.
     */
    public static function sendStatusUpdate(YatriVisa $yatri, string $type, string $newValue, ?string $note = null): void
    {
        try {
            $base = self::bookingData($yatri, null, false, null, []);
            $base['status_type']  = $type;       // e.g. "Visa Status" / "Payment Status"
            $base['status_value'] = $newValue;   // e.g. "Approved" / "Paid"
            $base['status_note']  = $note;

            if (!empty($yatri->email)) {
                Mail::to($yatri->email)->send(new StatusUpdateMail($base, false));
            }
            Mail::to(self::ADMIN_EMAIL)->send(new StatusUpdateMail($base, true));
        } catch (\Throwable $e) {
            Log::error('Status update email failed: ' . $e->getMessage());
        }
    }

    /** Build the shared data array used by every booking email. */
    public static function bookingData(YatriVisa $yatri, $amount, bool $isPayLater, ?string $validUntil, array $pay): array
    {
        $yatri->loadMissing('package', 'companions');

        $unit   = (int) preg_replace('/[^0-9]/', '', (string) $yatri->package_type);
        $people = max(1, (int) $yatri->travellers_count);
        $total  = $amount !== null && $amount !== ''
            ? (int) preg_replace('/[^0-9]/', '', (string) $amount)
            : ($yatri->total_amount > 0 ? (int) round($yatri->total_amount) : $unit * $people);

        $companions = $yatri->companions->map(function ($c) {
            return [
                'relation'    => $c->relation,
                'name'        => $c->full_name,
                'nationality' => $c->nationality,
                'passport_no' => $c->passport_no,
            ];
        })->all();

        return [
            'yatri_id'       => $yatri->yatri_id,
            'name'           => trim($yatri->first_name . ' ' . $yatri->last_name) ?: 'Yatri',
            'email'          => $yatri->email,
            'phone'          => $yatri->phone,
            'package'        => optional($yatri->package)->name,
            'ticket_type'    => $yatri->ticket_type,
            'unit_price'     => $unit,
            'people'         => $people,
            'total'          => $total,
            'payment_type'   => $yatri->payment_type,
            'payment_status' => $yatri->payment_status,
            'visa_status'    => $yatri->visa_status,
            'companions'     => $companions,
            'is_pay_later'   => $isPayLater,
            'valid_until'    => $validUntil,
            'pay'            => $pay,
            'submitted_at'   => optional($yatri->created_at)->format('d M, Y'),
        ];
    }
}
