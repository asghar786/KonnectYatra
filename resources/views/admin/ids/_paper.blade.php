{{-- Paper picker for the Yatri ID sheets (fronts and backs). The layout must be
     built for the paper actually in the tray: an A4 sheet sent to Letter paper
     (or the reverse) is scaled by the printer, which changes the card size and
     breaks front/back alignment. The choice is kept in this browser and shared
     by the front and back pages, so both faces always use the same geometry.
     Sits inside .db-breadcrumb, which _print hides on paper. --}}
<label class="mb-0 mr-2 d-flex align-items-center" style="font-weight:600;gap:6px;">Paper
    <select id="idPaper" class="form-control form-control-sm" style="width:auto;">
        <option value="a4">A4</option>
        <option value="letter">US Letter</option>
    </select>
</label>
<script type="text/javascript">
(function () {
    var KEY = 'ky.yatriIds.paper';
    var sel = document.getElementById('idPaper');
    // A later @page rule wins over the A4 one in _print.
    var page = document.createElement('style');
    document.head.appendChild(page);
    function apply(v) {
        var letter = v === 'letter';
        document.documentElement.classList.toggle('paper-letter', letter);
        page.textContent = letter ? '@page{size:Letter portrait;margin:0;}' : '';
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
