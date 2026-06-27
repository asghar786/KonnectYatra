{{-- Shared booking summary block. Expects $d (array from BookingMailer::bookingData). --}}
<table style="width:100%; border-collapse:collapse; margin:16px 0;">
    <tr><td style="padding:7px 0; width:190px; color:#5a6273;">Booking ID</td><td style="padding:7px 0; font-weight:bold;">{{ $d['yatri_id'] ?: 'Pending' }}</td></tr>
    <tr><td style="padding:7px 0; color:#5a6273;">Lead Traveller</td><td style="padding:7px 0;">{{ $d['name'] }}</td></tr>
    @if(!empty($d['package']))<tr><td style="padding:7px 0; color:#5a6273;">Package</td><td style="padding:7px 0;">{{ $d['package'] }}</td></tr>@endif
    @if(!empty($d['ticket_type']))<tr><td style="padding:7px 0; color:#5a6273;">Ticket Type</td><td style="padding:7px 0;">{{ ucwords(str_replace('_',' ', $d['ticket_type'])) }}</td></tr>@endif
    @if(!empty($d['submitted_at']))<tr><td style="padding:7px 0; color:#5a6273;">Submitted On</td><td style="padding:7px 0;">{{ $d['submitted_at'] }}</td></tr>@endif
    <tr><td style="padding:7px 0; color:#5a6273;">People Travelling</td><td style="padding:7px 0;">{{ $d['people'] }}</td></tr>
    @if($d['people'] > 1)
    <tr><td style="padding:7px 0; color:#5a6273;">Price / Person</td><td style="padding:7px 0;">${{ number_format($d['unit_price']) }}</td></tr>
    @endif
    <tr><td style="padding:7px 0; color:#5a6273;">Total Amount</td><td style="padding:7px 0; color:#f54e18; font-weight:bold; font-size:18px;">${{ number_format($d['total']) }}</td></tr>
    @if(!empty($d['payment_type']))<tr><td style="padding:7px 0; color:#5a6273;">Payment Method</td><td style="padding:7px 0;">{{ $d['payment_type'] }}</td></tr>@endif
    @if(!empty($d['payment_status']))<tr><td style="padding:7px 0; color:#5a6273;">Payment Status</td><td style="padding:7px 0; text-transform:capitalize;">{{ $d['payment_status'] }}</td></tr>@endif
</table>

@if(!empty($d['companions']))
<h3 style="margin:18px 0 6px; font-size:15px;">Travelling Companions <span style="font-size:12px; color:#8a5a22; background:#fff4ef; border:1px solid #ffd9c9; border-radius:10px; padding:2px 8px;">Keep together for hotel rooms</span></h3>
<table style="width:100%; border-collapse:collapse; font-size:13px;">
    <tr style="background:#faf7ff;">
        <th align="left" style="padding:6px 8px; border:1px solid #eef0f4;">#</th>
        <th align="left" style="padding:6px 8px; border:1px solid #eef0f4;">Relation</th>
        <th align="left" style="padding:6px 8px; border:1px solid #eef0f4;">Full Name</th>
        <th align="left" style="padding:6px 8px; border:1px solid #eef0f4;">Nationality</th>
    </tr>
    <tr>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">1</td>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">Lead Traveller</td>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">{{ $d['name'] }}</td>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">&mdash;</td>
    </tr>
    @foreach($d['companions'] as $i => $c)
    <tr>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">{{ $i + 2 }}</td>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">{{ $c['relation'] ?: '—' }}</td>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">{{ $c['name'] ?: '—' }}</td>
        <td style="padding:6px 8px; border:1px solid #eef0f4;">{{ $c['nationality'] ?: '—' }}</td>
    </tr>
    @endforeach
</table>
@endif
