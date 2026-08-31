{{-- Styling for the Quick Yatri sheet. Shared by the printable page and the
     admin entry screen so both render the identical layout. --}}
<style type="text/css">
    .qy-page{
        font-family:'Open Sans',Helvetica,sans-serif;
        color:#111;
        background:#fff;
        box-sizing:border-box;
        display:flex;
        flex-direction:column;
        /* Without this, a browser printing with "background graphics" off
           drops every fill colour below (the blue option bars, the price
           table header) and leaves only a soft, edgeless grey on paper. This
           is inherited, so it covers the whole sheet from one declaration. */
        print-color-adjust:exact;
        -webkit-print-color-adjust:exact;
    }
    .qy-page-1{padding:0.15in 0.3in; gap:2pt; font-size:8.6pt; line-height:1.3}  /* padding and gap are trimmed on purpose: page 1 is a fixed 11in box with
     no slack, and the height freed here is what the notes/QR row grew
     into (it was the Uploads/Signature/QR row until 2026-08-27). The 17 field rows are deliberately NOT tightened - they are written
     in by hand. */
    .qy-page-2{padding:0.3in 0.42in; gap:8pt; font-size:9.2pt; line-height:1.32}
    .qy-page a{color:#1a3fa0}

    /* Photo box */
    .qy-photo{width:1.45in; border:2px solid #1a3fa0; border-radius:9pt; display:flex; align-items:center; justify-content:center; font-size:11pt; letter-spacing:0.04em; color:#333; overflow:hidden; flex:0 0 auto}
    .qy-photo img{width:100%; height:100%; object-fit:cover; display:block}
    .qy-photo-label{width:100%; height:100%; margin:0; display:flex; align-items:center; justify-content:center; cursor:pointer; text-align:center}
    .qy-photo-label small{display:block; font-size:7pt; letter-spacing:0; color:#8a93a5; margin-top:3pt; text-transform:none}
    .qy-photo-label:hover{background:#f5f8ff}

    /* Blue option bars — a border of their own so the box reads as a bounded
       group even where a printer doesn't reproduce the fill colour. */
    .qy-bar{background:#1a3fa0; color:#fff; border:1.25pt solid #111; border-radius:5pt; padding:5pt 9pt; display:flex; align-items:center; gap:9pt; font-family:'Archivo Narrow',sans-serif; font-weight:700; font-size:12pt; line-height:1.1}
    .qy-bar-ico{width:20pt; height:20pt; border-radius:50%; background:#fff; color:#1a3fa0; display:inline-flex; align-items:center; justify-content:center; flex:0 0 auto; font-size:13pt; line-height:1}

    /* Tick boxes — drawn squares when printing, real inputs when typing */
    .qy-box{border:1px solid #111; display:inline-flex; align-items:center; justify-content:center; flex:0 0 auto; font-size:8pt; line-height:1; color:#111}
    .qy-box-light{border-color:#fff; color:#fff}
    .qy-tick{margin:0; flex:0 0 auto; accent-color:#1a3fa0; cursor:pointer}

    /* Value / writing-line slots */
    .qy-rule{flex:1; border-bottom:1px solid #111; height:11pt; display:inline-block; min-width:36pt}
    .qy-fill{display:inline-block; min-height:10pt}
    .qy-val{display:inline-block; min-height:10pt; word-break:break-word}
    .qy-in{width:100%; border:0; outline:0; background:transparent; font:inherit; color:#111; padding:0; min-width:0}
    /* Every free-text answer reads in CAPS — while it is being typed and
       in print — so the sheet is legible however it was filled in and
       whatever state Caps Lock was in. Display only: the stored value is
       whatever was typed. Email is the one field held the other way. */
    .qy-caps{text-transform:uppercase}
    .qy-lower{text-transform:lowercase}
    .qy-in.qy-rule{border-bottom:1px solid #111; height:13pt}
    /* Amount / Paid / Receipt # / Balance — four labelled writing lines in a
       417.8px row. The 36pt floor above is a sensible minimum for a lone
       writing line and an overflow here: honoured on all four it demands
       435px, which pushes the panel through its own border. The floor is
       lifted only on this row, where every rule is still measured to be wider
       than the longest value it prints. */
    .qy-money-line .qy-rule{min-width:0}
    .qy-in:focus{background:#eef4ff}
    .qy-grid td{vertical-align:middle}
    /* Label columns size to their text, as in the approved render — without this
       the auto table layout wraps "Citizenship / Nationality:" onto two lines. */
    .qy-grid td:nth-child(1),
    .qy-grid td:nth-child(3){white-space:nowrap}
</style>
