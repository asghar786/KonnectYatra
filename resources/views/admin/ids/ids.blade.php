@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .dt-buttons {
        display: none;
    }
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
    /* Hide inactive tab content before JS runs to avoid the flash (FOUC).
       The first tab (Yatri Ids) is shown by default; TabsManager toggles the rest. */
    .tabs-content__text{
        display: none;
    }
    .tabs-content__text:first-child{
        display: block;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">IDs</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>IDs</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/ids/create') }}" class="btn btn-primary">
                Create ID <i class="fa fa-plus"></i>
            </a>
            <a href="{{ url('admin/ids/back') }}" class="btn btn-primary">
                Update Back View
            </a>
            <a href="{{ url('admin/yatri-id', 1) }}" class="btn btn-primary ml-2">
                View IDs <i class="fa fa-eye"></i>
            </a>
            <!--<a href="{{ url('admin/admin-id') }}" class="btn btn-primary ml-2">-->
            <!--    View Admin IDs <i class="fa fa-eye"></i>-->
            <!--</a>-->
            <a href="{{ url('admin/staff_ids', 1) }}" class="btn btn-primary ml-2">
                View Crew IDs <i class="fa fa-eye"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="tabs">
                        <div class="tabs-tags row">
                            <span class="tabs-tags__tag col-md-6">Yatri Ids</span>
                            <span class="tabs-tags__tag col-md-6">Crew Member</span>
                        </div>
                        <div class="tabs-content">
                            <div class="tabs-content__text">
                                <div class="row my-4">
                                    <div class="col-lg-12">
                                        <table class="table table-striped" id="myTables">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center" scope="col">Yatri #</th>
                                                    <th class="text-center" scope="col">Photo</th>
                                                    <th class="text-center" scope="col">Name</th>
                                                    <th class="text-center" scope="col">Father Name</th>
                                                    <th class="text-center" scope="col">Passport #</th>
                                                    <th class="text-center" scope="col">State</th>
                                                    <th class="text-center" scope="col">Type</th>
                                                    <th class="text-center" scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($yatri) > 0)
                                                @foreach($yatri as $yatri_id)
                                                <tr>
                                                    <td class="text-center">{{@$yatri_id->yatri_no}}</td>
                                                    <td class="text-center">
                                                        <img src="{{ asset('ids/'.@$yatri_id->photo) }}" height="80" width="80">
                                                    </td>
                                                    <td class="text-center">{{@$yatri_id->name}}</td>
                                                    <td class="text-center">{{@$yatri_id->father_name}}</td>
                                                    <td class="text-center">{{@$yatri_id->passport_no}}</td>
                                                    <td class="text-center">{{@$yatri_id->state}}</td>
                                                    <td class="text-center">{{@$yatri_id->type}}</td>
                                                    <td>
                                                        <div style="display: flex;">
                                                            {{-- <a href="{{url('admin/yatri-id',$yatri_id->id)}}" class="bg-primary mr-2" style="color:white; padding:9px;">View ID</a> --}}
                                                            <a href="{{ url('admin/ids/edit', @$yatri_id->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{@$yatri_id->id}}"></a>
                                                            <form method="POST" action="{{ url('/admin/ids/delete', @$yatri_id->id) }}">
                                                                @csrf
                                                                <input name="_method" type="hidden" value="GET">
                                                                <button type="submit" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;"><i class="text-white fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="8" class="text-center">No result found.</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                            {{-- @endforeach --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tabs-content__text">
                                <div class="row my-4">
                                    <div class="col-lg-12">
                                        <table class="table table-striped" id="myTables">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center" scope="col">Photo</th>
                                                    <th class="text-center" scope="col">Name</th>
                                                    <th class="text-center" scope="col">Father Name</th>
                                                    <th class="text-center" scope="col">CNIC #</th>
                                                    <th class="text-center" scope="col">Role</th>
                                                    <th class="text-center" scope="col">Type</th>
                                                    <th class="text-center" scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($crew) > 0)
                                                @foreach($crew as $yatri_id)
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="{{ asset('ids/'.@$yatri_id->photo) }}" height="80" width="80">
                                                    </td>
                                                    <td class="text-center">{{@$yatri_id->name}}</td>
                                                    <td class="text-center">{{@$yatri_id->father_name}}</td>
                                                    <td class="text-center">{{@$yatri_id->cnic}}</td>
                                                    <td class="text-center">{{@$yatri_id->role}}</td>
                                                    <td class="text-center">{{@$yatri_id->type}}</td>
                                                    <td>
                                                        <div style="display: flex;">
                                                            <a href="{{ url('admin/ids/edit', @$yatri_id->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{@$yatri_id->id}}"></a>
                                                            <form method="POST" action="{{ url('/admin/ids/delete', @$yatri_id->id) }}">
                                                                @csrf
                                                                <input name="_method" type="hidden" value="GET">
                                                                <button type="submit" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;"><i class="text-white fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="8" class="text-center">No result found.</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                            {{-- @endforeach --}}
                                        </table>
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