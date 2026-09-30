{{-- Hotel check-in sheet (dompdf, Letter landscape). Page 1+: the check-in
     list, one <tbody> per room so a room never splits across pages; then the
     Room Summary. Tables only — dompdf cannot lay out flex or grid.
     Trap: counter(pages) resolves to 0 in this dompdf build, so the footer
     prints the page number alone. --}}
@php
    use App\Support\HotelCheckin;
    use App\Support\Business;

    $rooms = [];
    foreach ($list['rows'] as $i => $row) {
        $row['sn'] = $i + 1;
        $rooms[$row['room']][] = $row;
    }
    $count = ['double' => 0, 'twin' => 0, 'triple' => 0];
    foreach ($rooms as $members) {
        if (isset($count[$members[0]['bed']])) $count[$members[0]['bed']]++;
    }
    $nights  = HotelCheckin::nights($list['check_in'], $list['check_out']);
    $logo    = public_path('assets2/id/logo.png');
    $initials = function ($name) {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $out = strtoupper(substr($parts[0] ?? '', 0, 1) . (count($parts) > 1 ? substr(end($parts), 0, 1) : ''));
        return $out !== '' ? $out : '?';
    };
    $title = $list['hotel'] . ' — Check-In List';
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 20pt 28pt 30pt; }
    * { box-sizing: border-box; }
    body { font-family: "DejaVu Sans", Helvetica, Arial, sans-serif; font-size: 8.6pt; color: #1f2a44; margin: 0; }

    /* ---- Title: the three lines of the office's own sheet ---- */
    .head { width: 100%; border-collapse: collapse; }
    .head td { vertical-align: middle; padding: 0; }
    .head .logo { width: 150pt; }
    .head .logo img { height: 34pt; }
    .head .mid { text-align: center; }
    .head .side { width: 150pt; text-align: right; font-size: 7pt; color: #6b7689; line-height: 1.45; }
    .head .side img { width: 54pt; height: 28.4pt; border: .6pt solid #d5dbe6; }
    .head .side .from { font-size: 7.2pt; font-weight: bold; color: #16294d; letter-spacing: .4pt; margin-top: 3pt; text-transform: uppercase; }
    .eyebrow { font-size: 6.8pt; letter-spacing: 2.4pt; color: #b22234; font-weight: bold; text-transform: uppercase; }
    .brand { font-size: 18pt; font-weight: bold; color: #16294d; letter-spacing: .6pt; margin-top: 1pt; }
    /* Stars-and-stripes band under the title: red, white, red, then navy. */
    .band { width: 100%; border-collapse: collapse; margin-top: 6pt; }
    .band td { padding: 0; height: 2.2pt; font-size: 0; line-height: 0; }
    .title { font-size: 12.5pt; font-weight: bold; color: #1a3fa0; margin-top: 2pt; }
    .dates { font-size: 9.6pt; font-weight: bold; color: #1f2a44; margin-top: 3pt; }
    .dates .n { color: #b22234; }


    /* ---- The list ---- */
    table.list { width: 100%; border-collapse: collapse; }
    table.list thead th { background: #16294d; color: #fff; font-size: 6.6pt; font-weight: bold; letter-spacing: .4pt; text-transform: uppercase; padding: 5pt 5pt; white-space: nowrap; text-align: left; border-right: .6pt solid #2c4170; }
    table.list thead th:last-child { border-right: 0; }
    table.list thead th.c { text-align: center; }
    table.list tbody { page-break-inside: avoid; }
    table.list td { padding: 1.5pt 5pt; height: 16pt; border-bottom: .6pt solid #dfe4ee; border-right: .6pt solid #e7ebf2; vertical-align: middle; }
    table.list td:last-child { border-right: 0; }
    table.list tbody.alt td { background: #f6f8fc; }
    table.list tbody td.roomcell { border-left: 2.5pt solid #b9c3d6; }
    table.list tbody.shared td.roomcell { border-left-color: #b22234; }
    table.list tbody tr.last td { border-bottom: 1pt solid #b9c3d6; }
    .c { text-align: center; }
    .sn { font-weight: bold; color: #6b7689; text-align: center; }
    .ph { width: 22pt; text-align: center; padding: 2pt !important; }
    .ph img { width: 15pt; height: 15pt; border-radius: 3pt; }
    /* A nested table, not a div: a bare div stretches to the row in dompdf. */
    table.ini { width: 15pt; border-collapse: collapse; margin: 0 auto; }
    table.ini td { width: 15pt; height: 15pt; padding: 0 !important; border: 0 !important; background: #e6ecfa !important; color: #1a3fa0; font-weight: bold; font-size: 6.6pt; text-align: center; vertical-align: middle; border-radius: 3pt; }
    .nm { font-weight: bold; font-size: 9pt; color: #16294d; }
    .nat { font-weight: bold; color: #1a3fa0; text-align: center; }
    .pp { font-family: "DejaVu Sans Mono", monospace; font-size: 8.4pt; letter-spacing: .2pt; }
    .room { text-align: center; }
    .room .b { display: inline-block; min-width: 16pt; padding: 2pt 5pt; background: #16294d; color: #fff; font-weight: bold; font-size: 9.5pt; border-radius: 3pt; }
    tbody.shared .room .b { background: #b22234; }
    .bed { text-align: center; font-weight: bold; }
    .hroom { text-align: center; font-family: "DejaVu Sans Mono", monospace; font-weight: bold; font-size: 9.5pt; }
    .write { }

    /* ---- Footer on every page ---- */
    .foot { position: fixed; bottom: -22pt; left: 0; right: 0; height: 14pt; font-size: 6.8pt; color: #8a91a0; border-top: .6pt solid #dfe4ee; padding-top: 3pt; }
    .foot .pg:after { content: "Page " counter(page); }
    .foot table { width: 100%; border-collapse: collapse; }
    .foot td { padding: 0; }

    .pb { page-break-before: always; }
    .summary-note { font-size: 7.6pt; color: #6b7689; margin: -3pt 0 8pt; text-align: center; }
    table.sum td.names { font-size: 8.8pt; line-height: 1.5; }
    table.sum td.names .no { color: #8a91a0; font-weight: bold; font-size: 7.6pt; }
    table.sum td { height: 24pt; }
</style>
</head>
<body>
<div class="foot">
    <table><tr>
        <td>Konnect.US Inc. &middot; {{ Business::addressLine() }}@if(Business::phone()) &middot; {{ Business::phone() }}@endif</td>
        <td style="text-align:center">{{ $list['city'] }} Hotel Check-In List</td>
        <td style="text-align:right"><span class="pg"></span></td>
    </tr></table>
</div>

@include('pdf._hotel_checkin_head', ['sub' => $title])



<table class="list">
    <thead>
        <tr>
            <th class="c" style="width:38pt">Yatri #</th>
            <th class="c" style="width:26pt">Photo</th>
            <th>Yatri Name</th>
            <th class="c" style="width:52pt">Nationality</th>
            <th style="width:78pt">Passport No.</th>
            <th class="c" style="width:36pt">Room</th>
            <th class="c" style="width:78pt">Room # by Hotel</th>
            <th class="c" style="width:52pt">Bed Type</th>
            <th class="c" style="width:70pt">Staff Initial</th>
            <th style="width:100pt">Complaint</th>
        </tr>
    </thead>
    @foreach($rooms as $no => $members)
        @php $n = count($members); @endphp
        <tbody class="{{ $loop->iteration % 2 === 0 ? 'alt' : '' }} {{ $n > 1 ? 'shared' : '' }}">
            @foreach($members as $m)
                @php $y = $m['yatri']; @endphp
                <tr class="{{ $loop->last ? 'last' : '' }}">
                    <td class="sn {{ $loop->first ? '' : '' }} roomcell">{{ $m['sn'] }}</td>
                    <td class="ph">
                        @if($y->photoPath())
                            <img src="{{ $y->photoPath() }}" alt="">
                        @else
                            <table class="ini"><tr><td>{{ $initials($y->applicant_name) }}</td></tr></table>
                        @endif
                    </td>
                    <td class="nm">{{ $y->applicant_name }}</td>
                    <td class="nat">{{ HotelCheckin::nationality($y->citizenship) }}</td>
                    <td class="pp">{{ $y->passport_no }}</td>
                    @if($loop->first)
                        <td class="room" rowspan="{{ $n }}"><span class="b">{{ $no }}</span></td>
                        <td class="hroom" rowspan="{{ $n }}">{{ $m['hotel_room'] }}</td>
                        <td class="bed" rowspan="{{ $n }}">{{ HotelCheckin::bedShort($m['bed']) }}</td>
                    @endif
                    <td class="write"></td>
                    <td class="write"></td>
                </tr>
            @endforeach
        </tbody>
    @endforeach
</table>

{{-- Room Summary — the office sheet's second tab: one line per room. --}}
<div class="pb"></div>
@include('pdf._hotel_checkin_head', ['sub' => $list['city'] . ' Hotel Room Summary'])
<table class="list sum">
    <thead>
        <tr>
            <th class="c" style="width:44pt">Room</th>
            <th class="c" style="width:80pt">Room # by Hotel</th>
            <th class="c" style="width:62pt">Bed Type</th>
            <th>Yatri # / Names</th>
            <th class="c" style="width:100pt">Staff Initial</th>
        </tr>
    </thead>
    @foreach($rooms as $no => $members)
        <tbody class="{{ $loop->iteration % 2 === 0 ? 'alt' : '' }} {{ count($members) > 1 ? 'shared' : '' }}">
            <tr class="last">
                <td class="room roomcell"><span class="b">{{ $no }}</span></td>
                <td class="hroom">{{ $members[0]['hotel_room'] }}</td>
                <td class="bed">{{ HotelCheckin::bedShort($members[0]['bed']) }}</td>
                <td class="names">
                    @foreach($members as $m)<span class="no">{{ $m['sn'] }}.</span> {{ $m['yatri']->applicant_name }}@if(!$loop->last) &nbsp;&middot;&nbsp; @endif @endforeach
                </td>
                <td class="write"></td>
            </tr>
        </tbody>
    @endforeach
</table>
</body>
</html>
