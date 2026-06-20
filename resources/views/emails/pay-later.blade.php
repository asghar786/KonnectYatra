<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Payment Instructions</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#1c2541; background:#f6f7f9; margin:0; padding:24px;">
    <div style="max-width:640px; margin:0 auto; background:#fff; border:1px solid #eef0f4; border-radius:12px; overflow:hidden;">
        <div style="background:linear-gradient(135deg,#2d1b69,#5b2a9e); color:#fff; padding:24px 28px;">
            <h2 style="margin:0; font-size:22px;">Konnect Yatra — Booking Confirmation</h2>
            <p style="margin:6px 0 0; opacity:.9;">Wahe Guru Ji ka Khalsa, Wahe Guru Ji ki Fateh</p>
        </div>

        <div style="padding:24px 28px;">
            <p>Dear {{ $data['name'] ?: 'Yatri' }},</p>
            <p>Thank you for your booking. Your order has been received with <b>Pay Later</b> selected.</p>

            <table style="width:100%; border-collapse:collapse; margin:18px 0;">
                <tr><td style="padding:8px 0; width:180px;"><b>Order Number</b></td><td style="padding:8px 0;">{{ $data['order_no'] }}</td></tr>
                @if(!empty($data['package']))<tr><td style="padding:8px 0;"><b>Package</b></td><td style="padding:8px 0;">{{ $data['package'] }}</td></tr>@endif
                @if(!empty($data['ticket_type']))<tr><td style="padding:8px 0;"><b>Ticket Type</b></td><td style="padding:8px 0;">{{ ucwords(str_replace('_',' ',$data['ticket_type'])) }}</td></tr>@endif
                <tr><td style="padding:8px 0;"><b>Amount Due</b></td><td style="padding:8px 0; color:#f54e18; font-weight:bold;">${{ number_format((int) $data['amount']) }}</td></tr>
                <tr><td style="padding:8px 0;"><b>Pay Before</b></td><td style="padding:8px 0;">{{ $data['valid_until'] }} (valid 30 days)</td></tr>
            </table>

            <p style="background:#fff4ef; border:1px solid #ffd9c9; border-radius:8px; padding:12px 14px;">
                Please complete your payment within <b>30 days</b> (by <b>{{ $data['valid_until'] }}</b>), otherwise your booking may be cancelled.
            </p>

            <h3 style="margin:22px 0 8px;">How to Pay</h3>
            @php $pay = $data['pay'] ?? []; @endphp

            @if(!empty($pay['bank_name']) || !empty($pay['bank_account']))
            <h4 style="margin:14px 0 4px;">Bank Wire Transfer</h4>
            <table style="width:100%; border-collapse:collapse;">
                @if(!empty($pay['bank_name']))<tr><td style="padding:4px 0; width:180px;">Bank Name</td><td style="padding:4px 0;">{{ $pay['bank_name'] }}</td></tr>@endif
                @if(!empty($pay['bank_title']))<tr><td style="padding:4px 0;">Account Title</td><td style="padding:4px 0;">{{ $pay['bank_title'] }}</td></tr>@endif
                @if(!empty($pay['bank_routing']))<tr><td style="padding:4px 0;">Routing Number</td><td style="padding:4px 0;">{{ $pay['bank_routing'] }}</td></tr>@endif
                @if(!empty($pay['bank_account']))<tr><td style="padding:4px 0;">Account Number</td><td style="padding:4px 0;">{{ $pay['bank_account'] }}</td></tr>@endif
            </table>
            @if(!empty($pay['bank_note']))<p style="color:#6b7280;">{!! nl2br(e($pay['bank_note'])) !!}</p>@endif
            @endif

            @if(!empty($pay['check_payable_to']) || !empty($pay['check_address']))
            <h4 style="margin:14px 0 4px;">Pay by Check</h4>
            <table style="width:100%; border-collapse:collapse;">
                @if(!empty($pay['check_payable_to']))<tr><td style="padding:4px 0; width:180px;">Make Check Payable To</td><td style="padding:4px 0;">{{ $pay['check_payable_to'] }}</td></tr>@endif
                @if(!empty($pay['check_account']))<tr><td style="padding:4px 0;">Account Number</td><td style="padding:4px 0;">{{ $pay['check_account'] }}</td></tr>@endif
                @if(!empty($pay['check_address']))<tr><td style="padding:4px 0; vertical-align:top;">Mail To</td><td style="padding:4px 0;">{!! nl2br(e($pay['check_address'])) !!}</td></tr>@endif
            </table>
            @endif

            @if(!empty($pay['cash_address']))
            <h4 style="margin:14px 0 4px;">Pay by Cash (Visit Our Office)</h4>
            <p style="margin:0;">{!! nl2br(e($pay['cash_address'])) !!}</p>
            @if(!empty($pay['cash_note']))<p style="color:#6b7280;">{!! nl2br(e($pay['cash_note'])) !!}</p>@endif
            @endif

            <p style="margin-top:22px;">For any questions, call us at <b>(718) 908-9464</b> or visit <a href="https://konnectyatra.org">konnectyatra.org</a>.</p>
            <p style="margin:0;">Konnect.us, Inc.</p>
        </div>
    </div>
</body>
</html>
