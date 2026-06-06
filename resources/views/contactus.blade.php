@extends('layouts.app')
@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url(public/assets/images2/newbanner1.jpg);     background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">CONTACT US</h1>
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
                        <h5 class="dash-style">GET IN TOUCH</h5>
                        <h2>CONTACT US TO GET MORE INFO</h2>
                        <p>
                        Don't hesitate to reach out to us for more information. Contact us, and we'll be happy to provide you with the details you need. We're here to assist you in any way we can.</p>
                     </div>
                     <form class="contact-from contact-bx ajax-form" action="{{ url('contactus') }}" method="POST">
                        @csrf
                        <div class="ajax-message"></div>
                        <p>
                           <input type="text" required name="name" placeholder="Your Name*">
                        </p>
                        <p>
                           <input type="email" required name="email" placeholder="Your Email*">
                        </p>
                        <p>
                           <input type="tel" required name="phone" placeholder="Your Phone*">
                        </p>
                        <p>
                           <input type="text" required name="subject" placeholder="Your Subject*">
                        </p>
                        <p>
                           <textarea rows="8" placeholder="Type Message*" name="message" required></textarea>
                        </p>
                        <p>
                           <input type="submit"  name="submit" value="SUBMIT MESSAGE">
                        </p>
                     </form>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-detail-wrap">
                     <h3>Need help ?? Feel free to contact us !</h3>
                     <p>
                     For any assistance or inquiries, please don't hesitate to reach out to us. We're here to help! Feel free to contact us with your questions, concerns, or any support you may need. Your satisfaction is our priority, and we look forward to assisting you.</p>
                     <div class="details-list">
                        <ul>
                           <li>
                              <span class="icon">
                                 <i class="fas fa-map-signs"></i>
                              </span>
                              <div class="details-content">
                                 <h4>Location Address</h4>
                                 <span>18502 Hillside Avenue, Jamaica, NY 11432</span>
                              </div>
                           </li>
                           <li>
                              <span class="icon">
                                 <i class="fas fa-envelope-open-text"></i>
                              </span>
                              <div class="details-content">
                                 <h4>Email Address</h4>
                                 <span><a href="mailto:rm@konnectyatra.org" class="__cf_email__">rm@konnectyatra.org</a></span>
                              </div>
                           </li>
                           <li>
                              <span class="icon">
                                 <i class="fas fa-phone-volume"></i>
                              </span>
                              <div class="details-content">
                                 <h4>Phone Number</h4>
                                 <span>+1 718-908-9464</span>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="contct-social social-links">
                        <h3>Follow us on social media..</h3>
                        <ul>
                           <li><a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="map-section">
         <div class="mapouter">
            <div class="gmap_canvas">
               <iframe src="https://maps.google.com/maps?q=18502%20Hillside%20Avenue,%20Jamaica,%20NY%2011432&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed" frameborder="0" scrolling="no" style="width: 100%; height: 400px;"></iframe><style>.mapouter{position:relative;height:400px;width:100%;background:#fff;} .maprouter a{color:#fff !important;position:absolute !important;top:0 !important;z-index:0 !important;}</style>
               <a href="https://blooketjoin.org/">blooket</a>
               <style>.gmap_canvas{overflow:hidden;height:400px;width:100%}.gmap_canvas iframe{position:relative;z-index:2}</style>
            </div>
         </div>
      </div>
   </div>
   <!-- contact form html end -->
</main>

@endsection