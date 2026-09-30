{{-- Hotel Booking Yatris — the check-in list for one hotel of the trip.

     One form holds the whole list in its on-screen order. Rows move up and
     down, and "With above" puts a row in the same room as the one above it,
     which is how a couple or a family shares a room; room numbers are worked
     out from the order (App\Support\HotelCheckin::numberRooms), and the script
     below re-numbers them live the same way.

     NB: no <b>, <p> or coloured <label> text here — adminassets/css/form.css
     forces them black with !important. --}}
@extends('admin.layouts.app')
@section('content')
@php
    use App\Support\HotelCheckin;
    $nights = HotelCheckin::nights($list['check_in'], $list['check_out']);
    $initials = function ($name) {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $out = strtoupper(substr($parts[0] ?? '', 0, 1) . (count($parts) > 1 ? substr(end($parts), 0, 1) : ''));
        return $out !== '' ? $out : '?';
    };
@endphp
<style type="text/css">
    /* ---- Tokens: primitive -> semantic -> component. Components below use
       only the semantic and component layers. ---- */
    .hc{
        --p-navy-900:#0f1d39; --p-navy-800:#16294d; --p-navy-700:#1f2a44;
        --p-blue-700:#1a3fa0; --p-blue-100:#dde6fb; --p-blue-50:#eef2fb;
        --p-orange-600:#e8601c; --p-orange-500:#f54e18; --p-orange-100:#fde0d2; --p-orange-50:#fff5f0;
        --p-gray-0:#fff; --p-gray-50:#f7f8fb; --p-gray-100:#eef0f4; --p-gray-200:#e3e7ee; --p-gray-300:#d5dbe6;
        --p-gray-500:#8a91a0; --p-gray-700:#42506a;
        --p-green-700:#157f3d; --p-green-50:#e7f8ec; --p-red-700:#b42318; --p-red-50:#fdecee;

        --c-surface:var(--p-gray-0); --c-surface-muted:var(--p-gray-50); --c-border:var(--p-gray-100); --c-border-strong:var(--p-gray-300);
        --c-text:var(--p-navy-700); --c-text-muted:var(--p-gray-500); --c-text-soft:var(--p-gray-700);
        --c-primary:var(--p-blue-700); --c-primary-soft:var(--p-blue-50); --c-primary-line:var(--p-blue-100);
        --c-accent:var(--p-orange-600); --c-accent-strong:var(--p-orange-500); --c-accent-soft:var(--p-orange-50); --c-accent-line:var(--p-orange-100);
        --c-success:var(--p-green-700); --c-success-soft:var(--p-green-50); --c-danger:var(--p-red-700); --c-danger-soft:var(--p-red-50);
        --c-hero-from:var(--p-navy-700); --c-hero-to:var(--p-blue-700);
        --radius-lg:16px; --radius-md:10px; --radius-sm:7px; --radius-pill:999px;
        --shadow-card:0 8px 28px rgba(28,37,65,.07); --shadow-lift:0 12px 28px rgba(28,37,65,.12);
        --ring:0 0 0 3px rgba(26,63,160,.22);
        --dur-fast:150ms; --dur-move:200ms;
        --font-display:Archivo,system-ui,sans-serif; --font-mono:'IBM Plex Mono',ui-monospace,monospace;

        --hc-avatar:42px;
        --hc-room-rail-single:var(--c-border-strong); --hc-room-rail-shared:var(--c-accent);
        --hc-room-even:var(--c-surface-muted); --hc-room-odd:var(--c-surface);
        color:var(--c-text);
    }
    .hc *{box-sizing:border-box;}

    .hc-hero{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; background:linear-gradient(120deg,var(--c-hero-from),var(--c-hero-to)); border-radius:var(--radius-lg); box-shadow:var(--shadow-lift); padding:22px 26px; margin-bottom:18px; color:#fff;}
    .hc-hero .t{font-family:var(--font-display); font-weight:800; font-size:21px; line-height:1.15;}
    .hc-hero .s{margin-top:5px; font-size:13px; opacity:.88; max-width:560px; line-height:1.5;}
    .hc-tabs{display:inline-flex; background:rgba(255,255,255,.12); border-radius:var(--radius-pill); padding:4px; gap:4px;}
    .hc-tabs a{display:inline-flex; flex-direction:column; align-items:center; padding:8px 20px; border-radius:var(--radius-pill); color:#fff; text-decoration:none; font-weight:700; font-size:13.5px; line-height:1.2; transition:background var(--dur-fast);}
    .hc-tabs a small{font-weight:500; font-size:11px; opacity:.8;}
    .hc-tabs a:hover{background:rgba(255,255,255,.14); color:#fff;}
    .hc-tabs a.on{background:#fff; color:var(--c-primary);}

    .hc-card{background:var(--c-surface); border:1px solid var(--c-border); border-radius:var(--radius-lg); box-shadow:var(--shadow-card); margin-bottom:18px;}
    .hc-card-head{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:10px; padding:16px 20px; border-bottom:1px solid var(--c-border);}
    .hc-card-head .h{font-weight:700; font-size:15.5px; color:var(--c-text);}
    .hc-card-head .sub{font-size:12.5px; color:var(--c-text-muted);}

    .hc-fields{display:grid; grid-template-columns:2fr 1fr 1fr auto; gap:14px; padding:18px 20px; align-items:end;}
    .hc-field .lab{display:block; font-size:11.5px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--c-text-muted); margin-bottom:6px;}
    .hc-input{width:100%; height:40px; border:1px solid var(--c-border-strong); border-radius:var(--radius-sm); padding:0 12px; font-size:14px; color:var(--c-text); background:var(--c-surface); transition:border-color var(--dur-fast), box-shadow var(--dur-fast);}
    .hc-input:focus{outline:none; border-color:var(--c-primary); box-shadow:var(--ring);}
    .hc-input.mono{font-family:var(--font-mono); letter-spacing:.02em; text-transform:uppercase;}
    .hc-nights{height:40px; display:inline-flex; align-items:center; gap:7px; padding:0 14px; border-radius:var(--radius-pill); background:var(--c-primary-soft); color:var(--c-primary); font-weight:700; font-size:13px; white-space:nowrap;}

    .hc-stats{display:flex; flex-wrap:wrap; gap:10px; padding:14px 20px; border-bottom:1px solid var(--c-border); background:var(--c-surface-muted);}
    .hc-stat{display:inline-flex; align-items:baseline; gap:6px; padding:6px 12px; border-radius:var(--radius-pill); background:var(--c-surface); border:1px solid var(--c-border); font-size:12.5px; color:var(--c-text-soft);}
    .hc-stat .n{font-family:var(--font-display); font-weight:800; font-size:16px; color:var(--c-text); font-variant-numeric:tabular-nums;}
    .hc-stat.warn{background:var(--c-accent-soft); border-color:var(--c-accent-line);}
    .hc-stat.warn .n{color:var(--c-accent);}

    /* form.css gives every th/td `border:1px solid black` and td a
       `padding:10px !important`, so both are overridden with !important here. */
    .hc-table{width:100%; border-collapse:separate; border-spacing:0;}
    .hc-table th{font-size:11px; font-weight:700; letter-spacing:.07em; text-transform:uppercase; color:var(--c-text-muted); padding:10px 10px !important; border:0 !important; border-bottom:1px solid var(--c-border) !important; background:var(--c-surface); white-space:nowrap; text-align:left;}
    .hc-table td{padding:8px 10px !important; vertical-align:middle; border:0 !important; border-bottom:1px solid var(--c-border) !important; font-size:13.5px;}
    .hc-roomcell{display:flex; align-items:center; gap:8px;}
    .hc-row{transition:background var(--dur-fast);}
    .hc-row.even td{background:var(--hc-room-even);}
    .hc-row.odd td{background:var(--hc-room-odd);}
    .hc-row td:first-child{border-left:4px solid var(--hc-room-rail-single) !important;}
    .hc-row.shared td:first-child{border-left-color:var(--hc-room-rail-shared) !important;}
    /* Occupants of one room read as one block: no rule between them. */
    .hc-row.room-end td{border-bottom:1px solid var(--c-border-strong) !important;}
    .hc-row:not(.room-end) td{border-bottom-color:transparent !important;}
    .hc-row.moved td{animation:hcFlash .9s ease-out;}
    @keyframes hcFlash{from{background:var(--c-accent-line);}}

    .hc-order{display:inline-flex; flex-direction:column; gap:3px;}
    .hc-icon{width:28px; height:24px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--c-border-strong); border-radius:6px; background:var(--c-surface); color:var(--c-text-soft); font-size:11px; cursor:pointer; transition:background var(--dur-fast), color var(--dur-fast), border-color var(--dur-fast);}
    .hc-icon:hover{background:var(--c-primary-soft); color:var(--c-primary); border-color:var(--c-primary-line);}
    .hc-icon:focus-visible{outline:none; box-shadow:var(--ring);}
    .hc-icon:disabled{opacity:.35; cursor:default; background:var(--c-surface); color:var(--c-text-muted); border-color:var(--c-border);}
    .hc-icon.del:hover{background:var(--c-danger-soft); color:var(--c-danger); border-color:var(--c-danger-soft);}

    .hc-sn{font-family:var(--font-mono); font-weight:600; font-size:13px; color:var(--c-text-muted);}
    .hc-person{display:flex; align-items:center; gap:12px; min-width:220px;}
    .hc-avatar{width:var(--hc-avatar); height:var(--hc-avatar); flex:0 0 auto; border-radius:10px; object-fit:cover; background:var(--c-primary-soft); border:2px solid var(--c-surface); box-shadow:0 2px 8px rgba(28,37,65,.18);}
    .hc-avatar.ini{display:inline-flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:800; font-size:14px; color:var(--c-primary);}
    .hc-name{font-weight:700; color:var(--c-text); line-height:1.25;}
    .hc-name small{display:block; font-weight:500; font-size:11.5px; color:var(--c-text-muted);}
    .hc-nat{display:inline-block; padding:3px 9px; border-radius:var(--radius-pill); background:var(--c-primary-soft); color:var(--c-primary); font-weight:700; font-size:11.5px; letter-spacing:.04em;}
    .hc-pp{font-family:var(--font-mono); font-size:13px; letter-spacing:.02em; color:var(--c-text);}
    .hc-muted{color:var(--c-text-muted);}

    .hc-room{display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:28px; padding:0 8px; border-radius:var(--radius-sm); background:var(--c-text); color:#fff; font-family:var(--font-display); font-weight:800; font-size:14px;}
    .hc-row.shared .hc-room{background:var(--c-accent);}
    .hc-same{font-size:12px; color:var(--c-text-muted); white-space:nowrap;}
    .hc-row .for-lead{display:block;}
    .hc-row .for-follow{display:none;}
    .hc-row.joined .for-lead{display:none;}
    .hc-row.joined .for-follow{display:inline;}
    .hc-select{height:34px; border:1px solid var(--c-border-strong); border-radius:var(--radius-sm); padding:0 8px; font-size:13px; color:var(--c-text); background:var(--c-surface); min-width:120px;}
    .hc-select:focus{outline:none; border-color:var(--c-primary); box-shadow:var(--ring);}
    .hc-hroom{height:34px; width:90px; border:1px solid var(--c-border-strong); border-radius:var(--radius-sm); padding:0 8px; font-family:var(--font-mono); font-size:13px; text-transform:uppercase;}
    .hc-hroom:focus{outline:none; border-color:var(--c-primary); box-shadow:var(--ring);}

    .hc-join{display:inline-flex; align-items:center; gap:6px; height:30px; padding:0 11px; border-radius:var(--radius-pill); border:1px dashed var(--c-border-strong); background:var(--c-surface); color:var(--c-text-soft); font-size:12px; font-weight:600; cursor:pointer; white-space:nowrap; transition:all var(--dur-fast);}
    .hc-join:hover{border-color:var(--c-accent); color:var(--c-accent);}
    .hc-join.on{border-style:solid; border-color:var(--c-accent); background:var(--c-accent-soft); color:var(--c-accent);}
    .hc-join:focus-visible{outline:none; box-shadow:var(--ring);}
    .hc-row:first-child .hc-join{visibility:hidden;}

    .hc-empty{padding:34px 20px; text-align:center; color:var(--c-text-muted); font-size:13.5px;}

    .hc-pool{display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:10px; padding:16px 20px;}
    .hc-pool-item{display:flex; align-items:center; gap:10px; padding:9px 12px; border:1px solid var(--c-border); border-radius:var(--radius-md); cursor:pointer; margin:0; font-weight:400; transition:border-color var(--dur-fast), background var(--dur-fast);}
    .hc-pool-item:hover{border-color:var(--c-primary-line); background:var(--c-primary-soft);}
    .hc-pool-item input{width:17px; height:17px; accent-color:var(--c-accent); flex:0 0 auto;}
    .hc-pool-item .hc-avatar{--hc-avatar:34px; width:34px; height:34px;}

    .hc-bar{position:sticky; bottom:0; z-index:5; display:flex; flex-wrap:wrap; align-items:center; gap:10px; padding:14px 20px; background:rgba(255,255,255,.96); border-top:1px solid var(--c-border); border-radius:0 0 var(--radius-lg) var(--radius-lg); backdrop-filter:blur(4px);}
    .hc-btn{display:inline-flex; align-items:center; gap:8px; height:40px; padding:0 18px; border-radius:var(--radius-pill); border:1px solid transparent; font-size:13.5px; font-weight:700; cursor:pointer; text-decoration:none; transition:background var(--dur-fast), box-shadow var(--dur-move), transform var(--dur-move);}
    .hc-btn:focus-visible{outline:none; box-shadow:var(--ring);}
    .hc-btn.primary{background:var(--c-primary); color:#fff;}
    .hc-btn.primary:hover{box-shadow:var(--shadow-lift); transform:translateY(-1px); color:#fff;}
    .hc-btn.accent{background:var(--c-accent-strong); color:#fff;}
    .hc-btn.accent:hover{box-shadow:0 8px 18px rgba(245,78,24,.3); transform:translateY(-1px); color:#fff;}
    .hc-btn.ghost{background:var(--c-surface); color:var(--c-text-soft); border-color:var(--c-border-strong);}
    .hc-btn.ghost:hover{background:var(--c-surface-muted); color:var(--c-text);}
    .hc-btn.danger{background:var(--c-surface); color:var(--c-danger); border-color:var(--c-danger-soft);}
    .hc-btn.danger:hover{background:var(--c-danger-soft);}
    .hc-dirty{margin-left:auto; font-size:12.5px; font-weight:600; color:var(--c-accent); display:none;}
    .hc-dirty.on{display:inline;}

    @media (max-width: 900px){
        .hc-fields{grid-template-columns:1fr 1fr;}
        .hc-table-wrap{overflow-x:auto;}
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Hotel Booking Yatris</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Bookings &amp; Yatris</li>
                <li>Hotel Booking Yatris</li>
            </ul>
        </div>

        <div class="hc">
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <div class="hc-hero">
                <div>
                    <div class="t">{{ $list['city'] }} Hotel Check-In List</div>
                    <div class="s">Arrange the yatris, put couples and families in one room with <i class="fa fa-link"></i> <span style="font-weight:700">With above</span>, pick the bed type, then save and download the sheet for the hotel desk.</div>
                </div>
                <div class="hc-tabs" role="tablist">
                    @foreach($hotels as $k => $h)
                        @php $n = HotelCheckin::nights(optional(HotelCheckin::stored($k))['check_in'] ?? $h['check_in'], optional(HotelCheckin::stored($k))['check_out'] ?? $h['check_out']); @endphp
                        <a href="{{ route('hotel-checkin', $k) }}" class="{{ $k === $list['key'] ? 'on' : '' }}" role="tab" aria-selected="{{ $k === $list['key'] ? 'true' : 'false' }}">
                            {{ $h['city'] }}<small>{{ $n ? $n.' night'.($n > 1 ? 's' : '') : 'dates not set' }}</small>
                        </a>
                    @endforeach
                </div>
            </div>

            <form method="post" action="{{ route('hotel-checkin-save', $list['key']) }}" id="hcForm">
                @csrf
                <div class="hc-card">
                    <div class="hc-card-head">
                        <span class="h">Hotel &amp; dates</span>
                        <span class="sub">Printed at the top of the sheet. Dates as DD-MMM-YYYY.</span>
                    </div>
                    <div class="hc-fields">
                        <div class="hc-field">
                            <span class="lab">Hotel</span>
                            <input class="hc-input" type="text" name="hotel" value="{{ old('hotel', $list['hotel']) }}" maxlength="120" required>
                        </div>
                        <div class="hc-field">
                            <span class="lab">Check-in</span>
                            <input class="hc-input mono" type="text" name="check_in" id="hcIn" value="{{ old('check_in', HotelCheckin::stamp($list['check_in'])) }}" placeholder="20-NOV-2026" autocomplete="off">
                        </div>
                        <div class="hc-field">
                            <span class="lab">Check-out</span>
                            <input class="hc-input mono" type="text" name="check_out" id="hcOut" value="{{ old('check_out', HotelCheckin::stamp($list['check_out'])) }}" placeholder="23-NOV-2026" autocomplete="off">
                        </div>
                        <span class="hc-nights" id="hcNights"><i class="fa fa-moon"></i> <span>{{ $nights ? $nights.' night'.($nights > 1 ? 's' : '') : '—' }}</span></span>
                    </div>
                </div>

                <div class="hc-card">
                    <div class="hc-card-head">
                        <span class="h">Yatris &amp; rooms</span>
                        <span class="sub">
                            @if(!$list['saved'])
                                Not saved yet &mdash; this is a starting list. Remove anyone not staying here, then save.
                            @else
                                Saved list. Use the arrows to move a yatri next to their partner.
                            @endif
                        </span>
                    </div>
                    <div class="hc-stats" id="hcStats">
                        <span class="hc-stat"><span class="n" data-stat="yatris">0</span> yatris</span>
                        <span class="hc-stat"><span class="n" data-stat="rooms">0</span> rooms</span>
                        <span class="hc-stat"><span class="n" data-stat="double">0</span> double</span>
                        <span class="hc-stat"><span class="n" data-stat="twin">0</span> twin</span>
                        <span class="hc-stat"><span class="n" data-stat="triple">0</span> triple</span>
                        <span class="hc-stat warn" data-warn><span class="n" data-stat="nobed">0</span> rooms without a bed type</span>
                    </div>

                    <div class="hc-table-wrap">
                    <table class="hc-table">
                        <thead>
                            <tr>
                                <th style="width:48px">Move</th>
                                <th style="width:40px">#</th>
                                <th>Yatri</th>
                                <th>Nationality</th>
                                <th>Passport No.</th>
                                <th style="width:120px">Room</th>
                                <th>Bed Type</th>
                                <th>Room # by Hotel</th>
                                <th style="width:40px"></th>
                            </tr>
                        </thead>
                        <tbody id="hcRows">
                            @foreach($list['rows'] as $row)
                                @php $y = $row['yatri']; @endphp
                                <tr class="hc-row" data-id="{{ $row['id'] }}">
                                    <td>
                                        <input type="hidden" data-f="id" value="{{ $row['id'] }}">
                                        <input type="hidden" data-f="join" value="{{ $row['join'] ? 1 : 0 }}">
                                        <span class="hc-order">
                                            <button type="button" class="hc-icon" data-act="up" title="Move up" aria-label="Move {{ $y->applicant_name }} up"><i class="fa fa-chevron-up"></i></button>
                                            <button type="button" class="hc-icon" data-act="down" title="Move down" aria-label="Move {{ $y->applicant_name }} down"><i class="fa fa-chevron-down"></i></button>
                                        </span>
                                    </td>
                                    <td><span class="hc-sn" data-sn>{{ $loop->iteration }}</span></td>
                                    <td>
                                        <div class="hc-person">
                                            @if($y->photoUrl())
                                                <img class="hc-avatar" src="{{ $y->photoUrl() }}" alt="" loading="lazy">
                                            @else
                                                <span class="hc-avatar ini" aria-hidden="true">{{ $initials($y->applicant_name) }}</span>
                                            @endif
                                            <span class="hc-name">{{ $y->applicant_name ?: '—' }}
                                                @if($y->father_name)<small>{{ $y->parentPrefix() }} {{ $y->father_name }}</small>@endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>@if(HotelCheckin::nationality($y->citizenship))<span class="hc-nat">{{ HotelCheckin::nationality($y->citizenship) }}</span>@else<span class="hc-muted">—</span>@endif</td>
                                    <td>@if($y->passport_no)<span class="hc-pp">{{ $y->passport_no }}</span>@else<span class="hc-muted">—</span>@endif</td>
                                    <td>
                                        <div class="hc-roomcell">
                                        <span class="for-lead"><span class="hc-room" data-room>{{ $row['room'] }}</span></span>
                                        <button type="button" class="hc-join {{ $row['join'] ? 'on' : '' }}" data-act="join" aria-pressed="{{ $row['join'] ? 'true' : 'false' }}" title="Same room as the yatri above"><i class="fa fa-link"></i> With above</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="for-lead">
                                            <select class="hc-select" data-f="bed" aria-label="Bed type">
                                                <option value="">— choose —</option>
                                                @foreach($beds as $bk => $bl)
                                                    {{-- Laravel 8: no @selected directive. --}}
                                                    <option value="{{ $bk }}" {{ $row['room_first'] && $row['bed'] === $bk ? 'selected' : '' }}>{{ $bl }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <span class="for-follow hc-same">same room</span>
                                    </td>
                                    <td>
                                        <span class="for-lead"><input class="hc-hroom" type="text" data-f="hotel_room" value="{{ $row['room_first'] ? $row['hotel_room'] : '' }}" maxlength="20" placeholder="—" aria-label="Room number given by the hotel"></span>
                                        <span class="for-follow hc-same">same room</span>
                                    </td>
                                    <td><button type="button" class="hc-icon del" data-act="remove" title="Remove from this list" aria-label="Remove {{ $y->applicant_name }} from this list"><i class="fa fa-times"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="hc-empty" id="hcEmpty" @if(count($list['rows'])) style="display:none" @endif>
                        No yatris on this list. Tick them below and save.
                    </div>

                    <div class="hc-bar">
                        <button class="hc-btn primary" type="submit" name="then" value="save"><i class="fa fa-save"></i> Save</button>
                        <button class="hc-btn accent" type="submit" name="then" value="pdf"><i class="fa fa-file-pdf"></i> Save &amp; Download PDF</button>
                        @if($otherSaved)
                            <button class="hc-btn ghost" type="submit" form="hcCopy"><i class="fa fa-copy"></i> Copy order from {{ $hotels[$other]['city'] }}</button>
                        @endif
                        @if($list['saved'])
                            <button class="hc-btn danger" type="submit" form="hcReset"><i class="fa fa-undo"></i> Reset list</button>
                        @endif
                        <span class="hc-dirty" id="hcDirty"><i class="fa fa-circle" style="font-size:8px"></i> Unsaved changes</span>
                    </div>
                </div>

                @if(count($list['unlisted']))
                <div class="hc-card">
                    <div class="hc-card-head">
                        <span class="h">Not on this list</span>
                        <span class="sub">Tick to add at the foot of the list, then Save.</span>
                    </div>
                    <div class="hc-pool">
                        @foreach($list['unlisted'] as $y)
                            <label class="hc-pool-item">
                                <input type="checkbox" name="add[]" value="{{ $y->id }}">
                                @if($y->photoUrl())
                                    <img class="hc-avatar" src="{{ $y->photoUrl() }}" alt="" loading="lazy">
                                @else
                                    <span class="hc-avatar ini" aria-hidden="true">{{ $initials($y->applicant_name) }}</span>
                                @endif
                                <span class="hc-name">{{ $y->applicant_name ?: '—' }}
                                    <small>{{ $y->passport_no ?: 'no passport no.' }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif
            </form>

            <form method="post" action="{{ route('hotel-checkin-copy', $list['key']) }}" id="hcCopy" onsubmit="return confirm('Replace this list with the {{ $hotels[$other]['city'] }} order, rooms and bed types? Room numbers given by the hotel are not copied.');">@csrf</form>
            <form method="post" action="{{ route('hotel-checkin-reset', $list['key']) }}" id="hcReset" onsubmit="return confirm('Reset the {{ $list['city'] }} list? The Quick Yatri applications are not touched.');">@csrf</form>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script type="text/javascript">
(function () {
    var body = document.getElementById('hcRows');
    var form = document.getElementById('hcForm');
    var dirty = false;
    var MONTHS = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];

    function rows() { return [].slice.call(body.querySelectorAll('.hc-row')); }
    function f(row, name) { return row.querySelector('[data-f="' + name + '"]'); }
    function markDirty() { dirty = true; document.getElementById('hcDirty').classList.add('on'); }

    // Same rules as HotelCheckin::numberRooms: a joined row shares the room of
    // the row above; a room of three with no bed chosen counts as Triple.
    function refresh() {
        var list = rows(), room = 0, rooms = [], cur = null;
        list.forEach(function (row, i) {
            var joined = i > 0 && f(row, 'join').value === '1';
            if (!joined) { room++; cur = { lead: row, members: [] }; rooms.push(cur); }
            cur.members.push(row);
            row.classList.toggle('joined', joined);
            row.querySelector('[data-sn]').textContent = i + 1;
            row.querySelector('[data-room]').textContent = room;
            row.querySelector('[data-act="up"]').disabled = i === 0;
            row.querySelector('[data-act="down"]').disabled = i === list.length - 1;
            // Name the fields in list order so the post arrives in this order.
            ['id', 'join', 'bed', 'hotel_room'].forEach(function (n) { f(row, n).name = 'rows[' + i + '][' + n + ']'; });
        });

        var stats = { yatris: list.length, rooms: rooms.length, double: 0, twin: 0, triple: 0, nobed: 0 };
        rooms.forEach(function (r, idx) {
            var shared = r.members.length > 1;
            r.members.forEach(function (m, k) {
                m.classList.toggle('shared', shared);
                m.classList.toggle('room-end', k === r.members.length - 1);
                m.classList.toggle('even', idx % 2 === 1);
                m.classList.toggle('odd', idx % 2 === 0);
            });
            var bed = f(r.lead, 'bed').value || (r.members.length >= 3 ? 'triple' : '');
            if (bed) { stats[bed]++; } else { stats.nobed++; }
        });
        Object.keys(stats).forEach(function (k) {
            var el = document.querySelector('[data-stat="' + k + '"]');
            if (el) el.textContent = stats[k];
        });
        document.querySelector('[data-warn]').style.display = stats.nobed ? '' : 'none';
        document.getElementById('hcEmpty').style.display = list.length ? 'none' : '';
    }

    function flash(row) { row.classList.remove('moved'); void row.offsetWidth; row.classList.add('moved'); }

    // Arrows move by room, never into one. The list is read as rooms; a yatri
    // in a shared room first steps out of it (to just above or below it), and a
    // yatri on their own hops over the whole next room. So a couple is never
    // split by someone passing through, and pairing is always an explicit
    // "With above" tick once the two sit next to each other.
    function roomsOf() {
        var out = [];
        rows().forEach(function (row, i) {
            if (i === 0 || f(row, 'join').value !== '1') out.push([row]);
            else out[out.length - 1].push(row);
        });
        return out;
    }
    function render(rooms) {
        rooms.forEach(function (room) {
            room.forEach(function (row, i) { setJoin(row, i > 0); body.appendChild(row); });
        });
    }
    // Take a row out of its room; the room's bed and hotel room number stay
    // with whoever now leads it.
    function takeOut(rooms, row) {
        for (var r = 0; r < rooms.length; r++) {
            var k = rooms[r].indexOf(row);
            if (k < 0) continue;
            if (k === 0 && rooms[r].length > 1) {
                f(rooms[r][1], 'bed').value = f(row, 'bed').value;
                f(rooms[r][1], 'hotel_room').value = f(row, 'hotel_room').value;
                f(row, 'bed').value = '';
                f(row, 'hotel_room').value = '';
            }
            rooms[r].splice(k, 1);
            var shared = rooms[r].length > 0;
            if (!shared) rooms.splice(r, 1);
            return { at: r, shared: shared };
        }
        return null;
    }
    function move(row, dir) {
        var rooms = roomsOf(), from = takeOut(rooms, row);
        var at = from.shared ? (dir < 0 ? from.at : from.at + 1) : from.at + dir;
        rooms.splice(Math.max(0, Math.min(rooms.length, at)), 0, [row]);
        render(rooms);
    }
    function detach(row) { var rooms = roomsOf(); takeOut(rooms, row); render(rooms); }
    function setJoin(row, on) {
        f(row, 'join').value = on ? '1' : '0';
        var b = row.querySelector('[data-act="join"]');
        b.classList.toggle('on', on);
        b.setAttribute('aria-pressed', on ? 'true' : 'false');
    }

    body.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-act]');
        if (!btn) return;
        var row = btn.closest('.hc-row');
        var act = btn.getAttribute('data-act');
        if (act === 'up' || act === 'down') {
            move(row, act === 'up' ? -1 : 1);
            flash(row);
            if (!btn.disabled) btn.focus();
        } else if (act === 'join') {
            setJoin(row, f(row, 'join').value !== '1');
        } else if (act === 'remove') {
            if (!confirm('Remove ' + row.querySelector('.hc-name').firstChild.textContent.trim() + ' from this list?')) return;
            detach(row);
            body.removeChild(row);
        } else {
            return;
        }
        markDirty();
        refresh();
    });
    form.addEventListener('input', markDirty);
    form.addEventListener('change', function () { markDirty(); refresh(); });
    form.addEventListener('submit', function () { dirty = false; });
    document.getElementById('hcReset') && document.getElementById('hcReset').addEventListener('submit', function () { dirty = false; });
    document.getElementById('hcCopy') && document.getElementById('hcCopy').addEventListener('submit', function () { dirty = false; });
    window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });

    // Live nights count from the two DD-MMM-YYYY boxes.
    function parse(v) {
        var m = /^(\d{1,2})-([A-Za-z]{3})-(\d{4})$/.exec((v || '').trim());
        if (!m) return null;
        var mo = MONTHS.indexOf(m[2].toUpperCase());
        return mo < 0 ? null : Date.UTC(+m[3], mo, +m[1]);
    }
    function nights() {
        var a = parse(document.getElementById('hcIn').value), b = parse(document.getElementById('hcOut').value);
        var n = (a !== null && b !== null) ? Math.round((b - a) / 864e5) : 0;
        document.querySelector('#hcNights span').textContent = n > 0 ? n + ' night' + (n > 1 ? 's' : '') : '—';
    }
    ['hcIn', 'hcOut'].forEach(function (id) {
        var el = document.getElementById(id);
        el.addEventListener('input', nights);
        el.addEventListener('blur', function () { el.value = el.value.toUpperCase(); });
    });

    refresh();
})();
</script>
@endsection
