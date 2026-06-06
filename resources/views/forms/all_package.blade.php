@extends('layouts.app')
@section('content')
<style type="text/css">
  .bg-blue{
    background: #f54e18;
    border-radius: 10px;
    padding: 15px 0px;
    color: white;
  }
  .pricing-content{position:relative;}
  .pricing_design{
    position: relative;
/*        margin: 0px 15px;*/
}
.pricing_design .single-pricing{
  background:#f54e18;
  padding: 60px 40px;
  border-radius:30px;
  box-shadow: 0 10px 40px -10px rgba(0,64,128,.2);
  position: relative;
  z-index: 1;
}
.pdsi{
  margin-left: 30px !important;
}
.pricing_design .single-pricing:before{
  content: "";
  background-color: #fff;
  width: 100%;
  height: 100%;
  border-radius: 18px 18px 190px 18px;
  border: 1px solid #eee;
  position: absolute;
  bottom: 0;
  right: 0;
  z-index: -1;
}
.price-head{}
.price-head h2 {
  margin-bottom: 20px;
  font-size: 26px;
  font-weight: 600;
}
.price-head h1 {
  font-weight: 600;
  margin-top: 30px;
  margin-bottom: 5px;
}
.single-pricing ul{
  list-style: none !important;
      margin-top: 15px !important;
}
.pdfa{
	margin-top: 15px !important;
	margin-left: 15px !important;
	margin-bottom: 0px!important;
}
.price-head span{}

.single-pricing ul{list-style:;margin-top: 30px;}
.single-pricing ul li {
  line-height: 30px;

}
.single-pricing ul li i {
  background: #554c86;
  color: #fff;
  width: 20px;
  height: 20px;
  border-radius: 30px;
  font-size: 11px;
  text-align: left;
  line-height: 20px;
  margin-right: 9px;
}
.pricing-price{}

.price_btn {
  background: #f54e18;
  padding: 10px 30px;
  color: #fff;
  display: inline-block;
  margin-top: 20px;
  border-radius: 2px;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}
.price_btn:hover{
  background:#f54e18;
  color: white !important;
  text-decoration: none;
}
a{
  text-decoration:none;    
}
.tab-content ul li {
    list-style: disc !important;
    margin-bottom: 3px !important;
    margin-left: 30px !important;
}
.section-title {
  margin-bottom: 60px;
}
.text-center {
  text-align: center!important;
}

.section-title h2 {
  font-size: 45px;
  font-weight: 600;
  margin-top: 0;
  position: relative;
  text-transform: capitalize;
}

.package-main{
	max-width: 1250px !important;
}

.bootstrap-select {
    display: none;
}

</style>

<main id="content" class="site-main">

  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" 
    style="background-image: url(public/assets/images2/Inner-banner-01.png);background-position: center !important;">
    <div class="container">
    <div class="inner-banner-content">
       <h1 class="inner-title" style="font-size:65px !important;">PACKAGES</h1>
     </div>
   </div>
