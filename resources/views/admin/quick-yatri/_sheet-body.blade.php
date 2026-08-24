{{--
    The Konnect.US Yatri Application sheet, reproduced from the approved design.

    One template, three modes — do not fork it:
      $mode = 'entry'  inputs, inside the admin layout (Add New / Edit)
      $mode = 'blank'  empty boxes, to print and hand to a candidate
      $mode = 'print'  a saved record laid out on the same sheet

    Expects: $row (App\Models\QuickYatri), $mode.
--}}
@php
    $isEntry = $mode === 'entry';
    $isBlank = $mode === 'blank';

    // A free-text cell.
    $txt = function ($name, $extra = '') use ($row, $isEntry, $isBlank) {
        if ($isEntry) {
            return '<input type="text" class="qy-in" name="' . $name . '" value="' . e(old($name, $row->{$name})) . '"' . $extra . '>';
        }
        if ($isBlank) {
            return '<span class="qy-fill"></span>';
        }
        return '<span class="qy-val">' . e($row->{$name}) . '</span>';
    };

    // Person names print in proper Title Case ("Banta Singh") no matter how
    // they were typed — passport-style ALL CAPS entry is common and still
    // fine to type; this only changes how it prints, never what is stored.
    $personName = function ($name, $extra = '') use ($row, $isEntry, $isBlank, $txt) {
        if ($isEntry || $isBlank) {
            return $txt($name, $extra);
        }
        $value = (string) $row->{$name};
        return '<span class="qy-val">' . e($value === '' ? '' : \Illuminate\Support\Str::title($value)) . '</span>';
    };

    // A US/Canada cell number prints as "+1 (718) 908-9464". Only reshapes a
    // clean 10-digit number (or 11 with a leading 1) — anything else prints
    // exactly as typed rather than guessing at a shape that doesn't fit.
    $phone = function ($name) use ($row, $isEntry, $isBlank, $txt) {
        if ($isEntry || $isBlank) {
            return $txt($name);
        }
        $digits = preg_replace('/\D/', '', (string) $row->{$name});
        if (strlen($digits) === 11 && $digits[0] === '1') {
            $digits = substr($digits, 1);
        }
        if (strlen($digits) === 10) {
            $formatted = '+1 (' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 3) . '-' . substr($digits, 6);
            return '<span class="qy-val">' . e($formatted) . '</span>';
        }
        return $txt($name);
    };

    // Dates read as DD-MMM-YYYY everywhere — 21-AUG-2026 — typed, shown and
    // printed. $picker names the jQuery UI class that ranges the calendar;
    // $onRule = the field sits on a writing line rather than in a bordered cell
    // (the Date beside the signature).
    $dat = function ($name, $picker = 'ky-date-any', $onRule = false) use ($row, $isEntry, $isBlank) {
        $cls = $onRule ? ' qy-rule' : '';
        if ($isEntry) {
            $val = old($name, $row->stamp($name));
            return '<input type="text" class="qy-in ' . $picker . $cls . '" name="' . $name
                . '" value="' . e($val) . '" placeholder="DD-MMM-YYYY" autocomplete="off">';
        }
        if ($isBlank) {
            return $onRule ? '<span class="qy-rule"></span>' : '<span class="qy-fill"></span>';
        }
        return '<span class="qy-val' . $cls . '">' . e($row->stamp($name)) . '</span>';
    };

    // Box sizes vary by context in the design (8pt in the grid, 9pt in the trip
    // band, 10pt in the price table), so each caller passes its own.
    $boxStyle = function ($size) {
        return ' style="width:' . $size . 'pt;height:' . $size . 'pt"';
    };

    // One of several mutually exclusive boxes (Gender, Yes/No, Port of Entry…).
    $radio = function ($name, $value, $size = 8) use ($row, $isEntry, $isBlank, $boxStyle) {
        if ($isEntry) {
            $checked = old($name, $row->{$name}) === $value ? ' checked' : '';
            return '<input type="radio" class="qy-tick" name="' . $name . '" value="' . e($value) . '"' . $checked . $boxStyle($size) . '>';
        }
        if ($isBlank) {
            return '<span class="qy-box"' . $boxStyle($size) . '></span>';
        }
        return '<span class="qy-box"' . $boxStyle($size) . '>' . ($row->{$name} === $value ? '&#10003;' : '') . '</span>';
    };

    // A standalone tick box (the option bars, the upload row).
    $check = function ($name, $size = 8, $cls = '') use ($row, $isEntry, $isBlank, $boxStyle) {
        if ($isEntry) {
            $checked = old($name, $row->{$name}) ? ' checked' : '';
            return '<input type="checkbox" class="qy-tick ' . $cls . '" name="' . $name . '" value="1"' . $checked . $boxStyle($size) . '>';
        }
        if ($isBlank) {
            return '<span class="qy-box ' . $cls . '"' . $boxStyle($size) . '></span>';
        }
        return '<span class="qy-box ' . $cls . '"' . $boxStyle($size) . '>' . ($row->{$name} ? '&#10003;' : '') . '</span>';
    };

    // The four reference boxes across the top sit on a rule, not in a cell.
    $ref = function ($name) use ($row, $isEntry, $isBlank) {
        if ($isEntry) {
            return '<input type="text" class="qy-in qy-rule" name="' . $name . '" value="' . e(old($name, $row->{$name})) . '">';
        }
        return '<span class="qy-rule">' . ($isBlank ? '' : e($row->{$name})) . '</span>';
    };

    // Round Trip used to be locked to one hard-coded route, "PHL-ISB/LHE-PHL
    // (PA/DE/NJ-SO)". This offers every active USA departure airport instead —
    // the same departure_origins table the public packages selector reads, so
    // there is one admin-managed list rather than a second one invented here.
    // Blank mode can't offer a dropdown on paper, so it gets a line to write on.
    $usOrigins = \App\Models\DepartureOrigin::where('country', 'USA')->where('status', 1)
        ->orderBy('sort_order')->orderBy('state')
        ->get(['airport_code', 'airport_name', 'state']);

    $airport = function () use ($row, $isEntry, $isBlank, $usOrigins) {
        if ($isBlank) {
            // A representative working one region's signup event can pre-fill
            // this via ?airport=CODE on the blank-form link (Quick Yatri list
            // page), so every sheet handed out there already reads e.g.
            // "MIA/FL" instead of leaving a line to write on.
            if ($row->departure_airport_code) {
                $origin = $usOrigins->firstWhere('airport_code', $row->departure_airport_code);
                $abbr = $origin ? \App\Support\GurdwaraGeo::stateAbbreviation($origin->state) : '';
                $label = e($row->departure_airport_code) . ($abbr !== '' ? '/' . e($abbr) : '');
                return '<span class="qy-val">' . $label . '</span>';
            }
            // Outside a table cell, unlike every other free-text field on the
            // sheet, so it needs its own writing line — qy-rule, the same
            // class the Signature line uses for the same reason.
            return '<span class="qy-rule" style="min-width:110pt"></span>';
        }
        if (!$isEntry) {
            $code = $row->departure_airport_code;
            if (!$code) {
                return '<span class="qy-val">&mdash;</span>';
            }
            $origin = $usOrigins->firstWhere('airport_code', $code);
            $label = e($code) . ($origin ? ' &mdash; ' . e($origin->state) : '');
            return '<span class="qy-val">' . $label . '</span>';
        }

        $selected = old('departure_airport_code', $row->departure_airport_code);
        $html = '<select class="qy-in" name="departure_airport_code" style="max-width:145pt">';
        $html .= '<option value="">Select airport&hellip;</option>';
        if ($selected && !$usOrigins->contains('airport_code', $selected)) {
            $html .= '<option value="' . e($selected) . '" selected>' . e($selected) . ' (current)</option>';
        }
        foreach ($usOrigins as $o) {
            $sel = $selected === $o->airport_code ? ' selected' : '';
            $label = e($o->airport_code) . ' &mdash; ' . e($o->state);
            $html .= '<option value="' . e($o->airport_code) . '"' . $sel . '>' . $label . '</option>';
        }
        $html .= '</select>';
        return $html;
    };

    // Same Zelle QR the dompdf yatri_form.blade.php prints — Admin > Payment
    // Settings, uploaded (never committed) — so there is one QR to keep
    // current, not a second copy specific to this sheet.
    $qrFile = \App\Models\SiteSetting::get(\App\Http\Controllers\Admin\PaymentSettingController::QR_KEY);
    $qrUrl = $qrFile ? asset(\App\Http\Controllers\Admin\PaymentSettingController::QR_DIRECTORY . '/' . $qrFile) : null;
