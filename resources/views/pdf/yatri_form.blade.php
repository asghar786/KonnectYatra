@php
    // Helpers
    $v = function ($val) { return ($val !== null && $val !== '' ) ? e($val) : 'N/A'; };
    $g = $yatri->gurdwara->gurdwara_name ?? $yatri->gurdwara_name ?? null;
    $amount = $yatri->amount ?: preg_replace('/[^0-9]/', '', (string) $yatri->package_type);
    $chrome = $chrome ?? true;
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
    .pagenum:after { content: counter(page) " of " counter(pages); }

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

    .top { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
    .top td { vertical-align: top; }
    .rec-title { color: #f54e18; font-weight: bold; letter-spacing: .05em; text-transform: uppercase; font-size: 11px; margin-bottom: 4px; }
    .photo-box { width: 96px; height: 120px; border: 1px dashed #c4cad6; text-align: center; color: #9aa3b2; font-size: 8px; }
    .photo-box img { width: 94px; height: 118px; object-fit: cover; }
    .doc-grid { width: 100%; border-collapse: separate; border-spacing: 6px 0; table-layout: fixed; }
    .doc-grid td { width: 25%; vertical-align: top; padding-bottom: 6px; }
    .doc-card { border: 1px dashed #c4cad6; border-radius: 6px; text-align: center; padding: 9px 6px; }
    .doc-card .dt { font-size: 9px; color: #5a6273; text-transform: uppercase; letter-spacing: .04em; }
    .doc-card .di { font-size: 8px; color: #9aa3b2; margin-top: 4px; }
    .decl { background: #fbf3ef; border-left: 4px solid #f54e18; padding: 7px 10px; font-size: 9px; color: #4b5563; margin-top: 8px; }
    .sign td { padding-top: 18px; font-size: 9px; }
    .sign .line { border-top: 1px solid #1c2541; padding-top: 4px; width: 80%; }
</style>
</head>
<body>

@if($chrome)
<div class="pg-header">
    <table style="width:100%"><tr>
        <td style="width:60%"><span class="ttl">YATRI BOOKING FORM</span><br><span class="sub">EXPLORE AND DISCOVER THE GLOBE</span></td>
        <td style="width:40%; text-align:right;"><span class="bid-label">BOOKING ID</span> <span class="bid">{{ $yatri->yatri_id }}</span></td>
    </tr></table>
    <div class="rule"></div>
</div>
<div class="pg-footer">
    <div class="rule"></div>
    <table style="width:100%"><tr>
        <td style="width:70%">KONNECT.US INC. — Explore and Discover the Globe · +1 (718) 908-9464 · 18502 Hillside Avenue, Jamaica, NY 11432</td>
        <td style="width:30%; text-align:right;">Page <span class="pagenum"></span></td>
    </tr></table>
</div>
@endif

{{-- ===== Top record summary + photo ===== --}}
<div class="rec-title">Pilgrimage Booking Record</div>
<table class="top">
    <tr>
        <td style="width:70%">
            <ul class="fields" style="padding-right:0;">
                <li><span class="lbl">Applicant</span><span class="val">{{ $v(trim($yatri->last_name.' '.$yatri->first_name)) }}</span></li>
                <li><span class="lbl">Booking ID</span><span class="val">{{ $v($yatri->yatri_id) }}</span></li>
                <li><span class="lbl">Submission Date</span><span class="val">{{ $yatri->created_at ? $yatri->created_at->format('d F, Y') : 'N/A' }}</span></li>
                <li><span class="lbl">Total Amount</span><span class="val brand-orange">${{ $amount ?: '0' }}</span></li>
            </ul>
        </td>
        <td style="width:30%; text-align:right; padding-left:14px;">
            <div class="photo-box">
                @if(!empty($photoSrc))
                    <img src="{{ $photoSrc }}">
                @else
                    AFFIX<br>PASSPORT-SIZE<br>PHOTOGRAPH<br><br>35 mm × 45 mm
                @endif
            </div>
        </td>
    </tr>
</table>

{{-- ===== Booking Information ===== --}}
<h2 class="sec">Booking Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Submission Date</span><span class="val">{{ $yatri->created_at ? $yatri->created_at->format('d F, Y') : 'N/A' }}</span></li>
        <li><span class="lbl">Package Type</span><span class="val">Single Occupancy</span></li>
        <li><span class="lbl">Hotel Name</span><span class="val">{{ $v(optional($yatri->hotel)->name) }}</span></li>
        <li><span class="lbl">Ticket Type</span><span class="val">{{ $v(ucwords(str_replace('_',' ', $yatri->ticket_type))) }}</span></li>
        <li><span class="lbl">Bus #</span><span class="val">{{ $v(optional($yatri->bus)->bus_number) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Package Name</span><span class="val">{{ $v(optional($yatri->package)->name) }}</span></li>
        <li><span class="lbl">Total Amount</span><span class="val brand-orange">${{ $amount ?: '0' }}</span></li>
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
        <li><span class="lbl">Date of Birth</span><span class="val">{{ $v($yatri->dob) }}</span></li>
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
    <td class="col"><ul class="fields">
        <li><span class="lbl">Has Spouse</span><span class="val">{{ $v($yatri->have_spouse) }}</span></li>
        <li><span class="lbl">Spouse Name</span><span class="val">{{ $v($yatri->spouse_name) }}</span></li>
        <li><span class="lbl">Spouse Birth Country</span><span class="val">{{ $v($yatri->spouse_birth_country) }}</span></li>
        <li><span class="lbl">Spouse Nationality</span><span class="val">{{ $v($yatri->spouse_nationality) }}</span></li>
    </ul></td>
</tr></table>

{{-- ===== Employment & Travel ===== --}}
<h2 class="sec">Employment &amp; Travel History</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Profession</span><span class="val">{{ $v($yatri->profession) }}</span></li>
        <li><span class="lbl">Travelled abroad (3 yrs)</span><span class="val">{{ $v(ucfirst($yatri->travel_history)) }}</span></li>
    </ul></td>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Granted Pakistani visa before</span><span class="val">{{ $v(ucfirst($yatri->pk_travel_history)) }}</span></li>
        @if(@$yatri->pk_travel_history == 'yes')
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
<h2 class="sec">Uploaded Documents</h2>
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
                <div class="di">@if(!empty($d[1])){{ strtoupper(pathinfo($d[1], PATHINFO_EXTENSION)) }} · attached @else not provided @endif</div>
            </div>
        </td>
        @endforeach
        @for($i = count($row); $i < 4; $i++)<td></td>@endfor
    </tr>
    @endforeach
</table>

{{-- ===== Payment ===== --}}
<h2 class="sec">Payment Information</h2>
<table class="kv"><tr>
    <td class="col"><ul class="fields">
        <li><span class="lbl">Payment Type</span><span class="val">{{ $v($yatri->payment_type) }}</span></li>
        <li><span class="lbl">Bank Receipt</span><span class="val">{{ $v($yatri->bank_receipt) }}</span></li>
        <li><span class="lbl">Amount</span><span class="val">{{ $yatri->amount ? '$'.$yatri->amount : 'N/A' }}</span></li>
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
