@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .ab-hero{background:#fff;border:1px solid #eee;border-radius:14px;box-shadow:0 4px 14px rgba(0,0,0,.07);padding:18px;margin-bottom:16px}
    .ab-hero h5{margin:0 0 4px;font-weight:700;color:#222;font-size:16px}
    .ab-hero p{margin:0;color:#777;font-size:13px}
    .ab-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px}
    .ab-actions .btn{font-weight:600}
    .ab-stats{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
    .ab-stat{background:#fff;border:1px solid #eee;border-radius:12px;padding:10px 18px;min-width:110px;text-align:center}
    .ab-stat b{display:block;font-size:22px;font-weight:800;color:#f54e18;line-height:1.1}
    .ab-stat span{font-size:11px;color:#888;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
    .ab-status{margin:0 0 14px;font-size:13.5px;padding:10px 14px;border-radius:10px;background:#f6f7f9;color:#555}
    .ab-status.err{background:#fdecea;color:#b42318}
    .ab-status.ok{background:#eaf7ee;color:#1f7a37}
    .ab-filters{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:14px}
    .ab-filters label{margin:0;font-size:13px;color:#555;font-weight:600;cursor:pointer;user-select:none}
    .ab-search{position:relative;flex:1;min-width:200px;max-width:360px}
    .ab-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .ab-search input{width:100%;padding:10px 14px 10px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none}
    .ab-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .ab-card{background:#fff;border:1px solid #eee;border-radius:14px;box-shadow:0 4px 14px rgba(0,0,0,.07);overflow:hidden;height:100%;display:flex;flex-direction:column}
    .ab-card.is-visited{border-left:4px solid #2fbf4f}
    .ab-photo{height:150px;background:#f3f4f6;position:relative;overflow:hidden}
    .ab-photo img{width:100%;height:100%;object-fit:cover;display:block}
    .ab-dist{position:absolute;top:10px;left:10px;background:#f54e18;color:#fff;font-size:11px;font-weight:700;padding:3px 11px;border-radius:20px}
    .ab-flag{position:absolute;top:10px;right:10px;font-size:10.5px;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(0,0,0,.6);color:#fff}
    .ab-flag.v{background:#2fbf4f}
    .ab-body{padding:14px 16px;flex:1}
    .ab-body h5{margin:0 0 8px;font-size:15px;font-weight:700;color:#222;line-height:1.3}
    .ab-meta{list-style:none;padding:0;margin:0}
    .ab-meta li{display:flex;gap:8px;font-size:12.5px;color:#555;padding:3px 0;word-break:break-word}
    .ab-meta li i{color:#f54e18;width:14px;text-align:center;margin-top:2px;flex-shrink:0}
    .ab-btns{display:flex;gap:6px;padding:10px 12px;border-top:1px solid #f3f3f3;flex-wrap:wrap}
    .ab-btns .btn{flex:1;min-width:78px;font-size:12.5px;padding:7px 6px}
    .ab-btns form{margin:0;flex:1;min-width:78px}
    .ab-btns form .btn{width:100%}
    .ab-empty{padding:40px;text-align:center;color:#999}
    @media (max-width:575px){ .ab-actions .btn{flex:1 0 100%} }
</style>

<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Address Book</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Address Book</li>
            </ul>
        </div>

        <div class="main-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="ab-stats">
                <div class="ab-stat"><b>{{ $total }}</b><span>Gurdwaras</span></div>
                <div class="ab-stat"><b>{{ $visited }}</b><span>Visited</span></div>
                <div class="ab-stat"><b>{{ $total - $visited }}</b><span>To visit</span></div>
            </div>

            <div class="ab-hero">
                <h5><i class="fa fa-map-marker-alt" style="color:#f54e18"></i> Gurdwaras near you</h5>
                <p>Allow location and the list below reorders by how far each gurdwara is from where you are standing.</p>
                <div class="ab-actions">
                    <button type="button" class="btn btn-primary" id="abLocate"><i class="fa fa-crosshairs"></i> Use my location</button>
                    <a class="btn btn-outline-secondary" id="abGoogle" target="_blank" rel="noopener" href="https://www.google.com/maps/search/gurdwara+near+me">
                        <i class="fa fa-search"></i> Find more on Google Maps
                    </a>
                    <a class="btn btn-warning" href="{{ route('create-gurdwara') }}"><i class="fa fa-plus"></i> Add Gurdwara</a>
                </div>
            </div>

            <p class="ab-status" id="abStatus">Tap <b>Use my location</b> to sort by distance, or search below.</p>

            <div class="ab-filters">
                <div class="ab-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="abSearch" placeholder="Search by name, city or state…">
                </div>
                <label><input type="checkbox" id="abHideVisited"> Hide visited</label>
            </div>

            <div class="row" id="abList"></div>
            <div class="ab-empty" id="abEmpty" style="display:none">No gurdwaras match.</div>
        </div>
    </div>
</main>

<script>
(function () {
    // Rows the server could place on a map, plus those it couldn't (shown last,
    // never silently dropped — they still need visiting and fixing).
    var LOCATED   = @json($located);
    var UNLOCATED = @json($unlocated);
    var VISIT_URL = "{{ url('admin/address-book') }}";
    var CSRF      = "{{ csrf_token() }}";
    var FALLBACK  = "{{ asset('assets/images2/News-04.png') }}";
    var here = null;

    function miles(a, b, c, d) {
        var R = 3958.8, r = Math.PI / 180;
        var dLat = (c - a) * r, dLng = (d - b) * r;
        var h = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(a * r) * Math.cos(c * r) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
        return 2 * R * Math.asin(Math.sqrt(h));
    }
    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    function navUrl(g) {
        // Prefer the postal address; fall back to coordinates when it's thin.
        var q = g.address ? (g.name + ', ' + g.address) : (g.lat + ',' + g.lng);
        return 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(q);
    }

    function card(g) {
        var img = g.image ? "{{ asset('gurdwara_images') }}/" + encodeURIComponent(g.image) : FALLBACK;
        var dist = (g.dist == null) ? '' :
            '<span class="ab-dist">' + (g.dist < 1 ? '<1' : Math.round(g.dist)) + ' mi</span>';
        var flag = g.visited
            ? '<span class="ab-flag v">Visited ' + esc(g.visited) + '</span>'
            : '<span class="ab-flag">Not visited</span>';
        return '' +
        '<div class="col-xl-3 col-lg-4 col-md-6 mb-4 ab-item" data-search="' + esc((g.name + ' ' + g.address).toLowerCase()) + '" data-visited="' + (g.visited ? 1 : 0) + '">' +
          '<div class="ab-card' + (g.visited ? ' is-visited' : '') + '">' +
            '<div class="ab-photo">' +
              '<img src="' + img + '" alt="' + esc(g.name) + '" onerror="this.src=\'' + FALLBACK + '\'">' +
              dist + flag +
            '</div>' +
            '<div class="ab-body">' +
              '<h5>' + esc(g.name) + '</h5>' +
              '<ul class="ab-meta">' +
                '<li><i class="fa fa-map-marker-alt"></i><span>' + (esc(g.address) || '<em>No address yet</em>') + '</span></li>' +
                (g.phone ? '<li><i class="fa fa-phone"></i><span>' + esc(g.phone) + '</span></li>' : '') +
              '</ul>' +
            '</div>' +
            '<div class="ab-btns">' +
              '<a class="btn btn-primary" target="_blank" rel="noopener" href="' + navUrl(g) + '"><i class="fa fa-diamond-turn-right"></i> Navigate</a>' +
              '<a class="btn btn-warning" href="' + g.edit_url + '"><i class="fa fa-edit"></i> Update</a>' +
              '<form method="POST" action="' + VISIT_URL + '/' + g.id + '/visit">' +
                '<input type="hidden" name="_token" value="' + CSRF + '">' +
                (g.visited ? '<input type="hidden" name="action" value="clear">' : '') +
                '<button class="btn ' + (g.visited ? 'btn-outline-secondary' : 'btn-success') + '">' +
                  '<i class="fa fa-check"></i> ' + (g.visited ? 'Undo' : 'Visited') +
                '</button>' +
              '</form>' +
            '</div>' +
          '</div>' +
        '</div>';
    }

    function render() {
        var rows = LOCATED.slice();
        if (here) {
            rows.forEach(function (g) { g.dist = miles(here.lat, here.lng, g.lat, g.lng); });
            rows.sort(function (a, b) { return a.dist - b.dist; });
        } else {
            rows.forEach(function (g) { g.dist = null; });
            rows.sort(function (a, b) { return a.name.localeCompare(b.name); });
        }
        document.getElementById('abList').innerHTML = rows.concat(UNLOCATED).map(card).join('');
        filter();
    }

    function filter() {
        var q = (document.getElementById('abSearch').value || '').toLowerCase().trim();
        var hide = document.getElementById('abHideVisited').checked;
        var shown = 0;
        document.querySelectorAll('.ab-item').forEach(function (el) {
            var ok = (!q || el.dataset.search.indexOf(q) !== -1) && !(hide && el.dataset.visited === '1');
            el.style.display = ok ? '' : 'none';
            if (ok) shown++;
        });
        document.getElementById('abEmpty').style.display = shown ? 'none' : '';
    }

    function status(msg, cls) {
        var el = document.getElementById('abStatus');
        el.innerHTML = msg;
        el.className = 'ab-status' + (cls ? ' ' + cls : '');
    }

    document.getElementById('abLocate').addEventListener('click', function () {
        if (!navigator.geolocation) {
            return status('This browser can\'t share a location. Use the search box instead.', 'err');
        }
        status('Getting your location…');
        navigator.geolocation.getCurrentPosition(function (pos) {
            here = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            // Point the Google button at where he actually is.
            document.getElementById('abGoogle').href =
                'https://www.google.com/maps/search/gurdwara/@' + here.lat + ',' + here.lng + ',13z';
            render();
            var n = LOCATED.length ? LOCATED[0] : null;
            status('Sorted by distance from you. Nearest: <b>' + esc(n ? n.name : '—') +
                   '</b>' + (n && n.dist != null ? ' (' + (n.dist < 1 ? '<1' : Math.round(n.dist)) + ' mi)' : ''), 'ok');
        }, function (err) {
            status('Couldn\'t get your location (' + esc(err.message) + '). Showing A–Z — search by city instead.', 'err');
        }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 });
    });

    document.getElementById('abSearch').addEventListener('input', filter);
    document.getElementById('abHideVisited').addEventListener('change', filter);
    render();
})();
</script>
@endsection
