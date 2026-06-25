@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .yt-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:visible;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:14px 14px;border:0;white-space:nowrap}
    #myTables tbody td{padding:13px 14px;font-size:13.5px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #myTables tbody tr:hover{background:#f9fafc}
    .yt-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .yt-yid{font-weight:600;color:#3949ab}
    .yt-name{font-weight:600;color:#1f2a44}
    .yt-amt{font-weight:700;font-variant-numeric:tabular-nums}
    .yt-amt.paid{color:#157f3d}
    .yt-amt.pend{color:#e23b2e}
    .yt-amt.total{color:#1f2a44}
    .yt-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 13px;border-radius:20px;font-size:12px;font-weight:600;white-space:nowrap}
    .yt-badge.paid{background:#e7f8ec;color:#157f3d}
    .yt-badge.unpaid{background:#feeceb;color:#d9534f}
    /* Consolidated payment cell */
    .yt-pay{display:flex;flex-direction:column;gap:2px}
    .yt-paybrk{color:#7b8499;font-size:11.5px;font-weight:600;white-space:nowrap}
    .yt-paybrk .pd{color:#157f3d}
    .yt-paybrk .du{color:#e23b2e}
    /* Travelling info cell */
    .yt-trip{display:flex;flex-direction:column;gap:2px;min-width:150px}
    .yt-trip-pkg{font-weight:600;color:#1f2a44}
    .yt-trip-pkg i{color:#e8721e;margin-right:5px}
    .yt-trip-sub{color:#7b8499;font-size:11.5px;font-weight:600}
    .yt-ttype{color:#3949ab}
    /* Visa status badge */
    .yt-vbadge{display:inline-flex;align-items:center;gap:6px;padding:5px 13px;border-radius:20px;font-size:12px;font-weight:600;white-space:nowrap}
    .yt-vbadge.pending{background:#fff4e5;color:#b76e00}
    .yt-vbadge.process{background:#e7f0fe;color:#1c5fd6}
    .yt-vbadge.approved{background:#e7f8ec;color:#157f3d}
    .yt-vbadge.rejected{background:#feeceb;color:#d9534f}
    /* Comments count button */
    .yt-comments{display:inline-flex;align-items:center;gap:7px;background:#f4f6fa;color:#3a4458;border:1px solid #e3e6ec;border-radius:9px;padding:6px 12px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap}
    .yt-comments:hover{background:#1f2a44;color:#fff;border-color:#1f2a44}
    .yt-comments .cnt{background:#e8721e;color:#fff;border-radius:20px;padding:0 7px;font-size:11px;min-width:18px;text-align:center;line-height:18px}
    .yt-comments:hover .cnt{background:#fff;color:#e8721e}
    .yt-menu .dropdown-header{font-size:11px;text-transform:uppercase;letter-spacing:.04em;color:#98a2b5;padding:6px 12px 2px}

    .yt-action-btn{display:inline-flex;align-items:center;gap:7px;background:#1f2a44;color:#fff;border:none;border-radius:9px;padding:7px 14px;font-size:13px;font-weight:600;cursor:pointer;transition:background .12s}
    .yt-action-btn:hover{background:#33415f;color:#fff}
    .yt-action-btn::after{margin-left:2px}
    .yt-menu{border:1px solid #eef0f4;border-radius:12px;box-shadow:0 12px 30px rgba(28,37,65,.14);padding:6px;min-width:180px}
    .yt-menu .dropdown-item{font-size:13.5px;border-radius:8px;padding:8px 12px;color:#2c3446;display:flex;align-items:center;gap:9px}
    .yt-menu .dropdown-item:hover{background:#f4f6fa;color:#1f2a44}
    .yt-menu .dropdown-item i{width:15px;color:#7b8499}
    .yt-menu .dropdown-item.danger{color:#e23b2e}
    .yt-menu .dropdown-item.danger i{color:#e23b2e}

    /* Top export button group (DataTables) */
    .dt-buttons{display:inline-flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
    .dt-buttons .dt-button{padding:0 !important;background:none !important;border:0 !important;margin:0 !important}
    .dt-buttons .dt-button button,
    .dt-buttons .btn{
        width:auto !important;border:1px solid #e3e6ec !important;background:#fff !important;color:#3a4458 !important;
        border-radius:10px !important;padding:8px 16px !important;font-size:13px !important;font-weight:600 !important;
        box-shadow:none !important;transition:all .12s !important;
    }
    .dt-buttons .dt-button button:hover,.dt-buttons .btn:hover{background:#1f2a44 !important;color:#fff !important;border-color:#1f2a44 !important}
    .dataTables_wrapper .dataTables_filter input{border:1px solid #e2e2e2;border-radius:20px;padding:6px 14px;outline:none}
    .dataTables_wrapper .dataTables_filter input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#1f2a44 !important;color:#fff !important;border-radius:8px;border:0}
    .dataTables_wrapper .dataTables_paginate .paginate_button{border-radius:8px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Bookings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Admin Can View Yatri Applied Bookings</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="yt-card">
                <table class="table" id="myTables">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Yatri #</th>
                            <th>Name</th>
                            <th>Passport #</th>
                            <th>Travelling Info</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Visa Status</th>
                            <th>Comments</th>
                            <th class="text-center not-export">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($yatries as $package)
                        @php
                            $total = (int) str_replace("$", "", @$package->package_type);
                            $pending = (int) @$package->pending_amount;
                            $paid = $total - $pending;
                            $isPaid = $pending <= 0;
                            $ticket = @$package->ticket_type ? ucwords(str_replace('_', ' ', $package->ticket_type)) : '';
                            $vs = @$package->visa_status ?: 'Pending';
                            $vsClass = ['Pending' => 'pending', 'In Process' => 'process', 'Approved' => 'approved', 'Rejected' => 'rejected'][$vs] ?? 'pending';
                        @endphp
                        <tr>
                            <td><span class="yt-idx">{{ $count }}</span></td>
                            <td><span class="yt-yid">{{ @$package->yatri_id }}</span></td>
                            <td><span class="yt-name">{{ trim(@$package->first_name.' '.@$package->middle_name.' '.@$package->last_name) }}</span></td>
                            <td>{{ @$package->passport ?: '—' }}</td>
                            <td>
                                <div class="yt-trip">
                                    <span class="yt-trip-pkg"><i class="fa fa-suitcase"></i>{{ optional(@$package->package)->name ?: '—' }}</span>
                                    <span class="yt-trip-sub">
                                        @if($ticket)<span class="yt-ttype">{{ $ticket }}</span>@endif
                                        @if(optional(@$package->package)->month_year) &middot; {{ $package->package->month_year }} @endif
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="yt-pay">
                                    <span class="yt-amt total">{{ @$package->package_type ?: '—' }}</span>
                                    <span class="yt-paybrk"><span class="pd">Paid ${{ number_format($paid) }}</span> &middot; <span class="du">Due {{ $pending > 0 ? '$'.number_format($pending) : '$0' }}</span></span>
                                </div>
                            </td>
                            <td>
                                @if($isPaid)
                                    <span class="yt-badge paid"><i class="fa fa-check-circle"></i> Paid</span>
                                @else
                                    <span class="yt-badge unpaid"><i class="fa fa-clock"></i> Unpaid</span>
                                @endif
                            </td>
                            <td><span class="yt-vbadge {{ $vsClass }}">{{ $vs }}</span></td>
                            <td>
                                <a href="{{ route('yatri-comments', $package->id) }}" class="yt-comments" title="Communication log">
                                    <i class="fa fa-comments"></i> <span class="cnt">{{ (int) @$package->comments_count }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="yt-action-btn dropdown-toggle" type="button" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bolt"></i> Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right yt-menu">
                                        <a href="{{ route('yatri-visa-edit', $package->id) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ url('admin/booking-detail', $package->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> Details</a>
                                        @if(@$package->payment_status == "pending")
                                        <a href="{{ url('admin/payment', $package->id) }}" class="dropdown-item"><i class="fa fa-dollar-sign"></i> Add Payment</a>
                                        @endif
                                        <a href="{{ route('yatri-comments', $package->id) }}" class="dropdown-item"><i class="fa fa-comments"></i> Comments</a>
                                        <a href="{{ url('admin/add-remarks', $package->id) }}" class="dropdown-item"><i class="fa fa-comment"></i> Remarks</a>
                                        <a href="{{ url('admin/add-balance/'.$package->id) }}" class="dropdown-item"><i class="fa fa-wallet"></i> Manage Balance</a>
                                        <div class="dropdown-divider"></div>
                                        <h6 class="dropdown-header">Visa Status</h6>
                                        <a href="{{ route('yatri-visa-status', [$package->id, 'pending']) }}" class="dropdown-item"><i class="fa fa-hourglass-half"></i> Pending</a>
                                        <a href="{{ route('yatri-visa-status', [$package->id, 'in_process']) }}" class="dropdown-item"><i class="fa fa-spinner"></i> In Process</a>
                                        <a href="{{ route('yatri-visa-status', [$package->id, 'approved']) }}" class="dropdown-item"><i class="fa fa-check"></i> Approved</a>
                                        <a href="{{ route('yatri-visa-status', [$package->id, 'rejected']) }}" class="dropdown-item"><i class="fa fa-times"></i> Rejected</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ url('admin/yatri-visa-delete/'.$package->id) }}" class="dropdown-item danger show_confirm"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php $count++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
