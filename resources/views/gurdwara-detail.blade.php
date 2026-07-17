@extends('layouts.app')
@section('content')
@php
    $fullAddress = trim(collect([
        $gurdwara->address, $gurdwara->city, $gurdwara->state, $gurdwara->zip, $gurdwara->country
    ])->filter()->implode(', '));
    $mapQuery = urlencode($gurdwara->gurdwara_name . ' ' . $fullAddress);
@endphp
<style type="text/css">
    .gd{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    .gd-card{background:#fff;border:1px solid #eef0f4;border-radius:18px;box-shadow:0 12px 36px rgba(28,37,65,.08);overflow:hidden}
    .gd-hero-img{width:100%;height:360px;object-fit:cover;display:block;background:#f1f2f6}
    .gd-pad{padding:28px 30px}
    .gd-title{font-size:28px;font-weight:800;color:var(--ink);margin:0 0 6px;line-height:1.25}
    .gd-addr{color:var(--muted);font-size:15px;margin:0}
    .gd-addr i{color:var(--brand);margin-right:6px}
    .gd-badge{display:inline-block;background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:20px;font-size:12px;font-weight:700;padding:4px 14px;margin-bottom:14px}
    .gd-sec-label{text-transform:uppercase;letter-spacing:.07em;font-size:12px;font-weight:700;color:var(--muted);margin:24px 0 12px}
    .gd-info{list-style:none;padding:0;margin:0}
    .gd-info li{display:flex;gap:12px;padding:11px 0;border-bottom:1px dashed #eef0f4;font-size:14.5px}
    .gd-info li:last-child{border-bottom:none}
    .gd-info li i{color:var(--brand);width:18px;text-align:center;margin-top:3px}
    .gd-info li .lbl{color:var(--muted);min-width:120px}
    .gd-info li .val{color:var(--ink);font-weight:600;word-break:break-word}
    .gd-people{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
    .gd-person{border:1px solid #eef0f4;border-radius:14px;padding:14px 16px}
    .gd-person .role{font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.04em}
    .gd-person .name{font-size:15px;font-weight:700;color:var(--ink);margin:3px 0}
    .gd-person .ph{font-size:13px;color:var(--brand)}
    .gd-map iframe{width:100%;height:340px;border:0;border-radius:16px}
    .gd-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:24px}
    .gd-btn{display:inline-flex;align-items:center;gap:8px;font-weight:700;font-size:14.5px;padding:12px 26px;border-radius:30px;text-decoration:none}
    .gd-btn.primary{background:var(--brand);color:#fff !important}
    .gd-btn.ghost{background:#fff;border:1px solid #e7e9ef;color:var(--ink) !important}
    .gd-btn:hover{transform:translateY(-2px)}
    .gd-related .gw-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;overflow:hidden;box-shadow:0 8px 22px rgba(28,37,65,.07)}
    .gd-related img{width:100%;height:160px;object-fit:cover}
    .gd-related .b{padding:14px 16px}
    .gd-related h6{margin:0 0 4px;font-weight:700;color:var(--ink);font-size:15px}
    .gd-related p{margin:0;font-size:13px;color:var(--muted)}
    @media (max-width:575px){.gd-people{grid-template-columns:1fr}.gd-hero-img{height:230px}}
</style>

<main id="content" class="site-main gd">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container"
            style="background-image: url('{{ \App\Models\PageBanner::url('gurdwaras', asset('assets/images2/News-04.png')) }}');background-position: center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:48px !important;">{{ $gurdwara->gurdwara_name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('gurdwaras') }}">Gurdwaras</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $gurdwara->city }}</li>
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
                    <div class="gd-card">
                        @if(!empty($gurdwara->gurdwara_image))
                        <img class="gd-hero-img" src="{{ asset('gurdwara_images/'.$gurdwara->gurdwara_image) }}" alt="{{ $gurdwara->gurdwara_name }}"
                             onerror="this.src='{{ asset('assets/images2/News-04.png') }}'">
                        @endif
                        <div class="gd-pad">
                            @if(!empty($gurdwara->sangat))<span class="gd-badge">{{ $gurdwara->sangat }} Sangat</span>@endif
                            <h1 class="gd-title">{{ $gurdwara->gurdwara_name }}</h1>
                            <p class="gd-addr"><i class="fa fa-map-marker-alt"></i>{{ $fullAddress }}</p>

                            <p class="gd-sec-label">Contact</p>
                            <ul class="gd-info">
                                @if(!empty($gurdwara->phone_no))<li><i class="fa fa-phone"></i><span class="lbl">Phone</span><span class="val"><a href="tel:{{ $gurdwara->phone_no }}">{{ $gurdwara->phone_no }}</a></span></li>@endif
                                @if(!empty($gurdwara->email_address))<li><i class="fa fa-envelope"></i><span class="lbl">Email</span><span class="val"><a href="mailto:{{ $gurdwara->email_address }}">{{ $gurdwara->email_address }}</a></span></li>@endif
                                <li><i class="fa fa-map"></i><span class="lbl">City / State</span><span class="val">{{ $gurdwara->city }}, {{ $gurdwara->state }} {{ $gurdwara->zip }}</span></li>
                            </ul>

                            @php
                                $people = collect([
                                    ['Chairman', $gurdwara->chairman_name, $gurdwara->chairman_phone_no, $gurdwara->chairman_email],
                                    ['Pardhan', $gurdwara->pardan_name, $gurdwara->phone_no, $gurdwara->pardan_email],
                                    ['Secretary', $gurdwara->secretary_name, $gurdwara->secretary_phone_no, $gurdwara->secretary_email],
                                    ['Office Manager', $gurdwara->manager_name, $gurdwara->manager_phone_no, $gurdwara->manager_email],
                                    ['Granthi', $gurdwara->granthi_name, null, $gurdwara->granthi_email],
                                    ['Head Granthi', $gurdwara->head_garanti_name, $gurdwara->head_garanti_phone_no, null],
                                    ['Ragi', $gurdwara->ragi_name, null, null],
                                    ['Senior Board Member', $gurdwara->senior_board_member, null, null],
                                ])->filter(fn($p) => !empty($p[1]));
                            @endphp
                            @if($people->count())
                            <p class="gd-sec-label">Management</p>
                            <div class="gd-people">
                                @foreach($people as $p)
                                <div class="gd-person">
                                    <div class="role">{{ $p[0] }}</div>
                                    <div class="name">{{ $p[1] }}</div>
                                    @if(!empty($p[2]))<div class="ph"><i class="fa fa-phone"></i> <a href="tel:{{ $p[2] }}">{{ $p[2] }}</a></div>@endif
                                    @if(!empty($p[3]))<div class="ph"><i class="fa fa-envelope"></i> <a href="mailto:{{ $p[3] }}">{{ $p[3] }}</a></div>@endif
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @if(!empty($gurdwara->notes))
                            <p class="gd-sec-label">Notes</p>
                            <p style="color:var(--ink);font-size:14.5px;line-height:1.6;white-space:pre-line;margin:0">{{ $gurdwara->notes }}</p>
                            @endif

                            <div class="gd-actions">
                                <a class="gd-btn primary" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ $mapQuery }}"><i class="fa fa-diamond-turn-right"></i> Get Directions</a>
                                <a class="gd-btn ghost" href="{{ route('gurdwaras') }}"><i class="fa fa-arrow-left"></i> All Gurdwaras</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="gd-card">
                        <div class="gd-pad" style="padding-bottom:14px">
                            <p class="gd-sec-label" style="margin-top:0">Location</p>
                            <div class="gd-map">
                                <iframe loading="lazy" allowfullscreen
                                    src="https://maps.google.com/maps?q={{ $mapQuery }}&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
                            </div>
                            <p class="text-muted mt-3" style="font-size:13px">{{ $fullAddress }}</p>
                        </div>
                    </div>

                    @if($related->count())
                    <div class="gd-related mt-4">
                        <p class="gd-sec-label" style="margin-top:0">More in {{ $gurdwara->state }}</p>
                        @foreach($related as $r)
                        <a href="{{ route('gurdwara_detail', $r->id) }}" class="d-block mb-3 gw-card" style="text-decoration:none">
                            <img src="{{ asset('gurdwara_images/'.$r->gurdwara_image) }}" alt="{{ $r->gurdwara_name }}" onerror="this.src='{{ asset('assets/images2/News-04.png') }}'">
                            <div class="b">
                                <h6>{{ $r->gurdwara_name }}</h6>
                                <p>{{ $r->city }}, {{ $r->state }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