@endphp

<div class="qy-page qy-page-1">

    {{-- Letterhead: photo box + masthead + reference numbers + trip band --}}
    <div style="display:flex; gap:10pt; align-items:stretch">
        <div class="qy-photo">
            @if($isEntry)
                <label class="qy-photo-label">
                    @if($row->photoUrl())
                        <img src="{{ $row->photoUrl() }}" alt="Photo">
                    @else
                        <span>PHOTO<small>click to upload</small></span>
                    @endif
                    <input type="file" name="photo" accept="image/*" hidden>
                </label>
            @elseif($row->photoUrl())
                <img src="{{ $row->photoUrl() }}" alt="Photo">
            @else
                PHOTO
            @endif
        </div>
        <div style="flex:1; display:flex; flex-direction:column; gap:5pt">
            <div style="text-align:center">
                <div style="font-family:'Archivo',sans-serif; font-weight:800; font-size:24pt; letter-spacing:-0.01em; color:#1a3fa0; line-height:1">KONNECT. <span style="color:#c8102e">US</span>, INC.</div>
                <div style="font-family:'Archivo',sans-serif; font-weight:700; font-size:11.5pt; color:#1a3fa0; margin-top:3pt">Explore and Discover the Globe</div>
            </div>
            <div style="display:flex; gap:14pt; align-items:center">
                <div style="border:2px solid #e08a1e; border-radius:6pt; padding:5pt 10pt; color:#1a3fa0; font-family:'Archivo',sans-serif; font-weight:700; font-size:11.5pt; white-space:nowrap">FIRST COME FIRST SERVE</div>
                <div style="flex:1; display:grid; grid-template-columns:1fr 1fr; gap:6pt 16pt; font-size:10pt">
                    <div style="display:flex; align-items:flex-end; gap:5pt">SR#:{!! $ref('sr_no') !!}</div>
                    <div style="display:flex; align-items:flex-end; gap:5pt">RT#:{!! $ref('rt_no') !!}</div>
                    <div style="display:flex; align-items:flex-end; gap:5pt">OW#:{!! $ref('ow_no') !!}</div>
                    <div style="display:flex; align-items:flex-end; gap:5pt">LP#:{!! $ref('lp_no') !!}</div>
                </div>
            </div>
            <div style="border:1px solid #111; padding:5pt 10pt; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8pt 12pt; font-size:10.5pt">
                <span style="display:flex; align-items:center; gap:6pt; flex-wrap:wrap">{!! $radio('booking_type', 'round_trip_phl', 9) !!}Round Trip {!! $airport() !!} &mdash; ISB/LHE</span>
                <span style="display:flex; align-items:center; gap:7pt">{!! $radio('booking_type', 'land_package', 9) !!}Land Package</span>
            </div>
        </div>
    </div>

    <div style="text-align:center; color:#e8112d; font-weight:700; font-size:11.5pt">* INCLUDES VISA AND FULL SECURITY *</div>

    {{-- Price grid --}}
    <table style="width:100%; border-collapse:collapse; font-size:10pt">
        <thead>
            <tr style="background:#d99215; color:#111; font-weight:700; text-align:center">
                <th style="border:1px solid #111; padding:5pt; width:34%">Trip</th>
                <th style="border:1px solid #111; padding:5pt; width:33%">5-Star Package</th>
                <th style="border:1px solid #111; padding:5pt; width:33%">Land Package</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border:1px solid #111; padding:4pt 9pt"><span style="display:flex; align-items:center; gap:9pt">{!! $radio('trip_option', 'round_trip_5star', 10) !!}Round Trip</span></td>
                <td style="border:1px solid #111; padding:4pt; text-align:center">$3,150</td>
                <td style="border:1px solid #111; padding:4pt; text-align:center"><span style="display:inline-flex; align-items:center; gap:9pt">{!! $radio('trip_option', 'round_trip_land', 10) !!}$1,650</span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:4pt 9pt"><span style="display:flex; align-items:center; gap:9pt">{!! $radio('trip_option', 'one_way_5star', 10) !!}One-Way Trip</span></td>
                <td style="border:1px solid #111; padding:4pt; text-align:center">$2,650</td>
                <td style="border:1px solid #111; padding:4pt; text-align:center">&mdash;</td>
            </tr>
        </tbody>
    </table>

    <div>
        <div style="color:#1a3fa0; font-weight:700; font-size:10.5pt; margin-bottom:3pt">Instructions and documents required:</div>
        <ul style="margin:0; padding-left:16pt; font-size:8.8pt; line-height:1.3; display:flex; flex-direction:column; gap:2pt">
            <li>1 passport-size photograph with a white background. If the visa system does not recognize the photograph, additional photographs may be requested.</li>
            <li>Copy of passport valid for at least 6 months; copy of Green Card if you are not a U.S. citizen. 2 Pages of Indian Passport.</li>
            <li>Copy of State ID card or Driver&rsquo;s License.</li>
            <li style="color:#e8112d">FALSE OR MISLEADING INFORMATION MAY CAUSE VISA REJECTION. FEES ARE NON-REFUNDABLE.</li>
        </ul>
    </div>

    {{-- The three option bars. Blank mode now gets a real box too, so a candidate
         filling the printed sheet by pen has something to tick — entry and print
         already added one because a stored record has to say which were chosen. --}}
    <div style="display:grid; grid-template-columns:1fr 1.12fr 1.12fr; gap:9pt">
        <div class="qy-bar">{!! $check('wheelchair_airport', 16, 'qy-box-light') !!}<span class="qy-bar-ico">&#9855;</span>Wheelchair at airport</div>
        <div class="qy-bar">{!! $check('wheelchair_full_trip', 16, 'qy-box-light') !!}<span class="qy-bar-ico">&#9855;</span>Wheelchair throughout the trip (+$300)</div>
        <div class="qy-bar">{!! $check('meal_vegetarian', 16, 'qy-box-light') !!}<span class="qy-bar-ico">&#127860;</span>Meal preference: Vegetarian meals only</div>
    </div>

    {{-- Applicant grid --}}
    <table class="qy-grid" style="width:100%; border-collapse:collapse; font-size:8.8pt">
        <tbody>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt; width:19%">Name of Applicant:</td>
                <td style="border:1px solid #111; padding:2pt 6pt; width:29%">{!! $personName('applicant_name', ' required') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt; width:19%">Gender:</td>
                <td style="border:1px solid #111; padding:2pt 6pt; width:33%"><span style="display:flex; gap:22pt; justify-content:center"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('gender', 'M') !!}M</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('gender', 'F') !!}F</span></span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Date of Birth (D/M/Y):</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $dat('date_of_birth', 'ky-date-dob') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Place of Birth:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('place_of_birth') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Cell Phone No.:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $phone('cell_phone') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Email:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('email') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Father&rsquo;s Name:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $personName('father_name') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Mother&rsquo;s Name:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $personName('mother_name') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Citizenship / Nationality:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('citizenship') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Passport No.:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('passport_no') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Date of Issue:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $dat('date_of_issue', 'ky-date-issue') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Date of Expiry:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $dat('date_of_expiry', 'ky-date-expiry') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">First visit to Pakistan?</td>
                <td style="border:1px solid #111; padding:2pt 6pt"><span style="display:flex; gap:20pt"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('first_visit_pakistan', 'Yes') !!}Yes</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('first_visit_pakistan', 'No') !!}No</span></span></td>
                <td style="border:1px solid #111; padding:2pt 6pt">Port of Entry:</td>
                <td style="border:1px solid #111; padding:2pt 6pt; font-size:8.4pt"><span style="display:flex; gap:11pt; justify-content:center"><span style="display:inline-flex; align-items:center; gap:4pt">{!! $radio('port_of_entry', 'Wagah') !!}Wagah</span><span style="display:inline-flex; align-items:center; gap:4pt">{!! $radio('port_of_entry', 'Islamabad') !!}Islamabad</span><span style="display:inline-flex; align-items:center; gap:4pt">{!! $radio('port_of_entry', 'Lahore') !!}Lahore</span></span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">If No - Previous Visit Date:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $dat('previous_visit_date', 'ky-date-past') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Profession:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('profession') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Family traveling with you?</td>
                <td style="border:1px solid #111; padding:2pt 6pt"><span style="display:flex; gap:20pt"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('family_traveling', 'Yes') !!}Yes</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('family_traveling', 'No') !!}No</span></span></td>
                <td style="border:1px solid #111; padding:2pt 6pt">No. of family members:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('family_members_count') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Family Member 1:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $personName('family_member_1') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Family Member 2:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $personName('family_member_2') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Marital Status:</td>
                <td style="border:1px solid #111; padding:2pt 6pt"><span style="display:flex; gap:16pt"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Married') !!}Married</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Single') !!}Single</span></span></td>
                <td style="border:1px solid #111; padding:2pt 6pt" colspan="2"><span style="display:flex; gap:20pt; justify-content:flex-end"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Divorced') !!}Divorced</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Widowed') !!}Widowed</span></span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Home Address:</td>
                <td style="border:1px solid #111; padding:2pt 6pt" colspan="3">{!! $txt('home_address') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">City:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('city') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">State / ZIP:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('state_zip') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Nearest Gurdwara:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('nearest_gurdwara') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">City / State:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('gurdwara_city_state') !!}</td>
            </tr>
        </tbody>
    </table>

    <ul style="margin:0; padding-left:15pt; font-size:8.3pt; line-height:1.28; display:flex; flex-direction:column; gap:1.5pt">
        <li>This application is valid through September 15, 2026. Add $100 for applications submitted from September 20 through October 15, 2026.</li>
        <li>You must follow all group rules and regulations.</li>
        <li>Cancellation: applicable airline cancellations charges plus a $100 service fee apply.</li>
        <li>Contact: <strong style="color:#1a3fa0">Rashad Mahmood</strong> &nbsp;|&nbsp; <strong style="color:#1a3fa0">+1 718-908-9464</strong> &nbsp;|&nbsp; <strong style="color:#1a3fa0">konnectus.inc@gmail.com</strong></li>
        <li>A separate application form is required for each traveler.</li>
    </ul>

    @php
        $qyBoxSize = '118pt';
        $qyCaptionStyle = 'font-family:\'Archivo Narrow\',sans-serif; font-weight:700; letter-spacing:0.03em; text-transform:uppercase; font-size:7.6pt; color:#1a3fa0';
    @endphp
    {{-- Three matched, bordered panels — Uploads no longer trails off as a
         short list with blank paper beneath it; all three carry the same
         footprint as Signature/QR, each using its own height on purpose:
         Uploads spreads header/checklist/date top-to-bottom, Signature stays
         a clear writing surface with the label pinned to the foot of it,
         Scan Me labels the code from above so the code itself loses no area
         to a caption competing for space inside it. --}}
    <div style="display:flex; align-items:flex-end; gap:12pt; margin-top:auto">
        <div style="flex:1; height:{{ $qyBoxSize }}; box-sizing:border-box; border:1px solid #111; border-radius:6pt; padding:8pt 11pt; display:flex; flex-direction:column; justify-content:space-between; font-size:8.6pt">
            <span style="{{ $qyCaptionStyle }}">Uploads</span>
            <div style="display:flex; flex-direction:column; gap:7pt">
                <span style="display:inline-flex; align-items:center; gap:6pt">{!! $check('upload_passport', 10) !!}Passport</span>
                <span style="display:inline-flex; align-items:center; gap:6pt">{!! $check('upload_green_card', 10) !!}Green Card</span>
                <span style="display:inline-flex; align-items:center; gap:6pt">{!! $check('upload_id_license', 10) !!}ID / Driver&rsquo;s License</span>
            </div>
            <span style="display:flex; align-items:flex-end; gap:5pt">Date:{!! $dat('signature_date', 'ky-date-past', true) !!}</span>
        </div>
        <div style="flex:0 0 auto; width:{{ $qyBoxSize }}; height:{{ $qyBoxSize }}; box-sizing:border-box; border:1px solid #111; border-radius:6pt; display:flex; align-items:flex-end; justify-content:center; padding-bottom:8pt; color:#8a93a5; font-size:8.5pt">Signature</div>
        <div style="flex:0 0 auto; display:flex; flex-direction:column; align-items:center; gap:4pt">
            <span style="{{ $qyCaptionStyle }}">Scan Me</span>
            {{-- Sized for a phone camera to actually read when printed —
                 anything much smaller than this is unreliable to scan. --}}
            @if($qrUrl)
                <img src="{{ $qrUrl }}" alt="Zelle QR code" style="width:{{ $qyBoxSize }}; height:{{ $qyBoxSize }}; object-fit:contain; border:1px solid #111; border-radius:6pt">
            @else
                <div style="width:{{ $qyBoxSize }}; height:{{ $qyBoxSize }}; box-sizing:border-box; border:1px dashed #999; border-radius:6pt; display:flex; align-items:center; justify-content:center; font-size:7pt; color:#999; text-align:center; line-height:1.2">QR not set</div>
            @endif
        </div>
    </div>
</div>
