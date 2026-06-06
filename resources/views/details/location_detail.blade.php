@extends('layouts.app')
@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url({{ asset('assets/images2/newbanner1.jpg') }});     background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">{{ @$location->name }}</h1>
            </div>
         </div>
      </div>
      {{-- <div class="inner-shape"></div> --}}
   </section>
   <!-- Inner Banner html end-->
   <!-- contact form html start -->
   <div class="contact-page-section">
      <div class="contact-form-inner">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="contact-from-wrap">
                     <div class="section-heading">
                        <h5 class="dash-style">LOCATION DETAIL</h5>
                        <h2>{{ @$location->name }}</h2>
                        <p>
                        These places widely recognized and frequented by people due to its significance, attractions, or accessibility. These locations often hold cultural, historical, or natural importance, drawing visitors from various regions.</p>
                     </div>
                     <div class="contact-detail-wrap pl-0">
                        <div class="details-list">
                           <ul>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>City</h4>
                                    <span>{{ @$location->city }}</a></span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>State</h4>
                                    <span>{{ @$location->state }}</span>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-detail-wrap">
                     <img src="{{ asset('locations/'.@$location->image) }}" style="width: 100%; border-radius: 30px; height: 400px !important;">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- contact form html end -->
</main>

@endsection