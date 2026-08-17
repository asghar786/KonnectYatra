@extends('layouts.app')

@php
    $pageTitle = 'Yatra Packages to Pakistan — Gurpurab, Vaisakhi & VIP Tours';
    $pageDescription = 'All Konnect Yatra pilgrimage packages: Gurpurab, Vaisakhi and VIP tours to '
        . 'Nankana Sahib, Panja Sahib and Kartarpur Sahib, with departures from cities across the '
        . 'USA and Canada. Round trip, one way and land-only pricing.';
    $schemaPackages = collect($all_packages)
        ->concat($all_packages1)
        ->concat($all_packages2)
        ->filter();
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    \App\Support\Schema::webPage([
        'type'        => 'CollectionPage',
        'name'        => 'Yatra Packages',
        'description' => $pageDescription,
        'breadcrumb'  => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Yatra Packages', null],
    ]),
    \App\Support\Schema::itemList(
        $schemaPackages->map(fn ($p) => [
            'url'  => route('package', $p->id),
            'name' => $p->name,
        ])->all(),
        'Konnect Yatra pilgrimage packages'
    ),
]) !!}
@endsection

@section('content')
<style type="text/css">
  .apkg{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
  /* Blessing header */
  .apkg-blessing{display:flex;flex-direction:column;align-items:center;gap:16px;margin:6px 0 30px}
  .apkg-blessing-row{display:flex;align-items:center;justify-content:center;gap:20px;flex-wrap:wrap;width:100%;max-width:680px;margin:0 auto}
  .apkg-blessing span{color:var(--brand);font-weight:600;font-size:19px;white-space:nowrap}
  .apkg-fcfs{display:inline-block;background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:30px;padding:14px 32px;font-weight:700;font-size:19px}
  .apkg-blessing-duo .apkg-fcfs{flex:1;text-align:center}
  .apkg-blessing-row:not(.apkg-blessing-duo) .apkg-fcfs{font-size:16px;padding:11px 28px}
  /* Tabs */
  .apkg-tabs{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;border:0;margin-bottom:36px}
  .apkg-tabs .nav-item{margin:0}
  .apkg-tabs .nav-link{border:1px solid #e7e9ef !important;border-radius:30px;color:var(--ink) !important;font-weight:600;font-size:16px;padding:11px 28px;background:#fff;transition:.15s}
  .apkg-tabs .nav-link:hover{border-color:var(--brand) !important;color:var(--brand) !important}
  .apkg-tabs .nav-link.active{background:var(--brand) !important;border-color:var(--brand) !important;color:#fff !important;box-shadow:0 8px 18px rgba(245,78,24,.28)}
  /* State selector */
  .apkg-state-pick{max-width:360px;margin:0 auto 34px}
  .apkg-state-pick label{font-weight:700;color:var(--ink);margin-bottom:8px;display:block}
  .apkg-state-pick select{border:1px solid #e2e4ea;border-radius:30px;padding:11px 18px;height:auto;font-size:15px}
  .apkg-state-pick select:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(245,78,24,.12)}
  /* Origin selector (cascading: country -> state -> airport) */
  .apkg-origin-pick{max-width:780px;margin:0 auto 34px;text-align:center}
  .apkg-origin-label{font-weight:700;color:var(--ink);margin-bottom:14px;font-size:18px}
  .apkg-origin-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  .apkg-origin-field{text-align:left}
  .apkg-origin-field label{font-weight:600;color:var(--ink);margin-bottom:6px;display:block;font-size:14px}
  .apkg-origin-field select{border:1px solid #e2e4ea;border-radius:30px;padding:11px 18px;height:auto;font-size:15px;width:100%}
  .apkg-origin-field select:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(245,78,24,.12)}
  .apkg-origin-field select:disabled{background:#f6f7f9;color:#9aa0ac;cursor:not-allowed}
  .apkg-origin-hint{text-align:center;color:#9aa0ac;font-size:16px;padding:30px 20px;margin:0}
  /* Shown when a chosen origin has no packages yet */
  .apkg-soon{text-align:center;padding:6px 20px 24px}
  .apkg-soon img{width:760px;max-width:100%;height:auto;border-radius:16px;box-shadow:0 14px 40px rgba(28,37,65,.12)}
  .apkg-soon p{margin:20px auto 0;max-width:560px;color:var(--muted);font-size:16px;line-height:1.6}
  .apkg-soon strong{color:var(--ink)}
  .apkg-soon a{color:var(--brand);font-weight:700}
  @media (max-width:575px){.apkg-origin-grid{grid-template-columns:1fr}}
  /* Pricing card */
  .apkg-card{background:#fff;border:1px solid #eef0f4;border-radius:20px;box-shadow:0 14px 40px rgba(28,37,65,.08);overflow:hidden;height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
  .apkg-card:hover{transform:translateY(-4px);box-shadow:0 20px 46px rgba(28,37,65,.14)}
  .apkg-card-head{background:linear-gradient(135deg,#2d1b69,#5b2a9e);color:#fff;padding:24px 26px;text-align:center}
  .apkg-card-head h3{margin:0;font-size:21px;font-weight:700;color:#fff;line-height:1.3}
  .apkg-card-head .apkg-state{display:inline-block;margin-top:10px;background:rgba(255,255,255,.18);padding:3px 14px;border-radius:20px;font-size:13px;font-weight:600}
  .apkg-card-body{padding:24px 26px;flex:1}
  .apkg-tier{margin-bottom:18px}
  .apkg-tier:last-of-type{margin-bottom:0}
  .apkg-tier-title{background:var(--brand);color:#fff;border-radius:10px;text-align:center;padding:9px 12px;font-weight:700;font-size:15px}
  .apkg-tier-title small{font-weight:500;opacity:.9}
  .apkg-price-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px}
  .apkg-price{text-align:center;border:1px solid #eef0f4;border-radius:14px;padding:14px 8px}
  .apkg-price span{display:block;font-size:13px;color:var(--muted);font-weight:600;margin-bottom:4px}
  .apkg-price b{font-size:22px;font-weight:800;color:var(--ink)}
  .apkg-price b small{font-size:14px;color:var(--brand);vertical-align:top}
  .apkg-price .call{font-size:15px;font-weight:700;color:var(--brand)}
  .apkg-card-foot{padding:6px 26px 26px;text-align:center}
  .apkg-btn{display:inline-flex;align-items:center;gap:9px;background:var(--brand);color:#fff !important;font-weight:700;font-size:16px;padding:13px 44px;border-radius:30px;box-shadow:0 8px 18px rgba(245,78,24,.3);transition:.15s}
  .apkg-btn:hover{transform:translateY(-2px);text-decoration:none;color:#fff}
  .apkg-empty{padding:50px 20px;text-align:center;color:#9aa0ac;font-size:17px;width:100%}
  .apkg-desc{margin-top:14px;color:#4b5563;font-size:14px;line-height:1.6}
  /* "Package Included" trigger button (replaces inline list) */
  .apkg-incl-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;margin-top:16px;
    background:#fff;color:var(--brand);border:1.5px dashed var(--brand);font-weight:700;font-size:15px;
    padding:12px 16px;border-radius:14px;cursor:pointer;transition:.15s}
  .apkg-incl-btn:hover{background:var(--brand);color:#fff}
  .apkg-incl-btn i{font-size:16px}
  /* animated "clickable" cue so visitors know the button opens details */
  .apkg-incl-cue{margin-left:6px;color:var(--brand);animation:apkgPoke 1.3s ease-in-out infinite}
  .apkg-incl-btn:hover .apkg-incl-cue{color:#fff}
  @keyframes apkgPoke{0%,100%{transform:translate(0,0)}50%{transform:translate(3px,3px)}}
  /* Modal */
  .pkgm-overlay{--brand:#f54e18;--ink:#1c2541;position:fixed;inset:0;background:rgba(20,26,45,.6);backdrop-filter:blur(2px);z-index:1080;
    display:none;align-items:center;justify-content:center;padding:16px}
  /* Ensure the footer button stays readable even outside the .apkg scope */
  .pkgm-foot .apkg-btn{background:#f54e18;color:#fff !important}
  .pkgm-foot .apkg-btn:hover{background:#e0440f}
  .pkgm-overlay.open{display:flex}
  .pkgm{background:#fff;border-radius:20px;width:100%;max-width:520px;max-height:88vh;display:flex;flex-direction:column;
    overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.35);animation:pkgmIn .2s ease}
  @keyframes pkgmIn{from{transform:translateY(14px);opacity:0}to{transform:translateY(0);opacity:1}}
  .pkgm-head{background:linear-gradient(135deg,#2d1b69,#5b2a9e);color:#fff;padding:18px 20px;display:flex;align-items:center;gap:14px}
  .pkgm-head .pkgm-ill{flex:0 0 auto;width:46px;height:46px;border-radius:12px;background:rgba(255,255,255,.16);
    display:flex;align-items:center;justify-content:center;font-size:22px}
  .pkgm-head h4{margin:0;font-size:18px;font-weight:800;line-height:1.2;color:#fff}
  .pkgm-head p{margin:2px 0 0;font-size:12.5px;opacity:.85}
  .pkgm-x{position:absolute;top:14px;right:16px;color:#fff;background:rgba(255,255,255,.18);border:0;width:30px;height:30px;
    border-radius:50%;font-size:16px;cursor:pointer;line-height:1}
  .pkgm-body{padding:16px 20px;overflow-y:auto;color:#33384a;font-size:14px;line-height:1.55}
  /* Turn the included list into a clean icon checklist regardless of source markup */
  .pkgm-body p,.pkgm-body li,.pkgm-body div{position:relative;padding:6px 0 6px 26px;margin:0;border-bottom:1px solid #f1f2f6}
  .pkgm-body p:last-child,.pkgm-body li:last-child{border-bottom:0}
  .pkgm-body p::before,.pkgm-body li::before{content:"\2713";position:absolute;left:0;top:6px;color:var(--brand);
    font-weight:900;font-size:13px}
  .pkgm-body strong,.pkgm-body b{color:var(--ink)}
  .pkgm-body ul{list-style:none;margin:0;padding:0}
  .pkgm-foot{padding:12px 20px 18px;border-top:1px solid #eef0f4}
  .pkgm-foot .apkg-btn{width:100%;justify-content:center;padding:13px 0}
  @media (max-width:575px){.apkg-price-row{grid-template-columns:1fr}.apkg-card-head h3{font-size:19px}
    .pkgm-head h4{font-size:16px}.pkgm-body{font-size:13.5px}}
</style>

<main id="content" class="site-main apkg">
  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container"
      style="background-image: url('{{ \App\Models\PageBanner::url('all-packages', asset('assets/images2/Inner-banner-01.png')) }}');background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size:65px !important;">PACKAGES</h1>
        </div>
      </div>
    </div>
    <div class="inner-shape"></div>
  </section>

  <section class="package-section section-sp2">
    <div class="container">
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
      </div>
      @endif

      <!-- Blessing -->
      <div class="apkg-blessing">
        <div class="apkg-blessing-row apkg-blessing-duo">
          <span class="apkg-fcfs">Wahe Guru Ji ka Khalsa</span>
          <span class="apkg-fcfs">Wahe Guru Ji ki Fateh</span>
        </div>
        <div class="apkg-blessing-row">
          <span class="apkg-fcfs">First Come First Serve</span>
        </div>
      </div>

      @php
        $fmtPrice = function ($v) {
            return ($v !== null && $v !== '' && (float) $v > 0)
                ? '<b><small>$</small>'.number_format((float) $v).'</b>'
                : '<span class="call">Call for Price</span>';
        };
      @endphp

      <!-- Tabs -->
      <ul class="nav nav-tabs apkg-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#vaisakhi" role="tab" aria-selected="false">Vaisakhi Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#birthday" role="tab" aria-selected="true">Gurpurab Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#vip" role="tab" aria-selected="false">VIP Packages</a>
        </li>
      </ul>

      <div class="tab-content">
        <!-- ============ VAISAKHI ============ -->
        <div class="tab-pane" id="vaisakhi" role="tabpanel">
          <div class="row justify-content-center">
            @forelse(@$all_packages as $val)
            <div class="col-lg-6 col-md-8 mb-4">
              <div class="apkg-card">
                <div class="apkg-card-head">
                  <h3>{{ @$val->name }}</h3>
                  @if(!empty(@$val->state))<span class="apkg-state">{{ $val->state }}</span>@endif
                </div>
                <div class="apkg-card-body">
                  <div class="apkg-tier">
                    <div class="apkg-tier-title">5&#9733; Hotel Package <small>(per person)</small></div>
                    <div class="apkg-price-row">
                      <div class="apkg-price"><span>Round Trip</span>{!! $fmtPrice(@$val->five_star_round_price) !!}</div>
                      <div class="apkg-price"><span>One Way</span>{!! $fmtPrice(@$val->five_star_single_price) !!}</div>
                    </div>
                  </div>
                  <div class="apkg-tier">
                    <div class="apkg-tier-title">4&#9733; Hotel Package <small>(per person)</small></div>
                    <div class="apkg-price-row">
                      <div class="apkg-price"><span>Round Trip</span>{!! $fmtPrice(@$val->four_star_round_price) !!}</div>
                      <div class="apkg-price"><span>One Way</span>{!! $fmtPrice(@$val->four_star_single_price) !!}</div>
                    </div>
                  </div>
                  @if(!empty(@$val->sdescription))
                  <button type="button" class="apkg-incl-btn js-pkg-incl" data-title="{{ @$val->name }}">
                    <i class="fa fa-clipboard-list"></i> Package Included
                    <i class="fa fa-mouse-pointer apkg-incl-cue" aria-hidden="true"></i>
                  </button>
                  <div class="js-pkg-incl-src d-none" style="display:none">{!! $val->sdescription !!}</div>
                  @endif
                </div>
                <div class="apkg-card-foot">
                  <a href="{{ url('all-packages', @$val->id) }}" class="apkg-btn"><i class="fa fa-plane"></i> Book Now</a>
                </div>
              </div>
            </div>
            @empty
            <div class="apkg-empty">No Vaisakhi packages available at the moment.</div>
            @endforelse
          </div>
        </div>

        <!-- ============ GURPURAB ============ -->
        <div class="tab-pane active" id="birthday" role="tabpanel">
          @if(count(@$all_packages1) > 0)
          <div class="apkg-origin-pick">
            <p class="apkg-origin-label"><i class="fa fa-map-marker-alt"></i> Select your origin</p>
            <div class="apkg-origin-grid">
              <div class="apkg-origin-field">
                <label>Country</label>
                <select class="form-control no-selectpicker" id="origin_country">
                  <option value="">— Choose country —</option>
                </select>
              </div>
              <div class="apkg-origin-field">
                <label>State / City</label>
                <select class="form-control no-selectpicker" id="origin_state" disabled>
                  <option value="">— Choose state —</option>
                </select>
              </div>
              <div class="apkg-origin-field">
                <label>Departure Airport</label>
                <select class="form-control no-selectpicker" id="origin_airport" disabled>
                  <option value="">— Choose airport —</option>
                </select>
              </div>
            </div>
          </div>
          <p class="apkg-origin-hint" id="apkg_hint">Please choose your country above to see available packages.</p>
          <div class="apkg-soon" id="apkg_soon" style="display:none;">
            <img src="{{ asset('assets/images2/comingsoon.webp') }}" alt="Coming soon — no packages from this departure airport yet">
            <p>We don't have a package departing from <strong id="apkg_soon_origin">this origin</strong> just yet.
              <a href="{{ url('contactus') }}">Contact us</a> and our team will arrange one for your group.</p>
          </div>
          <div class="row justify-content-center" id="apkg_cards">
            @foreach(@$all_packages1 as $key => $val)
            <div class="col-lg-6 col-md-8 mb-4 apkg-pkg" data-code="{{ $val->state_code }}" style="display:none;">
              <div class="apkg-card">
                <div class="apkg-card-head">
                  <h3>{{ @$val->name }}</h3>
                  @if(!empty(@$val->state))<span class="apkg-state">{{ $val->state }}</span>@endif
                </div>
                <div class="apkg-card-body">
                  <div class="apkg-tier">
                    <div class="apkg-tier-title">5&#9733; Hotel Package <small>(per person)</small></div>
                    <div class="apkg-price-row">
                      <div class="apkg-price"><span>Round Trip</span>{!! $fmtPrice(@$val->five_star_round_price) !!}</div>
                      <div class="apkg-price"><span>One Way</span>{!! $fmtPrice(@$val->five_star_single_price) !!}</div>
                    </div>
                  </div>
                  <div class="apkg-tier">
                    <div class="apkg-tier-title">4&#9733; Hotel Package <small>(per person)</small></div>
                    <div class="apkg-price-row">
                      <div class="apkg-price"><span>Round Trip</span>{!! $fmtPrice(@$val->four_star_round_price) !!}</div>
                      <div class="apkg-price"><span>One Way</span>{!! $fmtPrice(@$val->four_star_single_price) !!}</div>
                    </div>
                  </div>
                  @if(!empty(@$val->sdescription))
                  <button type="button" class="apkg-incl-btn js-pkg-incl" data-title="{{ @$val->name }}">
                    <i class="fa fa-clipboard-list"></i> Package Included
                    <i class="fa fa-mouse-pointer apkg-incl-cue" aria-hidden="true"></i>
                  </button>
                  <div class="js-pkg-incl-src d-none" style="display:none">{!! $val->sdescription !!}</div>
                  @endif
                </div>
                <div class="apkg-card-foot">
                  <a href="{{ url('all-packages', @$val->id) }}" class="apkg-btn"><i class="fa fa-plane"></i> Book Now</a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @else
          <div class="row"><div class="apkg-empty">No Gurpurab packages available at the moment.</div></div>
          @endif
        </div>

        <!-- ============ VIP ============ -->
        <div class="tab-pane" id="vip" role="tabpanel">
          <div class="row justify-content-center">
            @if(count(@$all_packages2) > 0)
            <div class="col-lg-6 col-md-8 mb-4">
              <div class="apkg-card">
                <div class="apkg-card-head">
                  <h3>Special Land Package</h3>
                  <span class="apkg-state">VIP</span>
                </div>
                <div class="apkg-card-body">
                  <div class="apkg-tier">
                    <div class="apkg-tier-title">5&#9733; Hotel Package <small>(per person)</small></div>
                    <div class="apkg-price-row">
                      <div class="apkg-price" style="grid-column:1 / -1">
                        <span>5 Nights &amp; 6 Days — starting from</span><b><small>$</small>950</b>
                      </div>
                    </div>
                  </div>
                  <div class="apkg-tier">
                    <div class="apkg-tier-title">4&#9733; Hotel Package <small>(per person)</small></div>
                    <div class="apkg-price-row">
                      <div class="apkg-price" style="grid-column:1 / -1">
                        <span>5 Nights &amp; 6 Days — starting from</span><b><small>$</small>750</b>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="apkg-card-foot">
                  <a href="{{ url('special-package') }}" class="apkg-btn"><i class="fa fa-plane"></i> Book Now</a>
                </div>
              </div>
            </div>
            @else
            <div class="apkg-empty">No VIP packages available at the moment.</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

{{-- Package Included modal (shared) --}}
<div class="pkgm-overlay" id="pkgIncludedModal">
  <div class="pkgm" role="dialog" aria-modal="true" style="position:relative">
    <button type="button" class="pkgm-x js-pkgm-close" aria-label="Close">&times;</button>
    <div class="pkgm-head">
      <div class="pkgm-ill"><i class="fa fa-route"></i></div>
      <div>
        <h4>Package Included</h4>
        <p id="pkgmSubtitle">Everything covered in your Yatra</p>
      </div>
    </div>
    <div class="pkgm-body" id="pkgmBody"></div>
    <div class="pkgm-foot">
      <button type="button" class="apkg-btn js-pkgm-close" style="border:0;cursor:pointer"><i class="fa fa-check"></i> Got it</button>
    </div>
  </div>
</div>

<script>
  // Origin data: Country -> State/City -> [{ name, code }]
  // Managed in admin → Packages & Travel → Departure Origins.
  const APKG_ORIGINS = {!! json_encode($origins ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

  // Collect all airport codes under a country (across all its states).
  function codesForCountry(c) {
    var codes = [];
    if (!c || !APKG_ORIGINS[c]) return codes;
    Object.keys(APKG_ORIGINS[c]).forEach(function (st) {
      APKG_ORIGINS[c][st].forEach(function (ap) { codes.push(ap.code); });
    });
    return codes;
  }

  // Collect airport codes under a single state.
  function codesForState(c, st) {
    var codes = [];
    if (!c || !st || !APKG_ORIGINS[c] || !APKG_ORIGINS[c][st]) return codes;
    APKG_ORIGINS[c][st].forEach(function (ap) { codes.push(ap.code); });
    return codes;
  }

  // Narrowest origin the visitor has picked so far, for the "coming soon" copy.
  function originLabel() {
    if ($('#origin_airport').val()) return $('#origin_airport option:selected').text();
    return $('#origin_state').val() || $('#origin_country').val() || 'this origin';
  }

  // Show only the package cards whose code is in `codes`. Three outcomes:
  // no country picked => hint; picked with matches => cards; picked with
  // none => "coming soon", since a blank page reads as broken.
  function filterCards(codes) {
    var shown = 0;
    $('#apkg_cards .apkg-pkg').each(function () {
      var match = codes.indexOf(String($(this).data('code') || '')) !== -1;
      $(this).toggle(match);
      if (match) shown++;
    });
    var picked = !!$('#origin_country').val();
    $('#apkg_hint').toggle(!picked);
    $('#apkg_soon').toggle(picked && shown === 0);
    if (picked && shown === 0) $('#apkg_soon_origin').text(originLabel());
  }

  $(function () {
    var $country = $('#origin_country'),
        $state   = $('#origin_state'),
        $airport = $('#origin_airport');

    // USA pinned 1st, Canada pinned 2nd, all other countries alphabetical.
    Object.keys(APKG_ORIGINS).sort(function (a, b) {
      var isUsa = function (n) { return /^(usa|u\.s\.a\.?|united states)$/i.test(String(n).trim()); };
      var isCanada = function (n) { return /^canada$/i.test(String(n).trim()); };
      var rank = function (n) { return isUsa(n) ? 0 : (isCanada(n) ? 1 : 2); };
      var ra = rank(a), rb = rank(b);
      if (ra !== rb) return ra - rb;
      return a.localeCompare(b);
    }).forEach(function (c) {
      $country.append(new Option(c, c));
    });

    // Nothing chosen yet -> no cards.
    filterCards([]);

    // ----- Package Included modal -----
    var $pkgm = $('#pkgIncludedModal');
    function openPkgm() { $pkgm.addClass('open'); $('body').css('overflow', 'hidden'); }
    function closePkgm() { $pkgm.removeClass('open'); $('body').css('overflow', ''); }

    $(document).on('click', '.js-pkg-incl', function () {
      var html  = $(this).siblings('.js-pkg-incl-src').html() || '';
      var title = $(this).data('title') || 'Everything covered in your Yatra';
      $('#pkgmBody').html(html);
      $('#pkgmSubtitle').text(title);
      openPkgm();
    });
    $(document).on('click', '.js-pkgm-close', closePkgm);
    $pkgm.on('click', function (e) { if (e.target === this) closePkgm(); });
    $(document).on('keydown', function (e) { if (e.key === 'Escape') closePkgm(); });

    $country.on('change', function () {
      var c = this.value;
      $state.html('<option value="">— Choose state —</option>').prop('disabled', !c);
      $airport.html('<option value="">— Choose airport —</option>').prop('disabled', true);
      if (c) {
        Object.keys(APKG_ORIGINS[c]).sort(function (a, b) {
          return a.localeCompare(b);
        }).forEach(function (st) {
          $state.append(new Option(st, st));
        });
      }
      filterCards(codesForCountry(c));
    });

    $state.on('change', function () {
      var c = $country.val(), st = this.value;
      $airport.html('<option value="">— Choose airport —</option>').prop('disabled', !st);
      if (st) {
        APKG_ORIGINS[c][st].slice().sort(function (a, b) {
          return a.name.localeCompare(b.name);
        }).forEach(function (ap) {
          $airport.append(new Option(ap.name + ' (' + ap.code + ')', ap.code));
        });
      }
      filterCards(st ? codesForState(c, st) : codesForCountry(c));
    });

    $airport.on('change', function () {
      var code = this.value;
      filterCards(code ? [code] : codesForState($country.val(), $state.val()));
    });
  });
</script>
@endsection
