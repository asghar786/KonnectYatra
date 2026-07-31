@php $d = $data; @endphp
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>New Gurdwara Info Request</title></head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#1c2541; background:#f6f7f9; margin:0; padding:24px;">
    <div style="max-width:600px; margin:0 auto; background:#fff; border:1px solid #eef0f4; border-radius:12px; overflow:hidden;">
        <div style="background:#16233a; color:#fff; padding:22px 28px;">
            <h2 style="margin:0; font-size:21px;">New Gurdwara Info Request</h2>
            <p style="margin:6px 0 0; opacity:.85;">Submitted from the KonnectYatra homepage popup</p>
        </div>

        <div style="padding:24px 28px;">
            <table style="width:100%; border-collapse:collapse;">
                <tr><td style="padding:8px 0; width:170px; color:#5a6273;">Name</td><td style="padding:8px 0; font-weight:bold;">{{ trim($d['first_name'].' '.$d['last_name']) }}</td></tr>
                <tr><td style="padding:8px 0; color:#5a6273;">Phone</td><td style="padding:8px 0;"><a href="tel:{{ $d['phone'] }}" style="color:#1c2541; text-decoration:none;">{{ $d['phone'] }}</a></td></tr>
                <tr><td style="padding:8px 0; color:#5a6273;">City</td><td style="padding:8px 0;">{{ $d['city'] }}</td></tr>
                <tr><td style="padding:8px 0; color:#5a6273;">State</td><td style="padding:8px 0;">{{ $d['state'] }}</td></tr>
                <tr><td style="padding:8px 0; color:#5a6273;">Zip Code</td><td style="padding:8px 0;">{{ $d['zip_code'] }}</td></tr>
                <tr><td style="padding:8px 0; color:#5a6273;">Nearest Gurdwara Sahib</td><td style="padding:8px 0; font-weight:bold;">{{ $d['near_gurdwara'] }}</td></tr>
                <tr><td style="padding:8px 0; color:#5a6273;">How they heard about us</td><td style="padding:8px 0;">{{ $d['heard_from'] ?? '—' }}</td></tr>
            </table>

            <p style="margin-top:20px;">
                <a href="https://konnectyatra.org/admin/gurdwara-leads" style="display:inline-block; background:#f54e18; color:#fff; text-decoration:none; font-weight:bold; padding:11px 22px; border-radius:8px;">View in Admin Panel</a>
            </p>
        </div>
        <div style="background:#f6f7f9; color:#8a93a6; font-size:11px; padding:14px 28px;">
            KonnectYatra website notification &middot; sent to {{ \App\Support\BookingMailer::ADMIN_EMAIL }}
        </div>
    </div>
</body>
</html>
