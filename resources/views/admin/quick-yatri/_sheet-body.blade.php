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

    // A free-text cell. Every free-text answer on the sheet reads in CAPS —
    // as it is typed, on screen and in print — so the sheet is legible
    // whichever way the applicant filled it in and whatever state Caps Lock
    // happened to be in. text-transform does that in one place for all three
    // modes and leaves the stored value untouched; $mail below is the one
    // exception. There is no separate Title Case treatment for person names
    // any more — names are text, and all text is CAPS.
    $txt = function ($name, $extra = '', $cls = ' qy-caps') use ($row, $isEntry, $isBlank) {
        if ($isEntry) {
            return '<input type="text" class="qy-in' . $cls . '" name="' . $name . '" value="' . e(old($name, $row->{$name})) . '"' . $extra . '>';
        }
        if ($isBlank) {
            return '<span class="qy-fill"></span>';
        }
        return '<span class="qy-val' . $cls . '">' . e($row->{$name}) . '</span>';
    };

    // Email is the one answer that stays lowercase: it gets read back and
    // typed into a mail client, where CAPS only makes it harder to check.
    // The controller already lower-cases it on save; this also tidies rows
    // saved before it did.
    $mail = function ($name) use ($txt) {
        return $txt($name, '', ' qy-lower');
    };

    // A US/Canada cell number reads "+1 (786) 516 2525" — typed, shown and
    // printed. Only reshapes a clean 10-digit number (or 11 with a leading 1);
    // anything else stays exactly as typed rather than guessing at a shape
    // that doesn't fit. Because the entry field shows the tidied form too,
    // re-saving a record stores it back in that shape.
    //
    // This runs at render time only, so it cannot shape a number while it is
    // being typed. The .qy-phone class is the hook the live mask in
    // entry.blade.php's @section('js') binds to for that.
    $phone = function ($name) use ($row, $isEntry, $isBlank, $txt) {
        if ($isBlank) {
            return $txt($name);
        }
        $raw = $isEntry ? (string) old($name, $row->{$name}) : (string) $row->{$name};
        $digits = preg_replace('/\D/', '', $raw);
        if (strlen($digits) === 11 && $digits[0] === '1') {
            $digits = substr($digits, 1);
        }
        $formatted = strlen($digits) === 10
            ? '+1 (' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 3) . ' ' . substr($digits, 6)
            : null;
        if ($isEntry) {
            return '<input type="text" class="qy-in qy-phone" name="' . $name
                . '" value="' . e($formatted === null ? $raw : $formatted)
                . '" inputmode="tel" autocomplete="tel">';
        }
        if ($formatted === null) {
            return $txt($name);
        }
        return '<span class="qy-val">' . e($formatted) . '</span>';
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

    // The grid's prices are edited in the admin (Quick Yatri → Update prices),
    // not typed into this template — a fare change must not need a deploy, and
    // the blank sheet handed out at an event has to carry today's price.
    $grid  = \App\Models\QuickYatri::tripOptions();
    $wcFee = \App\Models\QuickYatri::wheelchairFee();

    // An applicant quoted their own price (group size, departure airport, a
    // rate agreed at an event) must see *their* price on their own sheet. It
    // goes inside the cell their option is ticked in, with the grid price
    // struck through beside it, rather than on a line of its own: page 1 is a
    // fixed 11in box and it currently measures 11in exactly, so one extra line
    // anywhere here spills onto a third printed page. The reason for the price
    // is not printed for the same reason — it shows on the entry screen, in
    // the list and in the price dialog, none of which are height-capped.
    $agreed = (!$isBlank && $row->custom_price && $row->package_amount !== null)
        ? \App\Models\QuickYatri::money($row->package_amount)
        : null;

    $price = function ($key) use ($grid, $row, $agreed) {
        $standard = \App\Models\QuickYatri::money($grid[$key]['amount']);
        if ($agreed === null || $row->trip_option !== $key) {
            return e($standard);
        }

        return '<s style="color:#777; font-weight:400">' . e($standard) . '</s> <b>' . e($agreed) . '</b>';
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

    // "Travelling from" is a plain departure-airport question, so it offers
    // every US airport with commercial service (App\Support\UsAirports),
    // grouped by state — not the short departure_origins list, which is the
    // curated set of routes the public packages selector sells and would be
    // wrong to answer this with. Blank mode can't offer a dropdown on paper,
    // so it gets a line to write on.
    $airport = function () use ($row, $isEntry, $isBlank) {
        if ($isBlank) {
            // A representative working one region's signup event can pre-fill
            // this via ?airport=CODE on the blank-form link (Quick Yatri list
            // page), so every sheet handed out there already reads e.g.
            // "MIA/FL" instead of leaving a line to write on.
            if ($row->departure_airport_code) {
                return '<span class="qy-val qy-caps">' . e(\App\Support\UsAirports::shortLabel($row->departure_airport_code)) . '</span>';
            }
            // Outside a table cell, unlike every other free-text field on the
            // sheet, so it needs its own writing line — qy-rule, the same
            // class the Signature line uses for the same reason.
            return '<span class="qy-rule" style="min-width:150pt"></span>';
        }
        if (!$isEntry) {
            $code = $row->departure_airport_code;
            if (!$code) {
                return '<span class="qy-val">&mdash;</span>';
            }
            return '<span class="qy-val qy-caps">' . e(\App\Support\UsAirports::label($code)) . '</span>';
        }

        $selected = strtoupper((string) old('departure_airport_code', $row->departure_airport_code));
        $html = '<select class="qy-in qy-caps" name="departure_airport_code" style="max-width:250pt">';
        $html .= '<option value="">Select airport&hellip;</option>';
        // A code saved before this list existed (or since retired) would
        // otherwise vanish silently on the next save, so carry it as its own
        // option rather than dropping the record's answer.
        if ($selected !== '' && !\App\Support\UsAirports::has($selected)) {
            $html .= '<option value="' . e($selected) . '" selected>' . e($selected) . ' (current)</option>';
        }
        foreach (\App\Support\UsAirports::grouped() as $state => $airports) {
            $html .= '<optgroup label="' . e($state) . '">';
            foreach ($airports as $code => $airport) {
                $sel = $selected === $code ? ' selected' : '';
                $html .= '<option value="' . $code . '"' . $sel . '>' . e($code . ' — ' . $airport[0]) . '</option>';
            }
            $html .= '</optgroup>';
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
            <div style="border:1px solid #111; padding:5pt 10pt; display:flex; align-items:center; flex-wrap:wrap; gap:8pt 10pt; font-size:10.5pt">
                <span style="font-weight:600; white-space:nowrap">Travelling from</span>{!! $airport() !!}
            </div>
        </div>
    </div>

    <div style="text-align:center; color:#e8112d; font-weight:700; font-size:11.5pt">* INCLUDES VISA AND FULL SECURITY *</div>

    {{-- Price grid --}}
    <table style="width:100%; border-collapse:collapse; font-size:10pt">
        <thead>
            <tr style="background:#d99215; color:#111; font-weight:700; text-align:center">
                <th style="border:1px solid #111; padding:3.5pt; width:34%">Trip</th>
                <th style="border:1px solid #111; padding:3.5pt; width:33%">5-Star Package</th>
                <th style="border:1px solid #111; padding:3.5pt; width:33%">Land Package</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border:1px solid #111; padding:3pt 9pt"><span style="display:flex; align-items:center; gap:9pt">{!! $radio('trip_option', 'round_trip_5star', 10) !!}Round Trip</span></td>
                <td style="border:1px solid #111; padding:3pt; text-align:center">{!! $price('round_trip_5star') !!}</td>
                <td style="border:1px solid #111; padding:3pt; text-align:center"><span style="display:inline-flex; align-items:center; gap:9pt">{!! $radio('trip_option', 'round_trip_land', 10) !!}{!! $price('round_trip_land') !!}</span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 9pt"><span style="display:flex; align-items:center; gap:9pt">{!! $radio('trip_option', 'one_way_5star', 10) !!}One-Way Trip</span></td>
                <td style="border:1px solid #111; padding:3pt; text-align:center">{!! $price('one_way_5star') !!}</td>
                <td style="border:1px solid #111; padding:3pt; text-align:center">&mdash;</td>
            </tr>
        </tbody>
    </table>

    @if($isEntry && $agreed !== null)
        {{-- Entry only. The admin editing this sheet needs to see the agreed
             price and why it was given; the printed page cannot afford the
             line (see $agreed above), and the blank form belongs to nobody. --}}
        <div style="border:1px solid #1a3fa0; background:#eef2fb; padding:3.5pt 9pt; font-size:9.5pt; display:flex; align-items:baseline; gap:7pt; flex-wrap:wrap">
            <span style="font-weight:700; color:#1a3fa0">Agreed price for this applicant:</span>
            <span style="font-weight:700">{{ $agreed }}</span>
            @if($row->price_note)<span style="color:#444">&mdash; {{ $row->price_note }}</span>@endif
            <span style="color:#777; margin-left:auto">Change it from the price column on the Quick Yatri list.</span>
        </div>
    @endif

    <div>
        <div style="color:#1a3fa0; font-weight:700; font-size:10.5pt; margin-bottom:3pt">Instructions and documents required:</div>
        <ul style="margin:0; padding-left:16pt; font-size:8.8pt; line-height:1.26; display:flex; flex-direction:column; gap:1pt">
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
        <div class="qy-bar">{!! $check('wheelchair_full_trip', 16, 'qy-box-light') !!}<span class="qy-bar-ico">&#9855;</span>Wheelchair throughout the trip (+{{ \App\Models\QuickYatri::money($wcFee) }})</div>
        <div class="qy-bar">{!! $check('meal_vegetarian', 16, 'qy-box-light') !!}<span class="qy-bar-ico">&#127860;</span>Meal preference: Vegetarian meals only</div>
    </div>

    {{-- Applicant grid --}}
    <table class="qy-grid" style="width:100%; border-collapse:collapse; font-size:8.8pt">
        <tbody>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt; width:19%">Name of Applicant:</td>
                <td style="border:1px solid #111; padding:2pt 6pt; width:29%">{!! $txt('applicant_name', ' required') !!}</td>
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
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $mail('email') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:2pt 6pt">Father&rsquo;s Name:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('father_name') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Mother&rsquo;s Name:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('mother_name') !!}</td>
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
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('family_member_1') !!}</td>
                <td style="border:1px solid #111; padding:2pt 6pt">Family Member 2:</td>
                <td style="border:1px solid #111; padding:2pt 6pt">{!! $txt('family_member_2') !!}</td>
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

    @php
        // Page 1 bottom, redesigned 2026-08-27: a 60/40 split. The notes and the
        // Date sit in the left panel; the right panel is a square holding the
        // Zelle QR. It replaces the old three-panel Uploads / Signature / QR
        // row — the upload tick boxes are gone (page 2 already lists the
        // documents required, and their columns are left untouched in the DB),
        // and the signature moved to the foot of page 2, after the terms it is
        // actually signing to.
        //
        // $qyPanelSide is the square's side *and* the row's height, and it is
        // MEASURED, not chosen: page 1 is a fixed 11in box that runs full to
        // within a pixel or two, so this is the largest square the freed height
        // pays for. Raising it spills the sheet onto a third printed page.
        // Re-measure (.qy-page-1 client vs. content bottom) before touching it.
        //
        // Cut from 218pt to 204pt on 2026-08-31 to pay for the Receipts row.
        // The office allowed 10-15%; this is 6.4%, because a sweep showed that
        // is all it takes and a bigger square is a better-scanning code.
        //
        // The square's side is also its *width*, and that is the half that
        // matters: the 14pt goes to the conditions panel, whose bullets — being
        // wider — wrap into fewer lines. That is where the height for a third
        // row comes from, not from the square being shorter.
        //
        // MEASURED, and it sits near a cliff. Swept against the worst-case
        // sentence: 192-210pt all leave the page 3.8px spare, and at **216pt**
        // the first bullet tips into a sixth line and the page goes 12.6px
        // over. 204pt keeps 12pt of margin from that edge while giving the
        // bullets ~11px of spacing at the live sentence. Re-run the sweep
        // before changing it — the cliff moves with the font and the sentence.
        $qyPanelSide = '204pt';

        // The code is printed to be scanned off paper, and a scanner needs a
        // white margin around it to find the thing at all. The uploaded PNG has
        // none — its modules run straight into a dark edge — so the margin is
        // added here. See the note by the <img> below.
        $qyQuietZone = '9pt';

        $qyCaptionStyle = 'font-family:\'Archivo Narrow\',sans-serif; font-weight:700; letter-spacing:0.03em; text-transform:uppercase; font-size:8pt; color:#1a3fa0';
    @endphp
    <div style="display:flex; align-items:stretch; gap:12pt; margin-top:auto">
        {{-- 60% — the conditions of the application, the money line, and the
             date it was signed.
             The 7pt gap is measured like the square's side, and it is what pays
             for the first bullet being editable: at 8pt a five-line bullet drove
             the row 0.9px past the square, and page 1 has nothing to give. --}}
        <div style="flex:1 1 auto; min-width:0; box-sizing:border-box; border:1px solid #111; border-radius:6pt; padding:9pt 12pt; display:flex; flex-direction:column; justify-content:space-between; gap:6pt">
            {{-- The bullets are spaced by *distributing* what the panel has
                 left over, not by a fixed gap: this list shares a 218pt box
                 with the money line, the Receipts row and the payment line,
                 and the first bullet is editable up to VALIDITY_NOTE_MAX
                 characters — five lines when it is used in full. A fixed 11pt
                 gap read beautifully at the default note and drove the panel
                 24.6px past the square at the longest one, which is a third
                 printed page. So 2pt is the floor (5pt until the Receipts row
                 arrived and the office said the bullets could close up),
                 flex:1 hands the list the panel's slack, and
                 space-between spreads it back between the bullets: at ordinary
                 note lengths the spacing lands back at ~11pt and the sheet
                 looks exactly as it did, while a long note simply tightens
                 instead of overflowing. Measured, not chosen — re-measure the
                 panel against the square (see the $qyPanelSide note) before
                 changing either number. --}}
            <ul style="margin:0; padding-left:15pt; font-size:9.2pt; line-height:1.34; display:flex; flex-direction:column; justify-content:space-between; flex:1 1 auto; gap:2pt">
                {{-- Edited in the admin (Quick Yatri → Update prices) rather
                     than typed here: the deadline and the late fee move every
                     season. Capped at QuickYatri::VALIDITY_NOTE_MAX characters
                     because this box has a measured height budget — see the
                     $qyPanelSide note above. --}}
                <li>{{ \App\Models\QuickYatri::validityNote() }}</li>
                <li>You must follow all group rules and regulations.</li>
                <li>Cancellation: applicable airline cancellations charges plus a $100 service fee apply.</li>
                <li>Contact: <strong style="color:#1a3fa0">Rashad Mahmood</strong> &nbsp;|&nbsp; <strong style="color:#1a3fa0">+1 718-908-9464</strong> &nbsp;|&nbsp; <strong style="color:#1a3fa0">konnectus.inc@gmail.com</strong></li>
                <li>Minimum deposit of <strong>$500</strong> accepted.</li>
            </ul>
            @php
                // Amount / Paid / Balance, over the payment slots they are made
                // of. NONE of these three is stored: Amount is the trip's price
                // (the ticked row of the grid, or this applicant's own agreed
                // price, plus the wheelchair surcharge), Paid is the sum of the
                // payments taken, and Balance is the difference. Only the parts
                // on the Receipts row below are typed — a total stored beside
                // its own parts eventually contradicts them on a printed page.
                $qyAmount  = $isBlank ? null : $row->grandTotal();
                $qyPaid    = $isBlank ? null : $row->paidAmount();
                $qyBalance = $isBlank ? null : $row->balanceAmount();

                $qyMoney = function ($value) {
                    return $value === null ? '' : \App\Models\QuickYatri::money($value);
                };

                // The sheet prints whole dollars, but the column stores cents,
                // and the entry field has to hand back exactly what is stored:
                // showing a stored 1200.50 as "1200" would quietly drop 50c the
                // next time the record was saved.
                $qyTyped = function ($value) {
                    if ($value === null) {
                        return '';
                    }

                    return $value == (int) $value ? (string) (int) $value : rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
                };

                // Entry mode recomputes Amount and Balance as the option is
                // ticked and the payment typed (see entry.blade.php), so it
                // needs today's grid and the surcharge to compute from.
                $qyPrices = [];
                foreach ($grid as $qyKey => $qyOpt) {
                    $qyPrices[$qyKey] = (float) $qyOpt['amount'];
                }
                $qyCustomBase = ($row->custom_price && $row->package_amount !== null)
                    ? (float) $row->package_amount
                    : null;

                $qyCell = 'display:flex; align-items:flex-end; gap:4pt; flex:1 1 0; min-width:0';

                // The three payment slots, read through the model so this
                // template never has to know that slot 1's columns are the
                // unsuffixed originals.
                $qySlots = $row->payments();
            @endphp
            {{-- The money line — the totals only. All three are read-only in
                 every mode: on paper they are writing lines, on a saved record
                 they are computed from the grid and from the Receipts row
                 below, so no figure here can contradict what was actually
                 taken. --}}
            <span style="display:flex; align-items:flex-end; gap:11pt; font-size:9pt">
                <span style="{{ $qyCell }}">Amount:<span class="qy-rule" id="qyAmountLine"
                    data-prices="{{ json_encode($qyPrices) }}"
                    data-fee="{{ $wcFee }}"
                    data-base="{{ $qyCustomBase }}">{{ $qyMoney($qyAmount) }}</span></span>
                {{-- Paid is no longer typed here: it is the sum of the
                     Receipts row, kept live while the sheet is being filled in
                     (see entry.blade.php). One figure, one source. --}}
                <span style="{{ $qyCell }}">Paid:<span class="qy-rule" id="qyPaidLine">{{ $qyMoney($qyPaid) }}</span></span>
                <span style="{{ $qyCell }}">Balance:<span class="qy-rule" id="qyBalanceLine">{{ $qyMoney($qyBalance) }}</span></span>
            </span>
            {{-- The Receipts row: up to three payments, each an amount and the
                 six-digit number of the receipt written for it.

                 A yatri paying in parts is ordinary — a deposit at a gurdwara
                 event, the balance nearer departure — and the office comes back
                 to the same record to add the next one. Three slots, because
                 that is what was asked for and what this row can print legibly.

                 Each slot reads **R# first, then the amount** — the receipt is
                 what the office looks a payment up by, so it leads and the
                 money it covers follows. The two sit together rather than in
                 columns of their own: a receipt number with no amount beside it
                 traces nothing. "R#" and "$" mark which is which in the width a
                 pair of words would have cost — this row had to be paid for out
                 of the panel's height (see the $qyPanelSide note) and there was
                 none to spare. R# keeps the larger share of each slot (1.4 to
                 1) whichever side it sits: measured at 8.6pt "123454" is 39.3px
                 against "3,450" at 29.2px, and it carries the wider marker. --}}
            <span class="qy-receipts" style="display:flex; align-items:flex-end; gap:7pt; font-size:8.6pt">
                <span style="white-space:nowrap">Receipts:</span>
@foreach($qySlots as $qySlot)
                <span style="display:flex; align-items:flex-end; gap:4pt; flex:1 1 0; min-width:0">
                    <span style="display:flex; align-items:flex-end; gap:2pt; flex:1.4 1 0; min-width:0">R#@if($isEntry)<input type="text" class="qy-in qy-rule" name="{{ $qySlot['receipt_field'] }}" value="{{ old($qySlot['receipt_field'], $qySlot['receipt']) }}" maxlength="6" inputmode="numeric" autocomplete="off">@else<span class="qy-rule">{{ $isBlank ? '' : $qySlot['receipt'] }}</span>@endif</span>
                    <span style="display:flex; align-items:flex-end; gap:2pt; flex:1 1 0; min-width:0">$@if($isEntry)<input type="text" class="qy-in qy-rule qy-paid" name="{{ $qySlot['amount_field'] }}" value="{{ old($qySlot['amount_field'], $qyTyped($qySlot['amount'])) }}" autocomplete="off">@else<span class="qy-rule">{{ $isBlank || $qySlot['amount'] === null ? '' : number_format($qySlot['amount']) }}</span>@endif</span>
                </span>
@endforeach
            </span>
            {{-- How they are paying, which check it came in on, and the date
                 signed — on ONE line. The tick boxes go beside the Date rather
                 than on a row of their own because page 1 has no height to
                 give: a second row costs ~16pt and the first bullet is already
                 allowed to grow into all of it. Three boxes, not a choice of
                 one — a deposit paid one way and the balance another is
                 ordinary.

                 Check # went in beside them because the Date was holding far
                 more line than it prints on: at 8.6pt "21-AUG-2026" measures
                 70.7px and the rule was 154. The row now reads 8.6pt like the
                 Receipts row above it, and the tick group's gaps close from 9pt
                 to 6pt. What that frees is split 1.2 to 1 in the Date's favour
                 — it is the longest value on the row — which MEASURES 82.7px
                 for the date against 46.8px for the check, each comfortably
                 past the 70.7 and 39.3 they have to print.

                 Both labels are nowrap and .qy-payline lifts .qy-rule's 36pt
                 floor. Without either, the cells squeeze until "Check #:" wraps
                 and the row grows a second line — 14.1px page 1 has not got. --}}
            <span class="qy-payline" style="display:flex; align-items:flex-end; gap:5pt; font-size:8.6pt">
                <span style="display:flex; align-items:center; gap:6pt; white-space:nowrap">Payment:
                    <span style="display:inline-flex; align-items:center; gap:3pt">{!! $check('pay_cash', 9) !!}Cash</span>
                    <span style="display:inline-flex; align-items:center; gap:3pt">{!! $check('pay_zelle', 9) !!}Zelle</span>
                    <span style="display:inline-flex; align-items:center; gap:3pt">{!! $check('pay_check', 9) !!}Check</span>
                </span>
                {{-- Which check the money came in on. Not held to a digit count
                     the way the receipt numbers are: a check is the payer's and
                     carries whatever their bank printed on it. --}}
                <span style="display:flex; align-items:flex-end; gap:3pt; flex:1 1 0; min-width:0"><span style="white-space:nowrap">Check #:</span>@if($isEntry)<input type="text" class="qy-in qy-rule qy-caps" name="check_no" value="{{ old('check_no', $row->check_no) }}" maxlength="20" autocomplete="off">@else<span class="qy-rule qy-caps">{{ $isBlank ? '' : $row->check_no }}</span>@endif</span>
                <span style="display:flex; align-items:flex-end; gap:3pt; flex:1.2 1 0; min-width:0"><span style="white-space:nowrap">Date:</span>{!! $dat('signature_date', 'ky-date-past', true) !!}</span>
            </span>
        </div>

        {{-- 40% — a square panel with the code inside it, captioned in place so
             the caption costs the row no extra height. --}}
        <div style="flex:0 0 {{ $qyPanelSide }}; width:{{ $qyPanelSide }}; height:{{ $qyPanelSide }}; box-sizing:border-box; border:1px solid #111; border-radius:6pt; background:#fff; padding:{{ $qyQuietZone }}; display:flex; flex-direction:column; align-items:center; gap:5pt">
            <span style="{{ $qyCaptionStyle }}">Scan Me</span>
            {{-- Sized for a phone camera to actually read off the printed
                 sheet. Two things decide whether it does: how large the code
                 lands on paper, and whether it has a white quiet zone around
                 it. The uploaded PNG supplies neither — its modules run into a
                 dark edge with no margin — so the panel is padded white and the
                 code is fitted inside that.

                 The dark edge is baked into the image and cannot be fixed from
                 here. A QR with a white border and a shorter payload (fewer,
                 chunkier modules) re-uploaded in Admin > Payment Settings will
                 scan better than any amount of enlarging in this template. --}}
            <div style="flex:1 1 auto; min-height:0; width:100%; display:flex; align-items:center; justify-content:center">
                @if($qrUrl)
                    <img src="{{ $qrUrl }}" alt="Zelle QR code" style="max-width:100%; max-height:100%; object-fit:contain; display:block">
                @else
                    <div style="width:100%; height:100%; border:1px dashed #999; border-radius:4pt; display:flex; align-items:center; justify-content:center; font-size:7.5pt; color:#999; text-align:center; line-height:1.2">QR not set</div>
                @endif
            </div>
        </div>
    </div>
</div>
