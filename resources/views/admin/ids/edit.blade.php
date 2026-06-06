@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .tabs-tags__tag{
        padding: 20px;
        border-bottom: 3px solid black;
        text-align: center;
        color: black;
        font-size: 25px;
        font-weight: 700;
        cursor: pointer;
    }
    .active{
        border-bottom: 3px solid #f54e18;
        color: #f54e18;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">IDs</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="tabs">
                        
                        <div class="tabs-content">
                            <div class="tabs-content__text">
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-12">
                                        <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">ID Type</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->type}}" name="type" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Name</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->name}}" name="name" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Father Name</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->father_name}}" name="father_name" required="" />
                                                </div>
                                                @if($yatri_id->type == "Yatri")
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Yatri #</label>
                                                    <input type="number" class="form-control require" value="{{@$yatri_id->yatri_no}}" name="yatri_no" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Passport #</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->passport_no}}" name="passport_no" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Passport Country</label>
                                                    <select class="form-control require" name="passport_country">
                                                        <option value="US" @if(@$yatri_id->passport_country == "US") selected @endif>United States</option>
                                                        <option value="IND" @if(@$yatri_id->passport_country == "IND") selected @endif>India</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">State</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->state}}" name="state" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Trip Type</label>
                                                    <select class="form-control require" name="trip_type">
                                                        <option value="RT" @if(@$yatri_id->trip_type == "RT") selected @endif>Round Trip</option>
                                                        <option value="O/W" @if(@$yatri_id->trip_type == "O/W") selected @endif>One Way</option>
                                                        <option value="L/P" @if(@$yatri_id->trip_type == "L/P") selected @endif>Land Package</option>
                                                    </select>
                                                </div>

                                                @else

                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Role</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->role}}" name="role" />
                                                </div>

                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">CNIC #</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->cnic}}" name="cnic" />
                                                </div>

                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Country</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->country}}" name="country" />
                                                </div>

                                                @endif
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Photo</label>
                                                    <input type="file" class="form-control require" name="photo" @if(empty(@$yatri_id->photo)) required="" @endif />
                                                </div>
                                                @if(!empty(@$yatri_id->photo))
                                                <div class="form-group offset-md-6 col-md-6">
                                                    <img src="{{ asset('ids/'.@$yatri_id->photo) }}" height="150" width="150">
                                                </div>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="float: right;margin-bottom: 60px;">Update</button>
                                            <div class="response"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="tabs-content__text">
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-12">
                                        <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">ID Type</label>
                                                    <input type="text" class="form-control require" value="Crew Member" value="{{@$yatri_id->type}}" name="type" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Name</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->name}}" name="name" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Father Name</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->father_name}}" name="father_name" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Role</label>
                                                    <input type="text" class="form-control require" value="{{@$yatri_id->role}}" name="role" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Cnic #</label>
                                                    <input type="number" class="form-control require" value="{{@$yatri_id->cnic}}" name="cnic" required="" />
                                                </div>
                                                
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Country</label>
                                                    <select class="form-control require" name="country">
                                                        <option value="US" @if(@$yatri_id->passport_country == "US") selected @endif>United States</option>
                                                        <option value="Pakistan" @if(@$yatri_id->passport_country == "Pakistan") selected @endif>Pakistan</option>
                                                        <option value="IND" @if(@$yatri_id->passport_country == "IND") selected @endif>India</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Photo</label>
                                                    <input type="file" class="form-control require" name="photo" @if(empty(@$yatri_id->photo)) required="" @endif />
                                                </div>
                                                @if(!empty(@$yatri_id->photo))
                                                <div class="form-group offset-md-6 col-md-6">
                                                    <img src="{{ asset('ids/'.@$yatri_id->photo) }}" height="150" width="150">
                                                </div>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="float: right;">{{ @$btn_text }}</button>
                                            <div class="response"></div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')

<script type="text/javascript">
    function TabsManager(el) {
        this.tabsContainers = document.querySelectorAll(el);
        this.init();
    }

    TabsManager.prototype.init = function () {
        var self = this;

        document.body.addEventListener("click", function (event) {
            var target = event.target;

            while (target !== document.body) {
                if (target.matches(".tabs-tags__tag")) {
                    self.handleTabClick(target);
                    return;
                }

                target = target.parentNode;
            }
        });

        self.tabsContainers.forEach(function (tabsContainer) {
            if (tabsContainer) {
                var contentTexts = tabsContainer.querySelectorAll(".tabs-content__text");
                contentTexts.forEach(function (text, index) {
                    if (index !== 0) {
                        text.style.display = "none";
                    }
                });
                tabsContainer.querySelector(".tabs-tags__tag").classList.add("active");
            }
        });
    };

    TabsManager.prototype.handleTabClick = function (clickedTab) {
        var self = this;
        var tabsContainer = clickedTab.closest(".tabs");

        if (tabsContainer) {
            var contentTexts = tabsContainer.querySelectorAll(".tabs-content__text");
            var tags = tabsContainer.querySelectorAll(".tabs-tags__tag");
            var index = Array.from(tags).indexOf(clickedTab);
            contentTexts.forEach(function (text) {
                text.style.display = "none";
            });
            contentTexts[index].style.display = "block";
            tags.forEach(function (t) {
                t.classList.remove("active");
            });
            clickedTab.classList.add("active");
        }
    };

// Инициализация объекта TabsManager
var tabsManager = new TabsManager(".tabs");

</script>

@endsection