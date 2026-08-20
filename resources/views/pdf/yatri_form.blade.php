@php
    // Blank mode prints the same form with nothing filled in, to hand to a
    // candidate. Values become writing lines (the rule comes from CSS, so every
    // "{{ $v(...) }}" below works unchanged) and the sections that are hidden
    // when a record has no data are shown, because that is exactly where someone
    // needs somewhere to write.
    $blank = $blank ?? false;

    // Helpers
    $v = function ($val) use ($blank) {
        if ($blank) return '';
        return ($val !== null && $val !== '' ) ? e($val) : 'N/A';
    };
    // "Age: N Years" pill from a DD-MMM-YYYY date of birth; empty on bad/missing date.
    $agePill = function ($dob) use ($blank) {
        if ($blank) return '';
        if (empty($dob)) return '';
        $ts = strtotime($dob);
        if ($ts === false) return '';
        $age = (new DateTime())->setTimestamp($ts)->diff(new DateTime('today'))->y;
        if ($age < 0 || $age > 150) return '';
        return '<span class="age-pill">Age: ' . $age . ' Year' . ($age === 1 ? '' : 's') . '</span>';
    };
    $g = $yatri->gurdwara->gurdwara_name ?? $yatri->gurdwara_name ?? null;
    // Group total = per-person price × number of people travelling.
    $unitPrice  = (int) preg_replace('/[^0-9]/', '', (string) $yatri->package_type);
    $people     = max(1, (int) $yatri->travellers_count);
    $amount     = $yatri->total_amount > 0 ? (int) round($yatri->total_amount) : ($yatri->amount ?: $unitPrice * $people);
    $companions = $yatri->companions ?? collect();
    $chrome     = $chrome ?? true;

    // Zelle details from Admin → Settings → Payment Settings. Absent when a
    // caller has not supplied them (the Form C export shares none of this).
    $zelle = ($zelle ?? []) + ['name' => null, 'phone' => null, 'email' => null, 'account' => null, 'instructions' => null, 'qr' => null];

    // The transaction number of the most recent recorded payment. `raseed_no`
    // on the balance table is where staff enter the Zelle confirmation number,
    // so a paid booking prints its own reference back to the traveller.
    $paidReference = '';
    if (!$blank) {
        $lastPayment = collect($yatri->payments ?? [])->last();
        $paidReference = $lastPayment->raseed_no ?? '';
    }
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: {{ $chrome ? '96px 34px 56px' : '100px 34px 60px' }}; }
    * { box-sizing: border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; color: #1c2541; font-size: 10px; margin: 0; }
    .brand-orange { color: #f54e18; }

    /* Fixed header/footer (repeat on every page in dompdf & print) */
    .pg-header { position: fixed; top: -88px; left: 0; right: 0; height: 70px; }
    .pg-header .ttl { font-size: 15px; font-weight: bold; color: #16233a; }
    .pg-header .sub { font-size: 8px; letter-spacing: 1px; color: #f54e18; }
    .pg-header .bid-label { font-size: 8px; color: #8a93a6; letter-spacing: 1px; }
    .pg-header .bid { background: #f54e18; color: #fff; font-weight: bold; padding: 4px 10px; border-radius: 4px; font-size: 11px; }
    .pg-header .rule { border-bottom: 2px solid #f54e18; margin-top: 10px; }
    .pg-footer { position: fixed; bottom: -56px; left: 0; right: 0; font-size: 8px; color: #8a93a6; }
    .pg-footer .rule { border-top: 1px solid #e3a07f; margin-bottom: 6px; }
    /* Just the page number: this dompdf build never resolves counter(pages) —
       it renders 0 — so "Page 1 of 0" is the only thing "of" can produce here.
       The merged exports get a real "Page X of Y" because FPDI stamps those
       after the fact, when the total is actually known. */
    .pagenum:after { content: counter(page); }

    h2.sec { background: #16233a; color: #fff; font-size: 10px; letter-spacing: .06em; text-transform: uppercase;
             padding: 4px 10px; margin: 8px 0 2px; border-radius: 2px; }
    table.kv { width: 100%; border-collapse: collapse; }
    table.kv td { vertical-align: top; padding: 0; }
    .col { width: 50%; vertical-align: top; }
    ul.fields { list-style: none; margin: 0; padding: 0 18px 0 0; }
    ul.fields li { display: block; border-bottom: 1px solid #eef0f4; padding: 2.5px 0; }
    ul.fields .lbl { color: #5a6273; font-family: DejaVu Sans, Arial, sans-serif; }
    /* Filled-in applicant data: distinct font (serif) + bold */
    ul.fields .val { float: right; text-align: right; font-family: "DejaVu Serif", Georgia, serif; font-weight: bold; color: #0f1830; }
    /* Age pill next to Date of Birth */
    .age-pill { float: right; margin-right: 8px; background: #fff2ec; color: #f54e18; border: 1px solid #f7c3af;
                font-family: DejaVu Sans, Arial, sans-serif; font-weight: bold; font-size: 8px;
                padding: 1px 7px; border-radius: 8px; }

    .top { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
    .top td { vertical-align: top; }
    .rec-title { color: #f54e18; font-weight: bold; letter-spacing: .05em; text-transform: uppercase; font-size: 11px; margin-bottom: 4px; }
    .photo-cell { text-align: right; padding-left: 14px; }
    .photo-box { width: 96px; height: 120px; border: 1px dashed #c4cad6; text-align: center; vertical-align: middle; color: #9aa3b2; font-size: 8px; }
    .photo-box img { display: block; width: 96px; height: 120px; margin: 0 auto; }
    .doc-grid { width: 100%; border-collapse: separate; border-spacing: 6px 0; table-layout: fixed; }
    .doc-grid td { width: 25%; vertical-align: top; padding-bottom: 6px; }
    .doc-card { border: 1px dashed #c4cad6; border-radius: 6px; text-align: center; padding: 9px 6px; }
    .doc-card .dt { font-size: 9px; color: #5a6273; text-transform: uppercase; letter-spacing: .04em; }
    .doc-card .di { font-size: 8px; color: #9aa3b2; margin-top: 4px; }
    .decl { background: #fbf3ef; border-left: 4px solid #f54e18; padding: 7px 10px; font-size: 9px; color: #4b5563; margin-top: 8px; }
    .sign td { padding-top: 18px; font-size: 9px; }
    .sign .line { border-top: 1px solid #1c2541; padding-top: 4px; width: 80%; }

    /* ---- Pay by Zelle block ----
       The QR has to survive being printed and then scanned off paper, so it is
       given 150px (~40 mm) and a white quiet zone rather than being squeezed
       into the margin. */
    .pay-block { width: 100%; border-collapse: collapse; margin-top: 4px; }
    .pay-block td { vertical-align: top; }
    .pay-qr { width: 170px; padding: 6px 14px 6px 0; text-align: center; }
    .pay-qr img { width: 150px; height: 150px; background: #fff; border: 1px solid #e3e6ec; padding: 6px; }
    .pay-cap { font-size: 8px; color: #5a6273; margin-top: 4px; }
    .pay-noqr { width: 150px; height: 150px; border: 1px dashed #c4cad6; color: #9aa3b2; font-size: 9px;
                text-align: center; padding-top: 62px; margin: 0 auto; }
    .pay-info { vertical-align: top; }
    .pay-note { background: #fbf3ef; border-left: 3px solid #f54e18; padding: 5px 8px; font-size: 8.5px;
                color: #4b5563; margin-top: 5px; }
    .pay-txn { margin-top: 8px; font-size: 9px; }
    .pay-txn .lbl { color: #5a6273; }
    .pay-txn-line { display: block; border-bottom: 1px solid #9aa3b2; height: 14px; margin-top: 3px;
                    font-family: "DejaVu Serif", Georgia, serif; font-weight: bold; color: #0f1830; }

    /* ---- Blank (hand-fill) mode ----
       The value spans are empty, so give them a width and a rule and they become
       something to write on. Rows are taller than the filled version because a
       pen needs more room than 10px type. */
    .blank ul.fields li { padding: 6px 0 2px; }
    .blank ul.fields .val { width: 54%; height: 13px; border-bottom: 1px solid #9aa3b2; }
    /* …except the Zelle details, which are printed answers, not blanks to fill. */
    .blank .pay-info ul.fields li { padding: 2.5px 0; }
    .blank .pay-info ul.fields .val { width: auto; height: auto; border-bottom: 0; }
    .blank .doc-card .di { color: #5a6273; }
    .blank .fill-cell { height: 17px; }
    .blank .hint { color: #8a93a6; font-size: 8px; font-style: italic; }
</style>
</head>
<body class="{{ $blank ? 'blank' : '' }}">

@if($chrome)
<div class="pg-header">
    <table style="width:100%"><tr>
        <td style="width:60%"><span class="ttl">YATRI BOOKING FORM</span><br><span class="sub">EXPLORE AND DISCOVER THE GLOBE</span></td>
        <td style="width:40%; text-align:right;">
            @if($blank)
                <span class="bid-label">BOOKING ID</span> <span style="display:inline-block;width:90px;border-bottom:1px solid #9aa3b2;">&nbsp;</span>
            @else
                <span class="bid-label">BOOKING ID</span> <span class="bid">{{ $yatri->yatri_id }}</span>
            @endif
        </td>
    </tr></table>
    <div class="rule"></div>
</div>
<div class="pg-footer">
    <div class="rule"></div>
    <table style="width:100%"><tr>
        {{-- Address must match config/schema.php and the site header exactly (NAP). --}}
        <td style="width:70%">KONNECT.US INC. — Explore and Discover the Globe · +1 (718) 908-9464 · 148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434</td>
        <td style="width:30%; text-align:right;">Page <span class="pagenum"></span></td>
    </tr></table>
</div>
@endif

{{-- ===== Top record summary + photo ===== --}}
@if($blank)
<div class="rec-title">Yatri Application — Please Complete in Block Capitals</div>
<div class="hint" style="margin-bottom:5px;">Dates in DD-MMM-YYYY format, e.g. 20-AUG-2026. Leave anything that does not apply blank.</div>
@else
<div class="rec-title">Pilgrimage Booking Record</div>
@endif
<table class="top">
    <tr>
        <td style="width:70%">
            <ul class="fields" style="padding-right:0;">
                <li><span class="lbl">Applicant</span><span class="val">{{ $v(trim($yatri->last_name.' '.$yatri->first_name)) }}</span></li>
                <li><span class="lbl">Booking ID</span><span class="val">{{ $v($yatri->yatri_id) }}</span></li>
                <li><span class="lbl">Submission Date</span><span class="val">{{ $blank ? '' : ($yatri->created_at ? $yatri->created_at->format('d F, Y') : 'N/A') }}</span></li>
                <li><span class="lbl">Total Amount</span><span class="val brand-orange">{{ $blank ? '' : '$'.number_format($amount ?: 0).($people > 1 ? ' ('.$people.' people)' : '') }}</span></li>
            </ul>
        </td>
        <td class="photo-cell" style="width:30%;">
            <table align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                    <td class="photo-box">
                        @if(!empty($photoSrc))
                            <img src="{{ $photoSrc }}">
                        @else
                            AFFIX<br>PASSPORT-SIZE<br>PHOTOGRAPH<br><br>35 mm × 45 mm
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ===== Booking Information ===== --}}
<h2 class="sec">Booking Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Submission Date</span><span class="val">{{ $blank ? '' : ($yatri->created_at ? $yatri->created_at->format('d F, Y') : 'N/A') }}</span></li>
        <li><span class="lbl">Occupancy</span><span class="val">{{ $blank ? '' : ($people > 1 ? 'Group ('.$people.' people)' : 'Single Occupancy') }}</span></li>
        <li><span class="lbl">Hotel Name</span><span class="val">{{ $v(optional($yatri->hotel)->name) }}</span></li>
        <li><span class="lbl">Ticket Type</span><span class="val">{{ $v(ucwords(str_replace('_',' ', $yatri->ticket_type))) }}</span></li>
        <li><span class="lbl">Bus #</span><span class="val">{{ $v(optional($yatri->bus)->bus_number) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Package Name</span><span class="val">{{ $v(optional($yatri->package)->name) }}</span></li>
        @if($blank || $people > 1)
        <li><span class="lbl">Price / Person</span><span class="val">{{ $blank ? '' : '$'.number_format($unitPrice) }}</span></li>
        <li><span class="lbl">People Travelling</span><span class="val">{{ $blank ? '' : $people }}</span></li>
        @endif
        <li><span class="lbl">Total Amount</span><span class="val brand-orange">{{ $blank ? '' : '$'.number_format($amount ?: 0) }}</span></li>
    </ul></td>
</tr></table>

{{-- ===== Personal Information ===== --}}
<h2 class="sec">Personal Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Applicant Name</span><span class="val">{{ $v(trim($yatri->last_name.' '.$yatri->first_name.' '.$yatri->middle_name)) }}</span></li>
        <li><span class="lbl">First Name</span><span class="val">{{ $v($yatri->first_name) }}</span></li>
        <li><span class="lbl">Middle Name</span><span class="val">{{ $v($yatri->middle_name) }}</span></li>
        <li><span class="lbl">Last Name</span><span class="val">{{ $v($yatri->last_name) }}</span></li>
        <li><span class="lbl">Religion</span><span class="val">{{ $v($yatri->religion) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Date of Birth</span><span class="val">{{ $v($yatri->dob) }}</span>{!! $agePill($yatri->dob) !!}</li>
        <li><span class="lbl">Place of Birth</span><span class="val">{{ $v($yatri->place_birth) }}</span></li>
        <li><span class="lbl">Gender</span><span class="val">{{ $v(ucfirst($yatri->gender)) }}</span></li>
        <li><span class="lbl">Marital Status</span><span class="val">{{ $v(ucfirst($yatri->marital_status)) }}</span></li>
    </ul></td>
</tr></table>

{{-- ===== Contact Information ===== --}}
<h2 class="sec">Contact Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Primary Email</span><span class="val">{{ $v($yatri->email) }}</span></li>
        <li><span class="lbl">Other Email</span><span class="val">{{ $v($yatri->other_email) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Primary Mobile</span><span class="val">{{ $v($yatri->phone) }}</span></li>
        <li><span class="lbl">Other Mobile</span><span class="val">{{ $v($yatri->other_phone) }}</span></li>
    </ul></td>
</tr></table>

{{-- ===== Passport & Visa ===== --}}
<h2 class="sec">Passport &amp; Visa Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Passport No</span><span class="val">{{ $v($yatri->passport) }}</span></li>
        <li><span class="lbl">Passport Type</span><span class="val">{{ $v($yatri->passport_type) }}</span></li>
        <li><span class="lbl">Issuing Authority</span><span class="val">{{ $v($yatri->issuing_authority) }}</span></li>
        <li><span class="lbl">Passport Country</span><span class="val">{{ $v($yatri->passport_country) }}</span></li>
        <li><span class="lbl">Traveller Nationality</span><span class="val">{{ $v($yatri->nationality) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Issue Date</span><span class="val">{{ $v($yatri->issue_date) }}</span></li>
        <li><span class="lbl">Expiry Date</span><span class="val">{{ $v($yatri->expiry_date) }}</span></li>
        <li><span class="lbl">Reference No</span><span class="val">{{ $v($yatri->reference_no) }}</span></li>
        <li><span class="lbl">Permanent Residence</span><span class="val">{{ $v($yatri->residence_country) }}</span></li>
        <li><span class="lbl">Green Card Expiry</span><span class="val">{{ $v($yatri->green_card_expiry_date) }}</span></li>
    </ul></td>
</tr></table>

{{-- ===== Family ===== --}}
<h2 class="sec">Family Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Father Name</span><span class="val">{{ $v($yatri->father_name) }}</span></li>
        <li><span class="lbl">Father Nationality</span><span class="val">{{ $v($yatri->father_nationality) }}</span></li>
        <li><span class="lbl">Mother Name</span><span class="val">{{ $v($yatri->mother_name) }}</span></li>
        <li><span class="lbl">Mother Nationality</span><span class="val">{{ $v($yatri->mother_nationality) }}</span></li>
    </ul></td>
    @if($blank || !empty($yatri->spouse_name) || $yatri->have_spouse === 'yes')
    <td class="col"><ul class="fields">
        <li><span class="lbl">Has Spouse</span><span class="val">{{ $v($yatri->have_spouse) }}</span></li>
        <li><span class="lbl">Spouse Name</span><span class="val">{{ $v($yatri->spouse_name) }}</span></li>
        <li><span class="lbl">Spouse Birth Country</span><span class="val">{{ $v($yatri->spouse_birth_country) }}</span></li>
        <li><span class="lbl">Spouse Nationality</span><span class="val">{{ $v($yatri->spouse_nationality) }}</span></li>
    </ul></td>
    @else
    <td class="col"></td>
    @endif
</tr></table>

{{-- ===== Travelling Companions ===== --}}
@if($blank || $companions->count())
@php
    // Taller cells on the blank form — a pen needs more room than 10px type.
    $cell = 'padding:3px 6px;border:1px solid #eef0f4;' . ($blank ? 'height:17px;' : '');
@endphp
<h2 class="sec">Travelling Companions &mdash; Keep Together for Hotel Rooms</h2>
<table class="kv" style="border-collapse:collapse;">
    <thead>
        <tr style="background:#fbf3ef;">
            <td style="padding:3px 6px;border:1px solid #eef0f4;"><b>#</b></td>
            <td style="padding:3px 6px;border:1px solid #eef0f4;"><b>Relation</b></td>
            <td style="padding:3px 6px;border:1px solid #eef0f4;"><b>Full Name</b></td>
            <td style="padding:3px 6px;border:1px solid #eef0f4;"><b>Country of Birth</b></td>
            <td style="padding:3px 6px;border:1px solid #eef0f4;"><b>Nationality</b></td>
            <td style="padding:3px 6px;border:1px solid #eef0f4;"><b>Passport No</b></td>
        </tr>
    </thead>
    <tbody>
        {{-- Primary traveller is the first person in the group. --}}
        <tr>
            <td style="{{ $cell }}">1</td>
            <td style="{{ $cell }}">Primary Traveller</td>
            <td style="{{ $cell }}">{{ $blank ? '' : trim($yatri->last_name.' '.$yatri->first_name) }}</td>
            <td style="{{ $cell }}">{{ $v($yatri->place_birth) }}</td>
            <td style="{{ $cell }}">{{ $v($yatri->nationality) }}</td>
            <td style="{{ $cell }}">{{ $v($yatri->passport) }}</td>
        </tr>
        @if($blank)
            {{-- Four spare rows: a separate application form is required for each
                 traveller, but the group has to be listed to be roomed together. --}}
            @for($i = 2; $i <= 5; $i++)
            <tr>
                <td style="{{ $cell }}">{{ $i }}</td>
                <td style="{{ $cell }}">&nbsp;</td>
                <td style="{{ $cell }}">&nbsp;</td>
                <td style="{{ $cell }}">&nbsp;</td>
                <td style="{{ $cell }}">&nbsp;</td>
                <td style="{{ $cell }}">&nbsp;</td>
            </tr>
            @endfor
        @else
            @foreach($companions as $i => $c)
            <tr>
                <td style="{{ $cell }}">{{ $i + 2 }}</td>
                <td style="{{ $cell }}">{{ $v($c->relation) }}</td>
                <td style="{{ $cell }}">{{ $v($c->full_name) }}</td>
                <td style="{{ $cell }}">{{ $v($c->birth_country) }}</td>
                <td style="{{ $cell }}">{{ $v($c->nationality) }}</td>
                <td style="{{ $cell }}">{{ $v($c->passport_no) }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endif

{{-- ===== Employment & Travel ===== --}}
<h2 class="sec">Employment &amp; Travel History</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Profession</span><span class="val">{{ $v($yatri->profession) }}</span></li>
        <li><span class="lbl">Travelled abroad (3 yrs)</span><span class="val">{{ $v(ucfirst($yatri->travel_history)) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Granted Pakistani visa before</span><span class="val">{{ $v(ucfirst($yatri->pk_travel_history)) }}</span></li>
        @if($blank || @$yatri->pk_travel_history == 'yes')
        <li><span class="lbl">Entered Pakistan via</span><span class="val">{{ $v($yatri->pk_entry_port) }}</span></li>
        <li><span class="lbl">Recent date of entry</span><span class="val">{{ $v($yatri->pk_entry_date) }}</span></li>
        @endif
    </ul></td>
</tr></table>

{{-- ===== Gurdwara & Reference ===== --}}
<h2 class="sec">Gurdwara &amp; Reference</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Gurdwara Name</span><span class="val">{{ $v($g) }}</span></li>
        <li><span class="lbl">Address</span><span class="val">{{ $v($yatri->address) }}</span></li>
        <li><span class="lbl">City</span><span class="val">{{ $v($yatri->city) }}</span></li>
        <li><span class="lbl">State</span><span class="val">{{ $v($yatri->state) }}</span></li>
        <li><span class="lbl">Zip</span><span class="val">{{ $v($yatri->zip) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Secretary / Pardan Name</span><span class="val">{{ $v($yatri->secetary_name) }}</span></li>
        <li><span class="lbl">Secretary / Pardan Phone</span><span class="val">{{ $v($yatri->secretary_phone) }}</span></li>
        <li><span class="lbl">Reference Person Name</span><span class="val">{{ $v($yatri->reference_name) }}</span></li>
        <li><span class="lbl">Reference Person Phone</span><span class="val">{{ $v($yatri->reference_phone) }}</span></li>
    </ul></td>
</tr></table>

{{-- ===== Uploaded Documents ===== --}}
<h2 class="sec">{{ $blank ? 'Documents to Attach' : 'Uploaded Documents' }}</h2>
@if($blank)
<div class="hint" style="margin:3px 0 5px;">Passport must be valid for at least 6 months. Green Card required if you are not a U.S. citizen.</div>
@endif
@php
    $docList = [
        ['PHOTO', $yatri->photo],
        ['PASSPORT', $yatri->us_passport],
        ['ID / DRIVING LICENSE', $yatri->driving_license],
        ['GREEN CARD', $yatri->green_card],
    ];
    // Additional documents uploaded with the submission (e.g. Birth Certificate, Bank Statement).
    foreach ($yatri->documents as $extra) {
        $docList[] = [strtoupper($extra->name), $extra->file];
    }
@endphp
<table class="doc-grid">
    @foreach(array_chunk($docList, 4) as $row)
    <tr>
        @foreach($row as $d)
        <td>
            <div class="doc-card">
                <div class="dt">{{ $d[0] }}</div>
                <div class="di">@if($blank)&#9744; attached @elseif(!empty($d[1])){{ strtoupper(pathinfo($d[1], PATHINFO_EXTENSION)) }} · attached @else not provided @endif</div>
            </div>
        </td>
        @endforeach
        @for($i = count($row); $i < 4; $i++)<td></td>@endfor
    </tr>
    @endforeach
</table>

{{-- ===== Pay by Zelle ===== --}}
@if(!empty($zelle['qr']) || !empty($zelle['phone']) || !empty($zelle['name']))
<h2 class="sec">How to Pay &mdash; Scan with Your Bank's App</h2>
<table class="pay-block"><tr>
    <td class="pay-qr">
        @if(!empty($zelle['qr']))
            <img src="{{ $zelle['qr'] }}" alt="Zelle QR code">
            <div class="pay-cap">Open Zelle in your bank's app and scan</div>
        @else
            <div class="pay-noqr">QR code<br>not set up</div>
        @endif
    </td>
    <td class="pay-info">
        <ul class="fields" style="padding-right:0;">
            @if(!empty($zelle['name']))<li><span class="lbl">Pay to</span><span class="val">{{ $zelle['name'] }}</span></li>@endif
            @if(!empty($zelle['phone']))<li><span class="lbl">Zelle phone</span><span class="val">{{ $zelle['phone'] }}</span></li>@endif
            @if(!empty($zelle['email']))<li><span class="lbl">Zelle email</span><span class="val">{{ $zelle['email'] }}</span></li>@endif
            @if(!empty($zelle['account']))<li><span class="lbl">Account</span><span class="val">{{ $zelle['account'] }}</span></li>@endif
        </ul>
        @if(!empty($zelle['instructions']))
        <div class="pay-note">{{ $zelle['instructions'] }}</div>
        @endif
        <div class="pay-txn">
            <span class="lbl">Transaction / confirmation number once paid</span>
            <span class="pay-txn-line">{{ $paidReference }}</span>
        </div>
    </td>
</tr></table>
@endif

{{-- ===== Payment ===== --}}
<h2 class="sec">Payment Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Payment Type</span><span class="val">{{ $v($yatri->payment_type) }}</span></li>
        <li><span class="lbl">Bank Receipt</span><span class="val">{{ $v($yatri->bank_receipt) }}</span></li>
        <li><span class="lbl">Amount</span><span class="val">{{ $blank ? '' : ($yatri->amount ? '$'.$yatri->amount : 'N/A') }}</span></li>
        <li><span class="lbl">Transaction / Confirmation #</span><span class="val">{{ $blank ? '' : ($paidReference ?: 'N/A') }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Routing Number</span><span class="val">{{ $v($yatri->routing_number) }}</span></li>
        <li><span class="lbl">Account Number</span><span class="val">{{ $v($yatri->account_number) }}</span></li>
        <li><span class="lbl">Payment Status</span><span class="val">{{ $v(ucfirst($yatri->payment_status)) }}</span></li>
    </ul></td>
</tr></table>

<div class="decl">
    <b>Declaration:</b> I hereby declare that the information provided above is true and correct to the best of my knowledge.
    I authorize KONNECT.US INC. to process this booking on my behalf and agree to the applicable terms and conditions.
</div>
<table class="sign" style="width:100%"><tr>
    <td style="width:50%"><div class="line">Applicant Signature &amp; Date</div></td>
    <td style="width:50%"><div class="line">Authorized Signature (KONNECT.US INC.)</div></td>
</tr></table>

@if(!empty($autoprint))
<script>window.onload = function () { window.print(); };</script>
@endif
</body>
</html>
