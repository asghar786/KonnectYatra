@extends('layouts.app')

@php
    $fullAddress = trim(collect([$location->name, $location->city, $location->state])->filter()->implode(', '));
    $hasGeo = !empty($location->latitude) && !empty($location->longitude);
    $mapQuery = urlencode($location->name . ' ' . $location->city . ' ' . $location->state . ' Pakistan');

    $locUrl    = route('location_detail', $location->id);
    $locImages = collect([$location->image])
        ->concat(collect($location->images ?? [])->pluck('image'))
        ->filter()->unique()
        ->map(fn ($img) => asset('locations/' . $img))
        ->values();

    // A shrine on the yatra gets the qualifier people actually search for
    // ("Panja Sahib Yatra", "Gurdwara Dera Sahib Lahore Tour"); the Mughal and
    // civic landmarks on the itinerary are not pilgrimage sites and keep a
    // plain title. Keyed off the name so no column or admin field is needed.
    $isShrine = (bool) preg_match('/gurdwara|gurudwara|sahib|samadhi/iu', $location->name);

    // Nankana Sahib is a shrine in a city of the same name — "Nankana Sahib —
    // Nankana Sahib" helps nobody, so drop a city already inside the name.
    $titleCity = $location->city
        && stripos($location->name, (string) $location->city) === false
            ? $location->city
            : null;

    $pageTitle = $isShrine
        ? $location->name . ' Yatra & Tour' . ($titleCity ? ' — ' . $titleCity : '')
        : $location->name . ($titleCity ? ' — ' . $titleCity . ', Pakistan' : '');
    $pageDescription = \App\Support\Schema::text($location->description, 300)
        ?: $location->name . ($fullAddress ? ', ' . $fullAddress : '')
           . ' — a place visited on Konnect Yatra pilgrimage tours of Pakistan.';
    $pageImage = $locImages->first();
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    [
        '@type'       => 'TouristAttraction',
        '@id'         => $locUrl . '#place',
        'name'        => $location->name,
        'url'         => $locUrl,
        'description' => \App\Support\Schema::text($location->description, 500),
        'image'       => $locImages->all() ?: null,
        'address'     => \App\Support\Schema::postalAddress([
            'locality' => $location->city,
            'region'   => $location->state,
            'country'  => 'PK',
        ]),
        'geo'                 => \App\Support\Schema::geo($location->latitude, $location->longitude),
        'hasMap'              => 'https://www.google.com/maps/search/?api=1&query=' . $mapQuery,
        'touristType'         => ['Sikh pilgrims', 'Religious travellers'],
        'isAccessibleForFree' => true,
    ],
    \App\Support\Schema::webPage([
        'type'          => 'ItemPage',
        'name'          => $location->name,
        'description'   => $pageDescription,
        'image'         => $pageImage,
        'url'           => $locUrl,
        'dateModified'  => $location->updated_at,
        'primaryEntity' => $locUrl . '#place',
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Popular Locations', route('popular_locations')],
        [$location->name, null],
    ]),
]) !!}
@endsection

