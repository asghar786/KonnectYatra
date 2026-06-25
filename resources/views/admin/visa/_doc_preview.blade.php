@php
    // $url = full asset URL to the uploaded document.
    $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? $url, PATHINFO_EXTENSION));
    $isPdf = $ext === 'pdf';
@endphp
@if($isPdf)
    <a href="{{ $url }}" target="_blank" rel="noopener" title="Open PDF in new tab">
        <div style="position:relative; width:170px; height:140px; border:1px solid #ddd; overflow:hidden; background:#f7f7f7;">
            <iframe src="{{ $url }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                    style="width:170px; height:140px; border:0; pointer-events:none;" loading="lazy"></iframe>
            <span style="position:absolute; bottom:4px; right:4px; background:#d9534f; color:#fff; font-size:10px; font-weight:600; padding:1px 6px; border-radius:3px;">PDF</span>
        </div>
    </a>
@else
    <a href="{{ $url }}" data-lightbox="image-gallery">
        <img src="{{ $url }}" style="width: 170px; height: 140px; object-fit: cover; border:1px solid #ddd;">
    </a>
@endif
