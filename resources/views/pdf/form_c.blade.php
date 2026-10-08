@php
    // Only two things on this certificate come from the yatri's record: the
    // full name and the passport number. Everything else is the office's own
    // fixed wording for the group (FormC-Updated.pdf, 2026-10-08) or a line
    // left blank for the Registration Officer to write on.
    $fill = function ($val, $minWidth = 60) {
        $val = ($val !== null && trim((string) $val) !== '') ? e(trim((string) $val)) : '&nbsp;';
        return '<span class="fl" style="min-width:' . $minWidth . 'px">' . $val . '</span>';
    };

    $fullName   = trim(preg_replace('/\s+/', ' ', ($yatri->first_name ?? '') . ' ' . ($yatri->middle_name ?? '') . ' ' . ($yatri->last_name ?? '')));
    $passportNo = $yatri->passport ?? '';
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 125px 80px 70px; }
    * { box-sizing: border-box; }
    body { font-family: Helvetica, Arial, sans-serif; color: #000; font-size: 12px; line-height: 2.1; }
    .center { text-align: center; }
    .center p { margin: 0; line-height: 1.9; }
    .title { font-weight: bold; font-size: 11px; margin-bottom: 6px !important; }
    p { margin: 0; }
    .block { margin-top: 26px; text-align: left; }
    ul.notes { margin: 22px 0 0; padding-left: 40px; }
    ul.notes li { text-align: left; }
    /* Inline fill-in: value sits on an underline */
    .fl { display: inline-block; border-bottom: 1px solid #000; text-align: center;
          padding: 0 4px; line-height: 1.2; font-weight: bold; }
    u { text-decoration: underline; }
    sup { font-size: 8px; line-height: 1; }
    .sign { margin-top: 26px; width: 100%; border-collapse: collapse; }
    .sign td { padding: 0; vertical-align: top; }
</style>
</head>
<body>

<div class="center">
    <p class="title">Form &lsquo;C&rsquo;</p>
    <p>The Registration of Foreigners Rules, 1966 (See rule)</p>
    <p>Temporary Certificate of Registration</p>
    <p>Serial No.{!! $fill('', 90) !!}/2026</p>
</div>

<p class="block">
    Miss /Mr.{!! $fill($fullName, 200) !!} Foreigner of <b>INDIAN</b> Nationality holding Passport No.
    {!! $fill($passportNo, 90) !!} issued at <b><u>Indian Consulate, New York</u></b> arrived Pakistan on,
    <u>21<sup>st</sup> November 2026</u> by flight No.{!! $fill('', 70) !!} (Mode of transport) is proceeding to
    <b><u>ISLAMABAD</u></b> where her/his residential address would be: <b><u>Best Western Premier Hotel</u></b>
    address: <u>6 Club Road, Islamabad.</u>
    She/he has been temporarily registered at IIAP ISLAMABAD FIA CHECK POST, IIAP ISB., and is
    directed to report (place of arrival) the Registration Officer at DPO/CPO OFFICE as soon as
    possible after his / her arrival at the place of stay but within 24hrs / 07 days of the date of issue
    of her / his certificate of the purpose of receiving her / his certificate of Registration in part-II of
    from &ldquo;B&rdquo;.
</p>

<ul class="notes">
    <li>For a period of 24hrs / 07 days from the date of issue of this certificate or until the
        report prescribed above has been made whichever, is less, this Form will be deemed to
        be a Certificate of Registration Officer, Magistrate or Police Officer not below the rank
        of Head Constable.</li>
    <li>If for any reason the report prescribed in the paragraph (1) cannot be made within 24hrs
        /07 days as required by paragraph (2) above, the holder of this from is directed to report
        in person at the office of the undersigned or the nearest Registration Office and to
        comply with such direction as to Registration as may then be given.</li>
    <li>The contents of this Form have been explained to the holder, thereof.</li>
</ul>

<table class="sign">
    <tr>
        <td style="width:56%;">Place: Islamabad International Airport</td>
        <td style="width:44%;">Dated:</td>
    </tr>
    <tr>
        <td style="padding-top:28px;">&nbsp;</td>
        <td style="padding-top:28px;">Seal &amp; Signature of Registration Officer</td>
    </tr>
</table>

@if(!empty($autoprint))
<script>window.onload = function () { window.print(); };</script>
@endif
</body>
</html>
