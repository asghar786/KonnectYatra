{{-- Shared print rules for the ID fronts (staff_id_1, yatri_id) and the back
     sheet (back_view). Both faces MUST use identical page geometry, otherwise a
     duplex run puts each back on a different spot than its front and the cards
     cannot be cut. Included inside each view's <style> block.

     $idSize picks the stock:
       'cr80'  (default, Crew IDs)  Letter, CR80 3.375in x 2.125in, top-aligned.
       'yatri' (Yatri IDs)          A4 or US Letter (see _paper), 3.9in x 2.5in,
                                    2 x 4 spread over the whole sheet. Centred both
                                    ways, so front and back line up whichever edge
                                    the printer flips on. --}}
@php $yatriStock = ($idSize ?? 'cr80') === 'yatri'; @endphp
@media print{
  /* Only the deck goes on the sheet - drop the admin chrome and the toolbar. */
  .ttr-header,.ttr-sidebar,.ttr-overlay,.db-breadcrumb,.id-note,.id-picker{display:none!important;}
  html,body{background:#fff!important;margin:0!important;padding:0!important;}
  /* Bootstrap 4's print sheet sets `body{min-width:992px!important}`. A 992px
     page on 8.5in/8.27in paper makes Chrome shrink everything to fit, so the
     cards came out at 67% (Crew) and 80% (Yatri) of their stated size. `html
     body` outranks Bootstrap's plain `body`. */
  html body,html body .container{min-width:0!important;}
  /* The cards are designed wider than the paper (880px crew/back, 440px yatri)
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

@if($yatriStock)
  /* Every card must sit inside the area a printer can actually reach. Content
     nearer the paper edge than about .17in makes the printer shrink the whole
     page to fit - and shift it off-centre - so the cards come out undersized and
     the back no longer lands behind the front. That is what a .075in side margin
     did on 2026-10-12. Both layouts below are centred both ways (so either flip
     edge lines up) and keep clear of the edge.

     A4 (8.27in x 11.69in) is the default: two 3.9in cards leave only .47in of
     width, so the gutter is .13in with .17in each side - it cannot be wider on
     this paper. Rows: 1.6in spare, .32in above, between and below.
     The four rows are fixed, so a short last page puts its cards in exactly the
     slots a full page would. */
  @page{size:A4 portrait;margin:0;}
  .id-deck{display:grid!important;grid-template-columns:repeat(2,3.9in);grid-template-rows:repeat(4,2.5in);justify-content:center;align-content:space-evenly;column-gap:.13in;row-gap:0;box-sizing:content-box;height:11.6in;padding:.045in 0 0!important;margin:0!important;}
  /* .045in on top + 11.6in = the sheet's 11.69in less .045in at the foot: the
     grid sits dead centre, which is what lets a short-edge flip line up too. */

  /* US Letter (8.5in x 11in), picked with the Paper box beside Print (_paper
     sets html.paper-letter and the matching @page size). An A4 layout sent to
     Letter paper is 6% too tall, so the printer scales it to 94% - the wrong
     card size and no alignment. Letter is wider: .2in gutter, .25in each side.
     Rows: .05in + 10.9in + .05in = 11in, .18in above, between and below. */
  html.paper-letter .id-deck{column-gap:.2in;height:10.9in;padding:.05in 0 0!important;}
  .id-deck + .id-deck{break-before:page;page-break-before:always;}
  .id-slot{width:3.9in;height:2.5in;overflow:hidden;border-radius:0;outline:1px solid #c7d0de;page-break-inside:avoid;break-inside:avoid;}
  /* The back is designed 880px wide: 880 * .4254545 = 374.4px = 3.9in. */
  .id-slot .card{transform:none!important;zoom:.4254545;box-shadow:none!important;}
@else
  @page{size:Letter portrait;margin:.4in;}

  /* Eight cards to a sheet - which is exactly the 8 the controller pages by -
     laid out 2 across at true CR80 ID size (3.375in x 2.125in). */
  .id-deck{display:grid!important;grid-template-columns:repeat(2,3.375in);justify-content:center;align-content:start;gap:.2in .3in;padding:0!important;margin:0!important;}
  /* More than eight cards come as one deck per sheet, each starting a new page,
     so every sheet keeps the same top-aligned grid and its back still lines up. */
  .id-deck + .id-deck{break-before:page;page-break-before:always;}
  .id-slot{width:3.375in;height:2.13in;overflow:hidden;border-radius:8px;outline:1px solid #c7d0de;page-break-inside:avoid;break-inside:avoid;}
  /* 880px design width * .3681818 = 324px = 3.375in at the CSS 96dpi print scale. */
  .id-slot .card{transform:none!important;zoom:.3681818;box-shadow:none!important;}
@endif
}
