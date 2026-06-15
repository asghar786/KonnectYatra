@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .us-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:14px 16px;border:0;text-align:left;white-space:nowrap}
    #myTables thead th.tc{text-align:center}
    #myTables tbody td{padding:13px 16px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #myTables tbody tr:hover{background:#f9fafc}
    #myTables tbody td.tc{text-align:center}
    .us-user{display:inline-flex;align-items:center;gap:11px}
    .us-av{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;background:linear-gradient(135deg,#6d28d9,#4c1864);flex-shrink:0;text-transform:uppercase}
    .us-name{font-weight:600;color:#1f2a44}
    .us-email a{color:#1a73e8;text-decoration:none}
    .us-email a:hover{text-decoration:underline}
    .us-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap;text-transform:capitalize}
    .us-badge.admin{background:#eef2ff;color:#3949ab}
    .us-badge.user{background:#e7f8ec;color:#157f3d}
    .us-badge.other{background:#f1f2f6;color:#5a6273}

    .us-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .us-actions form{margin:0;display:inline}
    .us-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none}
    .us-btn:hover{transform:translateY(-2px)}
    .us-btn.view{background:#eaf2ff;color:#1a73e8}
    .us-btn.view:hover{background:#1a73e8;color:#fff;box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .us-btn.del{background:#feeceb;color:#e23b2e}
    .us-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .us-empty{padding:40px;text-align:center;color:#999;font-size:15px}

    /* Top export button group (DataTables) */
    .dt-buttons{display:inline-flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
    .dt-buttons .dt-button{padding:0 !important;background:none !important;border:0 !important;margin:0 !important}
    .dt-buttons .dt-button button,.dt-buttons .btn{
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
            <h4 class="breadcrumb-title">Users</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Users</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="us-card">
                <table class="table" id="myTables">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        @php
                            $role = strtolower(trim(@$user->role));
                            $roleClass = $role == 'admin' ? 'admin' : ($role == 'user' ? 'user' : 'other');
                            $initial = strtoupper(mb_substr(trim(@$user->name) ?: '?', 0, 1));
                        @endphp
                        <tr>
                            <td>
                                <span class="us-user">
                                    <span class="us-av">{{ $initial }}</span>
                                    <span class="us-name">{{ @$user->name ?: '—' }}</span>
                                </span>
                            </td>
                            <td class="us-email">@if(@$user->email)<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>@else — @endif</td>
                            <td>@if(@$user->role)<span class="us-badge {{ $roleClass }}">{{ $user->role }}</span>@else <span class="us-badge other">—</span> @endif</td>
                            <td class="tc">
                                <div class="us-actions">
                                    <a href="{{ url('admin/users/view', $user->id) }}" class="us-btn view" title="View Details"><i class="fa fa-eye"></i></a>
                                    <form method="POST" action="{{ url('admin/users/delete', $user->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="GET">
                                        <button type="submit" class="us-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="us-empty">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
