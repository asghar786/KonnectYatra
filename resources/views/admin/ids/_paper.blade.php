{{-- Paper picker for the ID sheets, Crew and Yatri, fronts and backs. The layout must be
     built for the paper actually in the tray: an A4 sheet sent to Letter paper
     (or the reverse) is scaled by the printer, which changes the card size and
     breaks front/back alignment. The choice is kept in this browser and shared
     by every ID page - it describes the printer, not the card - so both faces
     always use the same geometry. Until one is made, $paperDefault applies:
     'a4' for Yatri sheets, 'letter' for Crew, as each was first laid out.
     Sits inside .db-breadcrumb, which _print hides on paper. --}}
<label class="mb-0 mr-2 d-flex align-items-center" style="font-weight:600;gap:6px;">Paper
    <select id="idPaper" class="form-control form-control-sm" style="width:auto;">
        <option value="a4">A4</option>
        <option value="letter">US Letter</option>
    </select>
</label>
<script type="text/javascript">
(function () {
    var KEY = 'ky.ids.paper';
    var DEFAULT = @json($paperDefault ?? 'a4');
    var sel = document.getElementById('idPaper');
    // A later @page rule wins over the default one in _print.
    var page = document.createElement('style');
    document.head.appendChild(page);
    function apply(v) {
        var letter = (v === 'letter' || v === 'a4' ? v : DEFAULT) === 'letter';
        document.documentElement.classList.toggle('paper-letter', letter);
        document.documentElement.classList.toggle('paper-a4', !letter);
        page.textContent = '@page{size:' + (letter ? 'Letter' : 'A4') + ' portrait;margin:0;}';
        sel.value = letter ? 'letter' : 'a4';
    }
    var saved = null;
    try { saved = localStorage.getItem(KEY); } catch (e) {}
    apply(saved);
    sel.addEventListener('change', function () {
        apply(sel.value);
        try { localStorage.setItem(KEY, sel.value); } catch (e) {}
    });
})();
</script>
