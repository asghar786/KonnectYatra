@extends('admin.layouts.app')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style type="text/css">
    .lf-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 26px rgba(28,37,65,.07);margin-bottom:24px;overflow:hidden}
    .lf-card .hd{padding:15px 22px;border-bottom:1px solid #f1f2f6;font-weight:700;color:#1c2541;display:flex;align-items:center;gap:8px}
    .lf-card .bd{padding:22px}
    #locMap{height:340px;border-radius:12px;border:1px solid #e2e2e2;z-index:1}
    .lf-thumb{position:relative;display:inline-block;margin:6px;border-radius:10px;overflow:hidden;border:1px solid #e2e2e2}
    .lf-thumb img{width:120px;height:90px;object-fit:cover;display:block}
    .lf-thumb .acts{position:absolute;top:4px;right:4px;display:flex;gap:4px}
    .lf-thumb .acts a{width:24px;height:24px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;text-decoration:none;color:#fff}
    .lf-thumb .acts .del{background:#dc3545}.lf-thumb .acts .feat{background:#f5a623}
    .lf-thumb.is-feature{outline:3px solid #f5a623}
    .lf-thumb .badge-feat{position:absolute;bottom:4px;left:4px;background:#f5a623;color:#fff;font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px}
    .lf-drop{border:2px dashed #d8dbe2;border-radius:12px;padding:16px;text-align:center;color:#9aa0ac;cursor:pointer;transition:.15s}
    .lf-drop:hover{border-color:#f54e18;color:#f54e18}
    .lf-drop input{display:none}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Locations</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/locations') }}">Locations</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="lf-card">
                            <div class="hd"><i class="fa fa-map-pin text-info"></i> Location Details</div>
                            <div class="bd">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="form_label_color">Location Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ @$locations->name }}" name="name" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">City</label>
                                        <input type="text" class="form-control" id="lf-city" value="{{ @$locations->city }}" name="city">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">State / Province</label>
                                        <input type="text" class="form-control" id="lf-state" value="{{ @$locations->state }}" name="state">
                                    </div>
                                    <div class="col-md-12 form-group mb-0">
                                        <label class="form_label_color">Description</label>
                                        <textarea class="form-control" name="description" rows="4">{{ @$locations->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lf-card">
                            <div class="hd"><i class="fa fa-location-dot text-danger"></i> Geo Location</div>
                            <div class="bd">
                                <div class="row align-items-end">
                                    <div class="col-md-4 form-group">
                                        <label class="form_label_color">Latitude</label>
                                        <input type="text" class="form-control" id="lf-lat" name="latitude" value="{{ @$locations->latitude }}" placeholder="31.5497">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form_label_color">Longitude</label>
                                        <input type="text" class="form-control" id="lf-lng" name="longitude" value="{{ @$locations->longitude }}" placeholder="74.3436">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <button type="button" class="btn btn-outline-primary btn-block" id="lf-locate"><i class="fa fa-search-location"></i> Locate from name</button>
                                    </div>
                                </div>
                                <p class="text-muted" style="font-size:13px;margin:0 0 10px">Click the map to drop the pin, drag to fine-tune, or use <b>Locate from name</b>.</p>
                                <div id="locMap"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="lf-card">
                            <div class="hd"><i class="fa fa-images text-success"></i> Photos <span class="text-muted" style="font-weight:400;font-size:13px">(add several; tag one as feature)</span></div>
                            <div class="bd">
                                <label class="lf-drop">
                                    <i class="fa fa-cloud-upload-alt fa-2x d-block mb-2"></i>
                                    <span id="lf-gallery-text">Click to add photos (you can select several)</span>
                                    <input type="file" name="images[]" accept="image/*" multiple @if(empty(@$locations->image) && (empty(@$locations) || !$locations->images || !$locations->images->count())) required @endif>
                                </label>

                                @if(!empty(@$locations) && $locations->images && $locations->images->count())
                                <p class="text-muted mt-3 mb-1" style="font-size:13px">Click the <i class="fa fa-star" style="color:#f5a623"></i> to set a photo as the feature image.</p>
                                <div>
                                    @foreach($locations->images as $img)
                                    <div class="lf-thumb {{ $img->image === $locations->image ? 'is-feature' : '' }}">
                                        <img src="{{ asset('locations/'.$img->image) }}" alt="">
                                        <div class="acts">
                                            <a class="feat" href="{{ url('admin/locations/set-feature', $img->id) }}" title="Set as feature"><i class="fa fa-star"></i></a>
                                            <a class="del show_confirm" href="{{ url('admin/locations/image-delete', $img->id) }}" title="Remove"><i class="fa fa-times"></i></a>
                                        </div>
                                        @if($img->image === $locations->image)<span class="badge-feat">Feature</span>@endif
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <div class="mt-3">
                                    <label class="form_label_color" style="font-size:13px">Or upload a dedicated feature image</label>
                                    <input type="file" name="image" accept="image/*" class="form-control">
                                    @if(!empty(@$locations->image))
                                    <div class="mt-2"><span class="text-muted" style="font-size:12px">Current feature:</span><br><img src="{{ asset('locations/'.$locations->image) }}" style="width:100%;max-height:180px;object-fit:cover;border-radius:10px;margin-top:6px"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ url('admin/locations') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">{{ @$btn_text }}</button>
                </div>
            </form>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    if (typeof L === 'undefined' || !document.getElementById('locMap')) return;
    var latI = document.getElementById('lf-lat'), lngI = document.getElementById('lf-lng');
    var startLat = parseFloat(latI.value) || 30.3753, startLng = parseFloat(lngI.value) || 69.3451;
    var hasPin = latI.value !== '' && lngI.value !== '';
    var map = L.map('locMap').setView([startLat, startLng], hasPin ? 14 : 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
    setTimeout(function () { map.invalidateSize(); }, 200);
    var marker = null;
    function setPin(lat, lng, zoom) {
        if (marker) marker.setLatLng([lat, lng]);
        else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) { var p = e.target.getLatLng(); latI.value = p.lat.toFixed(7); lngI.value = p.lng.toFixed(7); });
        }
        latI.value = (+lat).toFixed(7); lngI.value = (+lng).toFixed(7);
        if (zoom) map.setView([lat, lng], zoom);
    }
    if (hasPin) setPin(startLat, startLng);
    map.on('click', function (e) { setPin(e.latlng.lat, e.latlng.lng); });
    function sync() { var la = parseFloat(latI.value), ln = parseFloat(lngI.value); if (!isNaN(la) && !isNaN(ln)) setPin(la, ln, 14); }
    latI.addEventListener('change', sync); lngI.addEventListener('change', sync);
    document.getElementById('lf-locate').addEventListener('click', function () {
        var parts = [
            (document.querySelector('input[name="name"]') || {}).value,
            (document.getElementById('lf-city') || {}).value,
            (document.getElementById('lf-state') || {}).value, 'Pakistan'
        ].filter(Boolean);
        var btn = this; btn.disabled = true; btn.innerHTML = 'Searching…';
        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(parts.join(', ')))
            .then(function (r) { return r.json(); })
            .then(function (d) { if (d && d.length) setPin(parseFloat(d[0].lat), parseFloat(d[0].lon), 15); else alert('Could not find it automatically. Click on the map to set the pin.'); })
            .catch(function () { alert('Lookup failed. Click on the map to set the pin.'); })
            .finally(function () { btn.disabled = false; btn.innerHTML = '<i class="fa fa-search-location"></i> Locate from name'; });
    });
    var gi = document.querySelector('input[name="images[]"]');
    if (gi) gi.addEventListener('change', function () {
        var n = this.files ? this.files.length : 0;
        document.getElementById('lf-gallery-text').textContent = n ? (n + ' photo(s) selected') : 'Click to add photos (you can select several)';
    });
})();
</script>
@endsection