</div>
</section>
<section class="package-section">
  <div class="container">

    <div class="col-12 mt-4">
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
      </div>
      @endif
    </div>
    <div class="row py-5">
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
    <div class="package-inner">
      <div class="row">
        <!-- @if(count(@$all_packages) > 0)
        @foreach(@$all_packages as $key => $val)
        <div class="col-lg-4 col-md-6 mb-5">
          <div class="package-wrap">
            <figure class="feature-image m-0">
              <a href="">
                <img src="{{ asset('assets/flyers/'.@$val['image']) }}" style="width: 100%; border-radius: 30px; height: 500px !important;" alt="">
              </a>
            </figure>
            <div class="package-content-wrap">
              <div class="package-content" style="padding: 0 11px 0;">
                
              </div>
            </div>

          </div>
          <div class="btn-wrap d-flex justify-content-center ">
            <a href="{{ url("all-packages", @$val->id) }}" class="button-text  width-6 btn-slider mt-0" style="    padding: 13px 50px !important;">Book Now</a>
          </div>
        </div>
        @endforeach
        @endif -->
        {{-- <div class="col-12">
          <h2 class="text-center" style="margin-top: 90px;">Vaisakhi Package to Nankana Sahib, Pakistan<br>
            <span class="" style="font-size: 25px;"> Leaving 08 April and Returning 20 April, 2024</span></h2>
          </div>

        </div> --}}
      </div>
    </div>
  </section>
  <section id="pricing" class="pricing-content section-padding container package-main">                              
    
  <div class="row">
  <div class="col-12 col-md-12 col-lg-12">
  <ul class="nav nav-tabs nav-justified" role="tablist">
    <li class="nav-item" id="rounddtrip">
      <a class="nav-link active" style="font-size: 20px;" data-toggle="tab" href="#vaisakhi" role="tab" aria-controls="vaisakhi" aria-selected="false">Vaisakhi Packages</a>
    </li>
    <li class="nav-item" id="oneeside">
      <a class="nav-link" style="font-size: 20px;" data-toggle="tab" href="#birthday" role="tab" aria-controls="birthday" aria-selected="true">GURPURAB Packages</a>
    </li>
    <li class="nav-item" id="vipside">
      <a class="nav-link" style="font-size: 20px;" data-toggle="tab" href="#vip" role="tab" aria-controls="vip" aria-selected="true">VIP Packages</a>
    </li>
  </ul>

  <div class="tab-content mt-3">
    <div class="tab-pane active" id="vaisakhi" role="tabpanel" aria-labelledby="chicken-tab">
      <div class="row "> 
        <div class="col-lg-12 d-flex justify-content-center">
          <p>No package found</p>
        </div>
    <!-- @if(count(@$all_packages) > 0)-->
    <!-- @foreach(@$all_packages as $key => $val)                    -->
    <!-- <div class="col-lg-6 col-sm-12 mt-5">-->
    <!--  <div class="pricing_design">-->
    <!--    <div class="single-pricing">-->
    <!--      <h3 class="text-center mb-5">-->
    <!--        {{ @$val->name }}-->
    <!--      </h3>-->
    <!--      <div class="price-head ">       -->
    <!--        <h5 class="text-center bg-blue">-->
    <!--          {{ @$val->state }} 5* Hotel package <span style="font-size: 15px;">(per person)</span>-->
    <!--        </h5>-->
    <!--        <div class="row">-->
    <!--          <div class="col-md-6 text-center">-->
    <!--            <p class="text-center mt-3">-->
    <!--              Round trip -->
    <!--            </p>-->
    <!--            <h4 style="margin-top: -15px;"><sub><del style="font-size: 14px; color: red;">$3300</del></sub> ${{ @$val->five_star_round_price }}</h4>-->
    <!--            <p style="color: green; font-size: 14px; margin-top: -7px;">Special Discount</p>-->
    <!--          </div>-->
    <!--          <div class="col-md-6 text-center">-->
    <!--            <p class="text-center mt-3">One Way</p>-->
    <!--            <h4 style="margin-top: -15px;"><sub><del style="font-size: 14px; color: red;">$2700</del></sub> ${{ @$val->five_star_single_price }}</h4>-->
    <!--            <p style="color: green; font-size: 14px; margin-top: -7px;">Special Discount</p>-->
    <!--          </div>  -->
    <!--        </div>-->
            <!--<h5 class="text-center mt-4 bg-blue">-->
            <!--  {{ @$val->state }} 4* Hotel package <span style="font-size: 15px;">(per person)</span>-->
            <!--</h5>-->
    <!--        <div class="row">-->
            <!--  <div class="col-md-6 text-center">-->
            <!--    <p class="text-center mt-3">-->
            <!--      Round trip -->
            <!--    </p>-->
            <!--    <h4 style="margin-top: -15px;">${{ @$val->four_star_round_price }}</h4>-->
            <!--  </div>-->

            <!--  <div class="col-md-6 text-center">-->
            <!--    <p class="text-center mt-3">One Way</p>-->
            <!--    <h4 style="margin-top: -15px;">${{ @$val->four_star_single_price }}</h4>-->
            <!--  </div>  -->
    <!--          {!! @$val->sdescription !!}-->
    <!--        </div>-->
            
    <!--        <div class="pricing-price pt-5">-->
    <!--          <a href="{{ url("agreement", @$val->id) }}" class="button-text  width-6 btn-slider mt-0" style="    padding: 13px 50px !important;">Book Now</a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <!--@endforeach-->
    <!--@else-->
    <!--<div class="col-lg-12 d-flex justify-content-center">-->
    <!--  <p>No package found</p>-->
    <!--</div>-->
    <!--@endif-->
  </div>
    </div>
    <div class="tab-pane" id="birthday" role="tabpanel" aria-labelledby="duck-tab">
      <div class="row">
     @if(count(@$all_packages1) > 0)
     <div class="col-lg-6 col-sm-12 mb-5">
      <div class="pricing_design">
        <div class="single-pricing">
          <div class="state mb-5">
             <label><b>Select State</b></label>
             <select class="form-control" id="state">
                 <option value="13">New York</option>
                 <option value="14">Washington Dulles</option>
                 <option value="15">Los Angeles</option>
                 <option value="17">Chicago</option>
                 <option value="16">Seattle</option>
                 <option value="18">Toronto</option>
             </select>
          </div>
          @foreach(@$all_packages1 as $key => $val)
          <div class="all_states state_{{ $val->id }}" @if($key !== 0) style="display: none;" @endif>
              <h3 class="text-center mb-5">
                {{ @$val->name }}
              </h3>
              <div class="price-head ">       
                <h5 class="text-center bg-blue">
                  {{ @$val->state }} 5* Hotel package <span style="font-size: 15px;">(per person)</span>
                </h5>
                <div class="row">
                  <div class="col-md-6 text-center">
                    <p class="text-center mt-3">
                      Round trip 
                    </p>
                    <h4 style="margin-top: -15px;">${{ @$val->five_star_round_price }}</h4>
                  </div>
                  <div class="col-md-6 text-center">
                    <p class="text-center mt-3">One Way</p>
                    <h4 style="margin-top: -15px;">${{ @$val->five_star_single_price }}</h4>
                  </div>  
                </div>
                <h5 class="text-center mt-4 bg-blue">
                  {{ @$val->state }} 4* Hotel package <span style="font-size: 15px;">(per person)</span>
                </h5>
                <div class="row">
                  <div class="col-md-6 text-center">
                    <p class="text-center mt-3">
                      Round trip 
                    </p>
                    <h4 style="margin-top: -15px;">${{ @$val->four_star_round_price }}</h4>
                  </div>
    
                  <div class="col-md-6 text-center">
                    <p class="text-center mt-3">One Way</p>
                    <h4 style="margin-top: -15px;">${{ @$val->four_star_single_price }}</h4>
                  </div>  
                  {!! @$val->sdescription !!}
                </div>
                
                <div class="pricing-price pt-5">
                  <a href="{{ url("all-packages", @$val->id) }}" class="button-text  width-6 btn-slider mt-0" style="    padding: 13px 50px !important;">Book Now</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    @else
    <div class="col-lg-12 d-flex justify-content-center">
      <p>No package found</p>
    </div>
    @endif
  </div>
    </div>
    <div class="tab-pane" id="vip" role="tabpanel" aria-labelledby="duck-tab">
      <div class="row ">  
     @if(count(@$all_packages2) > 0)
     <!--@foreach(@$all_packages2 as $key => $val)                    -->
     <div class="col-lg-6 col-sm-12 mb-5">
      <div class="pricing_design">
        <div class="single-pricing">
          <h3 class="text-center mb-5">
            SPECIAL LAND PACKAGE
          </h3>
          <div class="price-head ">       
            <h5 class="text-center bg-blue">
              5* Hotel package <span style="font-size: 15px;">(per person)</span>
            </h5>
            <div class="row">
              <div class="col-md-12 text-center">
                <p class="text-center mt-3">
                  Starting from <b style="font-size: 20px;">$950</b> for <b style="font-size: 16px;">5</b> Nights & <b style="font-size: 16px;">6</b> Days
                </p>
              </div>
            </div>
            <h5 class="text-center mt-4 bg-blue">
              4* Hotel package <span style="font-size: 15px;">(per person)</span>
            </h5>
            <div class="row">
              <div class="col-md-12 text-center">
                <p class="text-center mt-3">
                  Starting from <b style="font-size: 20px;">$750</b> for <b style="font-size: 16px;">5</b> Nights & <b style="font-size: 16px;">6</b> Days
                </p>
              </div>
              {!! @$val->sdescription !!}
            </div>
            
            <div class="pricing-price pt-5">
              <a href="{{ url("special-package") }}" class="button-text width-6 btn-slider mt-0" style="padding: 13px 50px !important;">Book Now</a>
            </div>
          </div>
        </div>
      </div>
    <!--</div>-->
    @endforeach
    @else
    <div class="col-lg-12 d-flex justify-content-center">
      <p>No package found</p>
    </div>
    @endif
  </div>
    </div>
  </div>
  
