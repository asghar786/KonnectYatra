@extends('admin.layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
<style type="text/css">
  .idcards{--navy:#16294d;--navy-deep:#0f1d39;--navy-2:#1d3461;--orange:#e8601c;--orange-soft:#f2843f;--ink:#1b2436;--paper:#fff;--line:#e4e8f0;--muted:#6b7689;}
  .idcards *{box-sizing:border-box;}
  .id-deck{display:flex;flex-wrap:wrap;gap:26px;justify-content:center;padding:10px 0 30px;}
  /* preview is scaled down; print restores full size */
  .id-slot{width:550px;height:347px;overflow:hidden;}
  .id-slot .card{transform:scale(.625);transform-origin:top left;}

  .idcards .card{width:880px;height:555px;border-radius:22px;overflow:hidden;background:var(--paper);position:relative;font-family:'Archivo',system-ui,sans-serif;color:var(--ink);
    box-shadow:0 1px 0 rgba(255,255,255,.7) inset,0 24px 48px -18px rgba(22,41,77,.45),0 6px 16px -8px rgba(22,41,77,.3);}
  .idcards .front{display:grid;grid-template-columns:300px 1fr;}
  .idcards .side{position:relative;background:radial-gradient(120% 80% at 18% 6%,var(--navy-2),var(--navy) 46%,var(--navy-deep) 100%);padding:30px 26px 0;display:flex;flex-direction:column;align-items:center;color:#fff;overflow:hidden;}
  .idcards .side .wm{position:absolute;right:-70px;bottom:-50px;width:280px;opacity:.07;filter:brightness(2);pointer-events:none;}
  .idcards .photo{width:206px;height:236px;border-radius:14px;object-fit:cover;border:4px solid #fff;background:#dfe3ea;box-shadow:0 14px 26px -12px rgba(0,0,0,.55);position:relative;z-index:1;}
  .idcards .side .name{margin-top:20px;font-size:25px;font-weight:800;letter-spacing:-.01em;text-align:center;z-index:1;}
  .idcards .side .sub{margin-top:5px;font-family:'IBM Plex Mono',monospace;font-size:11px;letter-spacing:.12em;color:#aebbd4;text-align:center;z-index:1;}
  .idcards .crew{margin-top:auto;margin-bottom:26px;z-index:1;display:inline-flex;align-items:center;gap:9px;background:linear-gradient(180deg,var(--orange-soft),var(--orange));color:#fff;padding:11px 20px;border-radius:999px;font-weight:800;letter-spacing:.16em;font-size:13px;text-transform:uppercase;box-shadow:0 10px 22px -10px rgba(232,96,28,.8);}
  .idcards .crew .dot{width:7px;height:7px;border-radius:50%;background:#fff;opacity:.9;}
  .idcards .main{display:flex;flex-direction:column;}
  .idcards .main-body{flex:1;padding:30px 34px 18px;position:relative;}
  .idcards .logo-row{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;}
  .idcards .logo-row img.logo{height:62px;width:auto;}
  .idcards .flag{width:50px;height:33px;border-radius:4px;overflow:hidden;flex:0 0 auto;box-shadow:0 2px 6px rgba(0,0,0,.18);position:relative;background:repeating-linear-gradient(180deg,#c1283d 0 2.54px,#fff 2.54px 5.08px);border:1px solid rgba(0,0,0,.08);}
  .idcards .flag .canton{position:absolute;top:0;left:0;width:55%;height:53.8%;background:#16294d;background-image:radial-gradient(circle,rgba(255,255,255,.95) .9px,transparent 1.1px);background-size:6px 5.4px;background-position:2px 2px;}
  .idcards .eyebrow{margin-top:22px;display:flex;align-items:center;gap:12px;}
  .idcards .eyebrow b{font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:600;letter-spacing:.26em;text-transform:uppercase;color:var(--navy);}
  .idcards .eyebrow .rule{height:2px;flex:1;background:linear-gradient(90deg,var(--orange),rgba(232,96,28,0));border-radius:2px;}
  .idcards .fields{margin-top:22px;display:grid;grid-template-columns:1fr 1fr;gap:18px 28px;}
  .idcards .field.full{grid-column:1 / -1;}
  .idcards .field .lab{font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.18em;text-transform:uppercase;color:var(--orange);font-weight:600;}
  .idcards .field .val{margin-top:5px;font-size:18px;font-weight:700;color:var(--navy);letter-spacing:-.005em;line-height:1.15;}
  .idcards .field .val.mono{font-family:'IBM Plex Mono',monospace;font-weight:600;font-size:17px;letter-spacing:.01em;}
  .idcards .foot{height:54px;background:linear-gradient(180deg,var(--navy-2),var(--navy-deep));display:flex;align-items:center;justify-content:space-between;padding:0 26px 0 30px;color:#dbe2f0;font-family:'IBM Plex Mono',monospace;font-size:12px;}
  /* The footer bar spans only the right column (580px), so the full street
     address needs two lines. Sized and leaded to sit centred rather than cramped. */
  .idcards .foot .addr{display:flex;align-items:center;gap:11px;font-size:11px;line-height:1.32;padding-right:14px;}
  .idcards .foot .addr img{height:24px;width:auto;flex:0 0 auto;filter:brightness(2);}
  .idcards .foot .web{color:#fff;font-weight:600;}
  .idcards .foot .web b{color:var(--orange-soft);}

@include('admin.ids._print')
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Crew IDs</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>Crew IDs</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                <a class="btn btn-info ml-2" href="{{ url('admin/back-view', $page ?? 1) }}">Back View</a>
            </div>
        </div>
        <div class="main-body pt-3 idcards">
            @php
                $fmtCnic = function ($c) {
                    $c = preg_replace('/\D/', '', (string) $c);
                    return strlen($c) === 13 ? substr($c, 0, 5).'-'.substr($c, 5, 7).'-'.substr($c, 12, 1) : ($c ?: '—');
                };
            @endphp
            <div class="id-deck" id="idDeck">
                @forelse($staff_ids as $value)
                <div class="id-slot">
                    <div class="card front">
                        <div class="side">
                            <img class="wm" src="{{ asset('assets2/id/globe.png') }}" alt="" />
                            <img class="photo" src="{{ asset('ids/'.@$value->photo) }}" onerror="this.src='{{ asset('assets2/id/logo.png') }}'" alt="Cardholder photo" />
                            <div class="name">{{ @$value->name }}</div>
                            <div class="sub">CNIC {{ $fmtCnic(@$value->cnic) }}</div>
                            <div class="crew"><span class="dot"></span>{{ @$value->type ?: 'Crew Member' }}</div>
                        </div>
                        <div class="main">
                            <div class="main-body">
                                <div class="logo-row">
                                    <img class="logo" src="{{ asset('assets2/id/logo.png') }}" alt="Konnect.US Inc." />
                                    <div class="flag"><div class="canton"></div></div>
                                </div>
                                <div class="eyebrow"><b>Staff Identification</b><span class="rule"></span></div>
                                <div class="fields">
                                    <div class="field full">
                                        <div class="lab">Role</div>
                                        <div class="val">{{ @$value->role ?: '—' }}</div>
                                    </div>
                                    <div class="field">
                                        <div class="lab">CNIC #</div>
                                        <div class="val mono">{{ $fmtCnic(@$value->cnic) }}</div>
                                    </div>
                                    <div class="field">
                                        <div class="lab">ID No.</div>
                                        <div class="val mono">KY-US-{{ str_pad(@$value->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                    <div class="field full">
                                        <div class="lab">Father's Name</div>
                                        <div class="val">{{ @$value->father_name ?: '—' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="foot">
                                {{-- Canonical office address, matching config/schema.php, the site
                                     header and the Contact page. The old 18502 Hillside Ave was
                                     superseded on 2026-08-17; keep all four byte-identical. --}}
                                <div class="addr"><img src="{{ asset('assets2/id/globe.png') }}" alt="" />148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434</div>
                                <div class="web"><b>www.</b>konnectyatra.org</div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No crew members found.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
