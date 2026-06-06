@extends('admin.layouts.app')
@section('content')
<style>
    .kpi-card{border:none;border-radius:14px;padding:18px 20px;color:#fff;box-shadow:0 6px 18px rgba(0,0,0,.08);height:100%}
    .kpi-card h2{font-size:30px;font-weight:700;margin:6px 0 0}
    .kpi-card .kpi-label{font-size:13px;opacity:.9;text-transform:uppercase;letter-spacing:.5px}
    .kpi-sub{font-size:12px;opacity:.85;margin-top:4px}
    .an-card{background:#fff;border-radius:14px;padding:18px;box-shadow:0 4px 14px rgba(0,0,0,.06);height:100%}
    .an-card h5{font-size:16px;font-weight:600;margin-bottom:14px}
    .an-table{width:100%;font-size:13px}
    .an-table th{border-bottom:2px solid #eee;text-align:left;padding:8px 6px;color:#666}
    .an-table td{border-bottom:1px solid #f2f2f2;padding:8px 6px}
    .an-table td:last-child,.an-table th:last-child{text-align:right;font-weight:600}
    .filter-btn{margin:0 4px 6px 0}
    .g-bg-1{background:linear-gradient(135deg,#4c1864,#9D50BB)}
    .g-bg-2{background:linear-gradient(135deg,#11998e,#38ef7d)}
    .g-bg-3{background:linear-gradient(135deg,#2193b0,#6dd5ed)}
    .g-bg-4{background:linear-gradient(135deg,#f7971e,#ffd200);color:#333!important}
    .g-bg-5{background:linear-gradient(135deg,#ee0979,#ff6a00)}
    .g-bg-6{background:linear-gradient(135deg,#373B44,#4286f4)}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Website Analytics</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Analytics</li>
            </ul>
        </div>
        <div class="main-body">

            <!-- Filter bar -->
            <div class="an-card mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        @php $ranges = ['today'=>'Today','30'=>'Last 30 Days','60'=>'Last 60 Days','90'=>'Last 90 Days']; @endphp
                        @foreach($ranges as $key => $label)
                        <a href="{{ url('admin/analytics') }}?range={{ $key }}"
                           class="btn btn-sm filter-btn {{ $range == $key ? 'btn-primary' : 'btn-outline-primary' }}">{{ $label }}</a>
                        @endforeach
                        <form method="GET" action="{{ url('admin/analytics') }}" class="d-inline-flex align-items-center" style="gap:6px">
                            <input type="hidden" name="range" value="custom">
                            <input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm" style="width:auto">
                            <span>to</span>
                            <input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm" style="width:auto">
                            <button class="btn btn-sm btn-dark">Apply</button>
                        </form>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <span class="text-muted mr-2">{{ $range_label }}</span>
                        <a href="{{ url('admin/analytics/export') }}?range={{ $range }}&from={{ $from }}&to={{ $to }}&format=csv" class="btn btn-sm btn-success"><i class="fa fa-file-csv"></i> CSV</a>
                        <a href="{{ url('admin/analytics/export') }}?range={{ $range }}&from={{ $from }}&to={{ $to }}&format=pdf" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf"></i> PDF</a>
                    </div>
                </div>
            </div>

            <!-- KPI widgets -->
            @php
                $mins = intdiv($avgDuration,60); $secs = $avgDuration % 60;
                $totalVisitors = $sessions;
            @endphp
            <div class="row">
                @foreach([
                    ['Total Visitors',$totalVisitors,'g-bg-1','sessions'],
                    ['Unique Visitors',$uniqueVisitors,'g-bg-2',null],
                    ['Page Views',$pageViews,'g-bg-3',null],
                    ['Avg. Session',$mins.'m '.$secs.'s','g-bg-6',null],
                    ['Bounce Rate',$bounceRate.'%','g-bg-5',null],
                    ['Conversions',$totalConversions,'g-bg-4',$conversionRate.'% conv. rate'],
                ] as $kpi)
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="kpi-card {{ $kpi[2] }}">
                        <div class="kpi-label">{{ $kpi[0] }}</div>
                        <h2>{{ $kpi[1] }}</h2>
                        @if(!empty($kpi[3]))<div class="kpi-sub">{{ $kpi[3] === 'sessions' ? $newVisitors.' new / '.$returningVisitors.' returning' : $kpi[3] }}</div>@endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Trend + hourly -->
            <div class="row">
                <div class="col-lg-8 mb-4"><div class="an-card"><h5>Daily Visitor Trend</h5><canvas id="dailyChart" height="110"></canvas></div></div>
                <div class="col-lg-4 mb-4"><div class="an-card"><h5>New vs Returning</h5><canvas id="nvrChart" height="200"></canvas></div></div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-4"><div class="an-card"><h5>Hourly Distribution (24h)</h5><canvas id="hourlyChart" height="110"></canvas></div></div>
                <div class="col-lg-4 mb-4"><div class="an-card"><h5>Traffic Sources</h5><canvas id="sourcesChart" height="200"></canvas></div></div>
            </div>

            <!-- Device / browser / OS -->
            <div class="row">
                <div class="col-lg-4 mb-4"><div class="an-card"><h5>Devices</h5><canvas id="deviceChart" height="180"></canvas></div></div>
                <div class="col-lg-4 mb-4">
                    <div class="an-card"><h5>Browsers</h5>
                        <table class="an-table"><tbody>
                        @forelse($browsers as $name => $c)<tr><td>{{ $name }}</td><td>{{ $c }}</td></tr>@empty<tr><td>No data</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="an-card"><h5>Operating Systems</h5>
                        <table class="an-table"><tbody>
                        @forelse($platforms as $name => $c)<tr><td>{{ $name }}</td><td>{{ $c }}</td></tr>@empty<tr><td>No data</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>

            <!-- Pages -->
            <div class="row">
                @php
                $pageTables = [
                    ['Most Visited Pages',$topPages,'url'],
                    ['Least Visited Pages',$leastPages,'url'],
                    ['Entry (Landing) Pages',$entryPages,'url'],
                    ['Exit Pages',$exitPages,'url'],
                ];
                @endphp
                @foreach($pageTables as $pt)
                <div class="col-lg-6 mb-4">
                    <div class="an-card"><h5>{{ $pt[0] }}</h5>
                        <table class="an-table"><thead><tr><th>Page</th><th>Views</th></tr></thead><tbody>
                        @forelse($pt[1] as $row)<tr><td>{{ $row->url }}</td><td>{{ $row->c }}</td></tr>@empty<tr><td>No data</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Geo -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="an-card"><h5>Visitors by Country</h5>
                        <table class="an-table"><thead><tr><th>Country</th><th>Sessions</th></tr></thead><tbody>
                        @forelse($countries as $row)<tr><td>{{ $row->country ?: 'Unknown' }}</td><td>{{ $row->c }}</td></tr>@empty<tr><td>No data yet (run analytics:resolve-geo)</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="an-card"><h5>Visitors by US State</h5>
                        <table class="an-table"><thead><tr><th>State</th><th>Sessions</th></tr></thead><tbody>
                        @forelse($states as $row)<tr><td>{{ $row->region }}</td><td>{{ $row->c }}</td></tr>@empty<tr><td>No US state data yet</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>

            <!-- Sources detail + conversions -->
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="an-card"><h5>Top Referrers</h5>
                        <table class="an-table"><thead><tr><th>Domain</th><th>Hits</th></tr></thead><tbody>
                        @forelse($topReferrers as $row)<tr><td>{{ $row->referrer_host }}</td><td>{{ $row->c }}</td></tr>@empty<tr><td>No referrals</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="an-card"><h5>UTM Campaigns</h5>
                        <table class="an-table"><thead><tr><th>Campaign</th><th>Hits</th></tr></thead><tbody>
                        @forelse($campaigns as $row)<tr><td>{{ $row->utm_campaign }}</td><td>{{ $row->c }}</td></tr>@empty<tr><td>No campaigns</td><td>0</td></tr>@endforelse
                        </tbody></table>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="an-card"><h5>Conversions</h5>
                        <table class="an-table"><thead><tr><th>Type</th><th>Count</th></tr></thead><tbody>
                        @php $convLabels=['contact_inquiry'=>'Contact Inquiries','booking_request'=>'Booking Requests','special_booking'=>'Special Bookings']; @endphp
                        @forelse($convByType as $type => $c)<tr><td>{{ $convLabels[$type] ?? $type }}</td><td>{{ $c }}</td></tr>@empty<tr><td>No conversions</td><td>0</td></tr>@endforelse
                        <tr><td><strong>Conversion Rate</strong></td><td><strong>{{ $conversionRate }}%</strong></td></tr>
                        </tbody></table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function(){
    var daily = @json($daily);
    var hourly = @json(array_values($hourly));
    var devices = @json($devices);
    var sources = @json($sources);

    var palette = ['#4c1864','#9D50BB','#2193b0','#38ef7d','#f7971e','#ee0979','#6dd5ed','#4286f4','#ff6a00'];

    // Daily trend
    new Chart(document.getElementById('dailyChart'), {
        type:'line',
        data:{ labels: daily.map(function(r){return r.d;}),
            datasets:[
                {label:'Sessions', data: daily.map(function(r){return r.sessions;}), borderColor:'#4c1864', backgroundColor:'rgba(76,24,100,.08)', fill:true, tension:.35},
                {label:'Page Views', data: daily.map(function(r){return r.views;}), borderColor:'#2193b0', backgroundColor:'rgba(33,147,176,.06)', fill:true, tension:.35}
            ]},
        options:{responsive:true, plugins:{legend:{position:'bottom'}}, scales:{y:{beginAtZero:true}}}
    });

    // Hourly
    new Chart(document.getElementById('hourlyChart'), {
        type:'bar',
        data:{ labels: Array.from({length:24},function(_,i){return i+':00';}),
            datasets:[{label:'Page Views', data: hourly, backgroundColor:'#9D50BB'}]},
        options:{responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
    });

    // New vs returning
    new Chart(document.getElementById('nvrChart'), {
        type:'doughnut',
        data:{ labels:['New','Returning'], datasets:[{data:[{{ $newVisitors }},{{ $returningVisitors }}], backgroundColor:['#38ef7d','#4286f4']}]},
        options:{responsive:true, plugins:{legend:{position:'bottom'}}}
    });

    // Sources
    var sLabels = Object.keys(sources), sVals = sLabels.map(function(k){return sources[k];});
    new Chart(document.getElementById('sourcesChart'), {
        type:'doughnut',
        data:{ labels:sLabels, datasets:[{data:sVals, backgroundColor:palette}]},
        options:{responsive:true, plugins:{legend:{position:'bottom'}}}
    });

    // Devices
    var dLabels = Object.keys(devices), dVals = dLabels.map(function(k){return devices[k];});
    new Chart(document.getElementById('deviceChart'), {
        type:'pie',
        data:{ labels:dLabels, datasets:[{data:dVals, backgroundColor:['#4c1864','#f7971e','#11998e']}]},
        options:{responsive:true, plugins:{legend:{position:'bottom'}}}
    });
})();
</script>
@endsection
