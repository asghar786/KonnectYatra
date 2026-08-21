{{-- Add New / Edit a Quick Yatri application.

     The screen is the sheet: the same template the printed form comes from,
     rendered in 'entry' mode so every box becomes an input. Typing here and
     writing on the paper mean filling in the identical fields in the identical
     order. Expects: $row, $action. --}}
@extends('admin.layouts.app')
@section('content')
@include('admin.quick-yatri._sheet-css')
<style type="text/css">
    .qy-canvas{overflow-x:auto; padding-bottom:6px}
    .qy-canvas .qy-page{width:8.5in; min-height:auto; margin:0 auto; border:1px solid #eef0f4; border-radius:10px; box-shadow:0 8px 28px rgba(28,37,65,.07)}
    .qy-actions{display:flex; align-items:center; justify-content:flex-end; gap:10px; margin:18px 0 4px; flex-wrap:wrap}
    .qy-btn{display:inline-flex; align-items:center; gap:8px; border:none; border-radius:10px; padding:11px 22px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:transform .12s, box-shadow .12s}
    .qy-btn:hover{transform:translateY(-2px)}
    .qy-btn.save{background:#f54e18; color:#fff; box-shadow:0 6px 16px rgba(245,78,24,.28)}
    .qy-btn.cancel{background:#eef1f6; color:#5a6273}
    .qy-note{color:#6b7280; font-size:13px; margin-right:auto}
    .qy-errors{background:#feeceb; border:1px solid #f6c9c4; color:#b3261e; border-radius:12px; padding:14px 18px; margin-bottom:18px; font-size:14px}
    .qy-errors ul{margin:8px 0 0; padding-left:18px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">{{ $row->exists ? 'Edit Application' : 'New Yatri Application' }}</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ route('quick-yatri') }}">Quick Yatri</a></li>
                <li>{{ $row->exists ? 'Edit' : 'Add New' }}</li>
            </ul>
        </div>
        <div class="main-body">

            @if($errors->any())
                <div class="qy-errors">
                    <strong>Please check the form:</strong>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="qyForm">
                @csrf
                <div class="qy-canvas">
                    @include('admin.quick-yatri._sheet-body', ['row' => $row, 'mode' => 'entry'])
                </div>

                <div class="qy-actions">
                    <span class="qy-note">Only the applicant&rsquo;s name is required — save a partly filled sheet and finish it later.</span>
                    <a href="{{ route('quick-yatri') }}" class="qy-btn cancel">Cancel</a>
                    <button type="submit" class="qy-btn save"><i class="fa fa-save"></i> {{ $row->exists ? 'Update Application' : 'Save Application' }}</button>
                </div>
            </form>

        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        // Show the chosen photograph in the box straight away.
        var input = document.querySelector('.qy-photo-label input[type=file]');
        if (!input) return;
        input.addEventListener('change', function () {
            var file = this.files && this.files[0];
            if (!file) return;
            var url = URL.createObjectURL(file);
            var label = this.closest('.qy-photo-label');
            label.innerHTML = '';
            var img = document.createElement('img');
            img.src = url;
            img.alt = 'Photo';
            label.appendChild(img);
            label.appendChild(this);
        });
    })();
</script>
@endsection
