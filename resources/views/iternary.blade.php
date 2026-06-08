@extends('layouts.app')
@section('content')
<style>
    .listt {
    scrollbar-width: thin;
    scrollbar-color: #BBB #EEE;
}

.listt::-webkit-scrollbar {
  width: 10px;
}

.listt::-webkit-scrollbar-track {
  background: #C0C3C6;
}
.btn-group.bootstrap-select.form-control {
    display: none;
}
.listt::-webkit-scrollbar-thumb {
  background-color: #888;
  border-radius: 10px;
  border: 3px solid #C0C3C6;
}
input[list]:focus {
    outline: none;
}
input[list] + div[list] {
    display: none;
    position: absolute;
    width: 95% !important;
    max-height: 164px;
    overflow-y: auto;
    max-width: 538px;
    background: #FFFFFF;
    border: var(--border);
    border-top: none;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 3px 3px -3px #333;
    z-index: 100;
}
input[list] + div[list] span {
    display: block;
    padding: 7px 5px 7px 20px;
    color: black;
    background-color: #F7F7F7;
    text-decoration: none;
    cursor: pointer;
}
input[list] + div[list] span:not(:last-child) {
  border-bottom: 1px solid #EEE;
}
input[list] + div[list] span:hover {
    background-color: #f54e18;
    color:white;
}
.dropdown-toggle:hover, .dropdown-toggle:focus {
    color: black !important;
}
/* ===== Itinerary page polish ===== */
.itin-wrap{--brand:#f54e18;--ink:#1c2541}
.itin-card{background:#fff;border:1px solid #eef0f4;border-radius:22px;box-shadow:0 18px 55px rgba(28,37,65,.13);padding:30px 34px}
.itin-wrap .nav-tabs{border:0 !important;display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-bottom:6px}
.itin-wrap .nav-tabs .nav-item{margin:0}
.itin-wrap .nav-tabs .nav-link{border:1px solid #e7e9ef !important;border-radius:30px;color:var(--ink) !important;font-weight:600;font-size:15px;padding:10px 28px;background:#fff;transition:.15s}
.itin-wrap .nav-tabs .nav-link:hover{border-color:var(--brand) !important;color:var(--brand) !important}
.itin-wrap .nav-tabs .nav-link.active{background:var(--brand) !important;border-color:var(--brand) !important;color:#fff !important;box-shadow:0 8px 18px rgba(245,78,24,.28)}
.itin-wrap label{font-weight:600;color:#374151;font-size:14px;margin-bottom:5px}
.itin-wrap .form-control{border:1px solid #e2e4ea;border-radius:12px;padding:12px 15px;height:auto;font-size:14.5px;transition:border-color .15s,box-shadow .15s}
.itin-wrap .form-control:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(245,78,24,.12)}
.itin-wrap .input-form > div{margin-bottom:12px}
.itin-wrap .addcity{color:var(--brand) !important;font-weight:600;cursor:pointer}
.itin-wrap .removecity{cursor:pointer;font-weight:600}
.itin-wrap #passengers-detail,.itin-wrap #submit-booking{background:var(--brand) !important;color:#fff !important;border:0;border-radius:30px;font-weight:700;font-size:15px;padding:13px 46px !important;box-shadow:0 8px 18px rgba(245,78,24,.3);transition:transform .15s;cursor:pointer}
.itin-wrap #passengers-detail:hover,.itin-wrap #submit-booking:hover{transform:translateY(-2px)}
.itin-head{margin-bottom:22px}
.itin-head h5{color:var(--brand)}
.itin-head h2{font-weight:700;color:var(--ink)}
.itin-head p{color:#6b7280;max-width:640px;margin:8px auto 0}
@media (max-width:575px){.itin-card{padding:22px 18px}}
</style>
<section class="inner-banner-wrap pb-0">
  <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('itinerary', asset('assets/images2/bg-img-1.jpg')) }}');background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
           <h1 class="inner-title" style="font-size:65px !important;">TRAVEL WITH US</h1>
       </div>
   </div>
</div>
</section>

<section class="package-section itin-wrap" style="margin-top:-90px !important;position:relative;z-index:5;">

    <div class="container">
        <div class="itin-card">
        <div class="itin-head text-center">
            <h5 class="dash-style">BOOK YOUR FLIGHT</h5>
            <h2>Plan Your Journey</h2>
            <p>Search round trip, one way or multi-city flights — share your details and our team will get back to you with the best fares.</p>
        </div>
        @if(session('status'))
        <div class="row mt-4">
           <div class="col-lg-12">
            <div class="alert alert-success" role="alert">
                {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        <form action="{{route('itinerary')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12 tablist">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li class="nav-item" id="rounddtrip">
                        <a class="nav-link active" data-toggle="tab" href="#roundTrip" role="tab" aria-controls="roundTrip" aria-selected="false">Round Trip</a>
                    </li>
                    <li class="nav-item" id="oneeside">
                        <a class="nav-link" data-toggle="tab" href="#oneWay1" role="tab" aria-controls="oneWay" aria-selected="true">One Way</a>
                    </li>

                    <li class="nav-item" id="multiicities">
                        <a class="nav-link" data-toggle="tab" href="#cities1" role="tab" aria-controls="cities" aria-selected="false">Multi Cities</a>
                    </li>

                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane active" id="roundTrip" role="tabpanel" aria-labelledby="chicken-tab">
                        <div id="step-1">
                        <div class="row input-form">
                          <div class=" autocomplete col-6 mt-2">
                            <label>From <span class="text-danger"> *</span>
                            </label>
                            <input type="text" list="list-language" class="form-control" id="myInput" placeholder="From — US airport" name="from" autocomplete="off">
                            <div class="listt1" id="listt" list="list-language"></div>
                            <span class="text-danger" id="error"></span>
                        </div>
                        <div class="  autocomplete col-6 mt-2">
                            <label>To <span class="text-danger"> *</span>
                            </label>
                            <input type="text" list="list-language1" class="form-control" id="myInput2" placeholder="To — Pakistan airport" name="to">
                            <div class="listt1" id="listt1" list="list-language1"></div>
                            <span class="text-danger" id="error2"></span>
                        </div>
                        <div class="col-6 mt-2">
                            <label>Date of Depart <span class="text-danger"> *</span>
                            </label>
                            <input type="date" class="form-control" id="departdate" name="departdate">
                            <span class="text-danger" id="error3"></span>
                        </div>
                        <div class="col-6 mt-2" id="return">
                            <label>Date of Return <span class="text-danger"> *</span>
                            </label>
                            <input type="date" class="form-control" id="returndate" name="returndate">
                            <span class="text-danger" id="error4"></span>
                        </div>
                        <div class="container" id="parent"></div>
                        <div class="col-6 mt-2" id="class">
                            <label for="class">Class <span class="text-danger"> *</span>
                            </label>
                            <select name="class" class="form-control" id="class">
                              <option value="Economy Class">Economy Class</option>
                              <option value="Premium Economy Class">Premium Economy Class</option>
                              <option value="Business Class">Business Class</option>
                          </select>
                      </div>
                      <div class="col-6 mt-2 text-right" id="addcity">
                        <a class="removecity mr-2  " style="color:red;">Cancel</a>
                        <a class="addcity   fa fa-plus"> Add Flight</a>
                    </div>
                    <div class="col-6 mt-2">
                        <label>Name <span class="text-danger"> *</span>
                        </label>
                        <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                        <span class="text-danger" id="error5"></span>
                    </div>
                    <div class="col-6 mt-2">
                        <label>Email <span class="text-danger"> *</span>
                        </label>
                        <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                        <span class="text-danger" id="error6"></span>
                    </div>
                    <div class="col-6 mt-2">
                        <label>Phone Number <span class="text-danger"> *</span>
                        </label>
                        <input type="string" class="form-control" id="phone" placeholder="Phone Number" name="contact">
                        <span class="text-danger" id="error6"></span>
                    </div>
                    <div class="col-6 mt-2">
                        <label class="mt-1">Passengers <span class="text-danger"> *</span>
                        </labeL>
                        <br>
                        <div class="dropdown">
                          <input class="passenger-input dropdown-toggle" type="text" id="dropdownMenuButton" name="passengers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" />
                          <span class="fa fa-angle-down errspan"></span>
                          <div class="passenger-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <span class="tickets mt-4">ADULT</span>
                            <div class="number mt-12">
                              <button class="minus-adult minus fa fa-minus" type="button"></button>
                              <input class="counterr" id="adult" type="text" name="adult" min="1" max="5" value="0" />
                              <button class="plus-adult plus fa fa-plus" type="button"></button>
                          </div>
                          <br>
                          <span class="tickets">CHILD</span>
                          <div class="number mt-2">
                              <button class="minus-child minus fa fa-minus" type="button"></button>
                              <input class="counterr" name="child" type="text" value="0" />
                              <button class="plus-child plus fa fa-plus" type="button"></button>
                          </div>
                          <br>
                          <span class="tickets">Infant</span>
                          <div class="number mt-2">
                              <button class="minus-infant minus fa fa-minus" type="button"></button>
                              <input class="counterr" type="text" name="infant" value="0" />
                              <button class="plus-infant plus fa fa-plus" type="button"></button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <input type="button" value="Next" class="btn float-right my-4 passengers-detail" id="passengers-detail" />
          </div><!-- /#step-1 -->

          <div id="step-2" style="display:none;">
              <div id="adultt"></div>
              <div class="text-right mt-3" style="clear:both;">
                  <input type="submit" value="Submit Booking" class="btn" id="submit-booking" />
              </div>
          </div>

      </div>
      <!-- Tab 2 -->
      <!-- <div class="tab-pane" id="oneWay1" role="tabpanel" aria-labelledby="duck-tab">
        2
    </div> -->
    <!-- tab3 -->

    <!-- <div class="tab-pane" id="cities1" role="tabpanel" aria-labelledby="kiwi-tab">
        3            
    </div> -->
    <!-- tab 3 end -->


</div>

</div>
</div>
</form>
</div>
</div>
</section>

<script>
// From = US airports, To = Pakistan airports.
// Runs after iternary.js (loaded in the footer) so it overrides its list.
window.addEventListener('load', function () {
    var usAirports = [
        "New York (JFK), USA", "New York (LGA), USA", "Newark (EWR), USA",
        "Washington Dulles (IAD), USA", "Washington (DCA), USA", "Baltimore (BWI), USA",
        "Boston (BOS), USA", "Chicago O'Hare (ORD), USA", "Chicago Midway (MDW), USA",
        "Atlanta (ATL), USA", "Los Angeles (LAX), USA", "San Francisco (SFO), USA",
        "San Diego (SAN), USA", "San Jose (SJC), USA", "Oakland (OAK), USA",
        "Sacramento (SMF), USA", "Seattle (SEA), USA", "Portland (PDX), USA",
        "Houston (IAH), USA", "Dallas (DFW), USA", "Austin (AUS), USA",
        "San Antonio (SAT), USA", "Miami (MIA), USA", "Orlando (MCO), USA",
        "Tampa (TPA), USA", "Fort Lauderdale (FLL), USA", "Philadelphia (PHL), USA",
        "Detroit (DTW), USA", "Minneapolis (MSP), USA", "Denver (DEN), USA",
        "Phoenix (PHX), USA", "Las Vegas (LAS), USA", "Charlotte (CLT), USA",
        "Raleigh-Durham (RDU), USA", "Nashville (BNA), USA", "Indianapolis (IND), USA",
        "Cleveland (CLE), USA", "Columbus (CMH), USA", "Pittsburgh (PIT), USA",
        "Kansas City (MCI), USA", "St. Louis (STL), USA", "Buffalo (BUF), USA",
        "Hartford (BDL), USA", "Salt Lake City (SLC), USA"
    ];
    var pkAirports = [
        "Islamabad (ISB), Pakistan", "Lahore (LHE), Pakistan", "Karachi (KHI), Pakistan",
        "Sialkot (SKT), Pakistan", "Peshawar (PEW), Pakistan", "Multan (MUX), Pakistan",
        "Faisalabad (LYP), Pakistan", "Quetta (UET), Pakistan", "Gwadar (GWD), Pakistan",
        "Sukkur (SKZ), Pakistan", "Bahawalpur (BHV), Pakistan", "Rahim Yar Khan (RYK), Pakistan",
        "Skardu (KDU), Pakistan", "Gilgit (GIL), Pakistan", "Dera Ghazi Khan (DEA), Pakistan",
        "Turbat (TUK), Pakistan"
    ];
    function fill(id, arr) {
        var el = document.getElementById(id);
        if (!el) return;
        el.innerHTML = arr.map(function (a) { return '<span>' + a + '</span>'; }).join('');
    }
    fill('listt', usAirports);   // From input (list-language)
    fill('listt1', pkAirports);  // To input  (list-language1)
});
</script>
@endsection