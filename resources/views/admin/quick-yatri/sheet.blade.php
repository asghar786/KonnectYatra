{{-- The printable Quick Yatri sheet — blank, or a saved record.

     Rendered for the browser rather than dompdf: the approved design is built
     on flexbox and CSS grid throughout, which dompdf cannot lay out, and the
     browser's own print engine reproduces it exactly. Print -> "Save as PDF"
     produces the downloadable file.

     Expects: $row, $mode ('blank' | 'print'), $autoPrint. --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $mode === 'blank' ? 'Yatri Application Form — Blank' : 'Yatri Application — ' . $row->applicant_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;700;800&family=Archivo+Narrow:wght@700&family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @include('admin.quick-yatri._sheet-css')
    <style type="text/css">
        @page{size:letter; margin:0}
        html,body{margin:0; padding:0; background:#525659}
        .qy-page{width:8.5in; height:11in; margin:0 auto 14px; box-shadow:0 6px 24px rgba(0,0,0,.35)}

        .qy-toolbar{position:sticky; top:0; z-index:5; background:#1f2a44; color:#fff; padding:12px 18px; display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; font-family:'Open Sans',Helvetica,sans-serif}
        .qy-toolbar h1{margin:0; font-size:15px; font-weight:600; letter-spacing:.01em}
        .qy-toolbar .sub{display:block; font-size:12px; font-weight:400; color:#aab3c5; margin-top:2px}
        .qy-toolbar-actions{display:flex; gap:9px; flex-wrap:wrap}
        .qy-tb-btn{display:inline-flex; align-items:center; gap:7px; border:none; border-radius:9px; padding:9px 16px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; transition:transform .12s, box-shadow .12s}
        .qy-tb-btn:hover{transform:translateY(-1px)}
        .qy-tb-btn.primary{background:#f54e18; color:#fff}
        .qy-tb-btn.ghost{background:rgba(255,255,255,.12); color:#fff}
        .qy-hint{max-width:8.5in; margin:14px auto 0; color:#d7dbe4; font-size:12.5px; font-family:'Open Sans',Helvetica,sans-serif; text-align:center}

        @media print{
            body{background:#fff}
            .qy-noprint{display:none !important}
            .qy-page{margin:0; box-shadow:none; page-break-after:always; break-after:page}
            .qy-page:last-of-type{page-break-after:auto; break-after:auto}
        }
    </style>
</head>
<body>

<div class="qy-toolbar qy-noprint">
    <h1>
        {{ $mode === 'blank' ? 'Blank Yatri Application Form' : 'Yatri Application — ' . $row->applicant_name }}
        <span class="sub">Print, or choose &ldquo;Save as PDF&rdquo; as the destination to download it.</span>
    </h1>
    <div class="qy-toolbar-actions">
        <a href="{{ route('quick-yatri') }}" class="qy-tb-btn ghost">&larr; Back to Quick Yatri</a>
        <button type="button" class="qy-tb-btn primary" onclick="window.print()">&#128424; Print / Save as PDF</button>
    </div>
</div>

@include('admin.quick-yatri._sheet-body', ['row' => $row, 'mode' => $mode])
@include('admin.quick-yatri._page-2')

<div class="qy-hint qy-noprint">Letter size, 2 pages. For an exact match set margins to &ldquo;None&rdquo; and enable background graphics in the print dialog.</div>

@if($autoPrint)
<script>window.addEventListener('load', function () { window.print(); });</script>
@endif

</body>
</html>
