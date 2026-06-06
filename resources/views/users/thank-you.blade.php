@extends('userslayouts.app')
@section('content')

    <style type="text/css">
        .owl-prev, .owl-next, .back-to-top, .btn {
            background-color: #f54e18 !important;
            color: #fff !important;
        }
        .title-head {
            border-color: #f54e18 !important;
        }
        .btn.dropdown-toggle.btn-default {
            color: #000 !important;
        }
    </style>

    <!-- Content -->
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">Thank You</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="{{ url('/user/user_dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                    <li>Thank You</li>
                </ul>
            </div>
            <!-- Breadcrumb row END -->
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-4">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-4">
                        <h6 class="text-center">Wahe Guru Ji ka Khalsa</h6>
                    </div>
                    <div class="col-4">
                        <h3 class="text-center">(First Come First Serve)</h3>
                    </div>
                    <div class="col-4">
                        <h6 class="text-center">Wahe Guru Ji ki Fateh</h6>
                    </div>
                </div>
            </div>
            <!-- inner page banner -->
            <div class="page-banner contact-page section-sp2 mb-0" style="margin-top: -80px;">
                <div class="container">
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h4 class="text-center">Thank You for the booking.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- inner page banner END -->
        </div>
    </main>
    <!-- Content END-->
@endsection
