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

<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">All Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/user/user_dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>All Packages</li>
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
        <div class="page-banner contact-page section-sp2" style="margin-top: -80px;">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <h4 class="mb-2 text-center">Holy Journey to Nankana Sahib (Guru Nanak Dev Ji’s Birthday)</h4>
                        <h5 class="mb-4 text-center text-danger">INCLUDES VISA AND FULL SECURITY</h5>
                        <div class="row g-3">
                            @if(count(@$all_packages) > 0)
                            @foreach(@$all_packages as $key => $val)
                            <div class="col-6 my-3 text-center">
                                <div class="video-bx">
                                    <img src="{{ asset('assets/flyers/'.@$val['image']) }}" style="height: 500px; border-radius: 15px;" class="">
                                    <div class="clearfix"></div>
                                    <a href="{{ url("user/all-packages", @$val->id) }}" class="btn btn-primary mt-3 w-50">Book Now</a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- inner page banner END -->
    </div>
    <!-- Content END-->
</main>
<style>
    table {
        border: 1px solid black;
        height: auto;
        width: auto;
    }

    th {

        padding: 0px;
        width: auto;
        height: auto;
        text-align: center;
    }

    td {
        border: 1px solid black;
        padding: 0px;
        width: auto;
        height: auto;
        text-align: center;
    }
</style>
<script>
    (function() {
        'use strict';

        var forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    var firstInvalidElement = form.querySelector(':invalid');
                    firstInvalidElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
<script>
    $(document).ready(function() {
            // Attach click event listener to each checkbox
        $("#package_1, #package_2, #package_3").click(function() {
                // If a checkbox is checked, enable the other two
            if ($(this).is(":checked")) {
                $("#package_1, #package_2, #package_3").not(this).prop("disabled", true);
            }
                // If a checkbox is unchecked, enable the other two
            else {
                $("#package_1, #package_2, #package_3").prop("disabled", false);
            }
        });
    });
</script>
<script>
        // Add event listeners to all the package checkboxes
    $("input[type='checkbox']").change(function() {
        var checked = $(this).is(":checked");
        var container = $(this).closest(".col-lg-4");
        container.find("input[type='radio']").prop("disabled", !checked);
        container.find("input[type='radio']").prop("required", true);
    });
</script>
<script>
    $(document).ready(function() {
            // Attach click event listener to radio buttons
        $('input[name="first_visit"]').on('click', function() {
                // If yes is selected, show the div
            if ($(this).val() === 'yes') {
                $('#previous-visit').prop('required', false);
                $('#entry-port').prop('required', false);
                $('#first-visit').hide();
            }
                // If no is selected, hide the div
            else {
                $('#previous-visit').prop('required', true);
                $('#entry-port').prop('required', true);
                $('#first-visit').show();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
            // Attach click event listener to radio buttons
        $('input[name="us_passport"]').on('click', function() {
                // If yes is selected, show the div
            if ($(this).val() === 'yes') {
                $('#green-card').prop('required', true);
            }
                // If no is selected, hide the div
            else {
                $('#green-card').prop('required', false);
            }
        });
    });
</script>
@endsection
