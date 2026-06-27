@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    body {
        background-color: #f8f9fa;
    }
    .doc-view { color:#333; }
    .doc-view:hover { color:#f54e18; }
</style>
@php
// Render an uploaded document as a file-type icon that opens in a modal popup.
$docView = function ($dir, $file) {
    if (empty($file)) return '<span>N/A</span>';
    $url   = asset($dir . '/' . $file);
    $ext   = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $isImg = in_array($ext, ['jpg','jpeg','png','gif','webp','bmp','svg']);
    $isPdf = ($ext === 'pdf');
    $icon  = $isImg ? 'fa-file-image' : ($isPdf ? 'fa-file-pdf' : 'fa-file-lines');
    $color = $isImg ? '#0d6efd' : ($isPdf ? '#dc3545' : '#6c757d');
    $type  = $isImg ? 'image' : ($isPdf ? 'pdf' : 'other');
    return '<a href="javascript:void(0)" class="doc-view d-inline-flex flex-column align-items-center text-decoration-none" '
         . 'data-url="' . $url . '" data-type="' . $type . '" title="Click to view">'
         . '<i class="fas ' . $icon . '" style="font-size:46px;color:' . $color . ';"></i>'
         . '<small class="mt-1">' . strtoupper($ext) . ' file</small></a>';
};
// Render a label/value row (with N/A fallback).
$field = function ($label, $value) {
    $value = (isset($value) && $value !== '' && $value !== null) ? e($value) : 'N/A';
    return '<li class="w-100 d-flex justify-content-between row mb-1">'
         . '<span class="col-lg-5" style="font-weight:500;">' . $label . ':</span>'
         . '<span class="col-lg-7">' . $value . '</span></li>';
};
@endphp
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Booking Details</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Booking Details</li>
            </ul>
            <div class="w-75 d-flex justify-content-end" style="gap:8px; flex-wrap:wrap;">
                <a class="btn btn-primary" href="{{ route('yatri-form-download', $yatri->id) }}"><i class="fa fa-download"></i> Download Yatri Form</a>
                <a class="btn btn-danger" href="{{ route('yatri-form-pdf', $yatri->id) }}"><i class="fa fa-file-pdf"></i> Form + Docs (with Header/Footer)</a>
                <a class="btn btn-info" href="{{ route('yatri-form-pdf-docs', $yatri->id) }}"><i class="fa fa-file-pdf"></i> Form + Docs (without Header/Footer)</a>
                <a class="btn btn-warning" href="{{ route('yatri-form-c', $yatri->id) }}"><i class="fa fa-id-card"></i> Download Form C</a>
            </div>
        </div>
        <div class="main-body">
            <div class="row my-4" id="detail-div" style="display: none;">
                <div class="w-100">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Booking Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Submission Date:</span>
                                    <span style="width: 60%;">{{ date("d F, Y", strtotime(@$yatri->created_at)) }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Package Type:</span>
                                    <span style="width: 60%;">Single Occupancy</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Hotel Name:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->hotel->name) ? @$yatri->hotel->name : "N/A" }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Total Amount:</span>
                                    <span style="width: 60%;">{{ @$yatri->package_type }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 w-50" style="list-style-type: none;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Package Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->package->name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Ticket Type:</span>
                                    <span style="width: 60%;">{{ ucfirst(str_replace("_", " ", @$yatri->ticket_type)) }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Bus #:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->bus->bus_number) ? @$yatri->bus->bus_number : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-100 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Yatri's Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <h4 class="mb-4 w-100" style="padding-left: 30px;">Yatri Details</h4>
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Applicant Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->last_name.' '.@$yatri->first_name.' '.@$yatri->middle_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Email:</span>
                                    <span style="width: 60%;">{{ @$yatri->email }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Phone:</span>
                                    <span style="width: 60%;">{{ @$yatri->phone }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Father Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->father_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Mother Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->mother_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Passport:</span>
                                    <span style="width: 60%;">{{ @$yatri->passport }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Address:</span>
                                    <span style="width: 60%;">{{ @$yatri->address }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">State:</span>
                                    <span style="width: 60%;">{{ @$yatri->state }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Secretary Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->secetary_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Secretary Phone:</span>
                                    <span style="width: 60%;">{{ @$yatri->secretary_phone }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Uploaded Photo:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->photo))
                                            {!! $docView('photo_uploads', $yatri->photo) !!}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                                <li class="w-100 row mb-3">
                                    <span style="width: 40%; font-weight: 500;">Uploaded Green Card:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->green_card))
                                            {!! $docView('greencard_uploads', $yatri->green_card) !!}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Gurdwara Name:</span>
                                    <span style="width: 60%;">{{ (!empty(@$yatri->gurdwara->gurdwara_name)) ? @$yatri->gurdwara->gurdwara_name : "N/A" }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Place of Birth:</span>
                                    <span style="width: 60%;">{{ @$yatri->place_birth }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Date of Birth:</span>
                                    <span style="width: 60%;">{{ @$yatri->dob }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Nationality:</span>
                                    <span style="width: 60%;">{{ @$yatri->passport_country }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Gender:</span>
                                    <span style="width: 60%;">{{ @$yatri->gender }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Profession:</span>
                                    <span style="width: 60%;">{{ @$yatri->profession }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">City:</span>
                                    <span style="width: 60%;">{{ @$yatri->city }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Zip:</span>
                                    <span style="width: 60%;">{{ @$yatri->zip }}</span>
                                </li>
                                <li class="w-100 row mb-3">
                                    <span style="width: 40%; font-weight: 500;">Uploaded Passport:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->us_passport))
                                            {!! $docView('passport_uploads', $yatri->us_passport) !!}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Uploaded ID/Driving License:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->driving_license))
                                            {!! $docView('drivinglicense_uploads', $yatri->driving_license) !!}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-100 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Payment Type:</span>
                                    <span style="width: 60%;">{{ @$yatri->payment_type }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Bank Receipt:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->bank_receipt))
                                            {!! $docView('bank_receipt', $yatri->bank_receipt) !!}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 w-50" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Routing Number:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->routing_number) ? @$yatri->routing_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Account Number:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->account_number) ? @$yatri->account_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Amount:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->amount) ? "$".@$yatri->amount : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Booking Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Submission Date:</span>
                                    <span class="col-lg-8">{{ date("d F, Y", strtotime(@$yatri->created_at)) }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Package Type:</span>
                                    <span class="col-lg-8">Single Occupancy</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Hotel Name:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->hotel->name) ? @$yatri->hotel->name : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Total Amount:</span>
                                    <span class="col-lg-8">{{ @$yatri->package_type }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Package Name:</span>
                                    <span class="col-lg-8">{{ @$yatri->package->name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Ticket Type:</span>
                                    <span class="col-lg-8">{{ ucfirst(str_replace("_", " ", @$yatri->ticket_type)) }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Bus #:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->bus->bus_number) ? @$yatri->bus->bus_number : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Yatri's Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <h4 class="mb-3 col-lg-12">Yatri Details — <span style="color:#f54e18;">{{ @$yatri->yatri_id ?: 'Pending' }}</span></h4>

                            <h6 class="col-lg-12 mt-2 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Personal Information</h6>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Applicant Name', trim(@$yatri->last_name.' '.@$yatri->first_name.' '.@$yatri->middle_name)) !!}
                                {!! $field('First Name', @$yatri->first_name) !!}
                                {!! $field('Middle Name', @$yatri->middle_name) !!}
                                {!! $field('Last Name', @$yatri->last_name) !!}
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Date of Birth', @$yatri->dob) !!}
                                {!! $field('Place of Birth', @$yatri->place_birth) !!}
                                {!! $field('Gender', @$yatri->gender) !!}
                                {!! $field('Marital Status', @$yatri->marital_status) !!}
                                {!! $field('Religion', @$yatri->religion) !!}
                            </ul>

                            <h6 class="col-lg-12 mt-4 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Contact Information</h6>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Primary Email', @$yatri->email) !!}
                                {!! $field('Other Email', @$yatri->other_email) !!}
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Primary Mobile', @$yatri->phone) !!}
                                {!! $field('Other Mobile', @$yatri->other_phone) !!}
                            </ul>

                            <h6 class="col-lg-12 mt-4 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Passport &amp; Visa Information</h6>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Passport No', @$yatri->passport) !!}
                                {!! $field('Passport Type', @$yatri->passport_type) !!}
                                {!! $field('Issuing Authority', @$yatri->issuing_authority) !!}
                                {!! $field('Passport Country', @$yatri->passport_country) !!}
                                {!! $field('Traveller Nationality', @$yatri->nationality) !!}
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Issue Date', @$yatri->issue_date) !!}
                                {!! $field('Expiry Date', @$yatri->expiry_date) !!}
                                {!! $field('Reference No', @$yatri->reference_no) !!}
                                {!! $field('Permanent Residence Country', @$yatri->residence_country) !!}
                                {!! $field('Green Card Expiry', @$yatri->green_card_expiry_date) !!}
                            </ul>

                            <h6 class="col-lg-12 mt-4 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Family Information</h6>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field("Traveller's Father Name", @$yatri->father_name) !!}
                                {!! $field("Traveller's Father Nationality", @$yatri->father_nationality) !!}
                                {!! $field("Traveller's Mother Name", @$yatri->mother_name) !!}
                                {!! $field("Traveller's Mother Nationality", @$yatri->mother_nationality) !!}
                            </ul>
                            @if(!empty(@$yatri->spouse_name) || @$yatri->have_spouse === 'yes')
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Has Spouse', @$yatri->have_spouse) !!}
                                {!! $field('Spouse Name', @$yatri->spouse_name) !!}
                                {!! $field('Spouse Birth Country', @$yatri->spouse_birth_country) !!}
                                {!! $field('Spouse Nationality', @$yatri->spouse_nationality) !!}
                            </ul>
                            @endif

                            @php $companions = @$yatri->companions; @endphp
                            @if(!empty($companions) && count($companions))
                            <h6 class="col-lg-12 mt-4 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">
                                Travelling Companions
                                <span class="badge badge-warning" style="font-weight:600;">Keep together for hotel rooms</span>
                                <span class="float-right" style="font-size:13px;color:#1c2541;">
                                    Total people: <b>{{ (int) (@$yatri->travellers_count ?: 1) }}</b>
                                    @if(@$yatri->total_amount > 0) &nbsp;|&nbsp; Total: <b style="color:#f54e18;">${{ number_format($yatri->total_amount) }}</b> @endif
                                </span>
                            </h6>
                            <div class="col-lg-12 mb-2">
                                <table class="table table-bordered mb-0" style="background:#fff;">
                                    <thead style="background:#faf7ff;">
                                        <tr>
                                            <th>#</th>
                                            <th>Relation</th>
                                            <th>Full Name</th>
                                            <th>Country of Birth</th>
                                            <th>Nationality</th>
                                            <th>Passport No</th>
                                            <th>Passport</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($companions as $i => $c)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $c->relation }}</td>
                                            <td>{{ $c->full_name }}</td>
                                            <td>{{ $c->birth_country }}</td>
                                            <td>{{ $c->nationality }}</td>
                                            <td>{{ $c->passport_no ?: '—' }}</td>
                                            <td>
                                                @if(!empty($c->passport_file))
                                                @php
                                                    $cExt  = strtolower(pathinfo($c->passport_file, PATHINFO_EXTENSION));
                                                    $cType = in_array($cExt, ['jpg','jpeg','png','gif','webp','bmp','svg']) ? 'image' : ($cExt === 'pdf' ? 'pdf' : 'other');
                                                @endphp
                                                <a href="javascript:void(0)" class="doc-view text-decoration-none"
                                                   data-url="{{ asset('passport_uploads/'.$c->passport_file) }}" data-type="{{ $cType }}" title="Click to view">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                @else — @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            <h6 class="col-lg-12 mt-4 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Employment &amp; Travel History</h6>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field("Traveller's Profession", @$yatri->profession) !!}
                                {!! $field('Travelled abroad in past 3 years', @$yatri->travel_history) !!}
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Granted Pakistani visa before', @$yatri->pk_travel_history) !!}
                                @if(@$yatri->pk_travel_history == 'yes')
                                {!! $field('Entered Pakistan via', @$yatri->pk_entry_port) !!}
                                {!! $field('Recent date of entry', @$yatri->pk_entry_date) !!}
                                @endif
                            </ul>

                            <h6 class="col-lg-12 mt-4 mb-2" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Gurdwara &amp; Reference</h6>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Gurdwara Name', @$yatri->gurdwara->gurdwara_name ?? @$yatri->gurdwara_name) !!}
                                {!! $field('Address', @$yatri->address) !!}
                                {!! $field('City', @$yatri->city) !!}
                                {!! $field('State', @$yatri->state) !!}
                                {!! $field('Zip', @$yatri->zip) !!}
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type:none;">
                                {!! $field('Secretary/Pardan Name', @$yatri->secetary_name) !!}
                                {!! $field('Secretary/Pardan Phone', @$yatri->secretary_phone) !!}
                                {!! $field('Reference Person Name', @$yatri->reference_name) !!}
                                {!! $field('Reference Person Phone', @$yatri->reference_phone) !!}
                            </ul>

                            <h6 class="col-lg-12 mt-4 mb-3" style="font-weight:700;border-bottom:2px solid #f54e18;padding-bottom:6px;">Uploaded Documents</h6>
                            <div class="col-lg-12 d-flex flex-wrap" style="gap:34px;">
                                <div class="text-center"><div style="font-weight:500;margin-bottom:6px;">Photo</div>{!! $docView('photo_uploads', @$yatri->photo) !!}</div>
                                <div class="text-center"><div style="font-weight:500;margin-bottom:6px;">Passport</div>{!! $docView('passport_uploads', @$yatri->us_passport) !!}</div>
                                <div class="text-center"><div style="font-weight:500;margin-bottom:6px;">ID / Driving License</div>{!! $docView('drivinglicense_uploads', @$yatri->driving_license) !!}</div>
                                <div class="text-center"><div style="font-weight:500;margin-bottom:6px;">Green Card</div>{!! $docView('greencard_uploads', @$yatri->green_card) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Payment Type:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->payment_type) ? @$yatri->payment_type : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Bank Receipt:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($yatri->bank_receipt))
                                            {!! $docView('bank_receipt', $yatri->bank_receipt) !!}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Routing Number:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->routing_number) ? @$yatri->routing_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Account Number:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->account_number) ? @$yatri->account_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Amount:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->amount) ? "$".@$yatri->amount : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Documents -->
            @if(!empty($yatri) && $yatri->documents && count($yatri->documents))
            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"><h6 class="mb-0">Additional Documents</h6></div>
                        <div class="card-body py-4 row">
                            @foreach($yatri->documents as $doc)
                            <div class="col-lg-3 col-md-4 col-6 text-center mb-4">
                                {!! $docView('document_uploads', $doc->file) !!}
                                <div class="mt-2" style="font-weight:500;">{{ $doc->name }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

<!-- Document viewer modal -->
<div class="modal fade" id="docModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Document</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center" id="docModalBody" style="min-height:200px;"></div>
            <div class="modal-footer">
                <a href="#" target="_blank" rel="noopener" id="docModalOpen" class="btn btn-primary">Open in new tab</a>
            </div>
        </div>
    </div>
</div>
<div class="ttr-overlay"></div>
@endsection
@section('js')
    <script type="text/javascript">
        function printDiv(divName) {

            var printContents = document.getElementById(divName).innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

                // document.body.style.marginTop="-45px";

            window.print();

            document.body.innerHTML = originalContents;

            location.reload();

        }

        // Open an uploaded document in the modal popup.
        $(document).on('click', '.doc-view', function () {
            var url = $(this).data('url');
            var type = $(this).data('type');
            var body = '';
            if (type === 'image') {
                body = '<img src="' + url + '" style="max-width:100%;max-height:75vh;">';
            } else if (type === 'pdf') {
                body = '<iframe src="' + url + '" style="width:100%;height:75vh;border:0;"></iframe>';
            } else {
                body = '<p class="py-4">Preview is not available for this file type. Use the button below to open it.</p>';
            }
            $('#docModalBody').html(body);
            $('#docModalOpen').attr('href', url);
            $('#docModal').modal('show');
        });
    </script>
@endsection