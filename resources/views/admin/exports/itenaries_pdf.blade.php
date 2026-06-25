<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    * { font-family: DejaVu Sans, sans-serif; }
    body { margin: 0; color: #1c2b4a; font-size: 9px; }
    .head { width: 100%; border-bottom: 3px solid #1c2b4a; padding-bottom: 8px; margin-bottom: 4px; }
    .head td { vertical-align: middle; }
    .head .logo { height: 46px; }
    .head .title { text-align: right; }
    .head .title h1 { margin: 0; font-size: 18px; color: #1c2b4a; letter-spacing: .5px; }
    .head .title .sub { font-size: 9px; color: #e8721e; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    .head .title .meta { font-size: 8.5px; color: #5b626f; margin-top: 2px; }
    table.data { width: 100%; border-collapse: collapse; margin-top: 6px; }
    table.data th { background: #1c2b4a; color: #fff; font-size: 8px; text-transform: uppercase; letter-spacing: .4px; padding: 6px 5px; text-align: left; }
    table.data td { padding: 5px 5px; border-bottom: 1px solid #e4e8f0; font-size: 8.5px; vertical-align: top; }
    table.data tr:nth-child(even) td { background: #f7f8fb; }
    .muted { color: #98a2b5; }
    .name { font-weight: bold; color: #1c2b4a; }
    .route b { color: #e8721e; }
    .foot { position: fixed; bottom: 0; left: 0; right: 0; font-size: 7.5px; color: #98a2b5; border-top: 1px solid #e4e8f0; padding-top: 5px; }
    .foot .tag { color: #e8721e; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
</style>
</head>
<body>
    <table class="head">
        <tr>
            <td>
                @if(file_exists(public_path('assets2/konnect-logo.png')))
                <img class="logo" src="{{ public_path('assets2/konnect-logo.png') }}" alt="">
                @else
                <h1 style="margin:0;">KONNECT.US INC.</h1>
                @endif
            </td>
            <td class="title">
                <div class="sub">Airline / Itinerary Enquiries</div>
                <h1>Itinerary Requests</h1>
                <div class="meta">Generated {{ $generatedAt->format('d M Y, h:i A') }} &nbsp;·&nbsp; {{ count($itenaries) }} record(s)</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width:22px;">#</th>
                <th style="width:78px;">Submitted</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width:70px;">Phone</th>
                <th>From &rarr; To</th>
                <th style="width:60px;">Travel Dates</th>
                <th style="width:60px;">Class</th>
                <th>Passengers</th>
                <th>Connected From</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itenaries as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ optional($row->created_at)->format('d M Y') }}<br><span class="muted">{{ optional($row->created_at)->format('h:i A') }}</span></td>
                <td class="name">{{ $row->name ?: '—' }}</td>
                <td>{{ $row->email ?: '—' }}</td>
                <td>{{ $row->contact ?: '—' }}</td>
                <td class="route">{{ $row->from ?: '—' }} <b>&rarr;</b> {{ $row->to ?: '—' }}</td>
                <td>{{ $row->depart ?: '—' }}@if($row->return)<br><span class="muted">ret {{ $row->return }}</span>@endif</td>
                <td>{{ $row->class ?: '—' }}</td>
                <td>{{ $row->passengers ?: '—' }}</td>
                <td>{{ trim(($row->city ? $row->city.', ' : '').($row->country ?: '')) ?: '—' }}@if($row->ip)<br><span class="muted">{{ $row->ip }}</span>@endif</td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;padding:20px;">No itinerary requests yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="foot">
        <span class="tag">Explore and Discover the Globe</span>
        &nbsp;·&nbsp; KONNECT.US INC. · 18502 Hillside Avenue, Jamaica, NY 11432 · www.konnectyatra.org
    </div>
</body>
</html>
