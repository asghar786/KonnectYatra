@extends('admin.layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
<style type="text/css">
  /* Printed at the Crew card's CR80 size, 3.375in x 2.125in (ratio 1.59), so the
     card is laid out at 440 x 277px. On screen it shows at that size; print
     scales it into the slot set up by _print, the same slots as the Crew sheet,
     so the eight fronts land exactly where the eight backs do. It was 440 x 282
     for a 3.9in x 2.5in stock until 2026-10-16. */
  .idcards *{box-sizing:border-box;}
  .id-deck{display:flex;flex-wrap:wrap;gap:26px;justify-content:center;padding:10px 0 30px;}
  .id-slot{width:440px;height:277px;overflow:hidden;}

  /* NB: no <b>, <p> or <label> inside the card. adminassets/css/form.css forces
     them black with !important. Style spans and divs with classes instead. */
  .idcards .ycard{width:440px;height:277px;overflow:hidden;background:#fff;position:relative;display:flex;flex-direction:column;font-family:'Rubik',sans-serif;color:#111;box-shadow:0 10px 24px -12px rgba(46,48,146,.45);}
  .idcards .ycard .ybanner{flex:0 0 66px;width:100%;height:66px;display:block;}
  /* Khanda watermark behind the details, as on the original card. */
  .idcards .ycard .ybody{flex:1;min-height:0;display:flex;gap:14px;padding:9px 12px 0;background:url("{{ asset('assets2/images/background.png') }}") center/150px no-repeat;}
  .idcards .ycard .yphoto-wrap{flex:0 0 116px;width:116px;height:140px;position:relative;overflow:hidden;}
  .idcards .ycard .yphoto{width:116px;height:140px;object-fit:cover;background:#e6e8ef;display:block;}
  /* A yatri with a title (role), e.g. Chief Organizer, gets it as a band across
     the foot of the photo. Only shown when set. */
  .idcards .ycard .yrole{position:absolute;left:0;right:0;bottom:0;background:#b22234;color:#fff;font-size:9.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;text-align:center;padding:3px 2px;line-height:1.15;border-top:1.5px solid #fff;}
  .idcards .ycard .yinfo{flex:1;min-width:0;padding-top:12px;font-size:16px;line-height:1.35;}
  .idcards .ycard .yinfo .k{font-weight:700;display:block;}
  .idcards .ycard .yinfo .k .tt{margin-left:22px;}
  .idcards .ycard .yinfo .v{display:block;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .idcards .ycard .yno{flex:0 0 96px;display:flex;flex-direction:column;align-items:center;}
  .idcards .ycard .yno .yflag{width:52px;height:auto;display:block;}
  .idcards .ycard .yno .ybox{margin-top:10px;width:100%;height:86px;border:1px solid #bbb;border-radius:10px;text-align:center;background:rgba(255,255,255,.85);}
  .idcards .ycard .yno .ybox .l{display:block;color:#aaa;font-size:15px;font-weight:700;margin-top:4px;}
  .idcards .ycard .yno .ybox .n{display:block;font-size:38px;font-weight:700;line-height:1.2;}
  .idcards .ycard .yname{flex:0 0 24px;display:flex;justify-content:space-between;align-items:center;gap:10px;padding:0 10px;font-weight:700;font-size:15px;white-space:nowrap;}
  .idcards .ycard .yname .f{font-size:13px;overflow:hidden;text-overflow:ellipsis;}
  /* Address only, centred, one line - the phone and website were taken off on 2026-09-30. */
  .idcards .ycard .yfoot{flex:0 0 36px;background:#2e3092;color:#fff;padding:0 8px;display:flex;align-items:center;justify-content:center;text-align:center;font-size:12.5px;font-weight:500;line-height:1.2;white-space:nowrap;}

@include('admin.ids._back_styles')
@include('admin.ids._print')
  @media print{
    /* This card is 440px wide: 440px * .7363636 = 324px = 3.375in at the
       CSS 96dpi print scale (and 277px -> 204px = 2.125in), as the Crew card. */
    .id-slot{border-radius:0;}
    .id-slot .ycard{transform:none;zoom:.7363636;box-shadow:none;}
    .id-pager{display:none!important;}
  }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri ID</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>Yatri ID</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                @include('admin.ids._paper')
                @include('admin.ids._duplex')
                <a class="btn btn-info ml-2" href="{{ url('admin/yatri-id-back', $page) }}">Back View</a>
            </div>
        </div>
        <div class="main-body pt-3 idcards">
            <div class="row my-3 id-pager">
                <div class="offset-lg-2 col-lg-4 mb-3 px-5">
                    <a class="btn btn-info" @if($prev > 0) href="{{ url('admin/yatri-id', $prev) }}" @else href="javascript:void(0)" @endif style="margin-left: 35px;">Prev Page</a>
                </div>
                <div class="col-lg-4 mb-3 px-5 d-flex justify-content-end">
                    <a class="btn btn-info" @if(count($yatri_ids) === 8) href="{{ url('admin/yatri-id', $next) }}" @else href="javascript:void(0)" @endif style="margin-right: 35px;">Next Page</a>
                </div>
            </div>
            {{-- Eight to a page, the same eight the controller pages by. The back
                 sheet below (and Back View) prints eight backs in the same slots. --}}
            <div class="id-deck">
                @forelse($yatri_ids as $value)
                <div class="id-slot">
                    <div class="ycard">
                        <img class="ybanner" src="{{ asset('assets2/images/imgage-card.png') }}" alt="Konnect Yatra USA" />
                        <div class="ybody">
                            <div class="yphoto-wrap">
                                <img class="yphoto" src="{{ asset('ids/'.$value->photo) }}" alt="" />
                                @if(trim((string) $value->role) !== '')<span class="yrole">{{ $value->role }}</span>@endif
                            </div>
                            <div class="yinfo">
                                <span class="k">State <span class="tt">({{ $value->trip_type }})</span></span>
                                <span class="v">{{ $value->state }}</span>
                                <span class="k">{{ $value->passport_country }} Passport #</span>
                                <span class="v">{{ $value->passport_no }}</span>
                            </div>
                            <div class="yno">
                                <img class="yflag" src="{{ asset('assets2/images/ds-removebg-preview.png') }}" alt="" />
                                <div class="ybox">
                                    <span class="l">Yatri #</span>
                                    <span class="n">{{ $value->yatri_no }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="yname">
                            <span>{{ $value->name }}</span>
                            <span class="f">Father's Name: {{ $value->father_name }}</span>
                        </div>
                        <div class="yfoot">
                            <span>{{ \App\Support\Business::addressLine() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No record found.</p>
                @endforelse
            </div>
            {{-- The back sheet for "Print Front + Back" (_duplex): hidden on screen and
                 in a front-only print, printed as page 2 behind the fronts. One back
                 per front, each in its front's mirrored slot (long-edge flip), so a
                 short page of 5 gets 5 backs, exactly behind those 5 cards. --}}
            @if(count($yatri_ids))
            <div class="id-deck back-deck">
                @foreach($yatri_ids as $behind => $unused)
                @include('admin.ids._back_card', ['behind' => $behind])
                @endforeach
            </div>
            @endif
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
