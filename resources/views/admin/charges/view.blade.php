@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    /* Tabs */
    .tabs-tags{display:flex;flex-wrap:nowrap;overflow-x:auto;border-bottom:2px solid #e7e9ef;margin:8px 0 4px}
    .tabs-tags__tag{
        flex:1 1 0;min-width:120px;padding:14px 10px;border-bottom:3px solid transparent;text-align:center;
        color:#5a6273;font-size:16px;font-weight:600;cursor:pointer;white-space:nowrap;
        transition:color .15s,border-color .15s,background .15s;
    }
    .tabs-tags__tag:hover{color:#f54e18;background:#fff6f2}
    .tabs-tags__tag.active{border-bottom:3px solid #f54e18;color:#f54e18;font-weight:700}
    .tabs-tags::-webkit-scrollbar{height:6px}
    .tabs-tags::-webkit-scrollbar-thumb{background:#d6d9e0;border-radius:6px}

    /* Toolbar */
    .ex-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin:18px 0}
    .ex-search{position:relative;flex:1;min-width:220px;max-width:380px}
    .ex-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .ex-search input{width:100%;padding:10px 14px 10px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .ex-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}

    /* Card table */
    .ex-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .ex-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .ex-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none}
    .ex-table thead th.tc{text-align:center}
    .ex-table tbody td{padding:14px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .ex-table tbody tr:last-child td{border-bottom:none}
    .ex-table tbody tr{transition:background .12s}
    .ex-table tbody tr:hover{background:#f9fafc}
    .ex-table tbody td.tc{text-align:center}
    .ex-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .ex-desc{font-weight:600;color:#1f2a44}
    .ex-amt{font-weight:700;font-variant-numeric:tabular-nums;color:#1f2a44}
    .ex-pp{font-variant-numeric:tabular-nums;color:#157f3d;font-weight:600}

    .ex-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .ex-actions form{margin:0;display:inline}
    .ex-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none}
    .ex-btn:hover{transform:translateY(-2px)}
    .ex-btn.edit{background:#eaf2ff;color:#1a73e8}
    .ex-btn.edit:hover{background:#1a73e8;color:#fff;box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .ex-btn.del{background:#feeceb;color:#e23b2e}
    .ex-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .ex-empty{padding:36px;text-align:center;color:#999;font-size:15px}

    /* Summary card */
    .ex-summary{display:inline-flex;align-items:center;gap:16px;background:#fff;border:1px solid #eef0f4;border-radius:14px;box-shadow:0 6px 20px rgba(28,37,65,.06);padding:16px 22px;margin-bottom:6px}
    .ex-summary .ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;background:linear-gradient(135deg,#6d28d9,#4c1864)}
    .ex-summary .lbl{font-size:12px;color:#8a91a0;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
    .ex-summary .val{font-size:24px;font-weight:800;color:#1f2a44;line-height:1.2}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Expenses</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Expenses</li>
            </ul>
        </div>

        <div class="main-body">
            <div class="ex-summary">
                <div class="ic"><i class="fa fa-users"></i></div>
                <div>
                    <div class="lbl">Total Yatri's</div>
                    <div class="val">{{ $total_yatri }}</div>
                </div>
            </div>

            @php
                $cities = [
                    'New York'    => $new_york,
                    'Washington'  => $washington,
                    'Los Angeles' => $los_angeles,
                    'Chicago'     => $chicago,
                    'Miami'       => $miami,
                    'Seattle'     => $seattle,
                    'Houston'     => $houston,
                    'Toronto'     => $torronto,
                    'Atlanta'     => $atlanta,
                ];
                $yatriCount = (int) $total_yatri;
            @endphp

            <div class="tabs">
                <div class="tabs-tags">
                    @foreach($cities as $city => $rows)
                        <span class="tabs-tags__tag">{{ $city }}</span>
                    @endforeach
                </div>
                <div class="tabs-content">
                    @foreach($cities as $city => $rows)
                    <div class="tabs-content__text">
                        <div class="ex-toolbar">
                            <a href="{{ url('admin/charges/create') }}?state={{ urlencode($city) }}" class="btn btn-primary">Add Expense <i class="fa fa-plus"></i></a>
                            <div class="ex-search">
                                <i class="fa fa-search"></i>
                                <input type="text" class="ex-search-input" data-target="exBody{{ $loop->index }}" placeholder="Search {{ $city }} expenses…" autocomplete="off">
                            </div>
                        </div>

                        <div class="ex-card">
                            <table class="ex-table">
                                <thead>
                                    <tr>
                                        <th class="tc">#</th>
                                        <th>Description</th>
                                        <th class="tc">Amount</th>
                                        <th class="tc">Per Person</th>
                                        <th class="tc">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="exBody{{ $loop->index }}">
                                    @forelse($rows as $key => $val)
                                    <tr class="ex-row" data-search="{{ strtolower(trim($val->description.' '.$val->amount)) }}">
                                        <td class="tc"><span class="ex-idx">{{ $key + 1 }}</span></td>
                                        <td><span class="ex-desc">{{ $val->description }}</span></td>
                                        <td class="tc"><span class="ex-amt">${{ number_format((float) $val->amount) }}</span></td>
                                        <td class="tc"><span class="ex-pp">$@if($yatriCount > 0){{ number_format((float) $val->amount / $yatriCount, 2) }}@else 0 @endif</span></td>
                                        <td class="tc">
                                            <div class="ex-actions">
                                                <a href="{{ url('admin/charges/edit', $val->id) }}" class="ex-btn edit" title="Edit"><i class="fa fa-edit"></i></a>
                                                <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="GET">
                                                    <button type="submit" class="ex-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="ex-empty">No expenses found for {{ $city }}.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="ex-empty ex-nores" style="display:none;">No expenses match your search.</div>
                        </div>
                    </div>
                    @endforeach
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
    document.querySelectorAll('.ex-search-input').forEach(function (input) {
        input.addEventListener('input', function () {
            var body = document.getElementById(this.getAttribute('data-target'));
            if (!body) return;
            var q = this.value.toLowerCase().trim(), visible = 0;
            var rows = body.querySelectorAll('.ex-row');
            rows.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            var noRes = body.closest('.ex-card').querySelector('.ex-nores');
            if (noRes) noRes.style.display = (visible === 0 && rows.length) ? 'block' : 'none';
        });
    });
</script>
@endsection
