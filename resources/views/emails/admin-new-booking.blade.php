@php $d = $data; @endphp
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>New Booking Received</title></head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#1c2541; background:#f6f7f9; margin:0; padding:24px;">
    <div style="max-width:660px; margin:0 auto; background:#fff; border:1px solid #eef0f4; border-radius:12px; overflow:hidden;">
        <div style="background:#16233a; color:#fff; padding:22px 28px;">
            <h2 style="margin:0; font-size:21px;">New Booking Received</h2>
            <p style="margin:6px 0 0; opacity:.85;">Booking ID: <b style="color:#fff;">{{ $d['yatri_id'] ?: 'Pending' }}</b></p>
        </div>

        <div style="padding:24px 28px;">
            <p>A new Yatri booking has been submitted on the website.</p>

            @include('emails.partials.summary', ['d' => $d])

            <h3 style="margin:18px 0 6px; font-size:15px;">Contact</h3>
            <table style="width:100%; border-collapse:collapse;">
                @if(!empty($d['email']))<tr><td style="padding:5px 0; width:190px; color:#5a6273;">Email</td><td style="padding:5px 0;">{{ $d['email'] }}</td></tr>@endif
                @if(!empty($d['phone']))<tr><td style="padding:5px 0; color:#5a6273;">Phone</td><td style="padding:5px 0;">{{ $d['phone'] }}</td></tr>@endif
            </table>

            <p style="margin-top:20px;">
                <a href="https://konnectyatra.org/admin/yatri-visa" style="display:inline-block; background:#f54e18; color:#fff; text-decoration:none; font-weight:bold; padding:11px 22px; border-radius:8px;">Open in Admin Panel</a>
            </p>
        </div>
        <div style="background:#f6f7f9; color:#8a93a6; font-size:11px; padding:14px 28px;">
            KonnectYatra admin notification &middot; sent to {{ \App\Support\BookingMailer::ADMIN_EMAIL }}
        </div>
    </div>
</body>
</html>
