@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .ah-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:18px}
    .ah-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .ah-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .ah-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .ah-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}

    .ah-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .ah-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .ah-table thead th{
        background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;
        letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none;
    }
    .ah-table thead th.tc{text-align:center}
    .ah-table tbody td{padding:14px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .ah-table tbody tr:last-child td{border-bottom:none}
    .ah-table tbody tr{transition:background .12s}
    .ah-table tbody tr:hover{background:#f9fafc}
    .ah-table tbody td.tc{text-align:center}
    .ah-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .ah-name{font-weight:600;color:#1f2a44}
    .ah-desc{color:#6b7280;font-size:13px}

    .ah-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap}
    .ah-badge.us{background:#e8f0fe;color:#1a56db}
    .ah-badge.pk{background:#e7f8ec;color:#157f3d}
    .ah-badge.other{background:#f1f2f6;color:#5a6273}

    .ah-amt{font-weight:600;font-variant-numeric:tabular-nums}
    .ah-amt.zero{color:#9aa1ad;font-weight:500}
    .ah-amt.pos{color:#157f3d}

    .ah-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .ah-actions form{margin:0;display:inline}
    .ah-btn{
        display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;
        border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none;
    }
    .ah-btn:hover{transform:translateY(-2px)}
    .ah-btn.edit{background:#eaf2ff;color:#1a73e8}
    .ah-btn.edit:hover{background:#1a73e8;color:#fff;box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .ah-btn.del{background:#feeceb;color:#e23b2e}
    .ah-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}

    .ah-empty{padding:40px;text-align:center;color:#999;font-size:15px}
    @media (max-width:768px){.ah-table thead{display:none}.ah-desc{display:block}}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Account Head</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Account Head</li>
            </ul>
        </div>

        <div class="main-body">
            <div class="ah-toolbar">
                <a href="{{ url('admin/account-head/create') }}" class="btn btn-primary">Add Account Head <i class="fa fa-plus"></i></a>
                <div class="ah-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="ahSearch" placeholder="Search by name, description or type…" autocomplete="off">
                </div>
            </div>

            <div class="ah-card">
                <table class="ah-table">
                    <thead>
                        <tr>
                            <th class="tc">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th class="tc">Payable</th>
                            <th class="tc">Receivable</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ahBody">
                        @forelse($account_head as $key => $val)
                        @php
                            $type = trim($val->type);
                            $typeClass = $type == 'United States' ? 'us' : ($type == 'Pakistan' ? 'pk' : 'other');
                            $payable = (float) $val->total_payable;
                            $receivable = (float) $val->total_receiveable;
                        @endphp
                        <tr class="ah-row" data-search="{{ strtolower(trim($val->name.' '.$val->description.' '.$type)) }}">
                            <td class="tc"><span class="ah-idx">{{ $key + 1 }}</span></td>
                            <td><span class="ah-name">{{ $val->name }}</span></td>
                            <td><span class="ah-desc">{{ $val->description }}</span></td>
                            <td><span class="ah-badge {{ $typeClass }}">{{ $type ?: '—' }}</span></td>
                            <td class="tc"><span class="ah-amt {{ $payable > 0 ? '' : 'zero' }}">${{ number_format($payable) }}</span></td>
                            <td class="tc"><span class="ah-amt {{ $receivable > 0 ? 'pos' : 'zero' }}">${{ number_format($receivable) }}</span></td>
                            <td class="tc">
                                <div class="ah-actions">
                                    <a href="{{ url('admin/account-head/edit', $val->id) }}" class="ah-btn edit" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form method="POST" action="{{ url('/admin/account-head/delete', $val->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="GET">
                                        <button type="submit" class="ah-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="ah-empty">No account heads found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="ah-empty" id="ahNoResults" style="display:none;">No account heads match your search.</div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('ahSearch');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.ah-row'));
        var noRes = document.getElementById('ahNoResults');
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
