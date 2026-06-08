@extends('layouts.app')
@section('content')
@php
    $fullAddress = trim(collect([$hotel->address, $hotel->city, $hotel->state])->filter()->implode(', '));
    $hasGeo = !empty($hotel->latitude) && !empty($hotel->longitude);
    $mapQuery = urlencode($hotel->name . ' ' . $fullAddress . ' Pakistan');
@endphp
@if($hasGeo)<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">@endif
<style type="text/css">
    .hd2{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    .hd2-card{background:#fff;border:1px solid #eef0f4;border-radius:18px;box-shadow:0 12px 36px rgba(28,37,65,.08);overflow:hidden}
    .hd2-feature{width:100%;height:420px;object-fit:cover;display:block;background:#f1f2f6;cursor:zoom-in}
    .hd2-gallery{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;padding:14px}
    .hd2-gallery img{width:100%;height:90px;object-fit:cover;border-radius:10px;cursor:zoom-in;transition:transform .15s}
    .hd2-gallery img:hover{transform:scale(1.05)}
    .hd2-pad{padding:26px 30px}
    .hd2-title{font-size:30px;font-weight:800;color:var(--ink);margin:0}
    .hd2-price{display:inline-block;background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:20px;font-size:15px;font-weight:700;padding:6px 16px}
    .hd2-addr{color:var(--muted);font-size:15px;margin:10px 0 0}.hd2-addr i{color:var(--brand);margin-right:7px}
    .hd2-sec{text-transform:uppercase;letter-spacing:.06em;font-size:12px;font-weight:700;color:var(--muted);margin:24px 0 12px}
    .hd2-desc{color:#374151;font-size:15px;line-height:1.75}
    .hd2-info{list-style:none;padding:0;margin:0}
    .hd2-info li{display:flex;gap:12px;padding:11px 0;border-bottom:1px dashed #eef0f4;font-size:14.5px}
    .hd2-info li:last-child{border-bottom:none}
    .hd2-info li i{color:var(--brand);width:18px;text-align:center;margin-top:3px}
    .hd2-info li .lbl{color:var(--muted);min-width:90px}.hd2-info li .val{color:var(--ink);font-weight:600}
    #hotelDetMap{height:320px;border-radius:16px;border:1px solid #eef0f4;z-index:1}
    .hd2-mapframe{width:100%;height:320px;border:0;border-radius:16px}
    .hd2-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}
    .hd2-btn{display:inline-flex;align-items:center;gap:8px;font-weight:700;font-size:14.5px;padding:12px 26px;border-radius:30px;text-decoration:none}
    .hd2-btn.primary{background:var(--brand);color:#fff !important}.hd2-btn.ghost{background:#fff;border:1px solid #e7e9ef;color:var(--ink) !important}
    .hd2-btn:hover{transform:translateY(-2px)}
    @media (max-width:767px){.hd2-feature{height:240px}.hd2-gallery{grid-template-columns:repeat(3,1fr)}}
    /* lightbox */
    #hd2Lb{position:fixed;inset:0;background:rgba(0,0,0,.92);display:none;align-items:center;justify-content:center;z-index:99999;padding:30px}
    #hd2Lb img{max-width:94%;max-height:90%;border-radius:8px}
    #hd2Lb .cls{position:absolute;top:18px;right:28px;color:#fff;font-size:36px;cursor:pointer}
</style>

<main id="content" class="site-main hd2">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container" style="background-image:url('{{ asset('assets/images2/newbanner1.jpg') }}');background-position:center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:52px !important;">{{ $hotel->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pakistan_hotels') }}">Hotels</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $hotel->city }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="section-sp2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="hd2-card">
                        <img class="hd2-feature hd2-zoom" src="{{ asset('hotels/'.$hotel->image) }}" data-full="{{ asset('hotels/'.$hotel->image) }}" alt="{{ $hotel->name }}">
                        @if($hotel->images && $hotel->images->count())
                        <div class="hd2-gallery">
                            @foreach($hotel->images as $img)
                            <img class="hd2-zoom" src="{{ asset('hotels/'.$img->image) }}" data-full="{{ asset('hotels/'.$img->image) }}" alt="{{ $hotel->name }} photo">
                            @endforeach
                        </div>
                        @endif
                        <div class="hd2-pad">
                            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:12px">
                                <h1 class="hd2-title">{{ $hotel->name }}</h1>
                                @if(!empty($hotel->price))<span class="hd2-price">${{ $hotel->price }} / night</span>@endif
                            </div>
                            <p class="hd2-addr"><i class="fa fa-location-dot"></i>{{ $fullAddress }}</p>

                            @if(!empty($hotel->description))
                            <p class="hd2-sec">About this hotel</p>
                            <div class="hd2-desc">{!! nl2br(e($hotel->description)) !!}</div>
                            @endif

                            <p class="hd2-sec">Details</p>
                            <ul class="hd2-info">
                                @if(!empty($hotel->phone))<li><i class="fa fa-phone"></i><span class="lbl">Phone</span><span class="val"><a href="tel:{{ $hotel->phone }}">{{ $hotel->phone }}</a></span></li>@endif
                                <li><i class="fa fa-city"></i><span class="lbl">City</span><span class="val">{{ $hotel->city }}</span></li>
                                <li><i class="fa fa-map"></i><span class="lbl">Province</span><span class="val">{{ $hotel->state }}{{ $hotel->zip ? ' '.$hotel->zip : '' }}</span></li>
                            </ul>

                            <div class="hd2-actions">
                                <a class="hd2-btn primary" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ $hasGeo ? $hotel->latitude.','.$hotel->longitude : $mapQuery }}"><i class="fa fa-diamond-turn-right"></i> Get Directions</a>
                                <a class="hd2-btn ghost" href="{{ route('pakistan_hotels') }}"><i class="fa fa-arrow-left"></i> All Hotels</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="hd2-card">
                        <div class="hd2-pad" style="padding-bottom:16px">
                            <p class="hd2-sec" style="margin-top:0">Location</p>
                            @if($hasGeo)
                            <div id="hotelDetMap" data-lat="{{ $hotel->latitude }}" data-lng="{{ $hotel->longitude }}" data-name="{{ $hotel->name }}"></div>
                            @else
                            <iframe class="hd2-mapframe" loading="lazy" allowfullscreen src="https://maps.google.com/maps?q={{ $mapQuery }}&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
                            @endif
                            <p class="text-muted mt-3" style="font-size:13px">{{ $fullAddress }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($related) && $related->count())
            <div class="mt-3">
                <div class="d-flex align-items-center" style="gap:14px;margin:30px 0 22px">
                    <h3 style="margin:0;font-size:24px;font-weight:700;color:var(--ink)"><i class="fa fa-hotel" style="color:var(--brand)"></i> More Hotels in {{ $hotel->city }}</h3>
                    <span style="flex:1;height:1px;background:#eceef3"></span>
                    <a href="{{ route('pakistan_hotels') }}" style="color:var(--brand);font-weight:600;font-size:14px;white-space:nowrap">View all <i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="row">
                    @foreach($related as $r)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="hd2-card" style="height:100%;display:flex;flex-direction:column">
                            <a href="{{ url('/hotel-detail', $r->id) }}" style="display:block;height:180px;overflow:hidden">
                                <img src="{{ asset('hotels/'.$r->image) }}" alt="{{ $r->name }}" style="width:100%;height:100%;object-fit:cover" onerror="this.style.opacity=.3">
                            </a>
                            <div style="padding:16px 18px;flex:1">
                                <h5 style="margin:0 0 6px;font-size:16px;font-weight:700;color:var(--ink)"><a href="{{ url('/hotel-detail', $r->id) }}" style="color:var(--ink)">{{ $r->name }}</a></h5>
                                <p style="margin:0;font-size:13px;color:var(--muted)"><i class="fa fa-location-dot" style="color:var(--brand);margin-right:6px"></i>{{ trim(collect([$r->city, $r->state])->filter()->implode(', ')) }}</p>
                            </div>
                            <div style="padding:0 18px 18px;display:flex;align-items:center;justify-content:space-between">
                                @if(!empty($r->price))<span style="color:var(--brand);font-weight:700;font-size:14px">${{ $r->price }}/night</span>@else<span></span>@endif
                                <a href="{{ url('/hotel-detail', $r->id) }}" style="color:var(--brand);font-weight:600;font-size:13px">View <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
</main>

<div id="hd2Lb"><span class="cls">&times;</span><img id="hd2LbImg" src="" alt=""></div>

@if($hasGeo)<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>@endif
<script>
(function () {
    // Lightbox
    var lb = document.getElementById('hd2Lb'), lbImg = document.getElementById('hd2LbImg');
    document.addEventListener('click', function (e) {
        var z = e.target.closest('.hd2-zoom');
        if (z) { lbImg.src = z.getAttribute('data-full'); lb.style.display = 'flex'; return; }
        if (e.target.closest('#hd2Lb')) { lb.style.display = 'none'; lbImg.src = ''; }
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { lb.style.display = 'none'; lbImg.src = ''; } });

    // Leaflet map
    var el = document.getElementById('hotelDetMap');
    if (el && typeof L !== 'undefined') {
        var lat = parseFloat(el.getAttribute('data-lat')), lng = parseFloat(el.getAttribute('data-lng'));
        var map = L.map('hotelDetMap').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup(el.getAttribute('data-name')).openPopup();
        setTimeout(function () { map.invalidateSize(); }, 200);
    }
})();
</script>
@endsection
