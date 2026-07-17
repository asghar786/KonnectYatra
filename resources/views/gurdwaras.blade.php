@extends('layouts.app')
@section('content')
<style type="text/css">
    .gw-tip{position:fixed;pointer-events:none;background:#1c2541;color:#fff;font-size:13px;padding:7px 12px;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,.25);z-index:9999;opacity:0;transition:opacity .12s;white-space:nowrap}
    .gw-tip b{color:#ffb499}
    #sikhMap svg path{transition:fill .15s}
    #sikhMap svg path.state:hover{fill-opacity:.85;cursor:pointer}
    .gw{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    /* Stats */
    .gw-stats{display:flex;justify-content:center;gap:16px;flex-wrap:wrap;margin:36px 0 10px}
    .gw-stat{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 24px rgba(28,37,65,.07);padding:18px 30px;text-align:center;min-width:160px}
    .gw-stat b{display:block;font-size:34px;font-weight:800;color:var(--brand);line-height:1}
    .gw-stat span{font-size:13px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em}
    /* Map */
    .gw-map-wrap{background:#fff;border:1px solid #eef0f4;border-radius:20px;box-shadow:0 14px 40px rgba(28,37,65,.08);padding:22px;margin-top:30px}
    #sikhMap{width:100%;height:480px}
    .gw-legend{display:flex;align-items:center;justify-content:center;gap:18px;flex-wrap:wrap;margin-top:14px;font-size:13px;color:var(--muted)}
    .gw-legend i{display:inline-block;width:16px;height:16px;border-radius:4px;margin-right:6px;vertical-align:middle}
    /* State filter pills */
    .gw-filters{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin:40px 0 10px}
    .gw-filter{border:1px solid #e7e9ef;background:#fff;border-radius:30px;color:var(--ink);font-weight:600;font-size:14px;padding:9px 20px;cursor:pointer;transition:.15s}
    .gw-filter:hover{border-color:var(--brand);color:var(--brand)}
    .gw-filter.active{background:var(--brand);border-color:var(--brand);color:#fff}
    /* ZIP search */
    .gw-zip{max-width:560px;margin:18px auto 6px;text-align:center}
    .gw-zip label{display:block;font-weight:700;color:var(--ink);margin-bottom:10px;font-size:15px}
    .gw-zip-row{position:relative;display:flex;gap:8px;align-items:center}
    .gw-zip-row > i{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#9aa0ac;font-size:14px;pointer-events:none}
    .gw-zip input{flex:1;border:1px solid #e2e4ea;border-radius:30px;padding:11px 18px 11px 40px;font-size:15px;height:auto;outline:0}
    .gw-zip input:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .gw-zip button{border:0;background:var(--brand);color:#fff;font-weight:700;font-size:15px;padding:11px 26px;border-radius:30px;cursor:pointer;white-space:nowrap}
    .gw-zip button:hover{filter:brightness(.95)}
    .gw-zip-clear{align-self:center;color:#6b7280;font-size:14px;text-decoration:underline;white-space:nowrap}
    .gw-zip-err{margin:10px 0 0;color:#b42318;font-size:14px}
    .gw-near-note{color:#6b7280;font-size:14px;margin:0 0 18px}
    .gw-photo .gw-dist{position:absolute;top:12px;left:12px;background:var(--brand);color:#fff;font-size:11px;font-weight:700;padding:3px 12px;border-radius:20px}
    @media (max-width:575px){.gw-zip-row{flex-wrap:wrap}.gw-zip input{width:100%;flex:1 0 100%}}
    /* State heading */
    .gw-state-head{display:flex;align-items:center;gap:14px;margin:46px 0 22px}
    .gw-state-head h2{margin:0;font-size:28px;font-weight:700;color:var(--ink)}
    .gw-state-head .count{background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:20px;font-size:13px;font-weight:700;padding:3px 14px}
    .gw-state-head .line{flex:1;height:1px;background:#eceef3}
    /* Card */
    .gw-card{background:#fff;border:1px solid #eef0f4;border-radius:18px;overflow:hidden;box-shadow:0 8px 24px rgba(28,37,65,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .gw-card:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(28,37,65,.14)}
    .gw-photo{height:210px;background:#f1f2f6;overflow:hidden;position:relative}
    .gw-photo img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
    .gw-card:hover .gw-photo img{transform:scale(1.05)}
    .gw-photo .gw-sangat{position:absolute;top:12px;right:12px;background:rgba(45,27,105,.92);color:#fff;font-size:11px;font-weight:600;padding:3px 12px;border-radius:20px}
    .gw-body{padding:20px 22px;flex:1}
    .gw-body h5{margin:0 0 8px;font-size:17px;font-weight:700;color:var(--ink);line-height:1.35}
    .gw-meta{list-style:none;padding:0;margin:0}
    .gw-meta li{display:flex;gap:10px;font-size:13.5px;color:#4b5563;padding:4px 0;line-height:1.5}
    .gw-meta li i{color:var(--brand);width:16px;text-align:center;margin-top:3px}
    .gw-foot{padding:0 22px 22px}
    .gw-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:var(--brand);color:#fff !important;font-weight:700;font-size:14.5px;padding:12px;border-radius:30px;text-decoration:none;transition:.15s}
    .gw-btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(245,78,24,.3);color:#fff}
    @media (max-width:575px){#sikhMap{height:320px}.gw-state-head h2{font-size:22px}}
</style>

<main id="content" class="site-main gw">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container"
            style="background-image: url('{{ \App\Models\PageBanner::url('gurdwaras', asset('assets/images2/News-04.png')) }}');background-position: center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:65px !important;">GURDWARAS</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gurdwaras</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="package-section section-sp2">
        <div class="container">

            <!-- Stats -->
            <div class="gw-stats">
                <div class="gw-stat"><b>{{ $totalGurdwaras }}</b><span>Gurdwaras</span></div>
                <div class="gw-stat"><b>{{ $totalStates }}</b><span>US States</span></div>
            </div>

            <!-- Geo Location for Sikh Communities -->
            <div class="section-heading text-center" style="margin-top:30px">
                <h5 class="dash-style" style="color:var(--brand)">EXPLORE BY LOCATION</h5>
                <h2 style="font-weight:700;color:var(--ink)">Geo Location for Sikh Communities</h2>
                <p class="text-muted" style="max-width:680px;margin:8px auto 0">
                    Sikh communities and Gurdwaras across the United States. Hover over a state to see how many Gurdwaras are listed there.
                </p>
            </div>
            <div class="gw-map-wrap">
                <div id="sikhMap"></div>
                <div class="gw-legend">
                    <span><i style="background:#ffd9c9"></i> Fewer Gurdwaras</span>
                    <span><i style="background:#f54e18"></i> More Gurdwaras</span>
                    <span><i style="background:#eef0f4"></i> None listed</span>
                </div>
            </div>

            <!-- State filters -->
            @if(count(@$gurdwaras) > 0)
            <div class="gw-filters">
                <button type="button" class="gw-filter active" data-state="all">All States</button>
                @foreach($gurdwaras as $value)
                <button type="button" class="gw-filter" data-state="{{ \Illuminate\Support\Str::slug($value['state']) }}">{{ $value['state'] }}</button>
                @endforeach
            </div>

            <!-- ZIP search -->
            <form class="gw-zip" method="GET" action="{{ url('gurdwaras') }}">
                <label for="gw-zip-input">Find gurdwaras near your ZIP code</label>
                <div class="gw-zip-row">
                    <i class="fa fa-crosshairs"></i>
                    <input type="text" id="gw-zip-input" name="zip" value="{{ @$zipQuery }}"
                           inputmode="numeric" maxlength="10" placeholder="e.g. 11419" aria-label="US ZIP code">
                    <button type="submit"><i class="fa fa-search"></i> Search</button>
                    @if(!empty($zipQuery))
                    <a class="gw-zip-clear" href="{{ url('gurdwaras') }}">Clear</a>
                    @endif
                </div>
                @if(!empty($zipError))<p class="gw-zip-err"><i class="fa fa-exclamation-circle"></i> {{ $zipError }}</p>@endif
            </form>

            {{-- ZIP results: nearest first, so a ZIP with no gurdwara of its own
                 still points people at the closest ones. --}}
            @if(!empty($zipResult))
            <div class="gw-near">
                <div class="gw-state-head">
                    <h2><i class="fa fa-map-marker-alt" style="color:var(--brand)"></i>
                        @if($zipResult['exact'] > 0)
                            Gurdwaras in {{ $zipResult['city'] }}, {{ $zipResult['state'] }}
                        @else
                            Nearest gurdwaras to {{ $zipResult['city'] }}, {{ $zipResult['state'] }}
                        @endif
                    </h2>
                    <span class="count">{{ $zipResult['zip'] }}</span>
                    <span class="line"></span>
                </div>
                @if($zipResult['exact'] === 0 && count($zipResult['gurdwaras']))
                <p class="gw-near-note">No gurdwara is listed in {{ $zipResult['city'] }} itself — here are the closest ones.</p>
                @endif

                @if(count($zipResult['gurdwaras']) === 0)
                <p class="gw-near-note">We couldn't find any gurdwara near {{ $zipResult['city'] }} yet.</p>
                @else
                <div class="row">
                    @foreach($zipResult['gurdwaras'] as $v)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="gw-card">
                            <a href="{{ route('gurdwara_detail', $v['id']) }}" class="gw-photo">
                                <img src="{{ asset('gurdwara_images/'.@$v['gurdwara_image']) }}" alt="{{ @$v['gurdwara_name'] }}"
                                     onerror="this.src='{{ asset('assets/images2/News-04.png') }}'">
                                <span class="gw-dist">{{ $v->distance < 1 ? '<1' : round($v->distance) }} mi</span>
                            </a>
                            <div class="gw-body">
                                <h5>{{ @$v['gurdwara_name'] }}</h5>
                                <ul class="gw-meta">
                                    <li><i class="fa fa-map-marker-alt"></i><span>{{ trim(collect([@$v['address'], @$v['city'], @$v['state'], @$v['zip']])->filter()->implode(', ')) }}</span></li>
                                    @if(!empty($v['phone_no']))<li><i class="fa fa-phone"></i><span>{{ $v['phone_no'] }}</span></li>@endif
                                </ul>
                            </div>
                            <div class="gw-foot">
                                <a href="{{ route('gurdwara_detail', $v['id']) }}" class="gw-btn">View Details <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <p class="gw-near-note">Showing results for {{ $zipResult['zip'] }} — <a href="{{ url('gurdwaras') }}">browse all states instead</a>.</p>
            </div>
            @endif

            <!-- Listing grouped by state -->
            <div class="gw-all" @if(!empty($zipResult)) style="display:none" @endif>
            @foreach($gurdwaras as $value)
            <div class="gw-state-block" data-state="{{ \Illuminate\Support\Str::slug($value['state']) }}">
                <div class="gw-state-head">
                    <h2><i class="fa fa-map-marker-alt" style="color:var(--brand)"></i> {{ $value['state'] }}</h2>
                    <span class="count">{{ count($value['gurdwaras']) }} {{ \Illuminate\Support\Str::plural('Gurdwara', count($value['gurdwaras'])) }}</span>
                    <span class="line"></span>
                </div>
                <div class="row">
                    @foreach($value['gurdwaras'] as $v)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="gw-card">
                            <a href="{{ route('gurdwara_detail', $v['id']) }}" class="gw-photo">
                                <img src="{{ asset('gurdwara_images/'.@$v['gurdwara_image']) }}" alt="{{ @$v['gurdwara_name'] }}"
                                     onerror="this.src='{{ asset('assets/images2/News-04.png') }}'">
                                @if(!empty($v['sangat']))<span class="gw-sangat">{{ $v['sangat'] }} Sangat</span>@endif
                            </a>
                            <div class="gw-body">
                                <h5>{{ @$v['gurdwara_name'] }}</h5>
                                <ul class="gw-meta">
                                    <li><i class="fa fa-map-marker-alt"></i><span>{{ trim(collect([@$v['address'], @$v['city'], @$v['state'], @$v['zip']])->filter()->implode(', ')) }}</span></li>
                                    @if(!empty($v['phone_no']))<li><i class="fa fa-phone"></i><span>{{ $v['phone_no'] }}</span></li>@endif
                                </ul>
                            </div>
                            <div class="gw-foot">
                                <a href="{{ route('gurdwara_detail', $v['id']) }}" class="gw-btn">View Details <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            </div>
            @else
            <div class="text-center text-muted" style="padding:60px 0;font-size:18px">No Gurdwaras listed yet.</div>
            @endif
        </div>
    </section>
</main>

@php
    // Gurdwara count keyed by full state name (for the D3 choropleth).
    $byName = [];
    foreach ($gurdwaras as $g) { $byName[$g['state']] = count($g['gurdwaras']); }
@endphp
<script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js"></script>
<script>
// --- State filter (event delegation: immune to load timing / re-renders) ---
document.addEventListener('click', function (e) {
    var btn = e.target.closest('.gw-filter');
    if (!btn) return;
    e.preventDefault();
    var s = btn.getAttribute('data-state');
    document.querySelectorAll('.gw-filter').forEach(function (b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.gw-state-block').forEach(function (blk) {
        blk.style.display = (s === 'all' || blk.getAttribute('data-state') === s) ? '' : 'none';
    });
});

// --- Sikh communities US choropleth (D3 + us-atlas) ---
window.addEventListener('load', function () {
    var el = document.getElementById('sikhMap');
    if (!el) return;
    var counts = @json($byName);
    if (typeof d3 === 'undefined' || typeof topojson === 'undefined') {
        el.innerHTML = '<p class="text-muted text-center" style="padding:210px 0 0">Map could not load. Use the state filters below.</p>';
        return;
    }
    var maxVal = 1;
    Object.keys(counts).forEach(function (k) { if (counts[k] > maxVal) maxVal = counts[k]; });
    var color = d3.scaleLinear().domain([0, maxVal]).range(['#ffd9c9', '#f54e18']);

    var tip = d3.select('body').append('div').attr('class', 'gw-tip');
    var svg = d3.select('#sikhMap').append('svg')
        .attr('viewBox', '0 0 975 610')
        .attr('preserveAspectRatio', 'xMidYMid meet')
        .style('width', '100%').style('height', '100%');

    d3.json('https://cdn.jsdelivr.net/npm/us-atlas@3/states-10m.json').then(function (us) {
        var fc = topojson.feature(us, us.objects.states);
        // us-atlas states-10m is raw lon/lat, so project it (Albers USA handles AK/HI).
        var projection = d3.geoAlbersUsa().fitSize([975, 610], fc);
        var path = d3.geoPath(projection);
        svg.append('g').selectAll('path').data(fc.features).join('path')
            .attr('class', 'state')
            .attr('d', path)
            .attr('stroke', '#ffffff').attr('stroke-width', 1)
            .attr('fill', function (d) { var c = counts[d.properties.name] || 0; return c > 0 ? color(c) : '#eef0f4'; })
            .style('cursor', function (d) { return (counts[d.properties.name] || 0) > 0 ? 'pointer' : 'default'; })
            .on('mousemove', function (event, d) {
                var c = counts[d.properties.name] || 0;
                tip.html('<b>' + d.properties.name + '</b> — ' + c + ' Gurdwara' + (c === 1 ? '' : 's') + (c > 0 ? ' &middot; click to view' : ''))
                   .style('left', (event.clientX + 14) + 'px')
                   .style('top', (event.clientY + 14) + 'px')
                   .style('opacity', 1);
            })
            .on('mouseout', function () { tip.style('opacity', 0); })
            .on('click', function (event, d) {
                if ((counts[d.properties.name] || 0) <= 0) return; // no gurdwaras → ignore
                var slug = d.properties.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                var pill = document.querySelector('.gw-filter[data-state="' + slug + '"]');
                if (pill) {
                    pill.click(); // reuse the same filter logic as the pills
                    tip.style('opacity', 0);
                    var block = document.querySelector('.gw-state-block[data-state="' + slug + '"]');
                    if (block) block.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
    }).catch(function (e) {
        console.error('Sikh map failed:', e);
        el.innerHTML = '<p class="text-muted text-center" style="padding:210px 0 0">Map could not load. Use the state filters below.</p>';
    });
});
</script>
@endsection
