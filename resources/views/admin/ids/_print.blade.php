{{-- Shared print rules for the ID fronts (staff_id_1, yatri_id) and the back
     sheet (back_view). Both faces MUST use identical page geometry, otherwise a
     duplex run puts each back on a different spot than its front and the cards
     cannot be cut. Included inside each view's <style> block.

     $idSize picks the stock:
       'cr80'  (default, Crew IDs)  Letter, CR80 3.375in x 2.125in, top-aligned.
       'yatri' (Yatri IDs)          A4, 3.9in x 2.5in, 2 x 4 spread over the
                                    whole sheet. Centred both ways, so front and
                                    back line up whichever edge the printer flips on. --}}
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
  /* A4 is 8.27in x 11.69in. Four 2.5in rows = 10in; the other 1.6in of the deck
     is shared out evenly above, between and below them, .32in each. The gutter
     between the two columns is set to that same .32in so the cards are spaced
     alike both ways: two 3.9in cards + .32in = 8.12in, leaving only .075in each
     side - the gutter cannot grow further without a smaller card. The four rows
     are fixed, so a short last page puts its cards in exactly the slots a full
     page would. */
  @page{size:A4 portrait;margin:0;}
  .id-deck{display:grid!important;grid-template-columns:repeat(2,3.9in);grid-template-rows:repeat(4,2.5in);justify-content:center;align-content:space-evenly;column-gap:.32in;row-gap:0;box-sizing:content-box;height:11.6in;padding:.045in 0 0!important;margin:0!important;}
  /* .045in on top + 11.6in = the sheet's 11.69in less .045in at the foot: the
     grid sits dead centre, which is what lets a short-edge flip line up too. */
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
