{{-- Reusable passenger card for the Ticket Details page.
     Expects: $name, $type ('Adult'|'Child'|'Infant'), $dob, $itenary --}}
<div class="tkt-card">
    <div class="tkt-card-head">
        <div class="tkt-pax">
            <span class="tkt-avatar"><i class="fa fa-user"></i></span>
            <div>
                <div class="tkt-name">{{ trim($name) ?: '—' }}</div>
                <div class="tkt-type">{{ $type }} Passenger</div>
            </div>
        </div>
        <span class="tkt-badge">{{ $type }} &middot; {{ $itenary->class ?: 'N/A' }}</span>
    </div>
    <div class="tkt-card-body">
        <div class="tkt-col">
            <div class="tkt-row"><i class="fa fa-envelope"></i><span>{{ $itenary->email ?: '—' }}</span></div>
            <div class="tkt-row"><i class="fa fa-phone"></i><span>{{ $itenary->contact ?: '—' }}</span></div>
            <div class="tkt-row"><i class="fa fa-calendar"></i><span>Date of Birth: {{ $dob ?: '—' }}</span></div>
        </div>
        <div class="tkt-col tkt-col-trip">
            <div class="tkt-route">
                <span class="tkt-port"><i class="fa fa-plane"></i> {{ $itenary->from ?: '—' }}</span>
                <span class="tkt-route-line"></span>
                <span class="tkt-port"><i class="fa fa-plane"></i> {{ $itenary->to ?: '—' }}</span>
            </div>
            <div class="tkt-dates">
                <i class="fa fa-clock-o"></i> <span class="tkt-dates-label">Trip Duration:</span>
                <span class="tkt-date">{{ $itenary->depart ?: '—' }}</span>
                <span class="tkt-arrow">&rarr;</span>
                <span class="tkt-date">{{ $itenary->return ?: '—' }}</span>
            </div>
        </div>
    </div>
</div>
