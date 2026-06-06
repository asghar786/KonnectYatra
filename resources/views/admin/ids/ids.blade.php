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
    /* Card view for IDs */
    .id-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .id-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    .id-card-photo{background:#f3f4f6;height:180px;display:flex;align-items:center;justify-content:center;overflow:hidden;color:#bbb;font-size:13px}
    .id-card-photo img{width:100%;height:100%;object-fit:cover}
    .id-card-body{padding:14px 16px;flex:1}
    .id-card-body h5{margin:0 0 6px;font-size:17px;font-weight:700;color:#222}
    .id-badge{display:inline-block;background:#f54e18;color:#fff;font-size:11px;padding:2px 10px;border-radius:20px;margin-bottom:10px;font-weight:600}
    .id-meta{list-style:none;padding:0;margin:0}
    .id-meta li{display:flex;justify-content:space-between;gap:10px;font-size:13px;padding:5px 0;border-bottom:1px dashed #f0f0f0}
    .id-meta li:last-child{border-bottom:none}
    .id-meta li span{color:#999}
    .id-meta li b{color:#333;text-align:right;word-break:break-word}
    .id-card-actions{display:flex;gap:8px;padding:12px 16px;border-top:1px solid #f3f3f3}
    .id-card-actions .btn{flex:1;text-align:center}
    .id-card-actions form{margin:0;flex:1}
    .id-card-actions form .btn{width:100%}
    .id-empty{padding:40px;text-align:center;color:#999;font-size:16px}
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
                                    @forelse($yatri as $yatri_id)
                                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                        <div class="id-card">
                                            <div class="id-card-photo">
                                                @if(!empty($yatri_id->photo))
                                                <img src="{{ asset('ids/'.$yatri_id->photo) }}" alt="No Photo">
                                                @else
                                                <span><i class="fa fa-user fa-2x"></i></span>
                                                @endif
                                            </div>
                                            <div class="id-card-body">
                                                <h5>{{ @$yatri_id->name }}</h5>
                                                <span class="id-badge">{{ @$yatri_id->type ?: 'Yatri' }}</span>
                                                <ul class="id-meta">
                                                    <li><span>Yatri #</span><b>{{ @$yatri_id->yatri_no ?: '—' }}</b></li>
                                                    <li><span>Father Name</span><b>{{ @$yatri_id->father_name ?: '—' }}</b></li>
                                                    <li><span>Passport #</span><b>{{ @$yatri_id->passport_no ?: '—' }}</b></li>
                                                    <li><span>State</span><b>{{ @$yatri_id->state ?: '—' }}</b></li>
                                                </ul>
                                            </div>
                                            <div class="id-card-actions">
                                                <a href="{{ url('admin/ids/edit', @$yatri_id->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <form method="POST" action="{{ url('/admin/ids/delete', @$yatri_id->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="GET">
                                                    <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12"><div class="id-empty">No Yatri IDs found.</div></div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tabs-content__text">
                                <div class="row my-4">
                                    @forelse($crew as $yatri_id)
                                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                        <div class="id-card">
                                            <div class="id-card-photo">
                                                @if(!empty($yatri_id->photo))
                                                <img src="{{ asset('ids/'.$yatri_id->photo) }}" alt="No Photo">
                                                @else
                                                <span><i class="fa fa-user fa-2x"></i></span>
                                                @endif
                                            </div>
                                            <div class="id-card-body">
                                                <h5>{{ @$yatri_id->name }}</h5>
                                                <span class="id-badge">{{ @$yatri_id->type ?: 'Crew Member' }}</span>
                                                <ul class="id-meta">
                                                    <li><span>Father Name</span><b>{{ @$yatri_id->father_name ?: '—' }}</b></li>
                                                    <li><span>CNIC #</span><b>{{ @$yatri_id->cnic ?: '—' }}</b></li>
                                                    <li><span>Role</span><b>{{ @$yatri_id->role ?: '—' }}</b></li>
                                                </ul>
                                            </div>
                                            <div class="id-card-actions">
                                                <a href="{{ url('admin/ids/edit', @$yatri_id->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <form method="POST" action="{{ url('/admin/ids/delete', @$yatri_id->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="GET">
                                                    <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12"><div class="id-empty">No Crew Members found.</div></div>
                                    @endforelse
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