@section('content')
@if($hasGeo)<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">@endif
<style type="text/css">
    .ld2{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    .ld2-card{background:#fff;border:1px solid #eef0f4;border-radius:18px;box-shadow:0 12px 36px rgba(28,37,65,.08);overflow:hidden}
    .ld2-feature{width:100%;height:420px;object-fit:cover;display:block;background:#f1f2f6;cursor:zoom-in}
    .ld2-gallery{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;padding:14px}
    .ld2-gallery img{width:100%;height:90px;object-fit:cover;border-radius:10px;cursor:zoom-in;transition:transform .15s}
    .ld2-gallery img:hover{transform:scale(1.05)}
    .ld2-pad{padding:26px 30px}
    .ld2-title{font-size:30px;font-weight:800;color:var(--ink);margin:0}
    .ld2-addr{color:var(--muted);font-size:15px;margin:10px 0 0}.ld2-addr i{color:var(--brand);margin-right:7px}
    .ld2-sec{text-transform:uppercase;letter-spacing:.06em;font-size:12px;font-weight:700;color:var(--muted);margin:24px 0 12px}
    .ld2-desc{color:#374151;font-size:15px;line-height:1.75}
    .ld2-info{list-style:none;padding:0;margin:0}
    .ld2-info li{display:flex;gap:12px;padding:11px 0;border-bottom:1px dashed #eef0f4;font-size:14.5px}
    .ld2-info li:last-child{border-bottom:none}
    .ld2-info li i{color:var(--brand);width:18px;text-align:center;margin-top:3px}
    .ld2-info li .lbl{color:var(--muted);min-width:90px}.ld2-info li .val{color:var(--ink);font-weight:600}
    #locDetMap{height:320px;border-radius:16px;border:1px solid #eef0f4;z-index:1}
    .ld2-mapframe{width:100%;height:320px;border:0;border-radius:16px}
    .ld2-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}
    .ld2-btn{display:inline-flex;align-items:center;gap:8px;font-weight:700;font-size:14.5px;padding:12px 26px;border-radius:30px;text-decoration:none}
    .ld2-btn.primary{background:var(--brand);color:#fff !important}.ld2-btn.ghost{background:#fff;border:1px solid #e7e9ef;color:var(--ink) !important}
    .ld2-btn:hover{transform:translateY(-2px)}
    @media (max-width:767px){.ld2-feature{height:240px}.ld2-gallery{grid-template-columns:repeat(3,1fr)}}
    #ld2Lb{position:fixed;inset:0;background:rgba(0,0,0,.92);display:none;align-items:center;justify-content:center;z-index:99999;padding:30px}
    #ld2Lb img{max-width:94%;max-height:90%;border-radius:8px}
    #ld2Lb .cls{position:absolute;top:18px;right:28px;color:#fff;font-size:36px;cursor:pointer}
</style>

<main id="content" class="site-main ld2">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container" style="background-image:url('{{ asset('assets/images2/newbanner1.jpg') }}');background-position:center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:52px !important;">{{ $location->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('popular_locations') }}">Locations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $location->city }}</li>
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
                    <div class="ld2-card">
                        <img class="ld2-feature ld2-zoom" src="{{ asset('locations/'.$location->image) }}" data-full="{{ asset('locations/'.$location->image) }}" alt="{{ $location->name }}">
                        @if($location->images && $location->images->count())
                        <div class="ld2-gallery">
                            @foreach($location->images as $img)
                            <img class="ld2-zoom" src="{{ asset('locations/'.$img->image) }}" data-full="{{ asset('locations/'.$img->image) }}" alt="{{ $location->name }} photo">
                            @endforeach
                        </div>
                        @endif
                        <div class="ld2-pad">
                            {{-- The banner above is this page's H1; repeating the name in a
                                 second H1 gave every location page two competing headings. --}}
                            <h2 class="ld2-title">{{ $location->name }}</h2>
                            <p class="ld2-addr"><i class="fa fa-map-marker-alt"></i>{{ trim(collect([$location->city, $location->state])->filter()->implode(', ')) }}</p>

                            @if(!empty($location->description))
                            <p class="ld2-sec">About this place</p>
                            <div class="ld2-desc">{!! nl2br(e($location->description)) !!}</div>
                            @endif

                            <p class="ld2-sec">Details</p>
                            <ul class="ld2-info">
                                <li><i class="fa fa-city"></i><span class="lbl">City</span><span class="val">{{ $location->city }}</span></li>
                                <li><i class="fa fa-map"></i><span class="lbl">Province</span><span class="val">{{ $location->state }}</span></li>
                            </ul>

                            <div class="ld2-actions">
                                <a class="ld2-btn primary" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ $hasGeo ? $location->latitude.','.$location->longitude : $mapQuery }}"><i class="fa fa-diamond-turn-right"></i> Get Directions</a>
                                <a class="ld2-btn ghost" href="{{ route('popular_locations') }}"><i class="fa fa-arrow-left"></i> All Locations</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="ld2-card">
                        <div class="ld2-pad" style="padding-bottom:16px">
                            <p class="ld2-sec" style="margin-top:0">Location</p>
                            @if($hasGeo)
                            <div id="locDetMap" data-lat="{{ $location->latitude }}" data-lng="{{ $location->longitude }}" data-name="{{ $location->name }}"></div>
                            @else
                            <iframe class="ld2-mapframe" loading="lazy" allowfullscreen src="https://maps.google.com/maps?q={{ $mapQuery }}&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                            @endif
                            <p class="text-muted mt-3" style="font-size:13px">{{ $fullAddress }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div id="ld2Lb"><span class="cls">&times;</span><img id="ld2LbImg" src="" alt=""></div>

@if($hasGeo)<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>@endif
<script>
(function () {
    var lb = document.getElementById('ld2Lb'), lbImg = document.getElementById('ld2LbImg');
    document.addEventListener('click', function (e) {
        var z = e.target.closest('.ld2-zoom');
        if (z) { lbImg.src = z.getAttribute('data-full'); lb.style.display = 'flex'; return; }
        if (e.target.closest('#ld2Lb')) { lb.style.display = 'none'; lbImg.src = ''; }
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { lb.style.display = 'none'; lbImg.src = ''; } });
    var el = document.getElementById('locDetMap');
    if (el && typeof L !== 'undefined') {
        var lat = parseFloat(el.getAttribute('data-lat')), lng = parseFloat(el.getAttribute('data-lng'));
        var map = L.map('locDetMap').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup(el.getAttribute('data-name')).openPopup();
        setTimeout(function () { map.invalidateSize(); }, 200);
    }
})();
</script>
@endsection
