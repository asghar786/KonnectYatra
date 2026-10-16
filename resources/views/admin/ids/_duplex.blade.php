{{-- Print buttons for the Crew and Yatri front pages, which also carry a back
     sheet (.id-deck.back-deck, eight _back_card slots) after every front sheet.

     "Print Front + Back" prints them interleaved: page 1 fronts, page 2 backs,
     page 3 fronts, ... - for a duplex printer, flip on LONG edge. Each back sheet
     has exactly as many backs as its front sheet has cards, each in the mirrored
     slot (same row, other column), because a long-edge flip swaps the columns.
     The grid is centred both ways, so mirrored slots coincide on the paper.
     "Front only" prints just the fronts, as before.

     Back shift: a duplex printer often puts side 2 a millimetre or two off side 1.
     After one test sheet, enter how far to move the backs (mm, as seen looking
     at the back; + is right / down). Kept in this browser and shared by every ID
     page, like the Paper choice - it describes the printer, not the card.

     $withCount: show the ticked-card count on the button (Crew page).
     Sits inside .db-breadcrumb, which _print hides on paper. --}}
<style type="text/css">
  .id-deck.back-deck{display:none!important;}
  @media print{
    html.print-duplex .id-deck.back-deck{display:grid!important;}
    /* The shift moves each card, not the sheet: an offset sheet pokes past the
       paper edge and Chrome then shrinks the WHOLE job, fronts too (98.7% at
       2.5mm, measured 2026-10-16). Capped at 3mm, inside the narrowest side
       margin (A4 Yatri, .15in), so no card can reach the edge. */
    html.print-duplex .id-deck.back-deck .id-slot{position:relative;left:var(--ky-back-x,0mm);top:var(--ky-back-y,0mm);}
  }
  .id-shift{display:flex;align-items:center;gap:3px;font-weight:600;font-size:13px;margin:0 8px 0 0;white-space:nowrap;}
  .id-shift input{width:52px;padding-left:4px;padding-right:2px;}
</style>
<span class="id-shift" title="Move the back side to line it up with the front on your duplex printer (millimetres, as seen on the back: + right / + down)">Back shift
    <input type="number" id="idBackX" class="form-control form-control-sm" step="0.5" min="-3" max="3" value="0" aria-label="Back shift right, mm">&rarr;
    <input type="number" id="idBackY" class="form-control form-control-sm" step="0.5" min="-3" max="3" value="0" aria-label="Back shift down, mm">&darr; mm
</span>
<button class="btn btn-success" type="button" id="printDuplex">Print Front + Back @if(!empty($withCount))(<span class="pick-n">0</span>)@endif</button>
<button class="btn btn-outline-secondary ml-2" type="button" id="printFront">Front only</button>
<script type="text/javascript">
(function () {
    var KEY = 'ky.ids.backShift';
    var root = document.documentElement;
    var bx = document.getElementById('idBackX'), by = document.getElementById('idBackY');
    function mm(el) {
        var v = parseFloat(el.value);
        return isFinite(v) ? Math.max(-3, Math.min(3, v)) : 0;
    }
    function apply() {
        root.style.setProperty('--ky-back-x', mm(bx) + 'mm');
        root.style.setProperty('--ky-back-y', mm(by) + 'mm');
    }
    try {
        var saved = JSON.parse(localStorage.getItem(KEY) || 'null');
        if (saved) { bx.value = +saved.x || 0; by.value = +saved.y || 0; }
    } catch (e) {}
    apply();
    [bx, by].forEach(function (el) {
        el.addEventListener('change', function () {
            el.value = mm(el);
            apply();
            try { localStorage.setItem(KEY, JSON.stringify({ x: mm(bx), y: mm(by) })); } catch (e) {}
        });
    });
    document.getElementById('printDuplex').addEventListener('click', function () {
        root.classList.add('print-duplex');
        window.print();
    });
    document.getElementById('printFront').addEventListener('click', function () {
        root.classList.remove('print-duplex');
        window.print();
    });
    // A later Ctrl+P prints the fronts only again.
    window.addEventListener('afterprint', function () { root.classList.remove('print-duplex'); });
})();
</script>
