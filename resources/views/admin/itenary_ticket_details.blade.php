@extends('admin.layouts.app')
@section('content')
<style>
    .tkt-head { display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
    .tkt-search { position:relative; min-width:260px; flex:1 1 260px; max-width:420px; }
    .tkt-search .fa { position:absolute; top:50%; left:14px; transform:translateY(-50%); color:#98a2b5; }
    .tkt-search input { width:100%; border:1px solid #e2e2e2; border-radius:24px; padding:9px 16px 9px 38px; outline:none; }
    .tkt-search input:focus { border-color:#f54e18; box-shadow:0 0 0 3px rgba(245,78,24,.12); }
    .tkt-card { background:#fff; border:1px solid #eef0f4; border-radius:14px; box-shadow:0 6px 22px rgba(28,37,65,.06); overflow:hidden; margin-bottom:18px; }
    .tkt-card-head { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:15px 20px; background:linear-gradient(90deg,#1f2a44,#2d3a5e); color:#fff; flex-wrap:wrap; }
    .tkt-pax { display:flex; align-items:center; gap:12px; }
    .tkt-avatar { width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:18px; flex:0 0 42px; }
    .tkt-name { font-size:16px; font-weight:700; line-height:1.2; }
    .tkt-type { font-size:12px; color:#c7cede; }
    .tkt-badge { background:#e8721e; color:#fff; font-size:12px; font-weight:600; padding:6px 14px; border-radius:20px; white-space:nowrap; }
    .tkt-card-body { display:flex; flex-wrap:wrap; padding:18px 20px; gap:16px 28px; }
    .tkt-col { flex:1 1 280px; min-width:0; }
    .tkt-col-trip { display:flex; flex-direction:column; justify-content:center; }
    .tkt-row { display:flex; align-items:center; gap:10px; color:#3a4458; font-size:14px; padding:5px 0; word-break:break-word; }
    .tkt-row i { color:#e8721e; width:16px; text-align:center; flex:0 0 16px; }
    .tkt-route { display:flex; align-items:center; gap:10px; font-weight:600; color:#1f2a44; flex-wrap:wrap; }
    .tkt-route i { color:#e8721e; }
    .tkt-route-line { flex:1 1 28px; height:2px; min-width:28px; background:repeating-linear-gradient(90deg,#cfd6e4 0 6px,transparent 6px 12px); }
    .tkt-dates { margin-top:12px; color:#5b6478; font-size:13.5px; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .tkt-dates i { color:#e8721e; }
    .tkt-dates-label { font-weight:600; color:#3a4458; }
    .tkt-date { background:#eef1f6; border-radius:8px; padding:3px 10px; font-weight:600; color:#2c3446; }
    .tkt-arrow { color:#98a2b5; }
    .tkt-empty { background:#fff; border:1px dashed #d8dde8; border-radius:14px; padding:40px; text-align:center; color:#98a2b5; }
    @media (max-width:767px){ .tkt-card-body{ flex-direction:column; } }
</style>
<!--Main container start -->
<main class="ttr-wrapper">
    <div class="container-fluid">

        <div class="db-breadcrumb tkt-head mb-4">
            <h4 class="breadcrumb-title mb-0">Ticket Details</h4>
            <div class="tkt-search">
                <span class="fa fa-search"></span>
                <input type="text" id="tktSearch" placeholder="Search passenger, email, route…">
            </div>
        </div>

        <div id="tktList">
            @foreach ($itenaryadults as $adult)
                @if($adult)
                    @foreach($itenaries as $itenary)
                        @include('admin._ticket_passenger', [
                            'name' => $adult->firstnamea.' '.$adult->lastnamea,
                            'type' => 'Adult',
                            'dob'  => $adult->doba,
                            'itenary' => $itenary,
                        ])
                    @endforeach
                @endif
            @endforeach

            @foreach ($itenarychilds as $child)
                @if($child)
                    @foreach($itenaries as $itenary)
                        @include('admin._ticket_passenger', [
                            'name' => $child->firstnamec.' '.$child->lastnamec,
                            'type' => 'Child',
                            'dob'  => $child->dobc,
                            'itenary' => $itenary,
                        ])
                    @endforeach
                @endif
            @endforeach

            @foreach ($itenaryinfants as $infant)
                @if($infant)
                    @foreach($itenaries as $itenary)
                        @include('admin._ticket_passenger', [
                            'name' => $infant->firstnamei.' '.$infant->lastnamei,
                            'type' => 'Infant',
                            'dob'  => $infant->dobi,
                            'itenary' => $itenary,
                        ])
                    @endforeach
                @endif
            @endforeach
        </div>

        <div class="tkt-empty" id="tktNoResults" style="display:none;">No passengers match your search.</div>

    </div>
    <div class="ttr-overlay"></div>
</main>
@endsection

@section('js')
<script>
    (function () {
        var input = document.getElementById('tktSearch');
        if (!input) return;
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            var cards = document.querySelectorAll('#tktList .tkt-card');
            var shown = 0;
            cards.forEach(function (card) {
                var match = card.textContent.toLowerCase().indexOf(q) !== -1;
                card.style.display = match ? '' : 'none';
                if (match) shown++;
            });
            document.getElementById('tktNoResults').style.display = (shown === 0) ? 'block' : 'none';
        });
    })();
</script>
@endsection