</div>
</div>
</section>



</main>

<script>
  (function() {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms).forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          var firstInvalidElement = form.querySelector(':invalid');
          firstInvalidElement.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
        }

        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
<script>
  $(document).ready(function() {
    $(document).on("change", "#state", function () {
        var selected = $(this).find("option:selected").val();
        $(".all_states").fadeOut();
        $(".state_"+selected).fadeIn();
    });
    
      // Attach click event listener to each checkbox
    $("#package_1, #package_2, #package_3").click(function() {
        // If a checkbox is checked, enable the other two
      if ($(this).is(":checked")) {
        $("#package_1, #package_2, #package_3").not(this).prop("disabled", true);
      }
        // If a checkbox is unchecked, enable the other two
      else {
        $("#package_1, #package_2, #package_3").prop("disabled", false);
      }
    });
  });
</script>
<script>
    // Add event listeners to all the package checkboxes
  $("input[type='checkbox']").change(function() {
    var checked = $(this).is(":checked");
    var container = $(this).closest(".col-lg-4");
    container.find("input[type='radio']").prop("disabled", !checked);
    container.find("input[type='radio']").prop("required", true);
  });
</script>
<script>
  $(document).ready(function() {
      // Attach click event listener to radio buttons
    $('input[name="first_visit"]').on('click', function() {
        // If yes is selected, show the div
      if ($(this).val() === 'yes') {
        $('#previous-visit').prop('required', false);
        $('#entry-port').prop('required', false);
        $('#first-visit').hide();
      }
        // If no is selected, hide the div
      else {
        $('#previous-visit').prop('required', true);
        $('#entry-port').prop('required', true);
        $('#first-visit').show();
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
      // Attach click event listener to radio buttons
    $('input[name="us_passport"]').on('click', function() {
        // If yes is selected, show the div
      if ($(this).val() === 'yes') {
        $('#green-card').prop('required', true);
      }
        // If no is selected, hide the div
      else {
        $('#green-card').prop('required', false);
      }
    });
  });
</script>
@endsection
