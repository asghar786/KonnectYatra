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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- inner page banner END -->
</div>
<!-- Content END-->
@endsection
