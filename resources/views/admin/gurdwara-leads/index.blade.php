@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .gl-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:18px}
    .gl-total{display:inline-flex;align-items:center;gap:8px;background:#1f2a44;color:#fff;font-size:13px;font-weight:600;padding:9px 18px;border-radius:24px}
    .gl-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .gl-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .gl-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .gl-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}

    .gl-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .gl-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .gl-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none}
    .gl-table thead th.tc{text-align:center}
    .gl-table tbody td{padding:14px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .gl-table tbody tr:last-child td{border-bottom:none}
    .gl-table tbody tr:hover{background:#f9fafc}
    .gl-table tbody td.tc{text-align:center}
    .gl-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .gl-name{font-weight:600;color:#1f2a44}
    .gl-name small{display:block;color:#9aa0ac;font-size:11.5px;font-weight:400}
    .gl-phone{display:inline-flex;align-items:center;gap:7px;color:#1f2a44;text-decoration:none}
    .gl-phone i{color:#f54e18}
    .gl-phone:hover{color:#1a73e8}
    .gl-mail{display:flex;width:fit-content;align-items:center;gap:7px;color:#6b7280;text-decoration:none;font-size:12.5px;margin-top:3px}
    .gl-mail i{color:#f54e18}
    .gl-mail:hover{color:#1a73e8}
    .gl-count{display:inline-block;min-width:30px;text-align:center;font-weight:700;color:#1f2a44;background:#fff2ec;border:1px solid #ffd9c9;border-radius:20px;padding:4px 11px;font-size:12.5px}
    .gl-addr{color:#4b5563}
    .gl-addr small{display:block;color:#9aa0ac;font-size:11.5px}
    .gl-gurdwara{display:inline-block;font-weight:700;color:#2d1b69;background:#eef0ff;border-radius:20px;padding:4px 12px;font-size:12.5px}
    .gl-badge{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:600;background:#e7f8ec;color:#1c9e44;white-space:nowrap}
    .gl-sub{color:#6b7280;font-size:13px}

    .gl-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .gl-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none}
    .gl-btn:hover{transform:translateY(-2px)}
    .gl-btn.del{background:#feeceb;color:#e23b2e}
    .gl-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .gl-empty{padding:40px;text-align:center;color:#999;font-size:15px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gurdwara Leads</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Gurdwara Leads</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="gl-toolbar">
                <span class="gl-total"><i class="fa fa-address-card"></i> {{ count($leads) }} Submissions</span>
                <div class="gl-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="glSearch" placeholder="Search by name, father's name, phone, email, city, gurdwara…" autocomplete="off">
                </div>
            </div>

            <div class="gl-card">
                <table class="gl-table">
                    <thead>
                        <tr>
                            <th class="tc">#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th class="tc">Yatris</th>
                            <th>Near Gurdwara Sahib</th>
                            <th>Heard From</th>
                            <th>Submitted On</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody id="glBody">
                        @forelse($leads as $i => $lead)
                        <tr class="gl-row" data-search="{{ strtolower(trim($lead->full_name.' '.$lead->father_name.' '.$lead->phone.' '.$lead->email.' '.$lead->city.' '.$lead->state.' '.$lead->zip_code.' '.$lead->near_gurdwara)) }}">
                            <td class="tc"><span class="gl-idx">{{ $i + 1 }}</span></td>
                            <td><span class="gl-name">{{ $lead->full_name }}{{-- Leads carry no gender, so no S/o or D/o guess. --}}@if($lead->father_name)<small>Father: {{ $lead->father_name }}</small>@endif</span></td>
                            <td>
                                <a class="gl-phone" href="tel:{{ $lead->phone }}"><i class="fa fa-phone"></i> {{ $lead->phone }}</a>
                                @if($lead->email)<a class="gl-mail" href="mailto:{{ $lead->email }}"><i class="fa fa-envelope"></i> {{ $lead->email }}</a>@endif
                            </td>
                            <td><span class="gl-addr">{{ $lead->city }}, {{ $lead->state }}<small>Zip {{ $lead->zip_code }}</small></span></td>
                            <td class="tc">@if($lead->yatri_count)<span class="gl-count">{{ $lead->yatri_count }}</span>@else <span class="gl-sub">—</span> @endif</td>
                            <td><span class="gl-gurdwara">{{ $lead->near_gurdwara }}</span></td>
                            <td>@if($lead->heard_from)<span class="gl-badge">{{ $lead->heard_from }}</span>@else <span class="gl-sub">—</span> @endif</td>
                            <td><span class="gl-sub">{{ optional($lead->created_at)->format('d M Y, h:i A') ?: '—' }}</span></td>
                            <td class="tc">
                                <div class="gl-actions">
                                    <a href="{{ url('admin/gurdwara-leads/delete', $lead->id) }}" class="gl-btn del" title="Delete" onclick="return confirm('Delete this submission?')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="gl-empty">No submissions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="gl-empty" id="glNoResults" style="display:none;">No submissions match your search.</div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('glSearch');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.gl-row'));
        var noRes = document.getElementById('glNoResults');
        if (!input) return;
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim(), visible = 0;
            rows.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            noRes.style.display = (visible === 0 && rows.length) ? 'block' : 'none';
        });
    })();
</script>
@endsection
