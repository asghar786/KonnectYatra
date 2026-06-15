@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .wc-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .wc-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .wc-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .wc-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .wc-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .wc-hint{color:#8a91a0;font-size:13px;margin:10px 0 18px}

    .wc-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .wc-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .wc-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none}
    .wc-table thead th.tc{text-align:center}
    .wc-table tbody td{padding:14px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .wc-table tbody tr:last-child td{border-bottom:none}
    .wc-table tbody tr{transition:background .12s}
    .wc-table tbody tr:hover{background:#f9fafc}
    .wc-table tbody td.tc{text-align:center}
    .wc-order{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:13px;font-weight:700}
    .wc-thumb{width:180px;height:84px;border-radius:10px;object-fit:cover;background:#f1f2f6;display:block}
    .wc-title-txt{font-weight:600;color:#1f2a44}
    .wc-sub{color:#6b7280;font-size:12px}

    .wc-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap}
    .wc-badge.active{background:#e7f8ec;color:#157f3d}
    .wc-badge.hidden{background:#f1f2f6;color:#5a6273}
    .wc-pill{display:inline-block;background:#eef2ff;color:#3949ab;border-radius:8px;padding:3px 10px;font-size:11.5px;font-weight:600;margin:0 4px 4px 0}
    .wc-pill.alt{background:#f3f4f6;color:#555}

    .wc-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .wc-actions form{margin:0;display:inline}
    .wc-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none}
    .wc-btn:hover{transform:translateY(-2px)}
    .wc-btn.edit{background:#eaf2ff;color:#1a73e8}
    .wc-btn.edit:hover{background:#1a73e8;color:#fff;box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .wc-btn.del{background:#feeceb;color:#e23b2e}
    .wc-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .wc-empty{padding:40px;text-align:center;color:#999;font-size:15px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Home Slider</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Home Slider</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="wc-toolbar">
                <a href="{{ url('admin/home-slider/create') }}" class="btn btn-primary">Add Slide <i class="fa fa-plus"></i></a>
                <div class="wc-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="wcSearch" placeholder="Search slides by title…" autocomplete="off">
                </div>
            </div>
            <p class="wc-hint">These slides appear in the homepage hero slider. Recommended image size: ~1920×900px.</p>

            <div class="wc-card">
                <table class="wc-table">
                    <thead>
                        <tr>
                            <th class="tc">Order</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Buttons</th>
                            <th class="tc">Status</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody id="wcBody">
                        @forelse($slides as $slide)
                        <tr class="wc-row" data-search="{{ strtolower(trim($slide->title.' '.$slide->eyebrow)) }}">
                            <td class="tc"><span class="wc-order">{{ $slide->sort_order }}</span></td>
                            <td><img class="wc-thumb" src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" onerror="this.style.visibility='hidden'"></td>
                            <td>
                                <span class="wc-title-txt">{{ $slide->title }}</span>
                                @if($slide->eyebrow)<div class="wc-sub">{{ $slide->eyebrow }}</div>@endif
                            </td>
                            <td>
                                @if($slide->btn1_text)<span class="wc-pill">{{ $slide->btn1_text }}</span>@endif
                                @if($slide->btn2_text)<span class="wc-pill alt">{{ $slide->btn2_text }}</span>@endif
                                @if(!$slide->btn1_text && !$slide->btn2_text)<span class="wc-sub">—</span>@endif
                            </td>
                            <td class="tc">
                                @if($slide->is_active)<span class="wc-badge active">Active</span>@else<span class="wc-badge hidden">Hidden</span>@endif
                            </td>
                            <td class="tc">
                                <div class="wc-actions">
                                    <a href="{{ url('admin/home-slider/edit', $slide->id) }}" class="wc-btn edit" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form method="POST" action="{{ url('/admin/home-slider/delete', $slide->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="GET">
                                        <button type="submit" class="wc-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="wc-empty">No slides yet. Click "Add Slide" to create one.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="wc-empty" id="wcNoResults" style="display:none;">No slides match your search.</div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('wcSearch');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.wc-row'));
        var noRes = document.getElementById('wcNoResults');
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
