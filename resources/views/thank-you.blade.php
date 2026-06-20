@extends('layouts.app')
@section('content')

<style type="text/css">
    .owl-prev, .owl-next, .back-to-top, .btn {
        background-color: #f54e18 !important;
        color: #fff !important;
    }
    .title-head {
        border-color: #f54e18 !important;
    }
    .btn.dropdown-toggle.btn-default {
        color: #000 !important;
    }
</style>

<!-- Content -->
<div class="page-content bg-white">
    <!-- inner page banner -->
    <section class="inner-banner-wrap pb-0">
      <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('thank-you', asset('assets/images2/Inner-banner-01.png')) }}');background-position: center !important;">
          <div class="container">
            <div class="inner-banner-content">
                <h1 class="inner-title" style="font-size:65px !important;">THANK YOU</h1>
           </div>
       </div>
   </div>
</section>
<!-- inner page banner -->
<div class="page-banner contact-page section-sp2 mb-0">
    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <h3 class="text-center">Wahe Guru Ji ka Khalsa</h3>
            </div>
            <div class="col-4">
                <h4 class="text-center mt-2">(First Come First Serve)</h4>
            </div>
            <div class="col-4">
                <h3 class="text-center">Wahe Guru Ji ki Fateh</h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-12">
                        <h2 class="text-center" style="margin-top: 90px;">Thank You for the booking.</h2>
                    </div>
                    @if(session('paylater'))
                    @php $pl = session('paylater'); @endphp
                    <div class="col-lg-8 offset-lg-2">
                        <div class="p-4 mt-3" style="background:#fff4ef;border:1px solid #ffd9c9;border-radius:12px;text-align:center;">
                            <p style="font-size:18px;margin-bottom:8px;">Your Order Number: <b style="color:#f54e18;">{{ $pl['order_no'] }}</b></p>
                            @if(!empty($pl['email_sent']) && !empty($pl['email']))
                            <p style="margin-bottom:8px;">Your booking and payment details have been sent to your primary email: <b>{{ $pl['email'] }}</b>.</p>
                            @elseif(!empty($pl['email']))
                            <p style="margin-bottom:8px;">Your booking is confirmed against <b>{{ $pl['email'] }}</b>. (We couldn't send the email right now — please contact us if you don't receive it.)</p>
                            @endif
                            <p style="margin-bottom:0;">This booking is valid for <b>30 days</b> for payment (pay before <b>{{ $pl['valid_until'] }}</b>).</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- inner page banner END -->
</div>
<!-- Content END-->
@endsection
