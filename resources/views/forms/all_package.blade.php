@extends('layouts.app')
@section('content')
<style type="text/css">
  .apkg{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
  /* Blessing header */
  .apkg-blessing{display:flex;align-items:center;justify-content:center;gap:18px;flex-wrap:wrap;margin:6px 0 30px}
  .apkg-blessing span{color:var(--brand);font-weight:600;font-size:16px;white-space:nowrap}
  .apkg-fcfs{display:inline-block;background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:30px;padding:7px 24px;font-weight:700;font-size:16px}
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
  @media (max-width:575px){.apkg-price-row{grid-template-columns:1fr}.apkg-card-head h3{font-size:19px}}
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
        <span>Wahe Guru Ji ka Khalsa</span>
        <span class="apkg-fcfs">First Come First Serve</span>
        <span>Wahe Guru Ji ki Fateh</span>
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
          <a class="nav-link active" data-toggle="tab" href="#vaisakhi" role="tab" aria-selected="true">Vaisakhi Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#birthday" role="tab" aria-selected="false">Gurpurab Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#vip" role="tab" aria-selected="false">VIP Packages</a>
        </li>
      </ul>

      <div class="tab-content">
        <!-- ============ VAISAKHI ============ -->
        <div class="tab-pane active" id="vaisakhi" role="tabpanel">
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
                  @if(!empty(@$val->sdescription))<div class="apkg-desc">{!! $val->sdescription !!}</div>@endif
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
        <div class="tab-pane" id="birthday" role="tabpanel">
          @if(count(@$all_packages1) > 0)
          <div class="apkg-state-pick">
            <label><i class="fa fa-map-marker-alt"></i> Select Your State</label>
            <select class="form-control" id="state">
              <option value="13">New York</option>
              <option value="14">Washington Dulles</option>
              <option value="15">Los Angeles</option>
              <option value="17">Chicago</option>
              <option value="16">Seattle</option>
              <option value="18">Toronto</option>
            </select>
          </div>
          <div class="row justify-content-center">
            @foreach(@$all_packages1 as $key => $val)
            <div class="col-lg-6 col-md-8 mb-4 all_states state_{{ $val->id }}" @if($key !== 0) style="display:none;" @endif>
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
                  @if(!empty(@$val->sdescription))<div class="apkg-desc">{!! $val->sdescription !!}</div>@endif
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

<script>
  $(document).ready(function() {
    $(document).on("change", "#state", function () {
      var selected = $(this).find("option:selected").val();
      $(".all_states").fadeOut();
      $(".state_" + selected).fadeIn();
    });
  });
</script>
@endsection
