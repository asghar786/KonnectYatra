{{-- Shared print rules for the ID fronts (staff_id_1, yatri_id) and the back
     sheet (back_view). Both faces MUST use identical page geometry, otherwise a
     duplex run puts each back on a different spot than its front and the cards
     cannot be cut. Included inside each view's <style> block.

     Crew and Yatri IDs are the same card: CR80, 3.375in x 2.125in, eight to a
     sheet on US Letter or A4 (see _paper). Yatri IDs were a larger 3.9in x 2.5in
     stock until 2026-10-16, when the user asked for them at the Crew size. --}}
@media print{
  /* Only the deck goes on the sheet - drop the admin chrome and the toolbar. */
  .ttr-header,.ttr-sidebar,.ttr-overlay,.db-breadcrumb,.id-note,.id-picker{display:none!important;}
  html,body{background:#fff!important;margin:0!important;padding:0!important;}
  /* Bootstrap 4's print sheet sets `body{min-width:992px!important}`. A 992px
     page on 8.5in/8.27in paper makes Chrome shrink everything to fit, so the
     cards came out at 67% (Crew) and 80% (Yatri) of their stated size. `html
     body` outranks Bootstrap's plain `body`. */
  html body,html body .container{min-width:0!important;}
  /* The cards are designed wider than the slot (880px crew/back, 440px yatri)
     and are sized down with `zoom`, NOT a scale transform. A transform only
     changes how a card looks; its 880px box stays in the layout, and once a
     print runs past one page Chrome shrank the whole job to fit (to 67%).
     zoom resizes the box itself. Measured 2026-09-30 on 1- and 2-sheet PDFs. */
  /* .idcards.main-body is the page wrapper. Do NOT write plain .main-body here:
     the card's own inner column carries that class too, and zeroing its padding
     collapses every field on the card. */
  .ttr-wrapper,.container-fluid,.idcards.main-body{margin:0!important;padding:0!important;width:auto!important;}

  /* Browsers drop background colours when printing. Without this the navy photo
     panel, the orange CREW MEMBER pill and the footer bar all come out white. */
  .idcards,.idcards *{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;color-adjust:exact!important;}

  /* Eight cards to a sheet - which is exactly the 8 the controller pages by -
     at true CR80 ID size (3.375in x 2.125in), each with a grey dotted CUT LINE
     0.65cm outside its edges (user, 2026-10-16: cut there, leaving a margin
     round the card). Each grid cell is the card plus 0.65cm on every side and
     the cells touch, so neighbouring cards share one dotted line and one cut.
     0.65cm is the most that fits 8 to a sheet: a full 1cm needs 11.65in of
     height for four rows. The block is centred both ways, so the back lands
     behind the front whichever edge the paper is flipped on, and the four rows
     are fixed, so a short sheet keeps its slots.
     US Letter is the default: 4 x (2.13in + 1.3cm) = 10.57in tall, 2 x (3.375in
     + 1.3cm) = 7.77in wide, centred in .05in + 10.9in + .05in = 11in - so .21in
     clear above and below and .36in at the sides, all inside the area a
     printer can reach (nearer than about .17in and it shrinks the page). */
  @page{size:Letter portrait;margin:0;}
  .id-deck{display:grid!important;grid-template-columns:repeat(2,calc(3.375in + 1.3cm));grid-template-rows:repeat(4,calc(2.13in + 1.3cm));justify-content:center;align-content:center;justify-items:center;align-items:center;gap:0;box-sizing:content-box;height:10.9in;padding:.05in 0 0!important;margin:0!important;}
  /* A4, picked with the Paper box (_paper): .045in + 11.6in + .045in = 11.69in;
     the 7.77in-wide block leaves .25in at each side of the 8.27in sheet. */
  html.paper-a4 .id-deck{height:11.6in;padding:.045in 0 0!important;}
  /* More than eight cards come as one deck per sheet, each starting a new page,
     so every sheet keeps the same top-aligned grid and its back still lines up. */
  .id-deck + .id-deck{break-before:page;page-break-before:always;}
  /* The cut line is the slot's outline pushed out 0.65cm (an outline takes no
     layout space). The slot itself has square corners so the cut box is square
     - an outline follows border-radius, and an 8px radius grown by 0.65cm made
     big round corners. The card keeps its own rounded corners. */
  .id-slot{width:3.375in;height:2.13in;overflow:hidden;border-radius:0;outline:1.5px dotted #777;outline-offset:.65cm;page-break-inside:avoid;break-inside:avoid;}
  /* 880px design width * .3681818 = 324px = 3.375in at the CSS 96dpi print scale. */
  .id-slot .card{transform:none!important;zoom:.3681818;box-shadow:none!important;}
}
