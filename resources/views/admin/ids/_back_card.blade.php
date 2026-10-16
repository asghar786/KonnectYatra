{{-- One ID back in its print slot. Every back is identical: the front already
     carries the name, photo, CNIC, ID No. and role, so repeating them here tells
     the holder nothing new. Styled by _back_styles; needs $back_ids
     (Admin > IDs > Back IDs, the yatri_ids_back row).
     $behind (optional): the 0-based slot of the FRONT this back belongs to. The
     back is then placed in the mirrored slot - same row, other column - which is
     where that front lands after a long-edge duplex flip. --}}
<div class="id-slot bslot"@isset($behind) style="grid-row:{{ intdiv($behind, 2) + 1 }};grid-column:{{ 2 - $behind % 2 }};"@endisset>
    <div class="card back">
        <div class="back-head">
            <img class="gmark" src="{{ asset('assets2/id/globe.png') }}" alt="" />
            <div class="ht">
                <div class="o">KONNECT YATRA <em>· USA</em></div>
                <div class="t">Explore and Discover the Globe</div>
            </div>
            <div class="web"><span class="k">WEBSITE</span>www.konnectyatra.org</div>
        </div>
        <div class="magstripe"></div>
        <div class="back-body">
            <div class="bcol">
                <div class="btitle">Emergency Contact</div>
                <div class="who">{{ @$back_ids->name ?: 'Konnect Yatra Office' }}
                    <span>{{ @$back_ids->role ?: 'Tour Management' }}</span>
                </div>
                <div class="tel">
                    <span class="ico"><i class="fa fa-phone"></i></span>
                    <span class="num">{{ @$back_ids->phone ?: '+1 (718) 908-9464' }}</span>
                </div>
                <div class="stayrow">
                    @if(@$back_ids->hotel || @$back_ids->hotel1)
                    <div class="stay">
                        <div class="btitle">Staying At</div>
                        <ul>
                            @if(@$back_ids->hotel)<li>{{ $back_ids->hotel }}</li>@endif
                            @if(@$back_ids->hotel1)<li>{{ $back_ids->hotel1 }}</li>@endif
                        </ul>
                    </div>
                    @endif
                    <div class="qr">
                        <img src="{{ asset('assets2/id/qr-konnectyatra.svg') }}" alt="konnectyatra.org" />
                    </div>
                </div>
            </div>
            <div class="bcol terms">
                <div class="btitle">Terms &amp; Conditions</div>
                <div class="tmeta">
                    <div class="co">KONNECT.US, INC.</div>
                    <div class="nm">Yatra ID Card</div>
                    <div class="tr">November 2026 Yatra Tour</div>
                </div>
                <div class="lead">This Yatra ID Card is valid only during the period in which the holder is actively participating in the November 2026 Yatra Tour.</div>
                <ul>
                    <li>This ID Card may be presented upon request to authorized government personnel, security officials, or Konnect Yatra representatives.</li>
                    <li><span class="lbl">Lost or Stolen Card:</span> Any lost or stolen ID Card must be reported immediately to the assigned Tour Guide.</li>
                </ul>
            </div>
        </div>
        <div class="back-foot">
            <div class="rl">If found<br>return to</div>
            <div class="ra">Konnect.US Inc. — 148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434
                <span class="ln">+1 (718) 908-9464 · www.konnectyatra.org</span>
            </div>
        </div>
    </div>
</div>
