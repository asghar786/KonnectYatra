{{-- Styles for the ID back card (_back_card). Shared by the Back View sheet and by
     the Crew and Yatri front pages, which carry a back sheet of their own for the
     duplex Front + Back print. Included inside each view's <style> block, BEFORE
     _print. Load the Archivo + IBM Plex Mono fonts on the page as well. --}}
  .idcards{--navy:#16294d;--navy-deep:#0f1d39;--navy-2:#1d3461;--orange:#e8601c;--orange-soft:#f2843f;--ink:#1b2436;--paper:#fff;--line:#e4e8f0;--muted:#6b7689;}
  /* Screen preview only, scaled down. In @media screen because a two-class
     selector would otherwise outrank _print's plain .id-slot sizes on paper. */
  @media screen{
    .id-slot.bslot{width:550px;height:347px;overflow:hidden;}
    .id-slot.bslot .card{transform:scale(.625);transform-origin:top left;}
  }

  .idcards .card.back{width:880px;height:555px;border-radius:22px;overflow:hidden;background:var(--paper);position:relative;font-family:'Archivo',system-ui,sans-serif;color:var(--ink);
    box-shadow:0 1px 0 rgba(255,255,255,.7) inset,0 24px 48px -18px rgba(22,41,77,.45),0 6px 16px -8px rgba(22,41,77,.3);}
  .idcards .back{display:flex;flex-direction:column;}

  /* Header mirrors the front's navy panel so the two faces read as one card. */
  .idcards .back-head{flex:0 0 84px;background:radial-gradient(120% 140% at 14% 0%,var(--navy-2),var(--navy) 55%,var(--navy-deep));color:#fff;padding:0 30px;display:flex;align-items:center;gap:15px;}
  .idcards .back-head .gmark{height:46px;width:auto;filter:brightness(2);}
  .idcards .back-head .ht{flex:1;}
  .idcards .back-head .ht .o{font-size:21px;font-weight:900;letter-spacing:.01em;line-height:1.1;}
  .idcards .back-head .ht .o em{color:var(--orange-soft);font-style:normal;}
  .idcards .back-head .ht .t{font-family:'IBM Plex Mono',monospace;font-size:10.5px;letter-spacing:.1em;color:#aebbd4;margin-top:3px;}
  .idcards .back-head .web{text-align:right;font-family:'IBM Plex Mono',monospace;font-size:12px;color:#fff;line-height:1.35;}
  .idcards .back-head .web .k{color:#fff;display:block;font-size:9.5px;letter-spacing:.16em;font-weight:600;}
  .idcards .magstripe{flex:0 0 34px;background:repeating-linear-gradient(90deg,#0c1426 0 3px,#13203a 3px 6px);}

  /* NB: no <b> or <p> inside the card. adminassets/css/form.css carries
     `b{color:black!important}` and `p{color:black!important}`, which no amount of
     selector specificity can outrank - it is what turned the two navy strips'
     white text black. Style spans and divs with classes instead. */

  /* Two columns: what to do in an emergency, and the terms of the credential. */
  .idcards .back-body{flex:1;display:grid;grid-template-columns:1fr 380px;min-height:0;}
  /* Both columns are flex so the trailing block in each can be pinned to the
     bottom edge with margin-top:auto, rather than leaving a ragged gap. */
  .idcards .bcol{padding:24px 26px 20px 30px;min-width:0;display:flex;flex-direction:column;}
  .idcards .bcol+.bcol{padding:24px 30px 20px 26px;border-left:1px solid var(--line);}
  .idcards .btitle{font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--navy);font-weight:600;display:flex;align-items:center;gap:8px;}
  .idcards .btitle::before{content:"";width:14px;height:2px;background:var(--orange);flex:0 0 auto;}

  /* The reason the back exists: one phone number, big enough to read in a hurry. */
  .idcards .who{margin-top:13px;font-size:24px;font-weight:800;color:var(--navy);line-height:1.15;}
  .idcards .who span{display:block;font-size:14.5px;font-weight:600;color:var(--muted);margin-top:4px;}
  .idcards .tel{margin-top:15px;display:flex;align-items:center;gap:13px;background:linear-gradient(180deg,#fff5f0,#ffece1);border:1px solid #f7cdb4;border-left:4px solid var(--orange);border-radius:12px;padding:15px 18px;}
  .idcards .tel .ico{width:30px;height:30px;flex:0 0 auto;border-radius:50%;background:var(--orange);color:#fff;display:flex;align-items:center;justify-content:center;font-size:15px;}
  .idcards .tel .num{font-family:'IBM Plex Mono',monospace;font-size:30px;font-weight:600;color:var(--navy);letter-spacing:.01em;line-height:1;}
  /* Pinned to the bottom of its column so the panel reads as two anchored blocks.
     The row holds the hotels and the QR side by side; the QR sits outside .stay
     because it must print even when no hotel has been entered. */
  .idcards .stayrow{margin-top:auto;padding-top:18px;display:flex;align-items:flex-end;gap:20px;}
  .idcards .stay{flex:1;min-width:0;}
  .idcards .stay ul{list-style:none;margin:11px 0 0;padding:0;display:flex;flex-direction:column;gap:9px;}
  .idcards .stay li{font-size:16px;font-weight:600;color:var(--navy);padding-left:18px;position:relative;line-height:1.3;}
  .idcards .stay li::before{content:"";position:absolute;left:0;top:7px;width:7px;height:7px;border-radius:2px;background:var(--orange);}
  /* konnectyatra.org, identical on every card, so it is a committed SVG rather
     than a runtime encode - nothing to install on prod and it prints crisp at any
     scale. Version 2 / EC M (25 modules) keeps each module near .6mm at CR80 size,
     which is what makes it scan off a printed card. margin-left:auto holds it to
     the right edge on the cards that have no hotel block beside it. */
  /* 146px is the largest that clears the bottom edge: the left column's stack
     leaves 168px under the phone panel and the row adds 18px of its own padding.
     Sized up to the limit on purpose - it sets the printed module at roughly half
     a millimetre, which is what a phone camera needs off a card this size. No
     caption, because the header and the footer already print the address. */
  .idcards .qr{flex:0 0 146px;margin-left:auto;}
  .idcards .qr img{width:146px;height:146px;display:block;border-radius:8px;background:#fff;}

  /* What the credential IS, above the conditions it sets out. The column is
     380px and the type is sized to fill it: on the shorter Crew card the last
     bullet ends just above the bottom margin, so longer terms need a smaller size. */
  .idcards .terms .btitle{font-size:11.5px;}
  .idcards .terms .tmeta{margin-top:10px;}
  .idcards .terms .tmeta .co{font-family:'IBM Plex Mono',monospace;font-size:11.5px;letter-spacing:.14em;color:var(--orange);font-weight:600;}
  .idcards .terms .tmeta .nm{font-size:20px;font-weight:800;color:var(--navy);line-height:1.15;margin-top:2px;}
  .idcards .terms .tmeta .tr{font-size:14.5px;font-weight:600;color:var(--muted);margin-top:1px;}
  .idcards .terms .lead{font-size:15px;line-height:1.4;color:#42506a;margin:9px 0 0;}
  .idcards .terms ul{list-style:none;margin:10px 0 0;padding:0;display:flex;flex-direction:column;gap:8px;}
  .idcards .terms li{font-size:15px;line-height:1.4;color:#42506a;padding-left:16px;position:relative;}
  .idcards .terms li .lbl{color:var(--navy);font-weight:700;}
  .idcards .terms li::before{content:"";position:absolute;left:0;top:8px;width:6px;height:6px;border-radius:50%;background:var(--orange);}
  /* Return address sits in the navy foot, matching the front's footer bar. */
  .idcards .back-foot{flex:0 0 74px;background:linear-gradient(180deg,var(--navy-2),var(--navy-deep));color:#dbe2f0;padding:0 30px;display:flex;align-items:center;gap:16px;}
  .idcards .back-foot .rl{font-family:'IBM Plex Mono',monospace;font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:#fff;font-weight:600;line-height:1.35;flex:0 0 90px;}
  .idcards .back-foot .ra{font-size:17px;line-height:1.35;color:#fff;font-weight:600;}
  /* Block, or the phone/web run on from the end of the street address. */
  .idcards .back-foot .ra .ln{display:block;margin-top:3px;color:#fff;font-weight:600;font-family:'IBM Plex Mono',monospace;font-size:14.5px;letter-spacing:.02em;}
