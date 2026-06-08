@extends('admin.layouts.app')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style type="text/css">
    .hf-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 26px rgba(28,37,65,.07);margin-bottom:24px;overflow:hidden}
    .hf-card .hd{padding:15px 22px;border-bottom:1px solid #f1f2f6;font-weight:700;color:#1c2541;display:flex;align-items:center;gap:8px}
    .hf-card .bd{padding:22px}
    #hotelMap{height:360px;border-radius:12px;border:1px solid #e2e2e2;z-index:1}
    .hf-thumb{position:relative;display:inline-block;margin:6px;border-radius:10px;overflow:hidden;border:1px solid #e2e2e2}
    .hf-thumb img{width:120px;height:90px;object-fit:cover;display:block}
    .hf-thumb a{position:absolute;top:4px;right:4px;background:#dc3545;color:#fff;width:24px;height:24px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:12px;text-decoration:none}
    .hf-drop{border:2px dashed #d8dbe2;border-radius:12px;padding:16px;text-align:center;color:#9aa0ac;cursor:pointer;transition:.15s}
    .hf-drop:hover{border-color:#f54e18;color:#f54e18}
    .hf-drop input{display:none}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Hotels</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/hotels') }}">Hotels</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="hf-card">
                            <div class="hd"><i class="fa fa-hotel text-info"></i> Hotel Details</div>
                            <div class="bd">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label class="form_label_color">Hotel Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ @$hotels->name }}" name="name" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form_label_color">Price / night ($)</label>
                                        <input type="number" class="form-control" value="{{ @$hotels->price }}" name="price">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Phone Number</label>
                                        <input type="text" class="form-control" value="{{ @$hotels->phone }}" name="phone">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Zip Code</label>
                                        <input type="text" class="form-control" value="{{ @$hotels->zip }}" name="zip">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="form_label_color">Address</label>
                                        <input type="text" class="form-control" id="hf-address" value="{{ @$hotels->address }}" name="address">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">City</label>
                                        <input type="text" class="form-control" id="hf-city" value="{{ @$hotels->city }}" name="city">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">State / Province</label>
                                        <input type="text" class="form-control" id="hf-state" value="{{ @$hotels->state }}" name="state">
                                    </div>
                                    <div class="col-md-12 form-group mb-0">
                                        <label class="form_label_color">Description <span class="text-muted">(amenities, what guests can expect…)</span></label>
                                        <textarea class="form-control" name="description" rows="4">{{ @$hotels->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hf-card">
                            <div class="hd"><i class="fa fa-location-dot text-danger"></i> Geo Location</div>
                            <div class="bd">
                                <div class="row align-items-end">
                                    <div class="col-md-4 form-group">
                                        <label class="form_label_color">Latitude</label>
                                        <input type="text" class="form-control" id="hf-lat" name="latitude" value="{{ @$hotels->latitude }}" placeholder="33.6844">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form_label_color">Longitude</label>
                                        <input type="text" class="form-control" id="hf-lng" name="longitude" value="{{ @$hotels->longitude }}" placeholder="73.0479">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <button type="button" class="btn btn-outline-primary btn-block" id="hf-locate"><i class="fa fa-search-location"></i> Locate from address</button>
                                    </div>
                                </div>
                                <p class="text-muted" style="font-size:13px;margin:0 0 10px">Click on the map to drop the pin, drag it to fine-tune, or use <b>Locate from address</b> to auto-find it.</p>
                                <div id="hotelMap"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="hf-card">
                            <div class="hd"><i class="fa fa-star text-warning"></i> Feature Image</div>
                            <div class="bd">
                                <label class="hf-drop">
                                    <i class="fa fa-cloud-upload-alt fa-2x d-block mb-2"></i>
                                    <span>{{ !empty(@$hotels->image) ? 'Click to replace the feature image' : 'Click to upload the feature image' }}</span>
                                    <input type="file" name="image" accept="image/*" @if(empty(@$hotels->image)) required @endif>
                                </label>
                                @if(!empty(@$hotels->image))
                                <div class="mt-3"><img src="{{ asset('hotels/'.$hotels->image) }}" style="width:100%;max-height:220px;object-fit:cover;border-radius:12px"></div>
                                @endif
                            </div>
                        </div>

                        <div class="hf-card">
                            <div class="hd"><i class="fa fa-images text-success"></i> Hotel Gallery <span class="text-muted" style="font-weight:400;font-size:13px">(inside photos)</span></div>
                            <div class="bd">
                                <label class="hf-drop">
                                    <i class="fa fa-plus-circle fa-2x d-block mb-2"></i>
                                    <span id="hf-gallery-text">Click to add photos (you can select several)</span>
                                    <input type="file" name="images[]" accept="image/*" multiple>
                                </label>
                                @if(!empty(@$hotels) && $hotels->images && $hotels->images->count())
                                <div class="mt-3">
                                    @foreach($hotels->images as $img)
                                    <div class="hf-thumb">
                                        <img src="{{ asset('hotels/'.$img->image) }}" alt="">
                                        <a href="{{ url('admin/hotels/image-delete', $img->id) }}" class="show_confirm" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ url('admin/hotels') }}" class="btn btn-secondary">Cancel</a>
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
    if (typeof L === 'undefined' || !document.getElementById('hotelMap')) return;
    var latI = document.getElementById('hf-lat'), lngI = document.getElementById('hf-lng');
    var startLat = parseFloat(latI.value) || 30.3753, startLng = parseFloat(lngI.value) || 69.3451;
    var hasPin = latI.value !== '' && lngI.value !== '';

    var map = L.map('hotelMap').setView([startLat, startLng], hasPin ? 14 : 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '© OpenStreetMap'
    }).addTo(map);
    setTimeout(function () { map.invalidateSize(); }, 200);

    var marker = null;
    function setPin(lat, lng, zoom) {
        if (marker) marker.setLatLng([lat, lng]);
        else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                var p = e.target.getLatLng();
                latI.value = p.lat.toFixed(7); lngI.value = p.lng.toFixed(7);
            });
        }
        latI.value = (+lat).toFixed(7); lngI.value = (+lng).toFixed(7);
        if (zoom) map.setView([lat, lng], zoom);
    }
    if (hasPin) setPin(startLat, startLng);

    map.on('click', function (e) { setPin(e.latlng.lat, e.latlng.lng); });

    function syncFromInputs() {
        var la = parseFloat(latI.value), ln = parseFloat(lngI.value);
        if (!isNaN(la) && !isNaN(ln)) setPin(la, ln, 14);
    }
    latI.addEventListener('change', syncFromInputs);
    lngI.addEventListener('change', syncFromInputs);

    document.getElementById('hf-locate').addEventListener('click', function () {
        var parts = [
            (document.querySelector('input[name="name"]') || {}).value,
            (document.getElementById('hf-address') || {}).value,
            (document.getElementById('hf-city') || {}).value,
            (document.getElementById('hf-state') || {}).value, 'Pakistan'
        ].filter(Boolean);
        var q = parts.join(', ');
        var btn = this; btn.disabled = true; btn.innerHTML = 'Searching…';
        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(q))
            .then(function (r) { return r.json(); })
            .then(function (d) {
                if (d && d.length) setPin(parseFloat(d[0].lat), parseFloat(d[0].lon), 15);
                else alert('Could not find that address automatically. Click on the map to set the pin manually.');
            })
            .catch(function () { alert('Lookup failed. Click on the map to set the pin manually.'); })
            .finally(function () { btn.disabled = false; btn.innerHTML = '<i class="fa fa-search-location"></i> Locate from address'; });
    });

    var gi = document.querySelector('input[name="images[]"]');
    if (gi) gi.addEventListener('change', function () {
        var n = this.files ? this.files.length : 0;
        document.getElementById('hf-gallery-text').textContent = n ? (n + ' photo(s) selected') : 'Click to add photos (you can select several)';
    });
})();
</script>
@endsection
