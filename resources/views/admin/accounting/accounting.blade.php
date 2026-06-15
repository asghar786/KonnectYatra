@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    /* Tabs */
    .tabs-tags{display:flex;flex-wrap:nowrap;border-bottom:2px solid #e7e9ef;margin:8px 0 4px}
    .tabs-tags__tag{
        flex:1 1 0;padding:14px 10px;border-bottom:3px solid transparent;text-align:center;
        color:#5a6273;font-size:16px;font-weight:600;cursor:pointer;transition:color .15s,border-color .15s,background .15s;
    }
    .tabs-tags__tag:hover{color:#f54e18;background:#fff6f2}
    .tabs-tags__tag.active{border-bottom:3px solid #f54e18;color:#f54e18;font-weight:700}

    /* Toolbar */
    .ac-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin:6px 0 18px}
    .ac-search{position:relative;flex:1;min-width:220px;max-width:380px}
    .ac-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .ac-search input{width:100%;padding:10px 14px 10px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .ac-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}

    /* Card table */
    .ac-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .ac-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .ac-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none}
    .ac-table thead th.tc{text-align:center}
    .ac-table tbody td{padding:14px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .ac-table tbody tr:last-child td{border-bottom:none}
    .ac-table tbody tr{transition:background .12s}
    .ac-table tbody tr:hover{background:#f9fafc}
    .ac-table tbody td.tc{text-align:center}
    .ac-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .ac-head{font-weight:600;color:#1f2a44}
    .ac-date{color:#6b7280;font-size:13px}
    .ac-amt{font-weight:700;font-variant-numeric:tabular-nums}
    .ac-amt.pay{color:#c2410c}
    .ac-amt.rec{color:#157f3d}

    .ac-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .ac-actions form{margin:0;display:inline}
    .ac-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none}
    .ac-btn:hover{transform:translateY(-2px)}
    .ac-btn.edit{background:#eaf2ff;color:#1a73e8}
    .ac-btn.edit:hover{background:#1a73e8;color:#fff;box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .ac-btn.del{background:#feeceb;color:#e23b2e}
    .ac-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}

    .ac-empty{padding:36px;text-align:center;color:#999;font-size:15px}

    /* Summary card */
    .ac-summary{display:inline-flex;align-items:center;gap:16px;background:#fff;border:1px solid #eef0f4;border-radius:14px;box-shadow:0 6px 20px rgba(28,37,65,.06);padding:16px 22px;margin-bottom:18px}
    .ac-summary .ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff}
    .ac-summary.pay .ic{background:linear-gradient(135deg,#f97316,#ea580c)}
    .ac-summary.rec .ic{background:linear-gradient(135deg,#22c55e,#16a34a)}
    .ac-summary .lbl{font-size:12px;color:#8a91a0;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
    .ac-summary .val{font-size:24px;font-weight:800;color:#1f2a44;line-height:1.2}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Accounting</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Accounting</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="tabs">
                        <div class="tabs-tags">
                            <span class="tabs-tags__tag">Account Payable</span>
                            <span class="tabs-tags__tag">Account Receivable</span>
                        </div>
                        <div class="tabs-content">

                            {{-- ============ PAYABLE ============ --}}
                            <div class="tabs-content__text">
                                <div class="mt-4">
                                    <div class="ac-summary pay">
                                        <div class="ic"><i class="fa fa-arrow-up"></i></div>
                                        <div>
                                            <div class="lbl">Total Payable Amounts</div>
                                            <div class="val">${{ number_format((float) $total_payable) }}</div>
                                        </div>
                                    </div>

                                    <div class="ac-toolbar">
                                        <a href="{{ url('admin/payable/create') }}" class="btn btn-primary">Add Payable <i class="fa fa-plus"></i></a>
                                        <div class="ac-search">
                                            <i class="fa fa-search"></i>
                                            <input type="text" class="ac-search-input" data-target="payBody" placeholder="Search payable…" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="ac-card">
                                        <table class="ac-table">
                                            <thead>
                                                <tr>
                                                    <th class="tc">#</th>
                                                    <th class="tc">Amount</th>
                                                    <th>Account Head</th>
                                                    <th>Date</th>
                                                    <th class="tc">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="payBody">
                                                @forelse($payable as $key => $val)
                                                <tr class="ac-row" data-search="{{ strtolower(trim(@$val->account_head->name.' '.$val->amount)) }}">
                                                    <td class="tc"><span class="ac-idx">{{ $key + 1 }}</span></td>
                                                    <td class="tc"><span class="ac-amt pay">${{ number_format((float) $val->amount) }}</span></td>
                                                    <td><span class="ac-head">{{ @$val->account_head->name ?: '—' }}</span></td>
                                                    <td><span class="ac-date">{{ date('d-m-Y', strtotime($val->created_at)) }}</span></td>
                                                    <td class="tc">
                                                        <div class="ac-actions">
                                                            <a href="{{ url('admin/payable/edit', $val->id) }}" class="ac-btn edit" title="Edit"><i class="fa fa-edit"></i></a>
                                                            <form method="POST" action="{{ url('/admin/payable/delete', $val->id) }}">
                                                                @csrf
                                                                <input name="_method" type="hidden" value="GET">
                                                                <button type="submit" class="ac-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr><td colspan="5" class="ac-empty">No payable records found.</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div class="ac-empty ac-nores" style="display:none;">No records match your search.</div>
                                    </div>
                                </div>
                            </div>

                            {{-- ============ RECEIVABLE ============ --}}
                            <div class="tabs-content__text">
                                <div class="mt-4">
                                    <div class="ac-summary rec">
                                        <div class="ic"><i class="fa fa-arrow-down"></i></div>
                                        <div>
                                            <div class="lbl">Total Receivable Amounts</div>
                                            <div class="val">${{ number_format((float) $total_receivable) }}</div>
                                        </div>
                                    </div>

                                    <div class="ac-toolbar">
                                        <a href="{{ url('admin/receivable/create') }}" class="btn btn-primary">Add Receivable <i class="fa fa-plus"></i></a>
                                        <div class="ac-search">
                                            <i class="fa fa-search"></i>
                                            <input type="text" class="ac-search-input" data-target="recBody" placeholder="Search receivable…" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="ac-card">
                                        <table class="ac-table">
                                            <thead>
                                                <tr>
                                                    <th class="tc">#</th>
                                                    <th class="tc">Amount</th>
                                                    <th>Account Head</th>
                                                    <th>Date</th>
                                                    <th class="tc">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recBody">
                                                @forelse($receivable as $key => $val)
                                                <tr class="ac-row" data-search="{{ strtolower(trim(@$val->account_head->name.' '.$val->amount)) }}">
                                                    <td class="tc"><span class="ac-idx">{{ $key + 1 }}</span></td>
                                                    <td class="tc"><span class="ac-amt rec">${{ number_format((float) $val->amount) }}</span></td>
                                                    <td><span class="ac-head">{{ @$val->account_head->name ?: '—' }}</span></td>
                                                    <td><span class="ac-date">{{ date('d-m-Y', strtotime($val->created_at)) }}</span></td>
                                                    <td class="tc">
                                                        <div class="ac-actions">
                                                            <a href="{{ url('admin/receivable/edit', $val->id) }}" class="ac-btn edit" title="Edit"><i class="fa fa-edit"></i></a>
                                                            <form method="POST" action="{{ url('/admin/receivable/delete', $val->id) }}">
                                                                @csrf
                                                                <input name="_method" type="hidden" value="GET">
                                                                <button type="submit" class="ac-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr><td colspan="5" class="ac-empty">No receivable records found.</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div class="ac-empty ac-nores" style="display:none;">No records match your search.</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection

@section('js')
<script type="text/javascript">
    function TabsManager(el) {
        this.tabsContainers = document.querySelectorAll(el);
        this.init();
    }
    TabsManager.prototype.init = function () {
        var self = this;
        document.body.addEventListener("click", function (event) {
            var target = event.target;
            while (target !== document.body) {
                if (target.matches(".tabs-tags__tag")) { self.handleTabClick(target); return; }
                target = target.parentNode;
            }
        });
        self.tabsContainers.forEach(function (tabsContainer) {
            if (tabsContainer) {
                var contentTexts = tabsContainer.querySelectorAll(".tabs-content__text");
                contentTexts.forEach(function (text, index) { if (index !== 0) text.style.display = "none"; });
                tabsContainer.querySelector(".tabs-tags__tag").classList.add("active");
            }
        });
    };
    TabsManager.prototype.handleTabClick = function (clickedTab) {
        var tabsContainer = clickedTab.closest(".tabs");
        if (tabsContainer) {
            var contentTexts = tabsContainer.querySelectorAll(".tabs-content__text");
            var tags = tabsContainer.querySelectorAll(".tabs-tags__tag");
            var index = Array.from(tags).indexOf(clickedTab);
            contentTexts.forEach(function (text) { text.style.display = "none"; });
            contentTexts[index].style.display = "block";
            tags.forEach(function (t) { t.classList.remove("active"); });
            clickedTab.classList.add("active");
        }
    };
    var tabsManager = new TabsManager(".tabs");

    // Per-table search
    document.querySelectorAll('.ac-search-input').forEach(function (input) {
        input.addEventListener('input', function () {
            var body = document.getElementById(this.getAttribute('data-target'));
            if (!body) return;
            var q = this.value.toLowerCase().trim(), visible = 0;
            var rows = body.querySelectorAll('.ac-row');
            rows.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            var noRes = body.closest('.ac-card').querySelector('.ac-nores');
            if (noRes) noRes.style.display = (visible === 0 && rows.length) ? 'block' : 'none';
        });
    });
</script>
@endsection
