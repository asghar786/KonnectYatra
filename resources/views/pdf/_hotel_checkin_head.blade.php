{{-- The title block of the hotel check-in sheet: logo, the three lines of the
     office's own sheet, and the US flag. The sheet is handed to five-star
     hotel desks, so it announces an American group at a glance — flag,
     "Group from the United States of America", and a red/white/navy band.
     Shared by the list page and the Room Summary page of pdf.hotel_checkin. --}}
@php $flag = public_path('assets2/id/us-flag.png'); @endphp
<table class="head"><tr>
    <td class="logo">@if(is_file($logo))<img src="{{ $logo }}" alt="Konnect.US Inc.">@endif</td>
    <td class="mid">
        <div class="eyebrow">Group Travel &middot; United States of America</div>
        <div class="brand">Konnect Yatra USA</div>
        <div class="title">{{ $sub }}</div>
        @if(App\Support\HotelCheckin::dateLine($list))
            <div class="dates">Check-In Date: {{ App\Support\HotelCheckin::stamp($list['check_in']) }}@if($list['check_out']) to {{ App\Support\HotelCheckin::stamp($list['check_out']) }}@endif
                @if($nights)<span class="n">({{ $nights }} Night{{ $nights > 1 ? 's' : '' }})</span>@endif
            </div>
        @endif
    </td>
    <td class="side">
        @if(is_file($flag))<img src="{{ $flag }}" alt="United States flag"><br>@endif
        <div class="from">Group from the USA</div>
        {{ count($list['rows']) }} yatris &middot; {{ count($rooms) }} rooms<br>
        {{ $count['double'] }} Double &middot; {{ $count['twin'] }} Twin &middot; {{ $count['triple'] }} Triple
    </td>
</tr></table>
<table class="band">
    <tr><td style="background:#b22234"></td></tr>
    <tr><td style="background:#ffffff"></td></tr>
    <tr><td style="background:#b22234"></td></tr>
    <tr><td style="background:#ffffff"></td></tr>
    <tr><td style="background:#16294d; height:3pt"></td></tr>
</table>
<div style="height:6pt"></div>
