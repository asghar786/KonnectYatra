<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body{font-family:DejaVu Sans, sans-serif;font-size:12px;color:#333}
    h1{font-size:20px;margin:0}
    h3{font-size:14px;border-bottom:2px solid #4c1864;padding-bottom:4px;margin-top:22px;color:#4c1864}
    table{width:100%;border-collapse:collapse;margin-top:8px}
    th,td{border:1px solid #ddd;padding:6px 8px;text-align:left}
    th{background:#4c1864;color:#fff}
    .kpis td{font-size:13px}
    .muted{color:#888}
</style>
</head>
<body>
    <h1>KonnectYatra — Website Analytics</h1>
    <p class="muted">{{ $range_label }} · Generated {{ now()->format('d M Y, H:i') }}</p>

    @php $mins = intdiv($avgDuration,60); $secs = $avgDuration % 60; @endphp
    <h3>Key Metrics</h3>
    <table class="kpis">
        <tr><td>Total Visitors (Sessions)</td><td>{{ $sessions }}</td><td>Unique Visitors</td><td>{{ $uniqueVisitors }}</td></tr>
        <tr><td>Page Views</td><td>{{ $pageViews }}</td><td>New / Returning</td><td>{{ $newVisitors }} / {{ $returningVisitors }}</td></tr>
        <tr><td>Avg. Session Duration</td><td>{{ $mins }}m {{ $secs }}s</td><td>Bounce Rate</td><td>{{ $bounceRate }}%</td></tr>
        <tr><td>Total Conversions</td><td>{{ $totalConversions }}</td><td>Conversion Rate</td><td>{{ $conversionRate }}%</td></tr>
    </table>

    <h3>Most Visited Pages</h3>
    <table><tr><th>Page</th><th>Views</th></tr>
        @forelse($topPages as $p)<tr><td>{{ $p->url }}</td><td>{{ $p->c }}</td></tr>@empty<tr><td colspan="2">No data</td></tr>@endforelse
    </table>

    <h3>Traffic Sources</h3>
    <table><tr><th>Source</th><th>Sessions</th></tr>
        @forelse($sources as $name => $c)<tr><td>{{ ucfirst($name) }}</td><td>{{ $c }}</td></tr>@empty<tr><td colspan="2">No data</td></tr>@endforelse
    </table>

    <h3>Visitors by Country</h3>
    <table><tr><th>Country</th><th>Sessions</th></tr>
        @forelse($countries as $c)<tr><td>{{ $c->country ?: 'Unknown' }}</td><td>{{ $c->c }}</td></tr>@empty<tr><td colspan="2">No data</td></tr>@endforelse
    </table>

    <h3>Visitors by US State</h3>
    <table><tr><th>State</th><th>Sessions</th></tr>
        @forelse($states as $s)<tr><td>{{ $s->region }}</td><td>{{ $s->c }}</td></tr>@empty<tr><td colspan="2">No data</td></tr>@endforelse
    </table>

    <h3>Conversions</h3>
    <table><tr><th>Type</th><th>Count</th></tr>
        @php $convLabels=['contact_inquiry'=>'Contact Inquiries','booking_request'=>'Booking Requests','special_booking'=>'Special Bookings']; @endphp
        @forelse($convByType as $type => $c)<tr><td>{{ $convLabels[$type] ?? $type }}</td><td>{{ $c }}</td></tr>@empty<tr><td colspan="2">No conversions</td></tr>@endforelse
    </table>
</body>
</html>
