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
            <div style="border:1px solid #111; padding:5pt 10pt; display:flex; justify-content:space-between; align-items:center; gap:12pt; font-size:10.5pt">
                <span style="display:flex; align-items:center; gap:7pt">{!! $radio('booking_type', 'round_trip_phl', 9) !!}Round Trip PHL-ISB/LHE-PHL (PA/DE/NJ-SO)</span>
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
            <li>Copy of passport valid for at least 6 months; copy of Green Card if you are not a U.S. citizen.</li>
            <li>2 Pages of Indian Passport</li>
            <li>Copy of State ID card or Driver&rsquo;s License.</li>
            <li style="color:#e8112d">FALSE OR MISLEADING INFORMATION MAY CAUSE VISA REJECTION. FEES ARE NON-REFUNDABLE.</li>
        </ul>
    </div>

    {{-- The three option bars. The approved design carries no tick box on these,
         so the blank sheet reproduces them exactly as drawn; entry and print add
         a white box, because a stored record has to say which were chosen. --}}
    <div style="display:grid; grid-template-columns:1fr 1.12fr 1.12fr; gap:9pt">
        <div class="qy-bar">@unless($isBlank){!! $check('wheelchair_airport', 10, 'qy-box-light') !!}@endunless<span class="qy-bar-ico">&#9855;</span>Wheelchair at airport</div>
        <div class="qy-bar">@unless($isBlank){!! $check('wheelchair_full_trip', 10, 'qy-box-light') !!}@endunless<span class="qy-bar-ico">&#9855;</span>Wheelchair throughout the trip (+$300)</div>
        <div class="qy-bar">@unless($isBlank){!! $check('meal_vegetarian', 10, 'qy-box-light') !!}@endunless<span class="qy-bar-ico">&#127860;</span>Meal preference: Vegetarian meals only</div>
    </div>

    {{-- Applicant grid --}}
    <table class="qy-grid" style="width:100%; border-collapse:collapse; font-size:8.8pt">
        <tbody>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt; width:19%">Name of Applicant:</td>
                <td style="border:1px solid #111; padding:3pt 6pt; width:29%">{!! $txt('applicant_name', ' required') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt; width:19%">Gender:</td>
                <td style="border:1px solid #111; padding:3pt 6pt; width:33%"><span style="display:flex; gap:22pt; justify-content:center"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('gender', 'M') !!}M</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('gender', 'F') !!}F</span></span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Date of Birth (D/M/Y):</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $dat('date_of_birth', 'ky-date-dob') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Place of Birth:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('place_of_birth') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Cell Phone No.:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('cell_phone') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Email:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('email') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Father&rsquo;s Name:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('father_name') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Mother&rsquo;s Name:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('mother_name') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Citizenship / Nationality:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('citizenship') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Passport No.:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('passport_no') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Date of Issue:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $dat('date_of_issue', 'ky-date-issue') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Date of Expiry:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $dat('date_of_expiry', 'ky-date-expiry') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">First visit to Pakistan?</td>
                <td style="border:1px solid #111; padding:3pt 6pt"><span style="display:flex; gap:20pt"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('first_visit_pakistan', 'Yes') !!}Yes</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('first_visit_pakistan', 'No') !!}No</span></span></td>
                <td style="border:1px solid #111; padding:3pt 6pt">Port of Entry:</td>
                <td style="border:1px solid #111; padding:3pt 6pt; font-size:8.4pt"><span style="display:flex; gap:11pt; justify-content:center"><span style="display:inline-flex; align-items:center; gap:4pt">{!! $radio('port_of_entry', 'Wagah') !!}Wagah</span><span style="display:inline-flex; align-items:center; gap:4pt">{!! $radio('port_of_entry', 'Islamabad') !!}Islamabad</span><span style="display:inline-flex; align-items:center; gap:4pt">{!! $radio('port_of_entry', 'Lahore') !!}Lahore</span></span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">If No - Previous Visit Date:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $dat('previous_visit_date', 'ky-date-past') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Profession:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('profession') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Family traveling with you?</td>
                <td style="border:1px solid #111; padding:3pt 6pt"><span style="display:flex; gap:20pt"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('family_traveling', 'Yes') !!}Yes</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('family_traveling', 'No') !!}No</span></span></td>
                <td style="border:1px solid #111; padding:3pt 6pt">No. of family members:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('family_members_count') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Family Member 1:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('family_member_1') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">Family Member 2:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('family_member_2') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Marital Status:</td>
                <td style="border:1px solid #111; padding:3pt 6pt"><span style="display:flex; gap:16pt"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Married') !!}Married</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Single') !!}Single</span></span></td>
                <td style="border:1px solid #111; padding:3pt 6pt" colspan="2"><span style="display:flex; gap:20pt; justify-content:flex-end"><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Divorced') !!}Divorced</span><span style="display:inline-flex; align-items:center; gap:5pt">{!! $radio('marital_status', 'Widowed') !!}Widowed</span></span></td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Home Address:</td>
                <td style="border:1px solid #111; padding:3pt 6pt" colspan="3">{!! $txt('home_address') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">City:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('city') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">State / ZIP:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('state_zip') !!}</td>
            </tr>
            <tr>
                <td style="border:1px solid #111; padding:3pt 6pt">Nearest Gurdwara:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('nearest_gurdwara') !!}</td>
                <td style="border:1px solid #111; padding:3pt 6pt">City / State:</td>
                <td style="border:1px solid #111; padding:3pt 6pt">{!! $txt('gurdwara_city_state') !!}</td>
            </tr>
        </tbody>
    </table>

    <ul style="margin:0; padding-left:15pt; font-size:8.3pt; line-height:1.28; display:flex; flex-direction:column; gap:1.5pt">
        <li>Price is guaranteed when booking is made at least 10 weeks in advance and paid in full.</li>
        <li>Make payments available at <strong style="color:#1a3fa0">Konnect-US, Inc.</strong> &nbsp;&nbsp;<strong style="color:#e8112d">Zelle: 718-908-9464</strong>. Please send a $1 test payment first. Once the $1 payment is confirmed, send the remaining balance.</li>
        <li>This application is valid through September 10, 2026. Add $100 for applications submitted from September 11 through October 15, 2026.</li>
        <li>You must follow all group rules and regulations.</li>
        <li>Cancellation: applicable airline cancellations charges plus a $100 service fee apply.</li>
        <li>Contact: <strong style="color:#1a3fa0">Rashad Mahmood</strong> &nbsp;|&nbsp; <strong style="color:#1a3fa0">+1 718-908-9464</strong> &nbsp;|&nbsp; <strong style="color:#1a3fa0">konnectus.inc@gmail.com</strong></li>
        <li>A separate application form is required for each traveler.</li>
    </ul>

    <div style="display:flex; align-items:flex-end; gap:14pt; font-size:9pt; margin-top:auto">
        <span style="display:flex; align-items:flex-end; gap:5pt; flex:1.5">Signature:<span class="qy-rule"></span></span>
        <span style="display:flex; align-items:flex-end; gap:5pt; flex:0.9">Date:{!! $dat('signature_date', 'ky-date-past', true) !!}</span>
        <span style="display:flex; align-items:center; gap:11pt; font-size:8.4pt">Upload:
            <span style="display:inline-flex; align-items:center; gap:4pt">{!! $check('upload_passport') !!}Passport</span>
            <span style="display:inline-flex; align-items:center; gap:4pt">{!! $check('upload_green_card') !!}Green Card</span>
            <span style="display:inline-flex; align-items:center; gap:4pt">{!! $check('upload_id_license') !!}ID / Driver&rsquo;s License</span>
        </span>
    </div>
</div>
