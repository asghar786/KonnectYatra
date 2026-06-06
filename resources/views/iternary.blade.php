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

<section class="package-section" style="margin-top:20px !important;">

    <div class="container">
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
                        
                        <div class="row input-form">
                          <div class=" autocomplete col-6 mt-2">
                            <label>From <span class="text-danger"> *</span>
                            </label>
                            <input type="text" list="list-language" class="form-control" id="myInput" placeholder="Departure From City" name="from" autocomplete="off">
                            <div class="listt1" id="listt" list="list-language"></div>
                            <span class="text-danger" id="error"></span>
                        </div>
                        <div class="  autocomplete col-6 mt-2">
                            <label>To <span class="text-danger"> *</span>
                            </label>
                            <input type="text" list="list-language1" class="form-control" id="myInput2" placeholder="Departure To City" name="to">
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
          <input type="button" value="Next" class="btn btn-sm float-right my-4 mr-4 passengers-detail" id="passengers-detail" />

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
</section>
@endsection