@extends('layouts.app')
@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url({{ asset('assets/images2/newbanner1.jpg') }});     background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">{{ @$hotel->name }}</h1>
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
                        <h5 class="dash-style">HOTEL DETAIL</h5>
                        <h2>{{ @$hotel->name }}</h2>
                        <p>
                        We are connected with five stars hotels in pakistan for your better experience.Immerse yourself in the memories, capturing the essence of each journey and the unique moments that define our travel experiences. Travel back in time through these evocative images.</p>
                     </div>
                     <div class="contact-detail-wrap pl-0">
                        <div class="details-list">
                           <ul>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Address</h4>
                                    <span>{{ @$hotel->address }}</span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>City</h4>
                                    <span>{{ @$hotel->city }}</a></span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Country</h4>
                                    <span>{{ @$hotel->state }}</span>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-detail-wrap">
                     <img src="{{ asset('hotels/'.@$hotel->image) }}" style="width: 100%; border-radius: 30px; height: 400px !important;">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- contact form html end -->
</main>

@endsection