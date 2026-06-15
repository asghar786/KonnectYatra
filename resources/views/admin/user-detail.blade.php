@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .ud-top{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:18px}
    .ud-back{display:inline-flex;align-items:center;gap:8px;color:#5a6273;text-decoration:none;font-weight:600;font-size:14px}
    .ud-back:hover{color:#1f2a44}

    .ud-profile{display:flex;flex-wrap:wrap;align-items:center;gap:20px;background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);padding:24px 26px;margin-bottom:22px}
    .ud-av{width:84px;height:84px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:#fff;background:linear-gradient(135deg,#6d28d9,#4c1864);text-transform:uppercase;flex-shrink:0;overflow:hidden}
    .ud-av img{width:100%;height:100%;object-fit:cover}
    .ud-id h3{margin:0 0 4px;font-size:22px;font-weight:800;color:#1f2a44}
    .ud-id .em{color:#1a73e8;text-decoration:none;font-size:14px}
    .ud-id .em:hover{text-decoration:underline}
    .ud-tags{display:flex;gap:8px;flex-wrap:wrap;margin-top:10px}
    .ud-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:600;text-transform:capitalize}
    .ud-badge.role{background:#eef2ff;color:#3949ab}
    .ud-badge.ok{background:#e7f8ec;color:#157f3d}
    .ud-badge.warn{background:#fff4e5;color:#b76e00}
    .ud-badge.flag{background:#f3effe;color:#6d28d9}
    .ud-meta{margin-left:auto;text-align:right;font-size:13px;color:#8a91a0;line-height:1.7}
    .ud-meta b{color:#2c3446}

    .ud-section-title{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#5a6273;margin:0 0 12px}
    .ud-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;margin-bottom:22px}
    .ud-field{background:#fff;border:1px solid #eef0f4;border-radius:12px;padding:13px 16px}
    .ud-field .k{font-size:11px;color:#9aa1ad;text-transform:uppercase;letter-spacing:.03em;font-weight:600}
    .ud-field .v{font-size:14.5px;color:#1f2a44;font-weight:600;margin-top:3px;word-break:break-word}

    .ud-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .ud-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .ud-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:14px 16px;text-align:left;white-space:nowrap;border:none}
    .ud-table thead th.tc{text-align:center}
    .ud-table tbody td{padding:13px 16px;font-size:13.5px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .ud-table tbody tr:last-child td{border-bottom:none}
    .ud-table tbody tr:hover{background:#f9fafc}
    .ud-table tbody td.tc{text-align:center}
    .ud-name{font-weight:600;color:#1f2a44}
    .ud-sub{color:#6b7280}
    .ud-pill{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:600}
    .ud-pill.paid{background:#e7f8ec;color:#157f3d}
    .ud-pill.pending{background:#feeceb;color:#d9534f}
    .ud-empty{padding:34px;text-align:center;color:#999;font-size:15px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">User Details</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/users') }}">Users</a></li>
                <li>{{ $user->name }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="ud-top">
                <a href="{{ url('/admin/users') }}" class="ud-back"><i class="fa fa-arrow-left"></i> Back to Users</a>
            </div>

            @php
                $initial = strtoupper(mb_substr(trim($user->name) ?: '?', 0, 1));
            @endphp
            <div class="ud-profile">
                <div class="ud-av">
                    @if(!empty($user->avatar))
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" onerror="this.parentNode.textContent='{{ $initial }}'">
                    @else
                        {{ $initial }}
                    @endif
                </div>
                <div class="ud-id">
                    <h3>{{ $user->name ?: '—' }}</h3>
                    @if($user->email)<a href="mailto:{{ $user->email }}" class="em"><i class="fa fa-envelope"></i> {{ $user->email }}</a>@endif
                    <div class="ud-tags">
                        <span class="ud-badge role">{{ $user->role ?: 'user' }}</span>
                        @if($user->email_verified_at)
                            <span class="ud-badge ok"><i class="fa fa-check-circle"></i> Verified</span>
                        @else
                            <span class="ud-badge warn"><i class="fa fa-clock"></i> Not Verified</span>
                        @endif
                        @if($user->chairman)<span class="ud-badge flag">Chairman</span>@endif
                        @if($user->secretary)<span class="ud-badge flag">Secretary</span>@endif
                        @if($user->president)<span class="ud-badge flag">President</span>@endif
                    </div>
                </div>
                <div class="ud-meta">
                    <div>User ID: <b>#{{ $user->id }}</b></div>
                    <div>Joined: <b>{{ optional($user->created_at)->format('d M Y') ?: '—' }}</b></div>
                    <div>Total Bookings: <b>{{ $bookings->count() }}</b></div>
                </div>
            </div>

            <p class="ud-section-title">Account Information</p>
            <div class="ud-grid">
                <div class="ud-field"><div class="k">Full Name</div><div class="v">{{ $user->name ?: '—' }}</div></div>
                <div class="ud-field"><div class="k">Email</div><div class="v">{{ $user->email ?: '—' }}</div></div>
                <div class="ud-field"><div class="k">Role</div><div class="v" style="text-transform:capitalize">{{ $user->role ?: 'user' }}</div></div>
                <div class="ud-field"><div class="k">Email Verified</div><div class="v">{{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('d M Y, h:i A') : 'No' }}</div></div>
                <div class="ud-field"><div class="k">Registered On</div><div class="v">{{ optional($user->created_at)->format('d M Y, h:i A') ?: '—' }}</div></div>
                <div class="ud-field"><div class="k">Last Updated</div><div class="v">{{ optional($user->updated_at)->format('d M Y, h:i A') ?: '—' }}</div></div>
            </div>

            <p class="ud-section-title">Bookings ({{ $bookings->count() }})</p>
            <div class="ud-card">
                <div class="table-responsive">
                    <table class="ud-table">
                        <thead>
                            <tr>
                                <th class="tc">#</th>
                                <th>Yatri #</th>
                                <th>Traveler Name</th>
                                <th>Package</th>
                                <th>Passport #</th>
                                <th class="tc">Amount</th>
                                <th class="tc">Payment</th>
                                <th>Booked On</th>
                                <th class="tc">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $i => $b)
                            @php $paid = strtolower(trim($b->payment_status)) == 'paid'; @endphp
                            <tr>
                                <td class="tc">{{ $i + 1 }}</td>
                                <td><span class="ud-name" style="color:#3949ab">{{ $b->yatri_id ?: '—' }}</span></td>
                                <td><span class="ud-name">{{ trim($b->first_name.' '.$b->middle_name.' '.$b->last_name) ?: '—' }}</span></td>
                                <td><span class="ud-sub">{{ @$b->package->name ?: ($b->package_type ?: '—') }}</span></td>
                                <td><span class="ud-sub" style="font-family:monospace">{{ $b->passport ?: '—' }}</span></td>
                                <td class="tc"><span class="ud-sub">{{ $b->package_type ?: '—' }}</span></td>
                                <td class="tc">
                                    @if($paid)<span class="ud-pill paid">Paid</span>@else<span class="ud-pill pending">{{ ucfirst($b->payment_status ?: 'Pending') }}</span>@endif
                                </td>
                                <td><span class="ud-sub">{{ optional($b->created_at)->format('d M Y') ?: '—' }}</span></td>
                                <td class="tc"><a href="{{ url('admin/booking-detail', $b->id) }}" class="ud-sub" style="color:#1a73e8;font-weight:600;text-decoration:none">View</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="ud-empty">This user has no bookings yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
