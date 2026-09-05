{{-- Quick Yatri's own landing page: the headline counts, the nearest groups,
     and the way in to everything else in the module.

     Deliberately NOT the applications list — that stays at route('quick-yatri')
     with its search, sorting and price dialogs, and everything that redirects
     there after a save still lands where it always did. --}}
@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .qd-hero{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:14px; background:linear-gradient(120deg,#1f2a44,#1a3fa0); border-radius:16px; box-shadow:0 10px 30px rgba(28,37,65,.18); padding:22px 26px; margin-bottom:20px; color:#fff}
    /* Both colours are forced: the admin theme styles h4 and p globally with
       selectors that outrank this block, and on the hero's dark gradient its
       near-black body colour is unreadable. */
    .qd-hero h4{font-family:Archivo,sans-serif; font-weight:800; font-size:20px; margin:0; color:#fff !important}
    .qd-hero p{margin:5px 0 0; font-size:13px; color:#e8eefb !important; max-width:560px; line-height:1.5}
    .qd-hero .cta{display:inline-flex; align-items:center; gap:8px; background:#f54e18; color:#fff; border-radius:24px; padding:11px 22px; font-size:13.5px; font-weight:600; text-decoration:none; box-shadow:0 6px 16px rgba(245,78,24,.3); transition:transform .12s}
    .qd-hero .cta:hover{transform:translateY(-2px); color:#fff}

    .qd-stats{display:grid; grid-template-columns:repeat(auto-fit,minmax(168px,1fr)); gap:14px; margin-bottom:20px}
    .qd-stat{background:#fff; border:1px solid #eef0f4; border-radius:14px; box-shadow:0 6px 20px rgba(28,37,65,.06); padding:16px 18px}
    .qd-stat em{display:block; font-style:normal; font-size:11.5px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#9aa0ac; margin-bottom:6px}
    .qd-stat b{font-family:Archivo,sans-serif; font-size:26px; font-weight:800; color:#1f2a44; line-height:1; font-variant-numeric:tabular-nums}
    .qd-stat small{display:block; margin-top:5px; font-size:12px; color:#8a91a0}
    .qd-stat.warn{border-color:#f3ddb8; background:#fff8ec}
    .qd-stat.warn b{color:#8a5a08}
    .qd-stat.warn em{color:#b4894a}
    .qd-stat a{color:#8a5a08; text-decoration:underline}

    .qd-grid{display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:16px; margin-bottom:20px}
    .qd-card{display:flex; align-items:flex-start; gap:14px; background:#fff; border:1px solid #eef0f4; border-radius:14px; box-shadow:0 6px 20px rgba(28,37,65,.06); padding:18px 20px; text-decoration:none; transition:transform .12s, box-shadow .12s}
    .qd-card:hover{transform:translateY(-3px); box-shadow:0 12px 28px rgba(28,37,65,.12)}
    .qd-ico{flex:none; width:42px; height:42px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-size:17px}
    .qd-ico.add{background:#feeae3; color:#f54e18}
    .qd-ico.list{background:#eaf2ff; color:#1a73e8}
    .qd-ico.grp{background:#eef0ff; color:#2d1b69}
    .qd-ico.dl{background:#e7f8ec; color:#157f3d}
    .qd-card h6{margin:0 0 4px; font-size:14.5px; font-weight:700; color:#1f2a44}
    .qd-card p{margin:0; font-size:12.5px; color:#8a91a0; line-height:1.5}

    .qd-panel{background:#fff; border:1px solid #eef0f4; border-radius:16px; box-shadow:0 8px 28px rgba(28,37,65,.07); overflow:hidden}
    .qd-panel-head{display:flex; align-items:center; justify-content:space-between; gap:12px; padding:16px 20px; border-bottom:1px solid #f0f2f6}
    .qd-panel-head h5{margin:0; font-size:15.5px; font-weight:700; color:#1f2a44}
    .qd-panel-head a{font-size:12.5px; font-weight:600; color:#1a73e8; text-decoration:none}
    .qd-trip{display:flex; flex-wrap:wrap; align-items:center; gap:12px; padding:14px 20px; border-bottom:1px solid #f4f6fa}
    .qd-trip:last-child{border-bottom:none}
    .qd-city{font-weight:700; color:#1f2a44; font-size:14px; min-width:190px}
    .qd-city small{display:block; font-weight:400; color:#9aa0ac; font-size:11.5px; margin-top:2px}
    .qd-sector{font-family:monospace; font-weight:700; color:#1a3fa0; font-size:12px; background:#eef2fb; border-radius:6px; padding:4px 9px}
    .qd-heads{margin-left:auto; display:inline-flex; align-items:center; gap:7px; background:#1f2a44; color:#fff; border-radius:20px; padding:5px 14px; font-size:12px; font-weight:600}
    .qd-none{padding:28px 20px; text-align:center; color:#9aa0ac; font-size:13.5px; line-height:1.6}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Quick Yatri</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Quick Yatri</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="qd-hero">
                <div>
                    <h4><i class="fa fa-bolt"></i> Quick Yatri</h4>
                    <p>Applications keyed straight off the Konnect.US sheet &mdash; capture them, price them, and group everyone flying together by the city they leave from.</p>
                </div>
                <a href="{{ route('quick-yatri-create') }}" class="cta"><i class="fa fa-plus"></i> Add New Application</a>
            </div>

            <div class="qd-stats">
                <div class="qd-stat">
                    <em>Applications</em>
                    <b>{{ $stats['total'] }}</b>
                    <small>{{ $stats['priced'] }} with a trip option ticked</small>
                </div>
                <div class="qd-stat">
                    <em>Own agreed price</em>
                    <b>{{ $stats['custom_price'] }}</b>
                    <small>priced off the standard grid</small>
                </div>
                <div class="qd-stat">
                    <em>Special requests</em>
                    <b>{{ $stats['wheelchair'] + $stats['vegetarian'] }}</b>
                    <small>{{ $stats['wheelchair'] }} wheelchair &middot; {{ $stats['vegetarian'] }} vegetarian</small>
                </div>
                <div class="qd-stat {{ $stats['missing_travel'] ? 'warn' : '' }}">
                    <em>No departure city</em>
                    <b>{{ $stats['missing_travel'] }}</b>
                    <small>
                        @if($stats['missing_travel'])
                            <a href="{{ route('quick-yatri-groups') }}">not in a group yet</a>
                        @elseif($stats['awaiting_dates'])
                            everyone is grouped &middot; {{ $stats['awaiting_dates'] }} awaiting flight dates
                        @else
                            everyone is grouped and booked
                        @endif
                    </small>
                </div>
            </div>

            <div class="qd-grid">
                <a href="{{ route('quick-yatri') }}" class="qd-card">
                    <span class="qd-ico list"><i class="fa fa-table"></i></span>
                    <span>
                        <h6>Applications</h6>
                        <p>The full list &mdash; search, sort, edit, print a sheet, and set an applicant&rsquo;s own price.</p>
                    </span>
                </a>
                <a href="{{ route('quick-yatri-groups') }}" class="qd-card">
                    <span class="qd-ico grp"><i class="fa fa-users"></i></span>
                    <span>
                        <h6>Group Manifest</h6>
                        <p>Everyone travelling together, split by departure city, with flight sectors &mdash; ready to print.</p>
                    </span>
                </a>
                <a href="{{ route('quick-yatri-create') }}" class="qd-card">
                    <span class="qd-ico add"><i class="fa fa-plus"></i></span>
                    <span>
                        <h6>Add New</h6>
                        <p>Key in a paper application on the same sheet the candidate filled in.</p>
                    </span>
                </a>
                <a href="{{ route('quick-yatri-blank') }}" target="_blank" rel="noopener" class="qd-card">
                    <span class="qd-ico dl"><i class="fa fa-download"></i></span>
                    <span>
                        <h6>Blank Form</h6>
                        <p>Print an empty sheet to hand out at an event. Ctrl+P &rarr; Save as PDF.</p>
                    </span>
                </a>
            </div>

            <div class="qd-panel">
                <div class="qd-panel-head">
                    <h5>Upcoming groups</h5>
                    <a href="{{ route('quick-yatri-groups') }}">View full manifest &rarr;</a>
                </div>
                @forelse($upcomingGroups as $group)
                    <div class="qd-trip">
                        <span class="qd-city">
                            {{ $group['city'] }} ({{ $group['airport_code'] }})
                            <small>
                                @if($group['departure_date'] && $group['return_date'])
                                    {{ $group['departure_date']->format('j M Y') }} &rarr; {{ $group['return_date']->format('j M Y') }}
                                @elseif($group['mixed_dates'])
                                    travelling on more than one date
                                @else
                                    flight not booked yet
                                @endif
                            </small>
                        </span>
                        <span class="qd-sector">{{ $group['rows']->first()->outboundSector() }}</span>
                        <span class="qd-sector">{{ $group['rows']->first()->returnSector() }}</span>
                        <span class="qd-heads"><i class="fa fa-user"></i> {{ $group['rows']->count() }}</span>
                    </div>
                @empty
                    <div class="qd-none">
                        No groups yet. An application joins one as soon as its sheet says which airport
                        the traveller is flying from &mdash; the dates can follow with the booking.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
