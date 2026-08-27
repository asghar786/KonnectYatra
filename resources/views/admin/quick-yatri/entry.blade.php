{{-- Add New / Edit a Quick Yatri application.

     The screen is the sheet: the same template the printed form comes from,
     rendered in 'entry' mode so every box becomes an input. Typing here and
     writing on the paper mean filling in the identical fields in the identical
     order. Expects: $row, $action. --}}
@extends('admin.layouts.app')
@section('content')
@include('admin.quick-yatri._sheet-css')
<style type="text/css">
    .qy-canvas{overflow-x:auto; padding-bottom:6px}
    .qy-canvas .qy-page{width:8.5in; min-height:auto; margin:0 auto; border:1px solid #eef0f4; border-radius:10px; box-shadow:0 8px 28px rgba(28,37,65,.07)}
    .qy-actions{display:flex; align-items:center; justify-content:flex-end; gap:10px; margin:18px 0 4px; flex-wrap:wrap}
    .qy-btn{display:inline-flex; align-items:center; gap:8px; border:none; border-radius:10px; padding:11px 22px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:transform .12s, box-shadow .12s}
    .qy-btn:hover{transform:translateY(-2px)}
    .qy-btn.save{background:#f54e18; color:#fff; box-shadow:0 6px 16px rgba(245,78,24,.28)}
    .qy-btn.cancel{background:#eef1f6; color:#5a6273}
    .qy-note{color:#6b7280; font-size:13px; margin-right:auto}
    .qy-errors{background:#feeceb; border:1px solid #f6c9c4; color:#b3261e; border-radius:12px; padding:14px 18px; margin-bottom:18px; font-size:14px}
    .qy-errors ul{margin:8px 0 0; padding-left:18px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">{{ $row->exists ? 'Edit Application' : 'New Yatri Application' }}</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ route('quick-yatri') }}">Quick Yatri</a></li>
                <li>{{ $row->exists ? 'Edit' : 'Add New' }}</li>
            </ul>
        </div>
        <div class="main-body">

            @if($errors->any())
                <div class="qy-errors">
                    <strong>Please check the form:</strong>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="qyForm">
                @csrf
                <div class="qy-canvas">
                    @include('admin.quick-yatri._sheet-body', ['row' => $row, 'mode' => 'entry'])
                </div>

                <div class="qy-actions">
                    <span class="qy-note">Only the applicant&rsquo;s name is required — save a partly filled sheet and finish it later.</span>
                    <a href="{{ route('quick-yatri') }}" class="qy-btn cancel">Cancel</a>
                    <button type="submit" class="qy-btn save"><i class="fa fa-save"></i> {{ $row->exists ? 'Update Application' : 'Save Application' }}</button>
                </div>
            </form>

        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
{{-- Dates are typed and shown as DD-MMM-YYYY (21-AUG-2026). jQuery UI is pulled
     in here rather than sitewide because the admin footer's generic ".datepicker"
     is a different plugin and cannot render month names. Whatever is typed by
     hand is normalised server-side on save, so the picker is the easy path
     rather than the only one. Same setup as the Yatri booking form. --}}
<link rel="stylesheet" href="{{ asset('new-assets/vendors/jquery-ui/jquery-ui.min.css') }}">
<script src="{{ asset('new-assets/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
<style>
/* Two things the picker cannot render on its own in here: the admin theme paints
   every table header white, which hides the day names against the white panel;
   and the vendored jQuery UI sprites are not images at all (the files in
   new-assets/vendors/jquery-ui/images are saved HTML), so the month arrows have
   to be drawn rather than sprited. Scoped to the picker's own element. */
#ui-datepicker-div th,
#ui-datepicker-div th span { color: #2c3e50; }

/* The admin theme also pads every table cell to 10px with !important, which
   pushes the last column outside the panel. Put jQuery UI's spacing back. */
#ui-datepicker-div .ui-datepicker-calendar th { padding: .7em .3em !important; }
#ui-datepicker-div .ui-datepicker-calendar td { padding: 1px !important; }

#ui-datepicker-div .ui-datepicker-prev,
#ui-datepicker-div .ui-datepicker-next {
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

#ui-datepicker-div .ui-datepicker-prev .ui-icon,
#ui-datepicker-div .ui-datepicker-next .ui-icon {
    position: static;
    margin: 0;
    width: auto;
    height: auto;
    overflow: visible;
    background: none;
    text-indent: 0;
    font-size: 0;                 /* hides the "Prev"/"Next" label */
}

#ui-datepicker-div .ui-datepicker-prev .ui-icon::before,
#ui-datepicker-div .ui-datepicker-next .ui-icon::before {
    font: 700 20px/1 Arial, sans-serif;
    color: #2c3e50;
}

#ui-datepicker-div .ui-datepicker-prev .ui-icon::before { content: '\2039'; }
#ui-datepicker-div .ui-datepicker-next .ui-icon::before { content: '\203A'; }
</style>
<script>
    $(function () {
        var base = {
            dateFormat:      'dd-M-yy',
            monthNamesShort: ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'],
            changeMonth:     true,
            changeYear:      true
        };
        var thisYear = new Date().getFullYear();

        function picker(selector, extra) {
            $(selector).datepicker($.extend({}, base, extra));
        }

        // Date of Birth: no future dates, back to 1920 for the oldest yatris.
        picker('.ky-date-dob', { yearRange: '1920:' + thisYear, maxDate: 0, defaultDate: '-25y' });

        // Passport Issue Date: in the past, and a passport runs at most 10 years.
        picker('.ky-date-issue', { yearRange: (thisYear - 10) + ':' + thisYear, maxDate: 0 });

        // Passport Expiry: ahead of today, at most 10 years out.
        picker('.ky-date-expiry', { yearRange: thisYear + ':' + (thisYear + 10), minDate: 0 });

        // Previous visit / signature date: past, within living memory.
        picker('.ky-date-past', { yearRange: (thisYear - 40) + ':' + thisYear, maxDate: 0 });

        // Anything else on the sheet that takes a date.
        picker('.ky-date-any', { yearRange: (thisYear - 40) + ':' + (thisYear + 10) });
    });
</script>
<script>
    (function () {
        // Cell Phone No. takes its shape as it is typed — "+1 (786) 516 2525" —
        // rather than only once the page is re-rendered. The same reshaping runs
        // server-side in $phone (_sheet-body), which stays the authority: this is
        // the typing affordance, not the rule.
        //
        // Capped at the 10 digits a US/Canada number has, so an international
        // number cannot be entered here. That matches what the sheet is for; if
        // that ever needs to change, the server-side formatter has to widen too.
        var field = document.querySelector('.qy-phone');
        if (!field) return;

        var PREFIX = '+1 (';   // fixed, never typed — and it contains a digit

        function shape(digits) {
            if (!digits) return '';
            var out = PREFIX + digits.slice(0, 3);
            if (digits.length > 3) out += ') ' + digits.slice(3, 6);
            if (digits.length > 6) out += ' ' + digits.slice(6, 10);
            return out;
        }

        // The "1" in "+1" must be dropped before counting, or backspacing into
        // the prefix reads it back as the first digit of the number.
        function strippedOfPrefix(value) {
            return value.slice(0, 2) === '+1' ? value.slice(2) : value;
        }

        function digitsOnly(value) {
            var d = strippedOfPrefix(value).replace(/\D/g, '');
            // A pasted "1 786…" is the same number, not an 11th digit.
            if (d.length === 11 && d.charAt(0) === '1') d = d.slice(1);
            return d.slice(0, 10);
        }

        // How many of the number's own digits sit left of the caret.
        function digitsBefore(value, caret) {
            return strippedOfPrefix(value.slice(0, caret)).replace(/\D/g, '').length;
        }

        // Where the caret goes to sit just after that many digits, counting from
        // past the prefix so the "+1" is never a landing spot.
        function caretAfter(shaped, n) {
            if (n <= 0) return Math.min(PREFIX.length, shaped.length);
            var seen = 0;
            for (var i = PREFIX.length; i < shaped.length; i++) {
                if (/\d/.test(shaped.charAt(i)) && ++seen === n) return i + 1;
            }
            return shaped.length;
        }

        function reformat() {
            var before = field.value;
            var wanted = digitsBefore(before, field.selectionStart);
            var shaped = shape(digitsOnly(before));

            // Nothing to restyle — leave the caret exactly where the browser put
            // it, so deleting a separator behaves the way the typist expects.
            if (shaped === before) return;

            field.value = shaped;
            var pos = caretAfter(shaped, wanted);
            field.setSelectionRange(pos, pos);
        }

        field.addEventListener('input', reformat);
        // Paste and autofill do not always raise a useful input event first.
        field.addEventListener('change', reformat);
        reformat();
    })();
</script>
<script>
    (function () {
        // Show the chosen photograph in the box straight away.
        var input = document.querySelector('.qy-photo-label input[type=file]');
        if (!input) return;
        input.addEventListener('change', function () {
            var file = this.files && this.files[0];
            if (!file) return;
            var url = URL.createObjectURL(file);
            var label = this.closest('.qy-photo-label');
            label.innerHTML = '';
            var img = document.createElement('img');
            img.src = url;
            img.alt = 'Photo';
            label.appendChild(img);
            label.appendChild(this);
        });
    })();
</script>
<script>
    (function () {
        // Amount / Paid / Balance, kept honest while the sheet is being typed.
        // Only Paid is stored: Amount follows the ticked row of the grid (or
        // this applicant's own agreed price, carried in data-base) plus the
        // wheelchair surcharge, and Balance is the difference. The same three
        // figures are computed server-side by QuickYatri::grandTotal() /
        // balanceAmount(), which stay the authority — this is the typing
        // affordance, so a price ticked and a deposit typed show their balance
        // before the page is saved, not after.
        var amountLine = document.getElementById('qyAmountLine');
        var balanceLine = document.getElementById('qyBalanceLine');
        var paid = document.querySelector('.qy-paid');
        if (!amountLine || !balanceLine || !paid) return;

        var prices = {};
        try {
            prices = JSON.parse(amountLine.getAttribute('data-prices')) || {};
        } catch (e) {
            return;
        }
        var fee = parseFloat(amountLine.getAttribute('data-fee')) || 0;
        // Set only when this row was given its own price in the list page's
        // price dialog. It is not editable here, so it overrides the grid for
        // as long as the record carries it — matching baseAmount().
        var customBase = parseFloat(amountLine.getAttribute('data-base'));
        var hasCustomBase = !isNaN(customBase);

        var trip = document.querySelectorAll('input[name=trip_option]');
        var wheelchair = document.querySelector('input[name=wheelchair_full_trip]');

        // "$3,150" — whole dollars, the shape QuickYatri::money() prints,
        // negatives included: an overpayment reads "-$350", not "$-350".
        function money(value) {
            var n = Math.round(value);
            return (n < 0 ? '-$' : '$') + Math.abs(n).toLocaleString('en-US');
        }

        // What the office typed, however they typed it: "$1,200" and "1200" are
        // the same deposit on a paper form. The controller normalises the same
        // way on save; this only decides what Balance shows meanwhile.
        function paidValue() {
            var n = parseFloat(paid.value.replace(/[$,\s]/g, ''));
            return isNaN(n) ? 0 : n;
        }

        // null until a price is settled — nothing ticked and no agreed price
        // means there is no total yet, and a blank line says so better than $0.
        function total() {
            var surcharge = wheelchair && wheelchair.checked ? fee : 0;
            if (hasCustomBase) return customBase + surcharge;
            for (var i = 0; i < trip.length; i++) {
                if (trip[i].checked && prices[trip[i].value] !== undefined) {
                    return prices[trip[i].value] + surcharge;
                }
            }
            return null;
        }

        function refresh() {
            var sum = total();
            amountLine.textContent = sum === null ? '' : money(sum);
            balanceLine.textContent = sum === null ? '' : money(sum - paidValue());
        }

        for (var i = 0; i < trip.length; i++) {
            trip[i].addEventListener('change', refresh);
        }
        if (wheelchair) wheelchair.addEventListener('change', refresh);
        paid.addEventListener('input', refresh);
        paid.addEventListener('change', refresh);
        refresh();
    })();
</script>
@endsection
