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
                                        <form method="POST" action="{{ url("admin/create_ids_back") }}" class="admin_form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Name</label>
                                                    <input type="text" class="form-control require" value="{{@$ids_back->name}}" name="name" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Role</label>
                                                    <input type="text" class="form-control require" value="{{@$ids_back->role}}" name="role" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Contact #</label>
                                                    <input type="text" class="form-control require" value="{{@$ids_back->phone}}" name="phone" required="" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Islamabad Hotel Name</label>
                                                    <input type="text" class="form-control require" value="{{@$ids_back->hotel}}" name="hotel" />
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form_label_color">Lahore Hotel Name</label>
                                                    <input type="text" class="form-control require" value="{{@$ids_back->hotel1}}" name="hotel1" />
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <div class="response"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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