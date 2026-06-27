{{-- Payment instructions block. Expects $pay (array), $total (int). --}}
@if(!empty($pay['bank_name']) || !empty($pay['bank_account']))
<h4 style="margin:14px 0 4px;">Bank Wire Transfer</h4>
<table style="width:100%; border-collapse:collapse;">
    @if(!empty($pay['bank_name']))<tr><td style="padding:4px 0; width:190px; color:#5a6273;">Bank Name</td><td style="padding:4px 0;">{{ $pay['bank_name'] }}</td></tr>@endif
    @if(!empty($pay['bank_title']))<tr><td style="padding:4px 0; color:#5a6273;">Account Title</td><td style="padding:4px 0;">{{ $pay['bank_title'] }}</td></tr>@endif
    @if(!empty($pay['bank_routing']))<tr><td style="padding:4px 0; color:#5a6273;">Routing Number</td><td style="padding:4px 0;">{{ $pay['bank_routing'] }}</td></tr>@endif
    @if(!empty($pay['bank_account']))<tr><td style="padding:4px 0; color:#5a6273;">Account Number</td><td style="padding:4px 0;">{{ $pay['bank_account'] }}</td></tr>@endif
</table>
@if(!empty($pay['bank_note']))<p style="color:#6b7280; margin:6px 0 0;">{!! nl2br(e($pay['bank_note'])) !!}</p>@endif
@endif

@if(!empty($pay['zelle_phone']) || !empty($pay['zelle_email']))
<h4 style="margin:14px 0 4px;">Zelle</h4>
<table style="width:100%; border-collapse:collapse;">
    @if(!empty($pay['zelle_name']))<tr><td style="padding:4px 0; width:190px; color:#5a6273;">Recipient Name</td><td style="padding:4px 0;">{{ $pay['zelle_name'] }}</td></tr>@endif
    @if(!empty($pay['zelle_phone']))<tr><td style="padding:4px 0; color:#5a6273;">Zelle Phone</td><td style="padding:4px 0;"><b>{{ $pay['zelle_phone'] }}</b></td></tr>@endif
    @if(!empty($pay['zelle_email']))<tr><td style="padding:4px 0; color:#5a6273;">Zelle Email</td><td style="padding:4px 0;">{{ $pay['zelle_email'] }}</td></tr>@endif
</table>
<p style="color:#6b7280; margin:6px 0 0;">Please send <b>$1</b> first to verify, then transfer the balance after confirmation.</p>
@endif

@if(!empty($pay['check_payable_to']) || !empty($pay['check_address']))
<h4 style="margin:14px 0 4px;">Pay by Check</h4>
<table style="width:100%; border-collapse:collapse;">
    @if(!empty($pay['check_payable_to']))<tr><td style="padding:4px 0; width:190px; color:#5a6273;">Make Check Payable To</td><td style="padding:4px 0;">{{ $pay['check_payable_to'] }}</td></tr>@endif
    @if(!empty($pay['check_account']))<tr><td style="padding:4px 0; color:#5a6273;">Account Number</td><td style="padding:4px 0;">{{ $pay['check_account'] }}</td></tr>@endif
    @if(!empty($pay['check_address']))<tr><td style="padding:4px 0; vertical-align:top; color:#5a6273;">Mail To</td><td style="padding:4px 0;">{!! nl2br(e($pay['check_address'])) !!}</td></tr>@endif
</table>
@endif

@if(!empty($pay['cash_address']))
<h4 style="margin:14px 0 4px;">Pay by Cash (Visit Our Office)</h4>
<p style="margin:0;">{!! nl2br(e($pay['cash_address'])) !!}</p>
@if(!empty($pay['cash_note']))<p style="color:#6b7280; margin:6px 0 0;">{!! nl2br(e($pay['cash_note'])) !!}</p>@endif
@endif
