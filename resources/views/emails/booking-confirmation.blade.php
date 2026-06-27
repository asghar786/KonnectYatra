@php $d = $data; @endphp
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Booking Confirmation</title></head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#1c2541; background:#f6f7f9; margin:0; padding:24px;">
    <div style="max-width:660px; margin:0 auto; background:#fff; border:1px solid #eef0f4; border-radius:12px; overflow:hidden;">
        <div style="background:linear-gradient(135deg,#2d1b69,#5b2a9e); color:#fff; padding:24px 28px;">
            <h2 style="margin:0; font-size:22px;">KonnectYatra — Booking Confirmation</h2>
            <p style="margin:6px 0 0; opacity:.9;">Wahe Guru Ji ka Khalsa, Wahe Guru Ji ki Fateh</p>
        </div>

        <div style="padding:24px 28px;">
            <p>Dear {{ $d['name'] }},</p>
            <p>Thank you for booking your holy journey with KonnectYatra. We have received your submission and the details are confirmed below.</p>

            @include('emails.partials.summary', ['d' => $d])

            @if($d['is_pay_later'])
            <p style="background:#fff4ef; border:1px solid #ffd9c9; border-radius:8px; padding:12px 14px;">
                You chose <b>Pay Later</b>. Please complete your payment of
                <b style="color:#f54e18;">${{ number_format($d['total']) }}</b>
                @if(!empty($d['valid_until'])) within <b>30 days</b> (by <b>{{ $d['valid_until'] }}</b>), @endif
                otherwise your booking may be cancelled.
            </p>
            @elseif(strtolower((string) $d['payment_status']) === 'paid')
            <p style="background:#e7f8ec; border:1px solid #b8e6c6; border-radius:8px; padding:12px 14px;">
                We have recorded your payment of <b>${{ number_format($d['total']) }}</b> via <b>{{ $d['payment_type'] }}</b>. Thank you!
            </p>
            @endif

            <h3 style="margin:22px 0 8px;">Payment Information</h3>
            <p style="margin:0 0 8px; color:#6b7280;">Please send <b>$1</b> first to verify the account, then transfer the balance after confirmation.</p>
            @include('emails.partials.payment-info', ['pay' => $d['pay'] ?? [], 'total' => $d['total']])

            <p style="margin-top:22px;"><b>What happens next?</b> Our team will review your application and documents, then contact you with your visa processing and travel updates.</p>
            <p style="margin-top:18px;">For any questions, call <b>+1 (718) 908-9464</b> or visit <a href="https://konnectyatra.org" style="color:#f54e18;">konnectyatra.org</a>.</p>
            <p style="margin:0;">KONNECT.US INC. — Explore and Discover the Globe</p>
        </div>
        <div style="background:#f6f7f9; color:#8a93a6; font-size:11px; padding:14px 28px;">
            18502 Hillside Avenue, Jamaica, NY 11432 &middot; +1 (718) 908-9464
        </div>
    </div>
</body>
</html>
