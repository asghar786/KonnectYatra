@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/apply_packages') }}">Yatri Packages</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <form method="POST" action="{{ @$action }}" enctype="multipart/form-data" class="admin_form  ajax-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Package Name</label>
                                        <input type="text" class="form-control" name="package_name" value="{{ @$package->name }}" placeholder="Enter Package Name" required />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">State</label>
                                        <select name="state" class="form-control" required>
                                            <option value="">-- Select State --</option>
                                            <option value="California" @if(@$package->state == 'California') selected @endif>California</option>
                                            <option value="Connecticut" @if(@$package->state == 'Connecticut') selected @endif>Connecticut</option>
                                            <option value="Delaware" @if(@$package->state == 'Delaware') selected @endif>Delaware</option>
                                            <option value="Florida" @if(@$package->state == 'Florida') selected @endif>Florida</option>
                                            <option value="Georgia" @if(@$package->state == 'Georgia') selected @endif>Georgia</option>
                                            <option value="Illinois" @if(@$package->state == 'Illinois') selected @endif>Illinois</option>
                                            <option value="Indiana" @if(@$package->state == 'Indiana') selected @endif>Indiana</option>
                                            <option value="Maryland" @if(@$package->state == 'Maryland') selected @endif>Maryland</option>
                                            <option value="Massachusetts" @if(@$package->state == 'Massachusetts') selected @endif>Massachusetts</option>
                                            <option value="Michigan" @if(@$package->state == 'Michigan') selected @endif>Michigan</option>
                                            <option value="New Jersey" @if(@$package->state == 'New Jersey') selected @endif>New Jersey</option>
                                            <option value="New York" @if(@$package->state == 'New York') selected @endif>New York</option>
                                            <option value="Ohio" @if(@$package->state == 'Ohio') selected @endif>Ohio</option>
                                            <option value="Pennsylvania" @if(@$package->state == 'Pennsylvania') selected @endif>Pennsylvania</option>
                                            <option value="Texas" @if(@$package->state == 'Texas') selected @endif>Texas</option>
                                            <option value="Virginia" @if(@$package->state == 'Virginia') selected @endif>Virginia</option>
                                            <option value="Washington DC" @if(@$package->state == 'Washington DC') selected @endif>Washington DC</option>
                                            <option value="Washington" @if(@$package->state == 'Washington') selected @endif>Washington (State)</option>
                                            <optgroup label="International / Other Origins">
                                                <option value="Ontario, Canada" @if(@$package->state == 'Ontario, Canada') selected @endif>Ontario, Canada</option>
                                                <option value="British Columbia, Canada" @if(@$package->state == 'British Columbia, Canada') selected @endif>British Columbia, Canada</option>
                                                <option value="Singapore" @if(@$package->state == 'Singapore') selected @endif>Singapore</option>
                                                <option value="Malaysia" @if(@$package->state == 'Malaysia') selected @endif>Malaysia</option>
                                                <option value="Germany" @if(@$package->state == 'Germany') selected @endif>Germany</option>
                                                <option value="Thailand" @if(@$package->state == 'Thailand') selected @endif>Thailand</option>
                                            </optgroup>
                                        </select>
                                        {{-- <input type="text" class="form-control require" id="state" name="state" value="{{ @$package->state }}" required /> --}}
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Package Type</label>
                                        <select name="package_type" class="form-control">
                                            <option value="Vaisakhi" @if(@$package->package_type == 'Vaisakhi') selected @endif>Vaisakhi</option>
                                            <option value="Gurpurab" @if(@$package->package_type == 'Gurpurab') selected @endif>Gurpurab</option>
                                            <option value="VIP" @if(@$package->package_type == 'VIP') selected @endif>VIP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">Upload Image</label>
                                        <input type="file" class="form-control require" id="image" name="image" @if(empty(@$package->image)) required @endif />
                                    </div>
                                    @if(!empty(@$package->image))
                                    <div class="col-lg-6 form-group">
                                        <div class="brochure-thumb" role="button" tabindex="0"
                                             data-brochure-src="{{ asset("assets/flyers/".@$package->image) }}"
                                             title="Click to zoom">
                                            <img src="{{ asset("assets/flyers/".@$package->image) }}" alt="Package brochure">
                                            <span class="brochure-thumb__zoom"><i class="fa fa-search-plus"></i></span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                {{-- <div class="row details">
                                    <div class="col-lg-12 form-group mb-2">
                                        <label class="form_label_color">More Details</label>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 1</label>
                                        <input type="date" class="form-control require date" id="day_1" name="day_1" value="{{ @$package->package_details->day_1 }}" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" id="plan_1" name="plan_1" value="{{ @$package->package_details->plan_1 }}" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" id="no_1" name="no_1" value="{{ @$package->package_details->no_1 }}" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 2</label>
                                        <input type="date" class="form-control require date" id="day_2" value="{{ @$package->package_details->day_2 }}" name="day_2" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" id="plan_2" name="plan_2" value="{{ @$package->package_details->plan_2 }}" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" id="no_2" name="no_2" value="{{ @$package->package_details->no_2 }}" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 3</label>
                                        <input type="date" class="form-control require date" id="day_3" value="{{ @$package->package_details->day_3 }}" name="day_3" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" id="plan_3" value="{{ @$package->package_details->plan_3 }}" name="plan_3" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" id="no_3" value="{{ @$package->package_details->no_3 }}" name="no_3" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 4</label>
                                        <input type="date" class="form-control require date" id="day_4" value="{{ @$package->package_details->day_4 }}" name="day_4" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" id="plan_4" value="{{ @$package->package_details->plan_4 }}" name="plan_4" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" id="no_4" value="{{ @$package->package_details->no_4 }}" name="no_4" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 5</label>
                                        <input type="date" class="form-control require date" value="{{ @$package->package_details->day_5 }}" id="day_5" name="day_5" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" id="plan_5" value="{{ @$package->package_details->plan_5 }}" name="plan_5" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" id="no_5" value="{{ @$package->package_details->no_5 }}" name="no_5" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 6</label>
                                        <input type="date" class="form-control require date" value="{{ @$package->package_details->day_6 }}" id="day_6" name="day_6" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" value="{{ @$package->package_details->plan_6 }}" id="plan_6" name="plan_6" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" id="no_6" value="{{ @$package->package_details->no_6 }}" name="no_6" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 7</label>
                                        <input type="date" class="form-control require date" id="day_7" value="{{ @$package->package_details->day_7 }}" name="day_7" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" id="plan_7" value="{{ @$package->package_details->plan_7 }}" name="plan_7" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" value="{{ @$package->package_details->no_7 }}" id="no_7" name="no_7" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Day 8</label>
                                        <input type="date" class="form-control require date" value="{{ @$package->package_details->day_8 }}" id="day_8" name="day_8" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Plan</label>
                                        <input type="text" class="form-control require" value="{{ @$package->package_details->plan_8 }}" id="plan_8" name="plan_8" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Nights Include</label>
                                        <input type="integer" class="form-control require" value="{{ @$package->package_details->no_8 }}" id="no_8" name="no_8" />
                                    </div>
                                </div> --}}
                                {{-- <div class="row">
                                    <div class="col-lg-4 form-group pt-2 text-center" style="margin-bottom: 0px; border-top: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color" style="font-size: 20px;">Single</label>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2 text-center" style="margin-bottom: 0px; border-top: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color" style="font-size: 20px;">Double</label>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2 text-center" style="margin-bottom: 0px; border-top: 1px solid #eee;">
                                        <label class="form_label_color" style="font-size: 20px;">Triple</label>
                                    </div>
                                    <div class="col-lg-4 form-group pt-3" style="margin-bottom: 0px; border-top: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Ticket</label>
                                        <input type="number" class="form-control single" name="single_ticket" value="{{ @$package->price_details->single_ticket }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-3" style="margin-bottom: 0px; border-top: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Ticket</label>
                                        <input type="number" class="form-control double" name="double_ticket" value="{{ @$package->price_details->double_ticket }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-3" style="margin-bottom: 0px; border-top: 1px solid #eee;">
                                        <label class="form_label_color">Ticket</label>
                                        <input type="number" class="form-control triple" name="triple_ticket" value="{{ @$package->price_details->triple_ticket }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Islamabad Lahore by Bus</label>
                                        <input type="number" class="form-control single" name="single_isb_to_lhr" value="{{ @$package->price_details->single_isb_to_lhr }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Islamabad Lahore by Bus</label>
                                        <input type="number" class="form-control double" name="double_isb_to_lhr" value="{{ @$package->price_details->double_isb_to_lhr }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Islamabad Lahore by Bus</label>
                                        <input type="number" class="form-control triple" name="triple_isb_to_lhr" value="{{ @$package->price_details->triple_isb_to_lhr }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Tolls & refreshment</label>
                                        <input type="number" class="form-control single" name="single_tolls" value="{{ @$package->price_details->single_tolls }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Tolls & refreshment</label>
                                        <input type="number" class="form-control double" name="double_tolls" value="{{ @$package->price_details->double_tolls }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Tolls & refreshment</label>
                                        <input type="number" class="form-control triple" name="triple_tolls" value="{{ @$package->price_details->triple_tolls }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">One Night Hotel in Islamabad</label>
                                        <input type="number" class="form-control single" name="single_isb_hotel" value="{{ @$package->price_details->single_isb_hotel }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">One Night Hotel in Islamabad</label>
                                        <input type="number" class="form-control double" name="double_isb_hotel" value="{{ @$package->price_details->double_isb_hotel }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">One Night Hotel in Islamabad</label>
                                        <input type="number" class="form-control triple" name="triple_isb_hotel" value="{{ @$package->price_details->triple_isb_hotel }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Transport from Airport to Hotel</label>
                                        <input type="number" class="form-control single" name="single_transport" value="{{ @$package->price_details->single_transport }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Transport from Airport to Hotel</label>
                                        <input type="number" class="form-control double" name="double_transport" value="{{ @$package->price_details->double_transport }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Transport from Airport to Hotel</label>
                                        <input type="number" class="form-control triple" name="triple_transport" value="{{ @$package->price_details->triple_transport }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">6 Night Hotel in Lahore</label>
                                        <input type="number" class="form-control single" name="single_lhr_hotel" value="{{ @$package->price_details->single_lhr_hotel }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">6 Night Hotel in Lahore</label>
                                        <input type="number" class="form-control double" name="double_lhr_hotel" value="{{ @$package->price_details->double_lhr_hotel }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">6 Night Hotel in Lahore</label>
                                        <input type="number" class="form-control triple" name="triple_lhr_hotel" value="{{ @$package->price_details->triple_lhr_hotel }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Food</label>
                                        <input type="number" class="form-control single" name="single_food" value="{{ @$package->price_details->single_food }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Food</label>
                                        <input type="number" class="form-control double" name="double_food" value="{{ @$package->price_details->double_food }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Food</label>
                                        <input type="number" class="form-control triple" name="triple_food" value="{{ @$package->price_details->triple_food }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Visa</label>
                                        <input type="number" class="form-control single" name="single_visa" value="{{ @$package->price_details->single_visa }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Visa</label>
                                        <input type="number" class="form-control double" name="double_visa" value="{{ @$package->price_details->double_visa }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Visa</label>
                                        <input type="number" class="form-control triple" name="triple_visa" value="{{ @$package->price_details->triple_visa }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Misc</label>
                                        <input type="number" class="form-control single" name="single_misc" value="{{ @$package->price_details->single_misc }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Misc</label>
                                        <input type="number" class="form-control double" name="double_misc" value="{{ @$package->price_details->double_misc }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Misc</label>
                                        <input type="number" class="form-control triple" name="triple_misc" value="{{ @$package->price_details->triple_misc }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Margin</label>
                                        <input type="number" class="form-control single" name="single_margin" value="{{ @$package->price_details->single_margin }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Margin</label>
                                        <input type="number" class="form-control double" name="double_margin" value="{{ @$package->price_details->double_margin }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Margin</label>
                                        <input type="number" class="form-control triple" name="triple_margin" value="{{ @$package->price_details->triple_margin }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Local Tour in Lahore</label>
                                        <input type="number" class="form-control single" name="single_local_tour" value="{{ @$package->price_details->single_local_tour }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Local Tour in Lahore</label>
                                        <input type="number" class="form-control double" name="double_local_tour" value="{{ @$package->price_details->double_local_tour }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Local Tour in Lahore</label>
                                        <input type="number" class="form-control triple" name="triple_local_tour" value="{{ @$package->price_details->triple_local_tour }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">7 days Crew</label>
                                        <input type="number" class="form-control single" name="single_crew" value="{{ @$package->price_details->single_crew }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">7 days Crew</label>
                                        <input type="number" class="form-control double" name="double_crew" value="{{ @$package->price_details->double_crew }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">7 days Crew</label>
                                        <input type="number" class="form-control triple" name="triple_crew" value="{{ @$package->price_details->triple_crew }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Tour to Kartarpur Sahib</label>
                                        <input type="number" class="form-control single" name="single_kartarpur" value="{{ @$package->price_details->single_kartarpur }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Tour to Kartarpur Sahib</label>
                                        <input type="number" class="form-control double" name="double_kartarpur" value="{{ @$package->price_details->double_kartarpur }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Tour to Kartarpur Sahib</label>
                                        <input type="number" class="form-control triple" name="triple_kartarpur" value="{{ @$package->price_details->triple_kartarpur }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Tour to Nanakana Sahib</label>
                                        <input type="number" class="form-control single" name="single_nanakana" value="{{ @$package->price_details->single_nanakana }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Tour to Nanakana Sahib</label>
                                        <input type="number" class="form-control double" name="double_nanakana" value="{{ @$package->price_details->double_nanakana }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="margin-bottom: 0px;">
                                        <label class="form_label_color">Tour to Nanakana Sahib</label>
                                        <input type="number" class="form-control triple" name="triple_nanakana" value="{{ @$package->price_details->triple_nanakana }}" placeholder="Enter Price" />
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Total Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control single_price" name="round_single_price" value="{{ @$package->round_single_price }}"  placeholder="0" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Total Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control double_price" name="round_double_price" value="{{ @$package->round_double_price }}" placeholder="0" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2" style="border-bottom: 1px solid #eee;">
                                        <label class="form_label_color">Total Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control triple_price" name="round_triple_price" value="{{ @$package->round_triple_price }}" placeholder="0" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">One Way Single Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="one_single_price" value="{{ @$package->one_single_price }}"  placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">One Way Double Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="one_double_price" value="{{ @$package->one_double_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee;">
                                        <label class="form_label_color">One Way Triple Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="one_triple_price" value="{{ @$package->one_triple_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-lg-6 form-group pt-2 text-center" style="margin-bottom: 0px; border-top: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color" style="font-size: 20px;">5* Hotel Price</label>
                                    </div>
                                    <div class="col-lg-6 form-group pt-2 text-center" style="margin-bottom: 0px; border-top: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color" style="font-size: 20px;">4* Hotel Price</label>
                                    </div>                                        
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee;">
                                        <label class="form_label_color">Round Trip Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="five_star_round_price" value="{{ @$package->five_star_round_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee;">
                                        <label class="form_label_color">Round Trip Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="four_star_round_price" value="{{ @$package->four_star_round_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">One Way Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="five_star_single_price" value="{{ @$package->five_star_single_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">One Way Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="four_star_single_price" value="{{ @$package->four_star_single_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Land Package Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="five_star_land_price" value="{{ @$package->five_star_land_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group pt-2 pb-3" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                                        <label class="form_label_color">Land Package Price</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center" style="width: 50px; height: 40px; padding-top: 8px; background-color: #f3f3f3; border: 1px solid #bbb;">
                                                <span>$</span>
                                            </div>
                                            <input type="number" class="form-control" name="four_star_land_price" value="{{ @$package->four_star_land_price }}" placeholder="0" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Round Way Description</label>
                                        <textarea class="form-control" name="round_way_description" id="round_way_description">{{ @$package->round_way_description }}</textarea>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">One Way Description</label>
                                        <textarea class="form-control" name="one_way_description" id="one_way_description">{{ @$package->one_way_description }}</textarea>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form_label_color">Land Description</label>
                                        <textarea class="form-control" name="one_way_description" id="one_way_description">{{ @$package->one_way_description }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label class="form_label_color">Short Description</label>
                                        <textarea class="form-control" name="sdescription" id="sdescription">{{ @$package->sdescription }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label class="form_label_color">Description</label>
                                        <textarea class="form-control" name="description" id="description">{{ @$package->description }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2" style="float: right;">{{ @$btn_text }}</button>
                                <div class="response"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>

{{-- Brochure zoom modal --}}
<div id="brochureModal" class="brochure-modal" aria-hidden="true">
    <span class="brochure-modal__close" title="Close">&times;</span>
    <img class="brochure-modal__img" src="" alt="Package brochure preview">
</div>

<style>
    .brochure-thumb{
        position: relative;
        display: inline-block;
        width: 150px;
        height: 150px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        overflow: hidden;
        cursor: zoom-in;
    }
    .brochure-thumb img{ width: 100%; height: 100%; object-fit: cover; display: block; }
    .brochure-thumb__zoom{
        position: absolute;
        right: 6px;
        bottom: 6px;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,.6);
        color: #fff;
        border-radius: 50%;
        font-size: 13px;
    }
    .brochure-modal{
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10500;
        background: rgba(0,0,0,.85);
        text-align: center;
    }
    .brochure-modal.is-open{ display: block; }
    .brochure-modal__img{
        max-width: 92%;
        max-height: 92%;
        margin: 4% auto;
        display: block;
        border-radius: 4px;
        box-shadow: 0 10px 40px rgba(0,0,0,.5);
    }
    .brochure-modal__close{
        position: absolute;
        top: 18px;
        right: 28px;
        color: #fff;
        font-size: 40px;
        line-height: 1;
        cursor: pointer;
        font-weight: 300;
    }
</style>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js" integrity="sha512-F8fV4+wpHYl9zul08Soff9H9fCx6OMIFfgbQcy+2v2gV7PdbT0OgM1LFwujQmwlLGWWKNbOFZ13uWP+Cbe0Ngw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    CKEDITOR.config.versionCheck = false;
    CKEDITOR.replace('description', {
            /*
             * Ensure that htmlwriter plugin, which is required for this sample, is loaded.
             */
        extraPlugins: 'htmlwriter',

            /*
             * Simple HTML5 doctype
             */
        docType: '<!DOCTYPE HTML>',

        allowedContent:true,
    });
    function addMonth(date, i) {
        var dy=date.getDay(); 
        date.setMonth(date.getMonth() + i * 1); 
        date.setDate(date.getDate() - (date.getDay()-dy)); 
        return date; 
    };
    CKEDITOR.replace('sdescription', {
            /*
             * Ensure that htmlwriter plugin, which is required for this sample, is loaded.
             */
        extraPlugins: 'htmlwriter',

            /*
             * Simple HTML5 doctype
             */
        docType: '<!DOCTYPE HTML>',

        allowedContent:true,
    });
    function addMonth(date, i) {
        var dy=date.getDay(); 
        date.setMonth(date.getMonth() + i * 1); 
        date.setDate(date.getDate() - (date.getDay()-dy)); 
        return date; 
    };
</script>

@if(!empty(@$package->month_year))
<script type="text/javascript">
    var min_date = $("#month_year").val() + '-01';
    var maxDate1 = addMonth(new Date($("#month_year").val() + '-10'), 1);
    var currentDate1 = new Date(maxDate1);
    var currentYear1 = currentDate1.getFullYear();
    var currentMonth1 = currentDate1.getMonth() + 1;
    var max_date = currentYear1 + '-' + (currentMonth1 < 10 ? '0' : '') + currentMonth1 + "-10";
    console.log(max_date);

    $('.date').attr('min', min_date);
    $('.date').attr('max', max_date);
    $('.date').attr('disabled', false);
</script>
@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ajax-form').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var formAction = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: formAction,
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                success : function(data)
                {
                    if(data.status == 1){
                        toastr["success"](data.message, "Completed!");
                    }else{
                        toastr["error"](data.message, "Completed!");
                    }
                },
                error : function(data){
                    alert('There is something wrong. Please wait or submit again.');
                },  
            });
        });

        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
            var currentMonth = currentDate.getMonth() + 1; // Adding 1 because months are zero-indexed.

            // Format the current month and year as "YYYY-MM".
            var minDate = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth;

            $('#month_year').attr('min', minDate);

            $("#month_year").change(function () {
                var minDate = $(this).val() + '-01';
                var maxDate = addMonth(new Date($(this).val() + '-10'), 1);
                var currentDate = new Date(maxDate);
                var currentYear = currentDate.getFullYear();
                var currentMonth = currentDate.getMonth() + 1;
                var max = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth + "-10";

                $('.date').attr('min', minDate);
                $('.date').attr('max', max);
                $('.date').attr('disabled', false);
            });

            $(document).on("change paste keyup", ".single", function () {
                var total = 0;
                $(".single").each(function (key, value) {
                    if ($(value).val() !== "") {
                        total = total + parseInt($(value).val());
                    }
                });

                $('.single_price').val(total);
            });

            $(document).on("change paste keyup", ".double", function () {
                var total = 0;
                $(".double").each(function (key, value) {
                    if ($(value).val() !== "") {
                        total = total + parseInt($(value).val());
                    }
                });

                $('.double_price').val(total);
            });

            $(document).on("change paste keyup", ".triple", function () {
                var total = 0;
                $(".triple").each(function (key, value) {
                    if ($(value).val() !== "") {
                        total = total + parseInt($(value).val());
                    }
                });

                $('.triple_price').val(total);
            });

            // Brochure zoom modal
            var $brochureModal = $('#brochureModal');
            $(document).on('click keydown', '.brochure-thumb', function (e) {
                if (e.type === 'keydown' && e.which !== 13 && e.which !== 32) return;
                e.preventDefault();
                $brochureModal.find('.brochure-modal__img').attr('src', $(this).data('brochure-src'));
                $brochureModal.addClass('is-open').attr('aria-hidden', 'false');
            });
            $(document).on('click', '#brochureModal, .brochure-modal__close', function (e) {
                if (e.target && $(e.target).hasClass('brochure-modal__img')) return;
                $brochureModal.removeClass('is-open').attr('aria-hidden', 'true');
            });
            $(document).on('keydown', function (e) {
                if (e.which === 27) $brochureModal.removeClass('is-open').attr('aria-hidden', 'true');
            });
        });
    </script>

    @endsection