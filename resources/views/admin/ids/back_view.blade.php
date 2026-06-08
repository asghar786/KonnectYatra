@extends('admin.layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
<style type="text/css">
  .idcards{--navy:#16294d;--navy-deep:#0f1d39;--navy-2:#1d3461;--orange:#e8601c;--orange-soft:#f2843f;--ink:#1b2436;--paper:#fff;--line:#e4e8f0;--muted:#6b7689;}
  .idcards *{box-sizing:border-box;}
  .id-deck{display:flex;flex-wrap:wrap;gap:26px;justify-content:center;padding:10px 0 30px;}
  .id-slot{width:550px;height:347px;overflow:hidden;}
  .id-slot .card{transform:scale(.625);transform-origin:top left;}

  .idcards .card{width:880px;height:555px;border-radius:22px;overflow:hidden;background:var(--paper);position:relative;font-family:'Archivo',system-ui,sans-serif;color:var(--ink);
    box-shadow:0 1px 0 rgba(255,255,255,.7) inset,0 24px 48px -18px rgba(22,41,77,.45),0 6px 16px -8px rgba(22,41,77,.3);}
  .idcards .back{display:flex;flex-direction:column;}
  .idcards .back-head{background:radial-gradient(120% 140% at 14% 0%,var(--navy-2),var(--navy) 55%,var(--navy-deep));color:#fff;padding:22px 30px;display:flex;align-items:center;gap:16px;}
  .idcards .back-head .gmark{height:50px;width:auto;filter:brightness(2);}
  .idcards .back-head .ht{flex:1;}
  .idcards .back-head .ht .o{font-size:22px;font-weight:900;letter-spacing:.01em;}
  .idcards .back-head .ht .o em{color:var(--orange-soft);font-style:normal;}
  .idcards .back-head .ht .t{font-family:'IBM Plex Mono',monospace;font-size:11px;letter-spacing:.1em;color:#aebbd4;margin-top:3px;}
  .idcards .back-head .web{text-align:right;font-family:'IBM Plex Mono',monospace;font-size:12px;color:#fff;}
  .idcards .back-head .web b{color:var(--orange-soft);display:block;font-size:11px;letter-spacing:.06em;}
  .idcards .magstripe{height:44px;background:repeating-linear-gradient(90deg,#0c1426 0 3px,#13203a 3px 6px);}
  .idcards .back-body{flex:1;display:grid;grid-template-columns:1fr 230px;gap:26px;padding:26px 30px 18px;}
  .idcards .terms h4{font-family:'IBM Plex Mono',monospace;font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:var(--navy);font-weight:600;margin-bottom:10px;display:flex;align-items:center;gap:8px;}
  .idcards .terms h4::before{content:"";width:14px;height:2px;background:var(--orange);display:inline-block;}
  .idcards .terms ul{list-style:none;display:flex;flex-direction:column;gap:7px;padding:0;margin:0;}
  .idcards .terms li{font-size:12px;line-height:1.45;color:#42506a;padding-left:14px;position:relative;}
  .idcards .terms li::before{content:"";position:absolute;left:0;top:7px;width:5px;height:5px;border-radius:50%;background:var(--orange);}
  .idcards .return{margin-top:18px;border:1px solid var(--line);border-left:3px solid var(--orange);border-radius:10px;padding:13px 15px;background:#fafbfd;}
  .idcards .return .l{font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:var(--orange);font-weight:600;}
  .idcards .return .a{margin-top:6px;font-size:13px;font-weight:600;color:var(--navy);line-height:1.4;}
  .idcards .qrcol{display:flex;flex-direction:column;align-items:center;gap:10px;}
  .idcards .qr{width:150px;height:150px;border-radius:12px;background:#fff;border:1px solid var(--line);padding:10px;box-shadow:0 8px 18px -12px rgba(22,41,77,.4);}
  .idcards .qr canvas{display:block;width:100%;height:100%;image-rendering:pixelated;}
  .idcards .qrcap{font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);}
  .idcards .cardno{font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:600;color:var(--navy);letter-spacing:.04em;}
  .idcards .back-foot{border-top:1px solid var(--line);padding:14px 30px 0;display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:end;}
  .idcards .sig{display:flex;flex-direction:column;}
  .idcards .sig .line{height:1px;background:var(--navy);opacity:.35;margin-bottom:6px;}
  .idcards .sig .l{font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);}
  .idcards .barcode{display:flex;flex-direction:column;align-items:flex-end;gap:6px;}
  .idcards .barcode canvas{height:46px;width:230px;}
  .idcards .barcode .n{font-family:'IBM Plex Mono',monospace;font-size:11px;letter-spacing:.22em;color:var(--navy);}
  .idcards .legal{grid-column:1 / -1;margin-top:12px;font-family:'IBM Plex Mono',monospace;font-size:9.5px;letter-spacing:.04em;color:var(--muted);border-top:1px dashed var(--line);padding:9px 0 16px;text-align:center;}

  @media print{
    body{background:#fff;}
    .id-deck{display:block;gap:0;padding:0;}
    .id-slot{width:auto;height:auto;overflow:visible;page-break-after:always;text-align:center;}
    .id-slot .card{transform:none;display:inline-block;}
  }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">ID — Back View</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>Back View</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                <button class="btn btn-success" type="button" onclick="printDiv('idDeck')">Print</button>
                <a class="btn btn-info ml-2" href="{{ url('admin/staff_ids', $page ?? 1) }}">Front View</a>
            </div>
        </div>
        <div class="main-body pt-3 idcards">
            <div class="id-deck" id="idDeck">
                @forelse($staff_ids as $value)
                <div class="id-slot">
                    <div class="card back">
                        <div class="back-head">
                            <img class="gmark" src="{{ asset('assets2/id/globe.png') }}" alt="" />
                            <div class="ht">
                                <div class="o">KONNECT YATRA <em>· USA</em></div>
                                <div class="t">Explore and Discover the Globe</div>
                            </div>
                            <div class="web"><b>WEBSITE</b>www.konnectyatra.org</div>
                        </div>
                        <div class="magstripe"></div>
                        <div class="back-body">
                            <div class="terms">
                                <h4>Conditions of Use</h4>
                                <ul>
                                    <li>This card is the property of Konnect.US Inc. and remains valid only while the holder is in active service.</li>
                                    <li>It is non-transferable and must be presented on request to authorized personnel.</li>
                                    <li>Misuse, alteration, or unauthorized duplication will result in immediate revocation.</li>
                                    <li>Report a lost or stolen card to the office within 24 hours.</li>
                                </ul>
                                <div class="return">
                                    <div class="l">If found, please return to</div>
                                    <div class="a">Konnect.US Inc. — 18502 Hillside Avenue, Jamaica, NY 11432</div>
                                </div>
                            </div>
                            <div class="qrcol">
                                <div class="qr"><canvas class="qrc" width="130" height="130" data-seed="11"></canvas></div>
                                <div class="qrcap">Scan to verify</div>
                                <div class="cardno">www.konnectyatra.org</div>
                            </div>
                        </div>
                        <div class="back-foot">
                            <div class="sig">
                                <div class="line"></div>
                                <div class="l">Authorized Signatory</div>
                            </div>
                            <div class="barcode">
                                <canvas class="barc" width="230" height="46" data-seed="42"></canvas>
                                <div class="n">KONNECT YATRA · USA</div>
                            </div>
                            <div class="legal">© {{ date('Y') }} Konnect.US Inc. · Explore and Discover the Globe · This credential is issued for identification purposes only.</div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No crew members found.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    function makeRnd(seed){ return function(){ seed=(seed*1103515245+12345)&0x7fffffff; return seed/0x7fffffff; }; }
    (function(){
        document.querySelectorAll('canvas.qrc').forEach(function(c){
            var ctx=c.getContext('2d'); var N=29, s=c.width/N;
            var rnd=makeRnd(parseInt(c.dataset.seed||'7',10)*1000+7);
            ctx.clearRect(0,0,c.width,c.height); ctx.fillStyle=c.dataset.color||'#16294d';
            var grid=Array.from({length:N},function(){return Array(N).fill(false);});
            for(var y=0;y<N;y++)for(var x=0;x<N;x++) grid[y][x]=rnd()>0.5;
            function finder(ox,oy){
                for(var y=0;y<7;y++)for(var x=0;x<7;x++){ var edge=(x===0||x===6||y===0||y===6),core=(x>=2&&x<=4&&y>=2&&y<=4); grid[oy+y][ox+x]=edge||core; }
                for(var y=-1;y<8;y++)for(var x=-1;x<8;x++){ var gx=ox+x,gy=oy+y; if(gx<0||gy<0||gx>=N||gy>=N)continue; if(x===-1||x===7||y===-1||y===7) grid[gy][gx]=false; }
            }
            finder(0,0);finder(N-7,0);finder(0,N-7);
            for(var y=0;y<N;y++)for(var x=0;x<N;x++) if(grid[y][x]) ctx.fillRect(Math.floor(x*s),Math.floor(y*s),Math.ceil(s),Math.ceil(s));
        });
        document.querySelectorAll('canvas.barc').forEach(function(c){
            var ctx=c.getContext('2d'); ctx.clearRect(0,0,c.width,c.height); ctx.fillStyle=c.dataset.color||'#16294d';
            var rnd=makeRnd(parseInt(c.dataset.seed||'42',10)*131+5); var x=2;
            while(x<c.width-2){ var w=1+Math.floor(rnd()*3); if(rnd()>0.45) ctx.fillRect(x,0,w,c.height); x+=w+1+Math.floor(rnd()*2); }
        });
    })();
</script>
@endsection
