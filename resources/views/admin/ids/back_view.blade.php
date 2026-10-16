@extends('admin.layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
<style type="text/css">
  .idcards *{box-sizing:border-box;}
  .id-deck{display:flex;flex-wrap:wrap;gap:26px;justify-content:center;padding:10px 0 30px;}
@include('admin.ids._back_styles')
@include('admin.ids._print')
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">ID — Back View</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>Back View</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                @include('admin.ids._paper')
                <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                <a class="btn btn-info ml-2" href="{{ $front_url }}">Front View</a>
            </div>
        </div>
        <div class="main-body pt-3 idcards">
            {{-- Every back is identical, so a uniform back lines up whichever way the
                 printer turns the paper, as long as the sheet is full - hence always
                 eight slots (see PackagesController::idBackSheet). Shared by the Crew
                 and Yatri IDs. One deck per front sheet; _print breaks the page
                 between decks. The front pages' "Print Front + Back" prints these
                 same backs interleaved with the fronts. --}}
            @if($sheets > 1)
            <div class="alert alert-info id-note">{{ $sheets }} back sheets &mdash; one behind each front sheet. Every back is the same, so any page fits any front.</div>
            @endif
            @for($s = 0; $s < $sheets; $s++)
            <div class="id-deck">
                @for($i = 0; $i < 8; $i++)
                @include('admin.ids._back_card')
                @endfor
            </div>
            @endfor
            @if($sheets === 0)
            <p class="text-muted">{{ $empty }}</p>
            @endif
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
