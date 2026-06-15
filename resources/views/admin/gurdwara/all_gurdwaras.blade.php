@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .gl-filters{display:flex;flex-wrap:wrap;align-items:flex-end;gap:16px;margin-bottom:18px}
    .gl-filters .fld{flex:1;min-width:200px}
    .gl-filters .fld.grow{flex:2}
    .gl-filters label{font-size:12px;font-weight:600;color:#5a6273;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px;display:block}
    .gl-filters .form-control{border:1px solid #e2e2e2;border-radius:10px;height:42px}
    .gl-filters .addwrap{display:flex;align-items:flex-end}

    .gl-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44 !important;color:#fff;font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.03em;padding:13px 14px;border:0;text-align:left;white-space:nowrap}
    #myTables tbody td{padding:13px 14px;font-size:13.5px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #myTables tbody tr:hover{background:#f9fafc}
    .gl-name{display:inline-flex;align-items:center;gap:9px;font-weight:600;color:#1f2a44}
    .gl-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;background:#c9ccd4}
    .gl-dot.green{background:#2fbf4f}
    .gl-dot.yellow{background:#e8c220}
    .gl-dot.red{background:#e94e35}
    .gl-sub{color:#6b7280}
    .gl-ph{font-variant-numeric:tabular-nums;color:#3949ab;font-weight:600}
    .gl-muted{color:#9aa1ad}

    /* Top export button group (DataTables) */
    .dt-buttons{display:inline-flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
    .dt-buttons .dt-button{padding:0 !important;background:none !important;border:0 !important;margin:0 !important}
    .dt-buttons .dt-button button,.dt-buttons .btn{
        width:auto !important;border:1px solid #e3e6ec !important;background:#fff !important;color:#3a4458 !important;
        border-radius:10px !important;padding:8px 16px !important;font-size:13px !important;font-weight:600 !important;
        box-shadow:none !important;transition:all .12s !important;
    }
    .dt-buttons .dt-button button:hover,.dt-buttons .btn:hover{background:#1f2a44 !important;color:#fff !important;border-color:#1f2a44 !important}
    .dataTables_wrapper .dataTables_filter input{border:1px solid #e2e2e2;border-radius:20px;padding:6px 14px;outline:none}
    .dataTables_wrapper .dataTables_filter input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#1f2a44 !important;color:#fff !important;border-radius:8px;border:0}
    .dataTables_wrapper .dataTables_paginate .paginate_button{border-radius:8px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">List of All Gurdwaras</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>All Gurdwaras</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="gl-filters">
                <div class="fld">
                    <label for="state">Select State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="all">All</option>
                        @if(count(@$all_states) > 0)
                            @foreach(@$all_states as $key => $value)
                                <option value="{{ $value->state }}">{{ $value->state }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="fld">
                    <label for="color">Select Color</label>
                    <select class="form-control" name="color" id="color">
                        <option value="all">All</option>
                        <option value="Green">Green</option>
                        <option value="Yellow">Yellow</option>
                        <option value="Red">Red</option>
                    </select>
                </div>
                <div class="fld addwrap">
                    <a href="{{ route('create-gurdwara') }}" class="btn btn-primary">Add Gurdwara <i class="fa fa-plus"></i></a>
                </div>
            </div>

            <div class="gl-card">
                <div class="table-responsive">
                    <table class="table" id="myTables" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name of Gurdwara</th>
                                <th>Address</th>
                                <th>Name of Pardan</th>
                                <th>Mobile No.</th>
                                <th>Name of Secretary</th>
                                <th>Mobile No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurdwaras as $gurdwara)
                            @php
                                $dot = $gurdwara->color == 'Green' ? 'green' : ($gurdwara->color == 'Yellow' ? 'yellow' : ($gurdwara->color == 'Red' ? 'red' : ''));
                            @endphp
                            <tr>
                                <td><span class="gl-name"><span class="gl-dot {{ $dot }}" title="{{ $gurdwara->color ?: 'No status' }}"></span>{{ $gurdwara->gurdwara_name }}</span></td>
                                <td><span class="gl-sub">{{ $gurdwara->address ?: '—' }}</span></td>
                                <td>{{ $gurdwara->pardan_name ?: 'N/A' }}</td>
                                <td><span class="gl-ph">{{ $gurdwara->phone_no ?: '—' }}</span></td>
                                <td>{{ $gurdwara->secretary_name ?: '—' }}</td>
                                <td><span class="gl-ph">{{ $gurdwara->secretary_phone_no ?: '—' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        var url = window.location.href;
        if(url.indexOf("state=") > -1) {
            var state = url.split("state=")[1];
            state = state.split("&color=")[0];
            $("#state option[value='"+decodeURIComponent(state)+"']").prop("selected", true);
        }
        if(url.indexOf("color=") > -1) {
            var color = url.split("color=")[1];
            $("#color option[value='"+decodeURIComponent(color)+"']").prop("selected", true);
        }

        $(document).on("change", "#state,#color", function() {
            var state = $("#state").find("option:selected").val();
            var color = $("#color").find("option:selected").val();
            window.location.href = "{{ route('admin_gurdwaras') }}?state=" + state + "&color=" + color;
        });
    });
</script>
@endsection
