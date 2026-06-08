@extends('layouts.app')
@section('content')
<style type="text/css">
    .ht{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    .ht-stats{display:flex;justify-content:center;gap:16px;flex-wrap:wrap;margin:36px 0 10px}
    .ht-stat{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 24px rgba(28,37,65,.07);padding:18px 30px;text-align:center;min-width:160px}
    .ht-stat b{display:block;font-size:34px;font-weight:800;color:var(--brand);line-height:1}
    .ht-stat span{font-size:13px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em}
    .ht-map-wrap{background:#fff;border:1px solid #eef0f4;border-radius:20px;box-shadow:0 14px 40px rgba(28,37,65,.08);padding:22px;margin-top:30px}
    #pkMap{width:100%;height:480px}
    .ht-tip{position:fixed;pointer-events:none;background:#1c2541;color:#fff;font-size:13px;padding:7px 12px;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,.25);z-index:9999;opacity:0;transition:opacity .12s;white-space:nowrap}
    .ht-tip b{color:#ffb499}
    .ht-filters{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin:40px 0 10px}
    .ht-filter{border:1px solid #e7e9ef;background:#fff;border-radius:30px;color:var(--ink);font-weight:600;font-size:14px;padding:9px 20px;cursor:pointer;transition:.15s}
    .ht-filter:hover{border-color:var(--brand);color:var(--brand)}
    .ht-filter.active{background:var(--brand);border-color:var(--brand);color:#fff}
    .ht-city-head{display:flex;align-items:center;gap:14px;margin:46px 0 22px}
    .ht-city-head h2{margin:0;font-size:28px;font-weight:700;color:var(--ink)}
    .ht-city-head .count{background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:20px;font-size:13px;font-weight:700;padding:3px 14px}
    .ht-city-head .line{flex:1;height:1px;background:#eceef3}
    .ht-card{background:#fff;border:1px solid #eef0f4;border-radius:20px;overflow:hidden;box-shadow:0 8px 24px rgba(28,37,65,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .ht-card:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(28,37,65,.14)}
    .ht-photo{height:220px;background:#f1f2f6;overflow:hidden;position:relative}
    .ht-photo img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
    .ht-card:hover .ht-photo img{transform:scale(1.05)}
    .ht-photo .ht-price{position:absolute;top:12px;right:12px;background:rgba(245,78,24,.95);color:#fff;font-size:13px;font-weight:700;padding:4px 12px;border-radius:20px}
    .ht-body{padding:20px 22px;flex:1}
    .ht-body h5{margin:0 0 8px;font-size:18px;font-weight:700;color:var(--ink)}
    .ht-body p{margin:0;font-size:13.5px;color:#4b5563;line-height:1.5}
    .ht-body p i{color:var(--brand);margin-right:6px}
    .ht-foot{padding:0 22px 22px}
    .ht-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:var(--brand);color:#fff !important;font-weight:700;font-size:14.5px;padding:12px;border-radius:30px;text-decoration:none;transition:.15s}
    .ht-btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(245,78,24,.3);color:#fff}
    @media (max-width:575px){#pkMap{height:340px}.ht-city-head h2{font-size:22px}}
</style>

<main id="content" class="site-main ht">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container"
            style="background-image: url('{{ \App\Models\PageBanner::url('pakistan-hotels', asset('assets/images2/Inner-banner-01.png')) }}');background-position:center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:60px !important;">PAKISTAN HOTELS</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hotels</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="package-section section-sp2">
        <div class="container">
            <div class="ht-stats">
                <div class="ht-stat"><b>{{ $totalHotels }}</b><span>Hotels</span></div>
                <div class="ht-stat"><b>{{ $totalCities }}</b><span>Cities</span></div>
            </div>

            <div class="section-heading text-center" style="margin-top:30px">
                <h5 class="dash-style" style="color:var(--brand)">EXPLORE BY LOCATION</h5>
                <h2 style="font-weight:700;color:var(--ink)">Our Hotels Across Pakistan</h2>
                <p class="text-muted" style="max-width:680px;margin:8px auto 0">
                    Click a city on the map (or a city pill) to see the hotels available there.
                </p>
            </div>
            <div class="ht-map-wrap"><div id="pkMap"></div></div>

            @if(count(@$hotels) > 0)
            <div class="ht-filters">
                <button type="button" class="ht-filter active" data-city="all">All Cities</button>
                @foreach($hotels as $group)
                <button type="button" class="ht-filter" data-city="{{ \Illuminate\Support\Str::slug($group['city']) }}">{{ $group['city'] }}</button>
                @endforeach
            </div>

            @foreach($hotels as $group)
            <div class="ht-city-block" data-city="{{ \Illuminate\Support\Str::slug($group['city']) }}">
                <div class="ht-city-head">
                    <h2><i class="fa fa-map-marker-alt" style="color:var(--brand)"></i> {{ $group['city'] }}</h2>
                    <span class="count">{{ count($group['hotels']) }} {{ \Illuminate\Support\Str::plural('Hotel', count($group['hotels'])) }}</span>
                    <span class="line"></span>
                </div>
                <div class="row">
                    @foreach($group['hotels'] as $hotel)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="ht-card">
                            <a href="{{ url('/hotel-detail', $hotel->id) }}" class="ht-photo">
                                <img src="{{ asset('hotels/'.$hotel->image) }}" alt="{{ $hotel->name }}" onerror="this.src='{{ asset('assets/images2/Inner-banner-01.png') }}'">
                                @if(!empty($hotel->price))<span class="ht-price">${{ $hotel->price }}/night</span>@endif
                            </a>
                            <div class="ht-body">
                                <h5>{{ $hotel->name }}</h5>
                                <p><i class="fa fa-location-dot"></i>{{ trim(collect([$hotel->address, $hotel->city, $hotel->state])->filter()->implode(', ')) }}</p>
                            </div>
                            <div class="ht-foot">
                                <a href="{{ url('/hotel-detail', $hotel->id) }}" class="ht-btn">Explore More <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            <div class="text-center text-muted" style="padding:60px 0;font-size:18px">No hotels listed yet.</div>
            @endif
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js"></script>
<script>
// City filter (event delegation)
document.addEventListener('click', function (e) {
    var btn = e.target.closest('.ht-filter');
    if (!btn) return;
    e.preventDefault();
    var s = btn.getAttribute('data-city');
    document.querySelectorAll('.ht-filter').forEach(function (b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.ht-city-block').forEach(function (blk) {
        blk.style.display = (s === 'all' || blk.getAttribute('data-city') === s) ? '' : 'none';
    });
});

// Pakistan map with city markers
window.addEventListener('load', function () {
    var el = document.getElementById('pkMap');
    if (!el) return;
    var markers = @json($cityMarkers);
    if (typeof d3 === 'undefined' || typeof topojson === 'undefined') {
        el.innerHTML = '<p class="text-muted text-center" style="padding:210px 0 0">Map could not load. Use the city filters below.</p>';
        return;
    }
    var tip = d3.select('body').append('div').attr('class', 'ht-tip');
    var svg = d3.select('#pkMap').append('svg')
        .attr('viewBox', '0 0 700 600').attr('preserveAspectRatio', 'xMidYMid meet')
        .style('width', '100%').style('height', '100%');

    d3.json('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-50m.json').then(function (world) {
        var countries = topojson.feature(world, world.objects.countries).features;
        var pk = countries.find(function (d) { return String(d.id) === '586' || (d.properties && d.properties.name === 'Pakistan'); });
        if (!pk) { el.innerHTML = '<p class="text-muted text-center" style="padding:210px 0 0">Map unavailable.</p>'; return; }
        var projection = d3.geoMercator().fitSize([700, 600], pk);
        var path = d3.geoPath(projection);

        svg.append('g').selectAll('path').data(countries).join('path')
            .attr('d', path).attr('fill', '#eef0f4').attr('stroke', '#fff').attr('stroke-width', 0.5);
        svg.append('path').datum(pk).attr('d', path)
            .attr('fill', '#ffe4d8').attr('stroke', '#f54e18').attr('stroke-width', 1.3);

        var maxC = d3.max(markers, function (m) { return m.count; }) || 1;
        svg.append('g').selectAll('circle').data(markers).join('circle')
            .attr('cx', function (m) { var p = projection([m.lng, m.lat]); return p ? p[0] : -100; })
            .attr('cy', function (m) { var p = projection([m.lng, m.lat]); return p ? p[1] : -100; })
            .attr('r', function (m) { return 7 + (m.count / maxC) * 13; })
            .attr('fill', '#f54e18').attr('fill-opacity', 0.78).attr('stroke', '#fff').attr('stroke-width', 2)
            .style('cursor', 'pointer')
            .on('mousemove', function (e, m) {
                tip.html('<b>' + m.city + '</b> — ' + m.count + ' Hotel' + (m.count === 1 ? '' : 's') + ' &middot; click to view')
                   .style('left', (e.clientX + 14) + 'px').style('top', (e.clientY + 14) + 'px').style('opacity', 1);
            })
            .on('mouseout', function () { tip.style('opacity', 0); })
            .on('click', function (e, m) {
                var slug = m.city.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                var pill = document.querySelector('.ht-filter[data-city="' + slug + '"]');
                if (pill) {
                    pill.click(); tip.style('opacity', 0);
                    var block = document.querySelector('.ht-city-block[data-city="' + slug + '"]');
                    if (block) block.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
    }).catch(function () {
        el.innerHTML = '<p class="text-muted text-center" style="padding:210px 0 0">Map could not load. Use the city filters below.</p>';
    });
});
</script>
@endsection
