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
  .idcards .photo{width:224px;height:256px;border-radius:14px;object-fit:cover;border:4px solid #fff;background:#dfe3ea;box-shadow:0 14px 26px -12px rgba(0,0,0,.55);position:relative;z-index:1;}
  /* The photo and the crew pill are fixed; name / father / CNIC float between them.
     Equal auto margins above the name and above the pill split whatever height a
     short name leaves, so the block sits centred instead of leaving one empty
     band over the pill - and a long name that wraps simply takes the slack. */
  .idcards .side .name{margin-top:auto;padding-top:14px;font-size:31px;font-weight:800;letter-spacing:-.01em;line-height:1.1;text-align:center;z-index:1;}
  /* Name reads "<name> s/o <father>" down the panel — one line each, because at
     this size a combined string wraps awkwardly on longer names ("Mohammad Kabir Ali"). */
  .idcards .side .sof{margin-top:9px;font-size:19px;font-weight:600;line-height:1.25;color:#c9d5ea;text-align:center;z-index:1;}
  .idcards .side .sof i{font-style:normal;color:#8f9fc0;font-weight:500;}
  .idcards .side .sub{margin-top:9px;font-family:'IBM Plex Mono',monospace;font-size:14px;letter-spacing:.1em;color:#aebbd4;text-align:center;z-index:1;}
  .idcards .crew{margin-top:auto;margin-bottom:26px;z-index:1;display:inline-flex;align-items:center;gap:10px;background:linear-gradient(180deg,var(--orange-soft),var(--orange));color:#fff;padding:12px 24px;border-radius:999px;font-weight:800;letter-spacing:.16em;font-size:16px;text-transform:uppercase;box-shadow:0 10px 22px -10px rgba(232,96,28,.8);}
  .idcards .crew .dot{width:8px;height:8px;border-radius:50%;background:#fff;opacity:.9;}
  .idcards .main{display:flex;flex-direction:column;}
  .idcards .main-body{flex:1;padding:30px 34px 22px;position:relative;display:flex;flex-direction:column;min-height:0;}
  .idcards .logo-row{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;}
  .idcards .logo-row img.logo{height:68px;width:auto;}
  .idcards .flag{width:50px;height:33px;border-radius:4px;overflow:hidden;flex:0 0 auto;box-shadow:0 2px 6px rgba(0,0,0,.18);position:relative;background:repeating-linear-gradient(180deg,#c1283d 0 2.54px,#fff 2.54px 5.08px);border:1px solid rgba(0,0,0,.08);}
  .idcards .flag .canton{position:absolute;top:0;left:0;width:55%;height:53.8%;background:#16294d;background-image:radial-gradient(circle,rgba(255,255,255,.95) .9px,transparent 1.1px);background-size:6px 5.4px;background-position:2px 2px;}
  .idcards .eyebrow{margin-top:24px;display:flex;align-items:center;gap:12px;}
  /* NB: no <b> or <p> inside the card. adminassets/css/form.css carries
     `b{color:black!important}`, which outranks any selector here - it was
     rendering the footer's "www." black on the navy bar, i.e. invisible.
     Style spans with classes instead. */
  .idcards .eyebrow .eb{font-family:'IBM Plex Mono',monospace;font-size:17px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:var(--navy);white-space:nowrap;}
  .idcards .eyebrow .rule{height:2px;flex:1;background:linear-gradient(90deg,var(--orange),rgba(232,96,28,0));border-radius:2px;}
  /* Sized up to fill the white panel: the details are what gets read at a checkpoint.
     The grid takes the rest of the panel and spreads its three rows down it, so
     the last field sits on the bottom margin rather than above a blank band.
     Columns are 3:2 because the CNIC is 15 characters and the ID No. 10 - an
     even split capped the mono size at 26px. A role or father's name that
     wraps to two lines still fits; the rows just close up. */
  .idcards .fields{margin-top:22px;flex:1;min-height:0;display:grid;grid-template-columns:3fr 2fr;gap:14px 24px;align-content:space-between;}
  .idcards .field.full{grid-column:1 / -1;}
  .idcards .field .lab{font-family:'IBM Plex Mono',monospace;font-size:16px;letter-spacing:.16em;text-transform:uppercase;color:var(--orange);font-weight:600;line-height:1.2;}
  .idcards .field .val{margin-top:6px;font-size:34px;font-weight:700;color:var(--navy);letter-spacing:-.005em;line-height:1.15;}
  .idcards .field .val.mono{font-family:'IBM Plex Mono',monospace;font-weight:600;font-size:30px;letter-spacing:0;white-space:nowrap;}
  .idcards .foot{height:54px;background:linear-gradient(180deg,var(--navy-2),var(--navy-deep));display:flex;align-items:center;justify-content:center;padding:0 16px;color:#fff;}
  /* The address has the whole bar to itself (the website lives on the back), so
     it is set larger in the card's own face on one centred line.
     18px here prints at about 5pt on the CR80 card. */
  .idcards .foot .addr{display:flex;align-items:center;gap:10px;font-family:'Archivo',system-ui,sans-serif;font-size:18px;font-weight:600;line-height:1.2;white-space:nowrap;color:#fff;}
  .idcards .foot .addr img{height:26px;width:auto;flex:0 0 auto;filter:brightness(2);}

  /* Pick which crew to print. Screen only: the print deck is rebuilt from the
     ticked cards (see the script below), and _print hides .id-picker. */
  .id-picker{display:flex;flex-wrap:wrap;align-items:center;gap:10px;justify-content:center;padding:6px 0 4px;}
  .id-picker .count{font-weight:600;color:#16294d;margin-left:6px;}
  .id-pick{display:flex;flex-direction:column;gap:8px;}
  .id-pick .pick-bar{display:flex;align-items:center;gap:10px;margin:0;padding:8px 12px;border:1px solid #d5dbe6;border-radius:8px;background:#fff;cursor:pointer;font-weight:600;user-select:none;}
  .id-pick .pick-bar input{width:18px;height:18px;margin:0;cursor:pointer;accent-color:#e8601c;}
  .id-pick .pick-bar .pid{margin-left:auto;font-family:'IBM Plex Mono',monospace;font-size:12px;color:#6b7689;}
  .id-pick.on .pick-bar{border-color:#e8601c;background:#fff5f0;}
  .id-pick .id-slot{cursor:pointer;transition:opacity .15s,filter .15s;}
  .id-pick:not(.on) .id-slot{opacity:.35;filter:grayscale(1);}
  #printDeck{display:none;}
  @media print{
    #idDeck{display:none!important;}
    #printDeck{display:block!important;}
  }

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
                <button class="btn btn-success" type="button" id="printPicked" onclick="window.print()">Print selected (<span class="pick-n">0</span>)</button>
                <a class="btn btn-info ml-2" id="backLink" href="{{ url('admin/back-view', 1) }}">Back View</a>
            </div>
        </div>
        <div class="main-body pt-3 idcards">
            @if(count($staff_ids))
            <div class="id-picker">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-pick="all">Select all</button>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-pick="none">Clear</button>
                <span class="count"><span class="pick-n">0</span> of {{ count($staff_ids) }} selected &middot; <span class="sheets">0</span> sheet(s)</span>
            </div>
            @endif
            @php
                $fmtCnic = function ($c) {
                    $c = preg_replace('/\D/', '', (string) $c);
                    return strlen($c) === 13 ? substr($c, 0, 5).'-'.substr($c, 5, 7).'-'.substr($c, 12, 1) : ($c ?: '—');
                };
            @endphp
            <div class="id-deck" id="idDeck">
                @forelse($staff_ids as $value)
                <div class="id-pick on" data-id="{{ $value->id }}">
                <label class="pick-bar">
                    <input type="checkbox" class="pick-cb" value="{{ $value->id }}" checked>
                    <span>{{ @$value->name }}</span>
                    <span class="pid">KY-US-{{ str_pad(@$value->id, 4, '0', STR_PAD_LEFT) }}</span>
                </label>
                <div class="id-slot">
                    <div class="card front">
                        <div class="side">
                            <img class="wm" src="{{ asset('assets2/id/globe.png') }}" alt="" />
                            <img class="photo" src="{{ asset('ids/'.@$value->photo) }}" onerror="this.src='{{ asset('assets2/id/logo.png') }}'" alt="Cardholder photo" />
                            <div class="name">{{ @$value->name }}</div>
                            @if(@$value->father_name)
                            <div class="sof"><i>s/o</i> {{ $value->father_name }}</div>
                            @endif
                            <div class="sub">CNIC {{ $fmtCnic(@$value->cnic) }}</div>
                            <div class="crew"><span class="dot"></span>{{ @$value->type ?: 'Crew Member' }}</div>
                        </div>
                        <div class="main">
                            <div class="main-body">
                                <div class="logo-row">
                                    <img class="logo" src="{{ asset('assets2/id/logo.png') }}" alt="Konnect.US Inc." />
                                    <div class="flag"><div class="canton"></div></div>
                                </div>
                                <div class="eyebrow"><span class="eb">Staff Identification</span><span class="rule"></span></div>
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
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                @empty
                <p class="text-muted">No crew members found.</p>
                @endforelse
            </div>
            {{-- Filled by the script with the ticked cards, eight per .id-deck, so each
                 printed sheet is its own grid and _print breaks the page between them. --}}
            <div id="printDeck"></div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script type="text/javascript">
(function () {
    var KEY = 'ky.crewIds.picked';
    var picks = [].slice.call(document.querySelectorAll('.id-pick'));
    if (!picks.length) return;
    var printDeck = document.getElementById('printDeck');
    var backBase = @json(url('admin/back-view', 1));

    // Remember the last selection in this browser only; everything still works
    // without it (private window, blocked storage) - it just starts all ticked.
    try {
        var saved = JSON.parse(localStorage.getItem(KEY) || 'null');
        if (Array.isArray(saved)) {
            picks.forEach(function (p) { p.querySelector('.pick-cb').checked = saved.indexOf(p.dataset.id) !== -1; });
        }
    } catch (e) {}

    function sync() {
        var chosen = picks.filter(function (p) { return p.querySelector('.pick-cb').checked; });
        picks.forEach(function (p) { p.classList.toggle('on', chosen.indexOf(p) !== -1); });

        printDeck.innerHTML = '';
        for (var i = 0; i < chosen.length; i += 8) {
            var deck = document.createElement('div');
            deck.className = 'id-deck';
            chosen.slice(i, i + 8).forEach(function (p) { deck.appendChild(p.querySelector('.id-slot').cloneNode(true)); });
            printDeck.appendChild(deck);
        }

        var n = chosen.length, sheets = Math.ceil(n / 8);
        [].forEach.call(document.querySelectorAll('.pick-n'), function (el) { el.textContent = n; });
        [].forEach.call(document.querySelectorAll('.id-picker .sheets'), function (el) { el.textContent = sheets; });
        document.getElementById('printPicked').disabled = n === 0;
        document.getElementById('backLink').href = backBase + '?cards=' + Math.max(n, 1);

        try { localStorage.setItem(KEY, JSON.stringify(chosen.map(function (p) { return p.dataset.id; }))); } catch (e) {}
    }

    picks.forEach(function (p) {
        p.querySelector('.pick-cb').addEventListener('change', sync);
        // Clicking the card itself toggles it too.
        p.querySelector('.id-slot').addEventListener('click', function () {
            var cb = p.querySelector('.pick-cb');
            cb.checked = !cb.checked;
            sync();
        });
    });
    [].forEach.call(document.querySelectorAll('[data-pick]'), function (b) {
        b.addEventListener('click', function () {
            var all = b.getAttribute('data-pick') === 'all';
            picks.forEach(function (p) { p.querySelector('.pick-cb').checked = all; });
            sync();
        });
    });
    sync();
})();
</script>
@endsection
