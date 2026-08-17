@extends('layouts.app')

@php
    $pageTitle = 'Popular Locations Visited on a Pakistan Yatra';
    $pageDescription = 'The historic Gurdwaras and sites Konnect Yatra pilgrims visit in Pakistan — '
        . 'Nankana Sahib, Panja Sahib, Kartarpur Sahib, Rohri Sahib, Sacha Sauda and the Gurdwaras '
        . 'of Lahore.';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    \App\Support\Schema::webPage([
        'type'        => 'CollectionPage',
        'name'        => 'Popular Locations',
        'description' => $pageDescription,
        'breadcrumb'  => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Popular Locations', null],
    ]),
    \App\Support\Schema::itemList(
        collect($locations)->map(fn ($l) => [
            'url'  => route('location_detail', $l->id),
            'name' => trim($l->name . ' — ' . $l->city, ' —'),
        ])->all(),
        'Places visited on a Konnect Yatra pilgrimage'
    ),
]) !!}
@endsection

@section('content')
<style type="text/css">
    .loc{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    .loc-search{position:relative;max-width:420px;margin:0 auto 34px}
    .loc-search i{position:absolute;top:50%;left:16px;transform:translateY(-50%);color:#aaa}
    .loc-search input{width:100%;padding:12px 16px 12px 42px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .loc-search input:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .loc-card{background:#fff;border:1px solid #eef0f4;border-radius:20px;overflow:hidden;box-shadow:0 8px 24px rgba(28,37,65,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .loc-card:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(28,37,65,.14)}
    .loc-photo{height:230px;background:#f1f2f6;overflow:hidden}
    .loc-photo img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
    .loc-card:hover .loc-photo img{transform:scale(1.05)}
    .loc-body{padding:20px 22px;flex:1}
    .loc-body h5{margin:0 0 6px;font-size:18px;font-weight:700;color:var(--ink)}
    .loc-body p{margin:0;font-size:13.5px;color:#4b5563}
    .loc-body p i{color:var(--brand);margin-right:6px}
    .loc-foot{padding:0 22px 22px}
    .loc-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:var(--brand);color:#fff !important;font-weight:700;font-size:14.5px;padding:12px;border-radius:30px;text-decoration:none;transition:.15s}
    .loc-btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(245,78,24,.3);color:#fff}
    .loc-empty{padding:50px;text-align:center;color:#9aa0ac;font-size:17px;width:100%}
</style>

<main id="content" class="site-main loc">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container"
            style="background-image: url('{{ \App\Models\PageBanner::url('popular-locations', asset('assets/images2/Inner-banner-01.png')) }}');background-position:center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:60px !important;">POPULAR LOCATIONS</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Locations</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="package-section section-sp2">
        <div class="container">
            <div class="section-heading text-center" style="margin-bottom:30px">
                <h5 class="dash-style" style="color:var(--brand)">EXPLORE GREAT LOCATIONS</h5>
                <h2 style="font-weight:700;color:var(--ink)">Popular Locations</h2>
                <p class="text-muted" style="max-width:720px;margin:8px auto 0">
                    Places widely recognized for their cultural, historical or natural importance — drawing visitors from various regions.
                </p>
            </div>

            <div class="loc-search">
                <i class="fa fa-search"></i>
                <input type="text" id="locSearch" placeholder="Search by name or city…" autocomplete="off">
            </div>

            <div class="row" id="locGrid">
                @forelse($locations as $value)
                <div class="col-lg-4 col-md-6 mb-4 loc-item" data-search="{{ strtolower(trim($value->name.' '.$value->city.' '.$value->state)) }}">
                    <div class="loc-card">
                        <a href="{{ url('/location-detail', $value->id) }}" class="loc-photo">
                            <img src="{{ asset('locations/'.$value->image) }}" alt="{{ $value->name }}" onerror="this.src='{{ asset('assets/images2/Inner-banner-01.png') }}'">
                        </a>
                        <div class="loc-body">
                            <h5>{{ $value->name }}</h5>
                            <p><i class="fa fa-map-marker-alt"></i>{{ trim(collect([$value->city, $value->state])->filter()->implode(', ')) }}</p>
                        </div>
                        <div class="loc-foot">
                            <a href="{{ url('/location-detail', $value->id) }}" class="loc-btn">Explore More <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="loc-empty">No locations listed yet.</div></div>
                @endforelse
            </div>
            <div class="loc-empty" id="locNoResults" style="display:none;">No locations match your search.</div>
        </div>
    </section>
</main>

<script>
(function () {
    var input = document.getElementById('locSearch');
    var items = Array.prototype.slice.call(document.querySelectorAll('.loc-item'));
    var noRes = document.getElementById('locNoResults');
    if (!input) return;
    input.addEventListener('input', function () {
        var q = this.value.toLowerCase().trim();
        var visible = 0;
        items.forEach(function (el) {
            var match = el.getAttribute('data-search').indexOf(q) !== -1;
            el.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        noRes.style.display = (visible === 0 && items.length) ? 'block' : 'none';
    });
})();
</script>
@endsection
