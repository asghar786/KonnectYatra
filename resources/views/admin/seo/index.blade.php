@extends('admin.layouts.app')
@section('content')
<style>
    /* typography.css sets `table thead th { color: white }` for every admin table,
       which is invisible on this card's white background. */
    .biz-hours thead th{color:#3b4661;background:#f4f6f9;font-weight:600;padding:10px}
    .biz-hours td{padding:8px 10px;vertical-align:middle}
    .biz-hours input[type=checkbox]{width:18px;height:18px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">SEO Settings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>SEO Settings</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fas fa-magnifying-glass-chart text-success"></i> Website SEO</h5>
                            <p class="text-muted">These details are used across the whole website — they fill the page title, meta description, keywords and social-share (Open Graph) tags that Google and social networks read.</p>

                            <form method="POST" action="{{ url('admin/seo') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color">Meta Title</label>
                                    <input type="text" name="seo_title" class="form-control" maxlength="255" value="{{ $seo_title }}" placeholder="Konnect Yatra — Holy Yatra Tours to Pakistan">
                                    <small class="text-muted">Best kept under ~60 characters. Shown as the browser tab title and the headline in Google results.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Meta Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3" maxlength="500" placeholder="Konnect Yatra arranges holy yatra tours to Nankana Sahib, Panja Sahib and Kartarpur Sahib...">{{ $seo_description }}</textarea>
                                    <small class="text-muted">~150–160 characters works best. This is the grey summary text in search results.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Meta Keywords</label>
                                    <input type="text" name="seo_keywords" class="form-control" maxlength="500" value="{{ $seo_keywords }}" placeholder="sikh yatra, nankana sahib, kartarpur, gurdwara tours">
                                    <small class="text-muted">Comma-separated. Optional and low impact, but kept for completeness.</small>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form_label_color">Social Share Image (Open Graph)</label>
                                    <input type="file" name="og_image" accept="image/*" class="form-control">
                                    <small class="text-muted">Shown when your link is shared on Facebook/WhatsApp/LinkedIn. Recommended 1200×630px.</small>
                                    @if(!empty($seo_og_image))
                                    <div class="mt-2"><img src="{{ asset($seo_og_image) }}" style="width:260px;max-height:140px;object-fit:cover;border-radius:8px"></div>
                                    @endif
                                </div>
                                <button class="btn btn-primary mt-3">Save SEO Settings</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="border-radius:14px;background:#f8f9fb">
                        <div class="card-body">
                            <h6 style="font-weight:700">Good to know</h6>
                            <ul style="font-size:13px;padding-left:18px;line-height:1.8">
                                <li>These act as the <strong>site-wide defaults</strong>. Individual blog posts already use their own title/description.</li>
                                <li>For <strong>Google Search Console verification</strong> and <strong>Microsoft Clarity</strong>, use <a href="{{ route('integrations') }}">Settings → Integrations</a>.</li>
                                <li>Google Analytics (GA4) is also under Integrations.</li>
                                <li>After saving, share a page link in WhatsApp/Facebook to preview the title, description and image.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================ Business details ============================ --}}
            <div class="row mt-4" id="business">
                <div class="col-lg-8">
                    <div class="card" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fas fa-location-dot text-danger"></i> Business Details</h5>
                            <p class="text-muted">
                                Used in two places at once: the address and phone printed on the site
                                (header strip, footer, Contact page, homepage), and the
                                <strong>Schema.org data</strong> Google reads to match this website
                                to your Google Business Profile. Because it is one source, those can
                                no longer disagree with each other.
                            </p>

                            <form method="POST" action="{{ url('admin/seo/business') }}">
                                @csrf

                                <h6 class="mt-4" style="font-weight:700;font-size:14px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280">Address</h6>
                                <div class="form-group">
                                    <label class="form_label_color">Street &amp; suite</label>
                                    <input type="text" name="street" class="form-control" maxlength="255"
                                           value="{{ old('street', $biz['street']) }}"
                                           placeholder="148-36 Guy R Brewers Blvd. Suit #202A">
                                    <small class="text-muted">Type it exactly as it appears on your Google Business Profile — punctuation included.</small>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group">
                                        <label class="form_label_color">City</label>
                                        <input type="text" name="locality" class="form-control" maxlength="120"
                                               value="{{ old('locality', $biz['locality']) }}" placeholder="Jamaica">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label class="form_label_color">State</label>
                                        <input type="text" name="region" class="form-control" maxlength="120"
                                               value="{{ old('region', $biz['region']) }}" placeholder="NY">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form_label_color">ZIP</label>
                                        <input type="text" name="postal" class="form-control" maxlength="20"
                                               value="{{ old('postal', $biz['postal']) }}" placeholder="11434">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form_label_color">Country</label>
                                        <input type="text" name="country" class="form-control" maxlength="2"
                                               value="{{ old('country', $biz['country']) }}" placeholder="US">
                                        <small class="text-muted">2 letters</small>
                                    </div>
                                </div>
                                <div class="alert alert-light border" style="font-size:13px">
                                    Currently shown on the site as:
                                    <strong id="addrPreview">{{ $biz_address_line }}</strong>
                                </div>

                                <h6 class="mt-4" style="font-weight:700;font-size:14px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280">Contact</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Phone</label>
                                        <input type="text" name="telephone" class="form-control" maxlength="60"
                                               value="{{ old('telephone', $biz_phone) }}" placeholder="+1-718-908-9464">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Email</label>
                                        <input type="email" name="email" class="form-control" maxlength="120"
                                               value="{{ old('email', $biz_email) }}" placeholder="rm@konnectyatra.org">
                                    </div>
                                </div>

                                <h6 class="mt-4" style="font-weight:700;font-size:14px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280">Map position</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Latitude</label>
                                        <input type="text" name="lat" class="form-control"
                                               value="{{ old('lat', $biz_geo['lat'] ?? '') }}" placeholder="e.g. 40.6712">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Longitude</label>
                                        <input type="text" name="lng" class="form-control"
                                               value="{{ old('lng', $biz_geo['lng'] ?? '') }}" placeholder="e.g. -73.7896">
                                    </div>
                                </div>
                                <div class="alert {{ $biz_geo ? 'alert-success' : 'alert-warning' }}" style="font-size:13px">
                                    @if($biz_geo)
                                        <i class="fas fa-check-circle"></i> Set — your exact position is published to Google.
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $biz_geo['lat'] }},{{ $biz_geo['lng'] }}" target="_blank" rel="noopener">Check the pin →</a>
                                    @else
                                        <i class="fas fa-triangle-exclamation"></i>
                                        <strong>Not set yet.</strong> Nothing is published until both boxes are filled —
                                        that is deliberate, because a guessed position puts your business on the wrong
                                        part of the map, which is worse than none at all.
                                    @endif
                                    <div class="mt-2">
                                        <strong>How to get them:</strong> open Google Maps, right-click your office,
                                        and click the numbers at the top of the menu — that copies
                                        <code>40.6712, -73.7896</code>. Paste the first number in Latitude and
                                        the second in Longitude.
                                    </div>
                                </div>

                                <h6 class="mt-4" style="font-weight:700;font-size:14px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280">Opening hours</h6>
                                <p class="text-muted" style="font-size:13px">
                                    Leave everything untouched to publish no hours at all. Google will only
                                    show an “Open now” badge once these are filled — so wrong hours are worse
                                    than none.
                                </p>
                                <div class="table-responsive">
                                    {{-- The admin theme sets `table thead th { color: white }` globally,
                                         which renders white-on-white here. Scoped override, so other
                                         admin tables (dark header bars) keep their styling. --}}
                                    <table class="table table-sm biz-hours" style="font-size:14px">
                                        <thead>
                                            <tr>
                                                <th style="width:130px">Day</th>
                                                <th style="width:150px">Opens</th>
                                                <th style="width:150px">Closes</th>
                                                <th>Closed all day</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($biz_hours as $row)
                                            <tr>
                                                <td style="vertical-align:middle"><strong>{{ $row['day'] }}</strong></td>
                                                <td><input type="time" class="form-control form-control-sm"
                                                           name="hours[{{ $row['day'] }}][open]"
                                                           value="{{ $biz_hours_set ? $row['open'] : '' }}"></td>
                                                <td><input type="time" class="form-control form-control-sm"
                                                           name="hours[{{ $row['day'] }}][close]"
                                                           value="{{ $biz_hours_set ? $row['close'] : '' }}"></td>
                                                <td style="vertical-align:middle">
                                                    <input type="checkbox" value="1"
                                                           name="hours[{{ $row['day'] }}][closed]"
                                                           @if($row['closed']) checked @endif>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <h6 class="mt-4" style="font-weight:700;font-size:14px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280">Other profiles</h6>
                                <div class="form-group">
                                    <label class="form_label_color">Additional profile links — one per line</label>
                                    <textarea name="sameas_extra" class="form-control" rows="4" maxlength="2000"
                                              placeholder="https://www.google.com/maps/place/...&#10;https://www.youtube.com/@konnectyatra&#10;https://www.tripadvisor.com/...">{{ old('sameas_extra', $biz_sameas) }}</textarea>
                                    <small class="text-muted">
                                        Your Google Business Profile, YouTube, TripAdvisor, Yelp — anywhere the
                                        business is listed. Facebook, X, Instagram and LinkedIn come from
                                        <a href="{{ route('integrations') }}">Settings → Integrations</a> and are
                                        included automatically.
                                    </small>
                                </div>

                                <div class="alert {{ count($biz_sameas_live) ? 'alert-success' : 'alert-warning' }}" style="font-size:13px">
                                    @if(count($biz_sameas_live))
                                        <i class="fas fa-check-circle"></i> Publishing {{ count($biz_sameas_live) }} profile link{{ count($biz_sameas_live) === 1 ? '' : 's' }}:
                                        <ul class="mb-0 mt-1" style="padding-left:18px">
                                            @foreach($biz_sameas_live as $u)<li style="word-break:break-all">{{ $u }}</li>@endforeach
                                        </ul>
                                    @else
                                        <i class="fas fa-triangle-exclamation"></i>
                                        <strong>No profile links yet.</strong> These are how Google confirms this
                                        website and your social pages are the same organisation. Adding them is the
                                        single cheapest improvement available here.
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-5 form-group">
                                        <label class="form_label_color">Price range</label>
                                        <select name="price_range" class="form-control">
                                            @foreach(['' => 'Not shown', '$' => '$  — budget', '$$' => '$$  — moderate', '$$$' => '$$$  — upmarket', '$$$$' => '$$$$  — premium'] as $val => $label)
                                                <option value="{{ $val }}" @if((string) $biz_price_range === (string) $val) selected @endif>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-2">Save Business Details</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card" style="border-radius:14px;background:#f8f9fb">
                        <div class="card-body">
                            <h6 style="font-weight:700">Why this matters</h6>
                            <ul style="font-size:13px;padding-left:18px;line-height:1.8">
                                <li>Your <strong>name, address and phone</strong> must read <em>identically</em> here, on the website and on your Google Business Profile. A mismatch is the most common reason a site fails to connect to its listing.</li>
                                <li>Editing the address here changes it <strong>everywhere on the site at once</strong> — you no longer have to update four pages by hand.</li>
                                <li>Latitude/longitude and opening hours are <strong>left out entirely until you fill them</strong>. Blank is safe; wrong is not.</li>
                                <li>Check your work with Google's <a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener">Rich Results Test</a> — paste in your homepage.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>

<script>
// Live preview of the assembled address line, so what gets published is never a surprise.
(function () {
    var out = document.getElementById('addrPreview');
    if (!out) return;

    var get = function (n) {
        var el = document.querySelector('[name="' + n + '"]');
        return el ? el.value.trim() : '';
    };

    var render = function () {
        var cityState = (get('locality') + ', ' + get('region')).replace(/^[\s,]+|[\s,]+$/g, '');
        var postal = get('postal');
        if (postal) cityState = (cityState + ' ' + postal).trim();

        var country = get('country').toUpperCase();
        if (country === 'US') country = 'USA';

        out.textContent = [get('street'), cityState, country].filter(Boolean).join(', ');
    };

    ['street', 'locality', 'region', 'postal', 'country'].forEach(function (n) {
        var el = document.querySelector('[name="' + n + '"]');
        if (el) el.addEventListener('input', render);
    });
})();
</script>
@endsection
