{{-- The travelling list (dompdf, Letter portrait) — the office's own
     spreadsheet as a PDF: logo, the boxed title, then Yatri # / Yatri Name /
     Nationality / Passport #, ticked yatris only, in the order set on
     admin/quick-yatri/yatri-list. The heading row repeats on every page
     (dompdf repeats a <thead>). Tables only — dompdf cannot lay out flex. --}}
@php
    use App\Support\YatriList;
    $logo = public_path('assets2/id/logo.png');
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 28pt 40pt 34pt; }
    body { font-family: "DejaVu Sans", Helvetica, Arial, sans-serif; font-size: 9.6pt; color: #1f2a44; margin: 0; }

    .logo { height: 46pt; margin-bottom: 8pt; }
    .title { border: 1.6pt solid #2f6f62; padding: 7pt 14pt; text-align: center; font-size: 12pt; font-weight: bold; color: #1f3864; line-height: 1.3; }

    table.list { width: 100%; border-collapse: collapse; margin-top: 0; }
    table.list th { background: #1f2a44; color: #fff; font-size: 10pt; font-weight: bold; padding: 6pt 6pt; border: .6pt solid #5a6785; text-align: center; }
    table.list td { padding: 4.5pt 8pt; border: .6pt solid #bfc6d4; vertical-align: middle; }
    table.list tr { page-break-inside: avoid; }
    .sn { text-align: center; width: 50pt; }
    .nm { font-weight: bold; color: #16294d; }
    .c { text-align: center; }
    .pp { text-align: center; letter-spacing: .3pt; }

    .foot { position: fixed; bottom: -20pt; left: 0; right: 0; font-size: 7pt; color: #8a91a0; }
    .foot .r { float: right; }
    .foot .pg:after { content: counter(page); }
</style>
</head>
<body>
    <div class="foot">
        Konnect.US, Inc. &middot; {{ count($yatris) }} yatri{{ count($yatris) === 1 ? '' : 's' }}
        <span class="r">Page <span class="pg"></span></span>
    </div>

    @if(is_file($logo))<img class="logo" src="{{ $logo }}" alt="Konnect.US, Inc.">@endif
    <div class="title">{{ $title }}</div>

    <table class="list">
        <thead>
            <tr>
                <th>Yatri #</th>
                <th>Yatri Name</th>
                <th>Nationality</th>
                <th>Passport #</th>
            </tr>
        </thead>
        <tbody>
            @foreach($yatris as $i => $yatri)
                <tr>
                    <td class="sn">{{ $i + 1 }}</td>
                    <td class="nm">{{ strtoupper(trim((string) $yatri->applicant_name)) }}</td>
                    <td class="c">{{ YatriList::nationality($yatri->citizenship) }}</td>
                    <td class="pp">{{ strtoupper(trim((string) $yatri->passport_no)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
