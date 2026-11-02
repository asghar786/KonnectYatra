{{-- Yatri List — the "List of Yatris Traveling to Pakistan…" sheet, drawn the
     way the office's spreadsheet looks, arranged from the Quick Yatri
     applications (App\Support\YatriList).

     Drag a row by its grip (or use the arrows) to set the order; untick a yatri
     to leave them off the PDF and Excel. Unticked rows keep their place on
     screen, and Yatri # counts the ticked rows only, the way the file will.

     NB: no <b>, <p> or coloured <label> text here — adminassets/css/form.css
     forces them black with !important, and gives every td 10px padding and a
     black border, so the table overrides both with !important. --}}
@extends('admin.layouts.app')
@section('content')
@php use App\Support\YatriList; @endphp
<style type="text/css">
    .yl{
        --navy:#1f2a44; --navy-2:#16294d; --blue:#1a3fa0; --blue-soft:#eef2fb; --blue-line:#dde6fb;
        --orange:#f54e18; --orange-soft:#fff5f0; --orange-line:#fde0d2;
        --green:#157f3d; --green-soft:#e7f8ec; --teal:#2f6f62;
        --line:#eef0f4; --line-strong:#d5dbe6; --cell:#bfc6d4; --muted:#8a91a0; --soft:#42506a;
        --ring:0 0 0 3px rgba(26,63,160,.22);
        color:var(--navy);
    }
    .yl *{box-sizing:border-box;}

    .yl-hero{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; background:linear-gradient(120deg,var(--navy),var(--blue)); border-radius:16px; box-shadow:0 12px 28px rgba(28,37,65,.12); padding:22px 26px; margin-bottom:18px; color:#fff;}
    .yl-hero .t{font-family:Archivo,system-ui,sans-serif; font-weight:800; font-size:21px; line-height:1.15;}
    .yl-hero .s{margin-top:5px; font-size:13px; opacity:.88; max-width:600px; line-height:1.5;}
    .yl-count{display:inline-flex; align-items:baseline; gap:8px; background:rgba(255,255,255,.12); border-radius:999px; padding:10px 20px; font-size:13px; white-space:nowrap;}
    .yl-count .n{font-family:Archivo,system-ui,sans-serif; font-weight:800; font-size:22px; font-variant-numeric:tabular-nums;}

    .yl-card{background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 8px 28px rgba(28,37,65,.07); margin-bottom:18px;}

    /* ---- The sheet: logo, boxed title, navy heading row ---- */
    .yl-sheet{padding:22px 24px 8px;}
    .yl-logo{height:58px; display:block; margin-bottom:12px;}
    .yl-title{display:block; width:100%; border:2px solid var(--teal); border-radius:2px; padding:10px 14px; text-align:center; font-family:Archivo,system-ui,sans-serif; font-weight:800; font-size:18px; letter-spacing:.01em; color:#1f3864; text-transform:uppercase; background:#fff; transition:box-shadow .15s, border-color .15s;}
    .yl-title:hover{border-color:var(--blue);}
    .yl-title:focus{outline:none; border-color:var(--blue); box-shadow:var(--ring);}
    .yl-title-hint{display:block; margin:5px 0 0; font-size:11.5px; color:var(--muted); text-align:center;}

    .yl-tools{display:flex; flex-wrap:wrap; align-items:center; gap:10px; padding:14px 24px 12px;}
    .yl-pill{display:inline-flex; align-items:center; gap:7px; height:32px; padding:0 13px; border-radius:999px; border:1px solid var(--line-strong); background:#fff; color:var(--soft); font-size:12.5px; font-weight:600; cursor:pointer; transition:background .15s, color .15s, border-color .15s;}
    .yl-pill:hover{background:var(--blue-soft); color:var(--blue); border-color:var(--blue-line);}
    .yl-pill:focus-visible{outline:none; box-shadow:var(--ring);}
    .yl-search{height:32px; min-width:220px; border:1px solid var(--line-strong); border-radius:999px; padding:0 14px; font-size:13px; color:var(--navy);}
    .yl-search:focus{outline:none; border-color:var(--blue); box-shadow:var(--ring);}
    .yl-tools .sp{margin-left:auto; font-size:12.5px; color:var(--muted);}

    .yl-wrap{padding:0 24px 18px; overflow-x:auto;}
    .yl-table{width:100%; border-collapse:collapse;}
    .yl-table th{background:var(--navy) !important; color:#fff !important; font-size:13.5px; font-weight:700; padding:10px 10px !important; border:1px solid #5a6785 !important; text-align:center; white-space:nowrap;}
    .yl-table th.ctl{background:#f7f8fb !important; color:var(--muted) !important; border-color:var(--line) !important; font-size:11px; letter-spacing:.06em; text-transform:uppercase;}
    .yl-table td{padding:7px 10px !important; border:1px solid var(--cell) !important; vertical-align:middle; font-size:14px; background:#fff;}
    .yl-table td.ctl{border-color:var(--line) !important; background:#fbfcfe; width:1%; white-space:nowrap;}
    .yl-sn{text-align:center; font-variant-numeric:tabular-nums; font-weight:600; width:80px;}
    .yl-nm{font-weight:700; color:var(--navy-2); text-transform:uppercase; letter-spacing:.01em;}
    .yl-nm small{display:block; font-weight:500; font-size:11.5px; color:var(--muted); text-transform:none; letter-spacing:0;}
    .yl-c{text-align:center;}
    .yl-pp{text-align:center; font-family:'IBM Plex Mono',ui-monospace,monospace; letter-spacing:.02em; text-transform:uppercase;}
    .yl-muted{color:var(--muted);}
    .yl-new{display:inline-block; margin-left:6px; padding:1px 7px; border-radius:999px; background:var(--orange-soft); color:var(--orange); border:1px solid var(--orange-line); font-size:10.5px; font-weight:700; letter-spacing:.04em; vertical-align:2px;}

    .yl-row{transition:opacity .15s;}
    .yl-row.off td:not(.ctl){background:#f7f8fb; color:var(--muted);}
    .yl-row.off .yl-nm{color:var(--muted); text-decoration:line-through; text-decoration-color:rgba(138,145,160,.6);}
    .yl-row.dragging td{background:var(--blue-soft) !important;}
    .yl-row.dragging{box-shadow:0 10px 24px rgba(28,37,65,.18); position:relative; z-index:2;}
    .yl-row.moved td{animation:ylFlash .9s ease-out;}
    @keyframes ylFlash{from{background:var(--orange-line);}}
    .yl-row[hidden]{display:none;}

    .yl-ctl{display:inline-flex; align-items:center; gap:6px;}
    .yl-grip{width:28px; height:30px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; color:var(--muted); cursor:grab; touch-action:none; user-select:none; transition:background .15s, color .15s;}
    .yl-grip:hover{background:var(--blue-soft); color:var(--blue);}
    .yl-dragging-on, .yl-dragging-on *{cursor:grabbing !important; user-select:none;}
    .yl-arrow{width:24px; height:22px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--line-strong); border-radius:6px; background:#fff; color:var(--soft); font-size:10px; cursor:pointer; padding:0;}
    .yl-arrow:hover{background:var(--blue-soft); color:var(--blue); border-color:var(--blue-line);}
    .yl-arrow:disabled{opacity:.3; cursor:default; background:#fff; color:var(--muted);}
    .yl-arrow:focus-visible, .yl-tick:focus-visible{outline:none; box-shadow:var(--ring);}
    .yl-arrows{display:inline-flex; flex-direction:column; gap:2px;}
    .yl-tick{width:19px; height:19px; accent-color:var(--orange); cursor:pointer; margin:0 4px;}

    .yl-empty{padding:34px 20px; text-align:center; color:var(--muted); font-size:13.5px;}

    .yl-bar{position:sticky; bottom:0; z-index:5; display:flex; flex-wrap:wrap; align-items:center; gap:10px; padding:14px 24px; background:rgba(255,255,255,.96); border-top:1px solid var(--line); border-radius:0 0 16px 16px; backdrop-filter:blur(4px);}
    .yl-btn{display:inline-flex; align-items:center; gap:8px; height:40px; padding:0 18px; border-radius:999px; border:1px solid transparent; font-size:13.5px; font-weight:700; cursor:pointer; text-decoration:none; transition:box-shadow .2s, transform .2s, opacity .15s;}
    .yl-btn:focus-visible{outline:none; box-shadow:var(--ring);}
    .yl-btn:hover:not(:disabled){transform:translateY(-1px); box-shadow:0 8px 18px rgba(28,37,65,.18);}
    .yl-btn:disabled{opacity:.45; cursor:not-allowed;}
    .yl-btn.primary{background:var(--blue); color:#fff;}
    .yl-btn.pdf{background:#c62828; color:#fff;}
    .yl-btn.xls{background:var(--green); color:#fff;}
    .yl-btn.ghost{background:#fff; color:var(--soft); border-color:var(--line-strong);}
    .yl-dirty{margin-left:auto; font-size:12.5px; font-weight:600; color:var(--orange); display:none;}
    .yl-dirty.on{display:inline;}

    @media (max-width: 700px){
        .yl-sheet, .yl-tools, .yl-wrap, .yl-bar{padding-left:14px; padding-right:14px;}
        .yl-title{font-size:15px;}
        .yl-search{min-width:0; flex:1;}
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri List</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ route('quick-yatri-dashboard') }}">Quick Yatri</a></li>
                <li>Yatri List</li>
            </ul>
        </div>

        <div class="yl">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <div class="yl-hero">
                <div>
                    <div class="t">Yatri List</div>
                    <div class="s">Drag yatris into the order you want by the <i class="fa fa-grip-vertical"></i> handle, untick anyone who should not be on the list, then download it as PDF or Excel. Only ticked yatris go into the file.</div>
                </div>
                <span class="yl-count"><span class="n" id="ylOn">0</span> of <span id="ylAll">{{ count($list['rows']) }}</span> on the list</span>
            </div>

            <form method="post" action="{{ route('quick-yatri-list-save') }}" id="ylForm">
                @csrf
                <div class="yl-card">
                    <div class="yl-sheet">
                        <img class="yl-logo" src="{{ asset('assets2/id/logo.png') }}" alt="Konnect.US, Inc.">
                        <input class="yl-title" type="text" name="title" value="{{ old('title', $list['title']) }}" maxlength="{{ YatriList::TITLE_MAX }}" aria-label="List title" required>
                        <span class="yl-title-hint"><i class="fa fa-pen"></i> Click the title to change it &mdash; it prints at the top of the PDF and Excel.</span>
                    </div>

                    <div class="yl-tools">
                        <button type="button" class="yl-pill" data-all="1"><i class="fa fa-check-square"></i> Tick all</button>
                        <button type="button" class="yl-pill" data-all="0"><i class="fa fa-square"></i> Untick all</button>
                        <input type="search" class="yl-search" id="ylSearch" placeholder="Find a yatri or passport #" aria-label="Find a yatri">
                        <span class="sp">
                            @if(!$list['saved'])
                                Not saved yet &mdash; showing every application, oldest first.
                            @else
                                New applications join at the foot, ticked.
                            @endif
                        </span>
                    </div>

                    <div class="yl-wrap">
                    <table class="yl-table">
                        <thead>
                            <tr>
                                <th class="ctl">Move</th>
                                <th class="ctl"><input type="checkbox" class="yl-tick" id="ylAllTick" aria-label="Tick or untick everyone"></th>
                                <th>Yatri #</th>
                                <th>Yatri Name</th>
                                <th>Nationality</th>
                                <th>Passport #</th>
                            </tr>
                        </thead>
                        <tbody id="ylRows">
                            @foreach($list['rows'] as $row)
                                @php $y = $row['yatri']; @endphp
                                <tr class="yl-row {{ $row['on'] ? '' : 'off' }}" data-find="{{ strtolower($y->applicant_name . ' ' . $y->passport_no) }}">
                                    <td class="ctl">
                                        <input type="hidden" data-f="id" value="{{ $y->id }}">
                                        <span class="yl-ctl">
                                            <span class="yl-grip" title="Drag to move" aria-hidden="true"><i class="fa fa-grip-vertical"></i></span>
                                            <span class="yl-arrows">
                                                <button type="button" class="yl-arrow" data-act="up" title="Move up" aria-label="Move {{ $y->applicant_name }} up"><i class="fa fa-chevron-up"></i></button>
                                                <button type="button" class="yl-arrow" data-act="down" title="Move down" aria-label="Move {{ $y->applicant_name }} down"><i class="fa fa-chevron-down"></i></button>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="ctl yl-c"><input type="checkbox" class="yl-tick" data-f="on" value="1" {{ $row['on'] ? 'checked' : '' }} aria-label="Include {{ $y->applicant_name }} in the PDF and Excel"></td>
                                    <td class="yl-sn" data-sn></td>
                                    <td class="yl-nm">{{ $y->applicant_name ?: '—' }}@if($row['new'])<span class="yl-new" title="Applied since the list was last saved">NEW</span>@endif
                                        @if($y->father_name)<small>{{ $y->parentPrefix() }} {{ $y->father_name }}</small>@endif
                                    </td>
                                    <td class="yl-c">{!! $y->citizenship ? e(YatriList::nationality($y->citizenship)) : '<span class="yl-muted">—</span>' !!}</td>
                                    <td class="yl-pp">{!! $y->passport_no ? e($y->passport_no) : '<span class="yl-muted">—</span>' !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="yl-empty" id="ylEmpty" @if(count($list['rows'])) style="display:none" @endif>
                        No Quick Yatri applications yet. <a href="{{ route('quick-yatri-create') }}">Add one</a>.
                    </div>
                    </div>

                    <div class="yl-bar">
                        <button class="yl-btn primary" type="submit" name="then" value=""><i class="fa fa-save"></i> Save</button>
                        <button class="yl-btn pdf" type="submit" name="then" value="pdf" data-dl><i class="fa fa-file-pdf"></i> Download PDF</button>
                        <button class="yl-btn xls" type="submit" name="then" value="xlsx" data-dl><i class="fa fa-file-excel"></i> Download Excel</button>
                        <a class="yl-btn ghost" href="{{ route('quick-yatri-dashboard') }}"><i class="fa fa-arrow-left"></i> Quick Yatri</a>
                        <span class="yl-dirty" id="ylDirty"><i class="fa fa-circle" style="font-size:8px"></i> Unsaved changes &mdash; a download saves them first</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script type="text/javascript">
(function () {
    var body = document.getElementById('ylRows');
    var form = document.getElementById('ylForm');
    var allTick = document.getElementById('ylAllTick');
    var dirty = false;

    function rows() { return [].slice.call(body.querySelectorAll('.yl-row')); }
    function tick(row) { return row.querySelector('[data-f="on"]'); }
    function markDirty() { dirty = true; document.getElementById('ylDirty').classList.add('on'); }
    function flash(row) { row.classList.remove('moved'); void row.offsetWidth; row.classList.add('moved'); }

    // Yatri # counts the ticked rows only — the number each one will carry in
    // the file. Fields are re-named in screen order so the post arrives in it.
    function refresh() {
        var list = rows(), n = 0;
        list.forEach(function (row, i) {
            var on = tick(row).checked;
            row.classList.toggle('off', !on);
            row.querySelector('[data-sn]').textContent = on ? ++n : '—';
            row.querySelector('[data-act="up"]').disabled = i === 0;
            row.querySelector('[data-act="down"]').disabled = i === list.length - 1;
            row.querySelector('[data-f="id"]').name = 'rows[' + i + '][id]';
            tick(row).name = 'rows[' + i + '][on]';
        });
        document.getElementById('ylOn').textContent = n;
        allTick.checked = list.length > 0 && n === list.length;
        allTick.indeterminate = n > 0 && n < list.length;
        [].forEach.call(document.querySelectorAll('[data-dl]'), function (b) { b.disabled = n === 0; });
    }

    body.addEventListener('change', function (e) {
        if (e.target.matches('[data-f="on"]')) { refresh(); markDirty(); }
    });

    function setAll(on) {
        rows().forEach(function (row) { if (!row.hidden) tick(row).checked = on; });
        refresh(); markDirty();
    }
    allTick.addEventListener('change', function () { setAll(allTick.checked); });
    [].forEach.call(document.querySelectorAll('[data-all]'), function (b) {
        b.addEventListener('click', function () { setAll(b.getAttribute('data-all') === '1'); });
    });

    body.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-act]');
        if (!btn) return;
        var row = btn.closest('.yl-row');
        if (btn.getAttribute('data-act') === 'up' && row.previousElementSibling) {
            body.insertBefore(row, row.previousElementSibling);
        } else if (btn.getAttribute('data-act') === 'down' && row.nextElementSibling) {
            body.insertBefore(row.nextElementSibling, row);
        } else {
            return;
        }
        refresh(); markDirty(); flash(row);
        btn.focus();
    });

    // Drag by the grip. Pointer events, so it works the same with a mouse, a
    // pen or a finger; the row follows the pointer by slotting in above the
    // first row whose middle is below it.
    var drag = null;
    body.addEventListener('pointerdown', function (e) {
        var grip = e.target.closest('.yl-grip');
        if (!grip || e.button > 0) return;
        e.preventDefault();
        drag = grip.closest('.yl-row');
        drag.classList.add('dragging');
        document.body.classList.add('yl-dragging-on');
    });
    document.addEventListener('pointermove', function (e) {
        if (!drag) return;
        e.preventDefault();
        var y = e.clientY, before = null;
        var others = rows().filter(function (r) { return r !== drag && !r.hidden; });
        for (var i = 0; i < others.length; i++) {
            var box = others[i].getBoundingClientRect();
            if (y < box.top + box.height / 2) { before = others[i]; break; }
        }
        if (before !== drag.nextElementSibling) {
            if (before) body.insertBefore(drag, before);
            else body.appendChild(drag);
        }
        // Scroll the page when the pointer nears the top or bottom edge.
        if (y < 70) window.scrollBy(0, -14);
        else if (y > window.innerHeight - 90) window.scrollBy(0, 14);
    });
    function drop() {
        if (!drag) return;
        var row = drag;
        drag = null;
        row.classList.remove('dragging');
        document.body.classList.remove('yl-dragging-on');
        refresh(); markDirty(); flash(row);
    }
    document.addEventListener('pointerup', drop);
    document.addEventListener('pointercancel', drop);

    document.getElementById('ylSearch').addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        rows().forEach(function (row) { row.hidden = q !== '' && row.getAttribute('data-find').indexOf(q) === -1; });
    });

    form.querySelector('[name="title"]').addEventListener('input', markDirty);

    // A download saves too, so nothing is unsaved after any submit. The file
    // arrives as an attachment and the page stays put, so clear the flag here.
    form.addEventListener('submit', function () {
        dirty = false;
        document.getElementById('ylDirty').classList.remove('on');
    });
    window.addEventListener('beforeunload', function (e) {
        if (dirty) { e.preventDefault(); e.returnValue = ''; }
    });

    refresh();
})();
</script>
@endsection
