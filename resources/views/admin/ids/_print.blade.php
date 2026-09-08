{{-- Shared print rules for the Crew ID front (staff_id_1) and back (back_view).
     Both faces MUST use identical page geometry, otherwise a duplex run puts
     each back on a different spot than its front and the cards cannot be cut.
     Included inside each view's <style> block. --}}
@media print{
  /* Only the deck goes on the sheet - drop the admin chrome and the toolbar. */
  .ttr-header,.ttr-sidebar,.ttr-overlay,.db-breadcrumb{display:none!important;}
  html,body{background:#fff!important;margin:0!important;padding:0!important;}
  /* .idcards.main-body is the page wrapper. Do NOT write plain .main-body here:
     the card's own inner column carries that class too, and zeroing its padding
     collapses every field on the card. */
  .ttr-wrapper,.container-fluid,.idcards.main-body{margin:0!important;padding:0!important;width:auto!important;}

  /* Browsers drop background colours when printing. Without this the navy photo
     panel, the orange CREW MEMBER pill and the footer bar all come out white. */
  .idcards,.idcards *{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;color-adjust:exact!important;}

  @page{size:Letter portrait;margin:.4in;}

  /* Eight cards to a sheet - which is exactly the 8 the controller pages by -
     laid out 2 across at true CR80 ID size (3.375in x 2.125in). */
  .id-deck{display:grid!important;grid-template-columns:repeat(2,3.375in);justify-content:center;align-content:start;gap:.2in .3in;padding:0!important;margin:0!important;}
  .id-slot{width:3.375in;height:2.13in;overflow:hidden;border-radius:8px;outline:1px solid #c7d0de;page-break-inside:avoid;break-inside:avoid;}
  /* 880px design width * .3681818 = 324px = 3.375in at the CSS 96dpi print scale. */
  .id-slot .card{transform:scale(.3681818)!important;transform-origin:top left;box-shadow:none!important;}
}
