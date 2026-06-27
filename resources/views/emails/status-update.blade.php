@php $d = $data; $forAdmin = $forAdmin ?? false; @endphp
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Booking Status Update</title></head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#1c2541; background:#f6f7f9; margin:0; padding:24px;">
    <div style="max-width:640px; margin:0 auto; background:#fff; border:1px solid #eef0f4; border-radius:12px; overflow:hidden;">
        <div style="background:linear-gradient(135deg,#2d1b69,#5b2a9e); color:#fff; padding:22px 28px;">
            <h2 style="margin:0; font-size:21px;">Booking Update</h2>
            <p style="margin:6px 0 0; opacity:.9;">Booking ID: <b style="color:#fff;">{{ $d['yatri_id'] ?: 'Pending' }}</b></p>
        </div>

        <div style="padding:24px 28px;">
            @if($forAdmin)
            <p>The following status was updated for <b>{{ $d['name'] }}</b>'s booking.</p>
            @else
            <p>Dear {{ $d['name'] }},</p>
            <p>There is an update on your KonnectYatra booking.</p>
            @endif

            <table style="width:100%; border-collapse:collapse; margin:16px 0; background:#f9f7ff; border:1px solid #eef0f4; border-radius:8px;">
                <tr>
                    <td style="padding:14px 16px; width:190px; color:#5a6273;">{{ $d['status_type'] ?? 'Status' }}</td>
                    <td style="padding:14px 16px;">
                        <span style="display:inline-block; background:#f54e18; color:#fff; font-weight:bold; padding:5px 14px; border-radius:20px;">{{ $d['status_value'] ?? '' }}</span>
                    </td>
                </tr>
            </table>

            @if(!empty($d['status_note']))
            <p style="background:#fff4ef; border:1px solid #ffd9c9; border-radius:8px; padding:12px 14px;">{{ $d['status_note'] }}</p>
            @endif

            <h3 style="margin:20px 0 6px; font-size:15px;">Booking Summary</h3>
            <table style="width:100%; border-collapse:collapse;">
                @if(!empty($d['package']))<tr><td style="padding:6px 0; width:190px; color:#5a6273;">Package</td><td style="padding:6px 0;">{{ $d['package'] }}</td></tr>@endif
                <tr><td style="padding:6px 0; color:#5a6273;">People Travelling</td><td style="padding:6px 0;">{{ $d['people'] }}</td></tr>
                <tr><td style="padding:6px 0; color:#5a6273;">Total Amount</td><td style="padding:6px 0; color:#f54e18; font-weight:bold;">${{ number_format($d['total']) }}</td></tr>
                @if(!empty($d['payment_status']))<tr><td style="padding:6px 0; color:#5a6273;">Payment Status</td><td style="padding:6px 0; text-transform:capitalize;">{{ $d['payment_status'] }}</td></tr>@endif
                @if(!empty($d['visa_status']))<tr><td style="padding:6px 0; color:#5a6273;">Visa Status</td><td style="padding:6px 0;">{{ $d['visa_status'] }}</td></tr>@endif
            </table>

            @if($forAdmin)
            <p style="margin-top:18px;">
                <a href="https://konnectyatra.org/admin/yatri-visa" style="display:inline-block; background:#16233a; color:#fff; text-decoration:none; font-weight:bold; padding:10px 20px; border-radius:8px;">Open in Admin Panel</a>
            </p>
            @else
            <p style="margin-top:18px;">For any questions, call <b>+1 (718) 908-9464</b> or visit <a href="https://konnectyatra.org" style="color:#f54e18;">konnectyatra.org</a>.</p>
            <p style="margin:0;">KONNECT.US INC. — Explore and Discover the Globe</p>
            @endif
        </div>
        <div style="background:#f6f7f9; color:#8a93a6; font-size:11px; padding:14px 28px;">
            18502 Hillside Avenue, Jamaica, NY 11432 &middot; +1 (718) 908-9464
        </div>
    </div>
</body>
</html>
