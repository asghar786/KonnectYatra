@extends('admin.layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
<style type="text/css">
  .idcards{--navy:#16294d;--navy-deep:#0f1d39;--navy-2:#1d3461;--orange:#e8601c;--orange-soft:#f2843f;--ink:#1b2436;--paper:#fff;--line:#e4e8f0;--muted:#6b7689;}
  .idcards *{box-sizing:border-box;}
  .id-deck{display:flex;flex-wrap:wrap;gap:26px;justify-content:center;padding:10px 0 30px;}
  .id-slot{width:550px;height:347px;overflow:hidden;}
  .id-slot .card{transform:scale(.625);transform-origin:top left;}

  .idcards .card{width:880px;height:555px;border-radius:22px;overflow:hidden;background:var(--paper);position:relative;font-family:'Archivo',system-ui,sans-serif;color:var(--ink);
    box-shadow:0 1px 0 rgba(255,255,255,.7) inset,0 24px 48px -18px rgba(22,41,77,.45),0 6px 16px -8px rgba(22,41,77,.3);}
  .idcards .back{display:flex;flex-direction:column;}

  /* Header mirrors the front's navy panel so the two faces read as one card. */
  .idcards .back-head{flex:0 0 84px;background:radial-gradient(120% 140% at 14% 0%,var(--navy-2),var(--navy) 55%,var(--navy-deep));color:#fff;padding:0 30px;display:flex;align-items:center;gap:15px;}
  .idcards .back-head .gmark{height:46px;width:auto;filter:brightness(2);}
  .idcards .back-head .ht{flex:1;}
  .idcards .back-head .ht .o{font-size:21px;font-weight:900;letter-spacing:.01em;line-height:1.1;}
  .idcards .back-head .ht .o em{color:var(--orange-soft);font-style:normal;}
  .idcards .back-head .ht .t{font-family:'IBM Plex Mono',monospace;font-size:10.5px;letter-spacing:.1em;color:#aebbd4;margin-top:3px;}
  .idcards .back-head .web{text-align:right;font-family:'IBM Plex Mono',monospace;font-size:12px;color:#fff;line-height:1.35;}
  .idcards .back-head .web .k{color:#fff;display:block;font-size:9.5px;letter-spacing:.16em;font-weight:600;}
  .idcards .magstripe{flex:0 0 34px;background:repeating-linear-gradient(90deg,#0c1426 0 3px,#13203a 3px 6px);}

  /* NB: no <b> or <p> inside the card. adminassets/css/form.css carries
     `b{color:black!important}` and `p{color:black!important}`, which no amount of
     selector specificity can outrank - it is what turned the two navy strips'
     white text black. Style spans and divs with classes instead. */

  /* Two columns: what to do in an emergency, and the terms of the credential. */
  .idcards .back-body{flex:1;display:grid;grid-template-columns:1fr 316px;min-height:0;}
  /* Both columns are flex so the trailing block in each can be pinned to the
     bottom edge with margin-top:auto, rather than leaving a ragged gap. */
  .idcards .bcol{padding:24px 26px 20px 30px;min-width:0;display:flex;flex-direction:column;}
  .idcards .bcol+.bcol{padding:24px 30px 20px 26px;border-left:1px solid var(--line);}
  .idcards .btitle{font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--navy);font-weight:600;display:flex;align-items:center;gap:8px;}
  .idcards .btitle::before{content:"";width:14px;height:2px;background:var(--orange);flex:0 0 auto;}

  /* The reason the back exists: one phone number, big enough to read in a hurry. */
  .idcards .who{margin-top:13px;font-size:24px;font-weight:800;color:var(--navy);line-height:1.15;}
  .idcards .who span{display:block;font-size:14.5px;font-weight:600;color:var(--muted);margin-top:4px;}
  .idcards .tel{margin-top:15px;display:flex;align-items:center;gap:13px;background:linear-gradient(180deg,#fff5f0,#ffece1);border:1px solid #f7cdb4;border-left:4px solid var(--orange);border-radius:12px;padding:15px 18px;}
  .idcards .tel .ico{width:30px;height:30px;flex:0 0 auto;border-radius:50%;background:var(--orange);color:#fff;display:flex;align-items:center;justify-content:center;font-size:15px;}
  .idcards .tel .num{font-family:'IBM Plex Mono',monospace;font-size:30px;font-weight:600;color:var(--navy);letter-spacing:.01em;line-height:1;}
  /* Pinned to the bottom of its column so the panel reads as two anchored blocks.
     The row holds the hotels and the QR side by side; the QR sits outside .stay
     because it must print even when no hotel has been entered. */
  .idcards .stayrow{margin-top:auto;padding-top:18px;display:flex;align-items:flex-end;gap:20px;}
  .idcards .stay{flex:1;min-width:0;}
  .idcards .stay ul{list-style:none;margin:11px 0 0;padding:0;display:flex;flex-direction:column;gap:9px;}
  .idcards .stay li{font-size:16px;font-weight:600;color:var(--navy);padding-left:18px;position:relative;line-height:1.3;}
  .idcards .stay li::before{content:"";position:absolute;left:0;top:7px;width:7px;height:7px;border-radius:2px;background:var(--orange);}
  /* konnectyatra.org, identical on every card, so it is a committed SVG rather
     than a runtime encode - nothing to install on prod and it prints crisp at any
     scale. Version 2 / EC M (25 modules) keeps each module near .6mm at CR80 size,
     which is what makes it scan off a printed card. margin-left:auto holds it to
     the right edge on the cards that have no hotel block beside it. */
  /* 146px is the largest that clears the bottom edge: the left column's stack
     leaves 168px under the phone panel and the row adds 18px of its own padding.
     Sized up to the limit on purpose - it sets the printed module at roughly half
     a millimetre, which is what a phone camera needs off a card this size. No
     caption, because the header and the footer already print the address. */
  .idcards .qr{flex:0 0 146px;margin-left:auto;}
  .idcards .qr img{width:146px;height:146px;display:block;border-radius:8px;background:#fff;}

  /* What the credential IS, above the conditions it sets out. */
  .idcards .terms .tmeta{margin-top:10px;}
  .idcards .terms .tmeta .co{font-family:'IBM Plex Mono',monospace;font-size:9.5px;letter-spacing:.14em;color:var(--orange);font-weight:600;}
  .idcards .terms .tmeta .nm{font-size:15px;font-weight:800;color:var(--navy);line-height:1.15;margin-top:2px;}
  .idcards .terms .tmeta .tr{font-size:11.5px;font-weight:600;color:var(--muted);margin-top:1px;}
  .idcards .terms .lead{font-size:11.5px;line-height:1.42;color:#42506a;margin:9px 0 0;}
  .idcards .terms ul{list-style:none;margin:8px 0 0;padding:0;display:flex;flex-direction:column;gap:6px;}
  .idcards .terms li{font-size:11.5px;line-height:1.42;color:#42506a;padding-left:14px;position:relative;}
  .idcards .terms li .lbl{color:var(--navy);font-weight:700;}
  .idcards .terms li::before{content:"";position:absolute;left:0;top:6px;width:5px;height:5px;border-radius:50%;background:var(--orange);}
  /* A signature belongs on the bottom edge, not floating mid-column. */
  .idcards .sig{margin-top:auto;padding-top:20px;}
  .idcards .sig .line{height:1px;background:var(--navy);opacity:.35;margin-bottom:6px;}
  .idcards .sig .l{font-family:'IBM Plex Mono',monospace;font-size:9.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);}

  /* Return address sits in the navy foot, matching the front's footer bar. */
  .idcards .back-foot{flex:0 0 74px;background:linear-gradient(180deg,var(--navy-2),var(--navy-deep));color:#dbe2f0;padding:0 30px;display:flex;align-items:center;gap:16px;}
  .idcards .back-foot .rl{font-family:'IBM Plex Mono',monospace;font-size:9.5px;letter-spacing:.16em;text-transform:uppercase;color:#fff;font-weight:600;line-height:1.35;flex:0 0 74px;}
  .idcards .back-foot .ra{font-size:13px;line-height:1.35;color:#fff;font-weight:600;}
  /* Block, or the phone/web run on from the end of the street address. */
  .idcards .back-foot .ra .ln{display:block;margin-top:3px;color:#fff;font-weight:600;font-family:'IBM Plex Mono',monospace;font-size:11.5px;letter-spacing:.02em;}

@include('admin.ids._print')
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">ID — Back View</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>Back View</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                <a class="btn btn-info ml-2" href="{{ $front_url }}">Front View</a>
            </div>
        </div>
        <div class="main-body pt-3 idcards">
            {{-- Every back is identical. The front already carries the name, photo, CNIC,
                 ID No. and role, so repeating them here tells the holder nothing new and
                 would force the back sheet to print mirrored to survive a duplex flip.
                 A uniform back lines up whichever way the printer turns the paper,
                 as long as the sheet is full - hence always eight slots (see
                 PackagesController::idBackSheet). Shared by the Crew and Yatri IDs. --}}
            <div class="id-deck" id="idDeck">
                @for($i = 0; $i < $slots; $i++)
                <div class="id-slot">
                    <div class="card back">
                        <div class="back-head">
                            <img class="gmark" src="{{ asset('assets2/id/globe.png') }}" alt="" />
                            <div class="ht">
                                <div class="o">KONNECT YATRA <em>· USA</em></div>
                                <div class="t">Explore and Discover the Globe</div>
                            </div>
                            <div class="web"><span class="k">WEBSITE</span>www.konnectyatra.org</div>
                        </div>
                        <div class="magstripe"></div>
                        <div class="back-body">
                            <div class="bcol">
                                <div class="btitle">Emergency Contact</div>
                                {{-- Admin > IDs > Back IDs writes these (yatri_ids_back). --}}
                                <div class="who">{{ @$back_ids->name ?: 'Konnect Yatra Office' }}
                                    <span>{{ @$back_ids->role ?: 'Tour Management' }}</span>
                                </div>
                                <div class="tel">
                                    <span class="ico"><i class="fa fa-phone"></i></span>
                                    <span class="num">{{ @$back_ids->phone ?: '+1 (718) 908-9464' }}</span>
                                </div>
                                <div class="stayrow">
                                    @if(@$back_ids->hotel || @$back_ids->hotel1)
                                    <div class="stay">
                                        <div class="btitle">Staying At</div>
                                        <ul>
                                            @if(@$back_ids->hotel)<li>{{ $back_ids->hotel }}</li>@endif
                                            @if(@$back_ids->hotel1)<li>{{ $back_ids->hotel1 }}</li>@endif
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="qr">
                                        <img src="{{ asset('assets2/id/qr-konnectyatra.svg') }}" alt="konnectyatra.org" />
                                    </div>
                                </div>
                            </div>
                            <div class="bcol terms">
                                <div class="btitle">Terms &amp; Conditions</div>
                                <div class="tmeta">
                                    <div class="co">KONNECT.US, INC.</div>
                                    <div class="nm">Yatra ID Card</div>
                                    <div class="tr">November 2026 Yatra Tour</div>
                                </div>
                                <div class="lead">This Yatra ID Card is valid only during the period in which the holder is actively participating in the November 2026 Yatra Tour.</div>
                                <ul>
                                    <li>This ID Card may be presented upon request to authorized government personnel, security officials, or Konnect Yatra representatives.</li>
                                    <li><span class="lbl">Lost or Stolen Card:</span> Any lost or stolen ID Card must be reported immediately to the assigned Tour Guide.</li>
                                </ul>
                                <div class="sig">
                                    <div class="line"></div>
                                    <div class="l">Authorized Signatory</div>
                                </div>
                            </div>
                        </div>
                        <div class="back-foot">
                            <div class="rl">If found<br>return to</div>
                            <div class="ra">Konnect.US Inc. — 148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434
                                <span class="ln">+1 (718) 908-9464 · www.konnectyatra.org</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
                @if($slots === 0)
                <p class="text-muted">{{ $empty }}</p>
                @endif
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
