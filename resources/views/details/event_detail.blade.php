@extends('layouts.app')
@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url({{ asset('assets/images2/newbanner1.jpg') }});     background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">OUR UPCOMING EVENT</h1>
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
                        <h5 class="dash-style">UPCOMING EVENT DETAIL</h5>
                        <h2>{{ @$event->title }}</h2>
                        <p>
                        Engage your intellect at upcoming Gurdwara events, nourishing your mind with enlightening experiences. Join us for enriching gatherings that stimulate thought and foster spiritual growth. Feed your brain with the wisdom and insights shared in these upcoming events at the Gurdwara.</p>
                     </div>
                     <div class="contact-detail-wrap pl-0">
                        <div class="details-list">
                           <ul>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Date</h4>
                                    <span>{{ date('d F Y', strtotime(@$event->event_date)) }}</span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Time</h4>
                                    <span>{{ @$event->event_time }}</span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Location</h4>
                                    <span>{{ @$event->location }}</span>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-detail-wrap">
                     <img src="{{ asset('news_and_events/'.@$event->image) }}" style="width: 100%; border-radius: 30px; height: 400px !important;">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- contact form html end -->
</main>

@endsection