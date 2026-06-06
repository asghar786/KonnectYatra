@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Visa Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Admin Can View Yatri Applied Visa Packages</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#hotelModel">
                Assign Hotel <i class="fa fa-plus"></i>
            </a>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#busModel">
                Assign Bus <i class="fa fa-plus"></i>
            </a>
            <div class="modal fade" id="hotelModel" tabindex="-1" role="dialog" aria-labelledby="hotelModelLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="hotelModelLabel">Assign Hotel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url("admin/assign-hotel") }}" id="hotel-form">
                                @csrf
                                <input type="hidden" name="visa_id" value="{{ $yatri->id }}">
                                <div class="form-group mb-2"> 
                                    <select class="form-control" name="hotel">
                                        <option value="">Select Hotel</option>
                                        @if(count(@$hotel) > 0)
                                        @foreach(@$hotel as $key => $value)
                                        @if(@$value->id == $yatri->hotel_id)
                                        <option value="{{ @$value->id }}" selected>{{ ucfirst(@$value->name) }}</option>
                                        @else
                                        <option value="{{ @$value->id }}">{{ ucfirst(@$value->name) }}</option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    <input type="number" name="room_number" class="form-control mt-3" id="room_number" placeholder="Enter Room Number">
                                    <input type="text" name="color" onkeydown="return /[a-z ]/i.test(event.key)" class="form-control mt-3" id="color" placeholder="Enter Color">
                                    {{-- <input type="radio" value="" id="hotel_{{ $key }}" @if(@$value->id == $yatri->hotel_id) checked @endif name="hotel">
                                    <label for="hotel_{{ $key }}" class="ml-2 mb-0" style="font-weight: normal;">{{ ucfirst(@$value->name) }}</label><br>
                                    <span class="ml-4">{{ @$value->address.', '.@$value->city }}</span> --}}
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" id="assign-hotel">Assign</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="busModel" tabindex="-1" role="dialog" aria-labelledby="busModelLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="busModelLabel">Assign Bus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url("admin/assign-bus") }}" id="bus-form">
                                @csrf
                                <input type="hidden" name="visa_id" value="{{ $yatri->id }}">
                                <select class="form-control" name="bus">
                                    <option value="">Select Bus</option>
                                    @if(count(@$bus) > 0)
                                    @foreach(@$bus as $key => $value)
                                    @if(@$value->id == $yatri->bus_id)
                                    <option value="{{ @$value->id }}" selected>{{ ucfirst(@$value->bus_number) }}</option>
                                    @else
                                    <option value="{{ @$value->id }}">{{ ucfirst(@$value->bus_number) }}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" id="assign-bus">Assign</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12 text-center py-3">
                    <h4>Passenger Details</h4>
                </div>
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><strong>Package Month </strong></td>
                                <td>{{ $yatri->package_month }}</td>
                            </tr>
                            <tr>
                                <td><strong>Package Price </strong></td>
                                <td>{{ $yatri->package_type }}</td>
                            </tr>
                            <tr>
                                <td><strong>Applicant Name </strong></td>
                                <td>{{ @$yatri->last_name.' '.@$yatri->first_name.' '.@$yatri->middle_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Place of Birth</strong></td>
                                <td>{{ $yatri->place_birth }} </td>
                            </tr>
                            <tr>
                                <td><strong>Gurdwara</strong></td>
                                <td>{{ @$yatri->gurdwara->gurdwara_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Hotel</strong></td>
                                <td>{{ @$yatri->hotel->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bus</strong></td>
                                <td>{{ @$yatri->bus->bus_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth</strong></td>
                                <td>{{ $yatri->dob }}</td>
                            </tr>
                            <tr>
                                <td><strong>Father Name </strong></td>
                                <td>{{ $yatri->father_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nationality </strong></td>
                                <td>{{ $yatri->nationality }}</td>
                            </tr>
                            <tr>
                                <td><strong>Passport </strong></td>
                                <td>{{ $yatri->passport }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender</strong></td>
                                <td>{{ $yatri->gender }}</td>
                            </tr>
                            <tr>
                                <td><strong>First Visit </strong></td>
                                <td>{{ $yatri->first_visit }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pre Visit Date </strong></td>
                                <td>{{ $yatri->pre_visit_date }}</td>
                            </tr>
                            <tr>
                                <td><strong>Port of Entry</strong></td>
                                <td>{{ $yatri->port_of_entry }}</td>
                            </tr>
                            <tr>
                                <td><strong>Profession</strong></td>
                                <td>{{ $yatri->profession }}</td>
                            </tr>
                            <tr>
                                <td><strong>Traveling Members </strong></td>
                                <td>{{ $yatri->traveling_members }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gurdwara Name </strong></td>
                                <td>{{ $yatri->gurdwara_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Address </strong></td>
                                <td>{{ $yatri->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>City </strong></td>
                                <td>{{ $yatri->city }}</td>
                            </tr>
                            <tr>
                                <td><strong>State </strong></td>
                                <td>{{ $yatri->state }}</td>
                            </tr>
                            <tr>
                                <td><strong>Zip </strong></td>
                                <td>{{ $yatri->zip }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pardan Name </strong></td>
                                <td>{{ $yatri->pardan_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Secetary Name </strong></td>
                                <td>{{ $yatri->secetary_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telephone </strong></td>
                                <td>{{ $yatri->telephone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date of Submission </strong></td>
                                <td>{{ Carbon\carbon::createFromFormat('Y-m-d H:i:s', $yatri->created_at)->format('m/d/Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Uploaded Photo</strong></td>
                                <td class="d-flex">
                                    @if(!empty($yatri->photo))
                                    <a href="{{asset('photo_uploads')}}/{{$yatri->photo}}" class="btn btn-warning text-white" data-lightbox="image-gallery" >View Photo</a> &nbsp;
                                    <div class="download-icon">
                                        <a href="{{asset('photo_uploads')}}/{{$yatri->photo}}" class="btn btn-success" download>
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Uploaded Passport</strong></td>
                                <td class="d-flex">
                                    @if(!empty($yatri->us_passport))
                                    <a href="{{asset('passport_uploads')}}/{{$yatri->us_passport}}" class="btn btn-warning text-white" data-lightbox="image-gallery" >View Passport</a> &nbsp;
                                    <div class="download-icon">
                                        <a href="{{asset('passport_uploads')}}/{{$yatri->us_passport}}" class="btn btn-success" download>
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Uploaded Green Card</strong></td>
                                <td class="d-flex">
                                    @if(!empty($yatri->green_card))
                                    <a href="{{asset('greencard_uploads')}}/{{$yatri->green_card}}" class="btn btn-warning text-white" data-lightbox="image-gallery">View Green Card</a> &nbsp;
                                    <div class="download-icon">
                                        <a href="{{asset('greencard_uploads')}}/{{$yatri->green_card}}" class="btn btn-success" download>
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Uploaded State ID/Driving License</strong></td>
                                <td class="d-flex">
                                    @if(!empty($yatri->driving_license))
                                    <a href="{{asset('drivinglicense_uploads')}}/{{$yatri->driving_license}}" class="btn btn-warning text-white" data-lightbox="image-gallery">View State ID/Driving License</a> &nbsp;
                                    <div class="download-icon">
                                        <a href="{{asset('drivinglicense_uploads')}}/{{$yatri->driving_license}}" class="btn btn-success" download>
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Payment Type </strong></td>
                                <td>{{ $yatri->payment_type }}</td>
                            </tr>
                            <tr>
                                <td><strong>Routing Number </strong></td>
                                <td>{{ $yatri->routing_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Account Number </strong></td>
                                <td>{{ $yatri->account_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Amount </strong></td>
                                <td>@if(!empty($yatri->amount)) ${{ $yatri->amount }} @endif</td>
                            </tr>
                            <tr>
                                <td><strong>Bank Receipt</strong></td>
                                <td class="d-flex">
                                    @if(!empty($yatri->bank_receipt))
                                    <a href="{{asset('bank_receipt')}}/{{$yatri->bank_receipt}}" class="btn btn-warning text-white" data-lightbox="image-gallery">View Bank Receipt</a> &nbsp;
                                    <div class="download-icon">
                                        <a href="{{asset('bank_receipt')}}/{{$yatri->bank_receipt}}" class="btn btn-success" download>
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Payment Status </strong></td>
                                <td><span @if(@$yatri->payment_status == "pending") class="badge badge-warning" @elseif(@$yatri->payment_status == "paid") class="badge badge-success" @else class="badge badge-danger" @endif style="font-size: 16px;">{{ucfirst($yatri->payment_status)}}</span></td>
                            </tr>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("click", "#assign-hotel", function () {
                $("#hotel-form").submit();
            });
            $(document).on("click", "#assign-bus", function () {
                $("#bus-form").submit();
            });
        });
    </script>
@endsection