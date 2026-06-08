@extends('admin.layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,500;0,8..60,600;1,8..60,400&display=swap" rel="stylesheet" />
<style type="text/css">
  .utk{--navy:#1c2b4a;--navy-soft:#2b3c5e;--orange:#e8721e;--ink:#1c1f26;--muted:#5b626f;--line:#2a3142;--hair:#c9ccd4;--paper:#fff;--band:#f4f5f7;
       background:#6b7280;padding:26px 0 40px;}
  .utk *{box-sizing:border-box;}
  .utk .page{width:8.5in;min-height:11in;margin:0 auto 24px;background:var(--paper);padding:.62in .7in .55in;
    box-shadow:0 18px 50px rgba(0,0,0,.34);position:relative;display:flex;flex-direction:column;
    font-family:"Source Serif 4",Georgia,serif;color:var(--ink);}
  .utk .cont-head{display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;border-bottom:2px solid var(--navy);margin-bottom:6px;}
  .utk .cont-head img{height:38px;width:auto;display:block;}
  .utk .cont-head .ct{font-family:"Archivo",sans-serif;font-weight:800;font-size:13px;letter-spacing:.04em;text-transform:uppercase;color:var(--navy);}
  .utk .cont-head .ct span{color:var(--orange);font-weight:600;}
  .utk header.doc-head{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;}
  .utk .brand img{height:64px;width:auto;display:block;}
  .utk .contact{text-align:right;font-size:9.2px;line-height:1.55;color:var(--muted);max-width:2.9in;font-family:"Archivo",sans-serif;}
  .utk .contact .co{font-weight:700;color:var(--navy);font-size:10px;letter-spacing:.02em;}
  .utk .rule{height:3px;margin:13px 0 0;background:linear-gradient(90deg,var(--navy) 0 70%,var(--orange) 70% 100%);}
  .utk .title-row{text-align:center;margin:20px 0 4px;}
  .utk .doc-kicker{font-family:"Archivo",sans-serif;font-size:10px;letter-spacing:.34em;text-transform:uppercase;color:var(--orange);font-weight:700;}
  .utk h1{font-family:"Archivo",sans-serif;font-weight:800;font-size:25px;letter-spacing:.02em;color:var(--navy);margin:5px 0 0;text-transform:uppercase;}
  .utk .subtitle{font-size:11px;color:var(--muted);margin-top:5px;font-style:italic;}
  .utk .meta-line{display:flex;justify-content:space-between;gap:18px;margin-top:14px;font-family:"Archivo",sans-serif;font-size:9.5px;color:var(--muted);}
  .utk .meta-line .field{display:flex;align-items:baseline;gap:7px;}
  .utk .meta-line .ln{border-bottom:1px solid var(--hair);min-width:120px;}
  .utk .declaration{margin-top:16px;font-size:11.6px;line-height:1.62;}
  .utk .declaration p{margin:0 0 9px;}
  .utk .declaration strong{color:var(--navy);}
  .utk section{margin-top:15px;}
  .utk .sec-head{display:flex;align-items:center;gap:10px;margin-bottom:9px;}
  .utk .sec-num{font-family:"Archivo",sans-serif;font-weight:800;font-size:10px;color:#fff;background:var(--navy);width:19px;height:19px;border-radius:4px;display:flex;align-items:center;justify-content:center;}
  .utk .sec-title{font-family:"Archivo",sans-serif;font-weight:700;font-size:11.5px;letter-spacing:.08em;text-transform:uppercase;color:var(--navy);}
  .utk .sec-line{flex:1;height:1px;background:var(--hair);}
  .utk .grid{display:grid;gap:11px 22px;}
  .utk .g2{grid-template-columns:1fr 1fr;}
  .utk .field{display:flex;flex-direction:column;gap:3px;}
  .utk label{font-family:"Archivo",sans-serif;font-size:8.6px;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);font-weight:600;margin:0;}
  .utk .input{border:none;border-bottom:1px solid var(--line);background:transparent;font-family:"Source Serif 4",serif;font-size:11.5px;color:var(--ink);padding:3px 2px;min-height:21px;width:100%;outline:none;}
  .utk .input:focus{border-bottom-color:var(--orange);}
  .utk .trav-table{width:100%;border-collapse:collapse;margin-top:2px;}
  .utk .trav-table th{font-family:"Archivo",sans-serif;font-size:8.4px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);font-weight:600;text-align:left;padding:0 8px 5px 0;}
  .utk .trav-table th.n{width:24px;}
  .utk .trav-table td{padding:0 8px 4px 0;vertical-align:bottom;}
  .utk .trav-table td.n{font-family:"Archivo",sans-serif;font-weight:700;color:var(--navy);font-size:11px;padding-bottom:9px;}
  .utk .cell{border-bottom:1px solid var(--line);}
  .utk .cell input{border:none;background:transparent;width:100%;font-family:"Source Serif 4",serif;font-size:11px;padding:5px 2px;outline:none;}
  .utk .trav-table tr:focus-within .cell{border-bottom-color:var(--orange);}
  .utk .ack{font-size:10px;line-height:1.5;}
  .utk .ack ol{margin:0;padding-left:0;list-style:none;counter-reset:ack;}
  .utk .ack li{counter-increment:ack;position:relative;padding:7px 0 7px 50px;border-bottom:1px dotted var(--hair);}
  .utk .ack li:last-child{border-bottom:none;}
  .utk .ack li::before{content:counter(ack,decimal-leading-zero);position:absolute;left:0;top:7px;font-family:"Archivo",sans-serif;font-weight:800;font-size:11px;color:var(--orange);}
  .utk .ack .initbox{position:absolute;left:26px;top:6px;width:18px;height:18px;border:1px solid var(--hair);border-radius:3px;}
  .utk .ack b{color:var(--navy);}
  .utk .sign-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px 34px;margin-top:6px;}
  .utk .sign-block .sline{border-bottom:1.4px solid var(--ink);height:34px;}
  .utk .sign-block .slabel{font-family:"Archivo",sans-serif;font-size:8.6px;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-top:4px;}
  .utk .disclaimer{margin-top:18px;padding:12px 13px;background:var(--band);border-left:3px solid var(--orange);}
  .utk .disclaimer h4{font-family:"Archivo",sans-serif;font-size:8.8px;letter-spacing:.12em;text-transform:uppercase;color:var(--navy);margin:0 0 5px;font-weight:700;}
  .utk .disclaimer p{font-size:7.9px;line-height:1.5;color:#454a55;margin:0 0 5px;text-align:justify;}
  .utk .disclaimer p:last-child{margin-bottom:0;}
  .utk .foot{padding-top:12px;display:flex;justify-content:space-between;align-items:center;font-family:"Archivo",sans-serif;font-size:7.6px;color:var(--muted);letter-spacing:.04em;border-top:1px solid var(--hair);margin-top:14px;}
  .utk .foot .tag{color:var(--orange);font-weight:700;letter-spacing:.16em;text-transform:uppercase;}

  @media print{
    @page{size:Letter;margin:0;}
    body{background:#fff;}
    .utk{background:#fff;padding:0;}
    .utk .page{box-shadow:none;margin:0 auto;break-after:page;}
    .utk .page:last-of-type{break-after:auto;}
  }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Undertaking Form</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Undertaking Form</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                <button class="btn btn-success" type="button" onclick="printUndertaking()">Print / Save as PDF</button>
                <button class="btn btn-secondary ml-2" type="button" onclick="document.querySelectorAll('.utk .input,.utk .cell input').forEach(function(i){i.value='';});">Clear Fields</button>
            </div>
        </div>
        <div class="main-body pt-3">
            <div id="utkPrint">
                <div class="utk">
                    <!-- PAGE 1 -->
                    <div class="page">
                        <header class="doc-head">
                            <div class="brand"><img src="{{ asset('assets2/konnect-logo.png') }}" alt="KONNECT.US INC." /></div>
                            <div class="contact">
                                <div class="co">KONNECT.US INC.</div>
                                <div>18502 Hillside Avenue</div>
                                <div>Jamaica, NY 11432 · USA</div>
                                <div>Tel +1 718-908-9464</div>
                                <div>rm@konnectyatra.org &middot; www.konnectyatra.org</div>
                            </div>
                        </header>
                        <div class="rule"></div>

                        <div class="title-row">
                            <div class="doc-kicker">Pakistan Travel Program</div>
                            <h1>Traveler&rsquo;s Undertaking</h1>
                            <div class="subtitle">Acknowledgement of Independent Personal Travel &amp; Release of Liability</div>
                        </div>

                        <div class="meta-line">
                            <div class="field">Form Ref. No.&nbsp; <span class="ln">&nbsp;</span></div>
                            <div class="field">Tour / Booking ID&nbsp; <span class="ln">&nbsp;</span></div>
                            <div class="field">Date&nbsp; <span class="ln">&nbsp;</span></div>
                        </div>

                        <div class="declaration">
                            <p>This is to certify that <strong>I&nbsp;/&nbsp;we</strong> wish to undertake a personal visit to our ancestral village and to meet members of our family and family friends. This portion of the journey is made entirely at our own choice and is <strong>independent of, and separate from,</strong> any tour, itinerary, transport, or arrangement organized by <strong>KONNECT.US&nbsp;INC.</strong> (&ldquo;the Company&rdquo;).</p>
                            <p>I&nbsp;/&nbsp;we accept <strong>full and sole responsibility</strong> for any mishap, loss, injury, or incident that may occur during this personal trip. I&nbsp;/&nbsp;we further understand and agree that I&nbsp;/&nbsp;we alone am&nbsp;/&nbsp;are responsible for <strong>all expenses</strong> of every kind that may be incurred during this personal trip.</p>
                        </div>

                        <section>
                            <div class="sec-head"><span class="sec-num">1</span><span class="sec-title">Personal Visit Details</span><span class="sec-line"></span></div>
                            <div class="grid g2">
                                <div class="field" style="grid-column:1 / -1;"><label>Address of Village &amp; Town</label><input class="input" type="text" /></div>
                                <div class="field"><label>District / Tehsil</label><input class="input" type="text" /></div>
                                <div class="field"><label>Province / Country</label><input class="input" type="text" /></div>
                                <div class="field"><label>Person Being Visited (Mr./Ms.)</label><input class="input" type="text" /></div>
                                <div class="field"><label>CNIC / NIC No. of Host</label><input class="input" type="text" /></div>
                                <div class="field"><label>Relationship to Traveler</label><input class="input" type="text" /></div>
                                <div class="field"><label>Host Contact Tel.</label><input class="input" type="text" /></div>
                                <div class="field"><label>Personal Trip — From (Date)</label><input class="input" type="text" /></div>
                                <div class="field"><label>Personal Trip — To (Date)</label><input class="input" type="text" /></div>
                            </div>
                        </section>

                        <section>
                            <div class="sec-head"><span class="sec-num">2</span><span class="sec-title">Traveler Information</span><span class="sec-line"></span></div>
                            <table class="trav-table">
                                <thead>
                                    <tr><th class="n">#</th><th>Yatri (Traveler) Name &amp; Contact Number</th><th>Passport No.</th><th>Nationality</th></tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= 6; $i++)
                                    <tr><td class="n">{{ $i }}</td><td class="cell"><input type="text" /></td><td class="cell"><input type="text" /></td><td class="cell"><input type="text" /></td></tr>
                                    @endfor
                                </tbody>
                            </table>
                        </section>

                        <div class="foot">
                            <span class="tag">Explore and Discover the Globe</span>
                            <span>KONNECT.US INC. · Traveler&rsquo;s Undertaking · Page 1 of 2</span>
                        </div>
                    </div>

                    <!-- PAGE 2 -->
                    <div class="page">
                        <header class="cont-head">
                            <img src="{{ asset('assets2/konnect-logo.png') }}" alt="KONNECT.US INC." />
                            <div class="ct">Traveler&rsquo;s Undertaking <span>— continued</span></div>
                        </header>

                        <section>
                            <div class="sec-head"><span class="sec-num">3</span><span class="sec-title">Acknowledgement, Assumption of Risk &amp; Release</span><span class="sec-line"></span></div>
                            <div class="ack">
                                <ol>
                                    <li><span class="initbox"></span><b>Independent travel.</b> This personal visit is not part of any package, escorted tour, or service sold by the Company. The Company acts solely as a travel facilitator and is not the provider of any local transport, lodging, or activity used during the personal trip.</li>
                                    <li><span class="initbox"></span><b>Assumption of risk.</b> I&nbsp;/&nbsp;we voluntarily assume all risks associated with travel to and within Pakistan, including those arising from road conditions, remote locations, health, weather, and local circumstances beyond the Company&rsquo;s control.</li>
                                    <li><span class="initbox"></span><b>Release &amp; waiver.</b> To the fullest extent permitted by law, I&nbsp;/&nbsp;we release, waive, and discharge the Company, its officers, employees, and agents from any and all liability, claims, or demands arising out of this personal trip.</li>
                                    <li><span class="initbox"></span><b>Documents &amp; insurance.</b> I&nbsp;/&nbsp;we are responsible for valid passports, visas, vaccinations, and adequate travel and medical insurance. I&nbsp;/&nbsp;we acknowledge the Company does not provide insurance of any kind.</li>
                                    <li><span class="initbox"></span><b>Advisories &amp; law.</b> I&nbsp;/&nbsp;we have reviewed current U.S. Department of State travel advisories for Pakistan and agree to comply with all applicable U.S. and local laws during the trip.</li>
                                    <li><span class="initbox"></span><b>Indemnification.</b> I&nbsp;/&nbsp;we agree to indemnify and hold the Company harmless from any loss, cost, or expense (including legal fees) arising from my&nbsp;/&nbsp;our personal trip or breach of this undertaking.</li>
                                </ol>
                            </div>
                        </section>

                        <section>
                            <div class="sec-head"><span class="sec-num">4</span><span class="sec-title">Declaration &amp; Signature</span><span class="sec-line"></span></div>
                            <p style="font-size:10px;line-height:1.5;margin:0 0 12px;color:#3a4050;">I&nbsp;/&nbsp;we have read and understood this Undertaking in its entirety and sign it freely, knowingly, and voluntarily.</p>
                            <div class="sign-grid">
                                <div class="sign-block"><div class="sline"></div><div class="slabel">Signature of Traveler</div></div>
                                <div class="sign-block"><div class="sline"></div><div class="slabel">Printed Name</div></div>
                                <div class="sign-block"><div class="sline"></div><div class="slabel">Date</div></div>
                                <div class="sign-block"><div class="sline"></div><div class="slabel">Witness / Company Representative</div></div>
                            </div>
                        </section>

                        <div class="disclaimer">
                            <h4>Important Notice &amp; Legal Disclaimer</h4>
                            <p>KONNECT.US INC. (&ldquo;the Company&rdquo;) operates as an independent travel agent and facilitator. The Company does not own, manage, control, or operate any third&#8209;party supplier of transport, accommodation, guiding, or other services and shall not be liable for any act, error, omission, injury, loss, damage, delay, or irregularity caused by such third parties or by events beyond its reasonable control, including but not limited to acts of God, civil unrest, government action, or force majeure.</p>
                            <p>This Undertaking is not a contract of insurance and does not replace travel, medical, or trip&#8209;cancellation coverage, which travelers are strongly advised to obtain independently. Travelers are responsible for monitoring and complying with all U.S. Department of State travel advisories and entry requirements for Pakistan. This document shall be governed by and construed under the laws of the State of New York, USA, and any dispute shall be subject to the exclusive jurisdiction of its courts. If any provision is held unenforceable, the remaining provisions shall continue in full force and effect.</p>
                        </div>

                        <div class="foot">
                            <span class="tag">Explore and Discover the Globe</span>
                            <span>KONNECT.US INC. · Traveler&rsquo;s Undertaking · Page 2 of 2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script type="text/javascript">
    function printUndertaking() {
        // Persist typed values into the DOM so they survive the print swap.
        document.querySelectorAll('#utkPrint input').forEach(function (i) {
            if (i.value) i.setAttribute('value', i.value); else i.removeAttribute('value');
        });
        var printContents = document.getElementById('utkPrint').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
