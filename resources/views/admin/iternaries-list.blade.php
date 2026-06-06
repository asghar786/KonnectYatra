@extends('admin.layouts.app')
@section('content')
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb" >
                <h4 class="breadcrumb-title">List of Iternaries</h4>
			</div>
            <div class="container-fluid mt-4 p-4">
                <div class="row p-3">
                    <div class="col-12">
                        <table  class="table table-striped" id="myTables">
                            <thead>
                                <tr bgcolor="#4c1864">
                                    <th scope="col"><font color="#fff">Sr #</font></th>
                                    <th scope="col"><font color="#fff">From</font></th>
                                    <th scope="col"><font color="#fff">To</font></th>
                                    <th scope="col"><font color="#fff">PNR</font></th>
                                    <th scope="col"><font color="#fff">Flight #</font></th>
                                    <th scope="col"><font color="#fff">Date of Departure</font></th>
                                    <th scope="col"><font color="#fff">Time of Departure</font></th>
                                    <th scope="col"><font color="#fff">Date of Arrival</font></th>
                                    <th scope="col"><font color="#fff">Ticket No.</font></th>
                                    <th scope="col"><font color="#fff">A/L Price</font></th>
                                    <th scope="col"><font color="#fff">Agency Price</font></th>
                                    <th scope="col"><font color="#fff">Net Profit</font></th>
                                </tr>
                            </thead>
                            <tbody id="mytable">
                                @if(count($itenaries) > 0)
                                @foreach($itenaries as $key => $itenary)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td data-label="from">{{$itenary->from}}</td>
                                    <td data-label="to">{{$itenary->to}}</td>
                                    <td data-label="Name"></td>
                                    <td data-label="email"></td>
                                    <td data-label="depart">{{$itenary->depart}}</td>
                                    <td data-label="time">{{$itenary->depart}}</td>
                                    <td data-label="arrival">{{$itenary->return}}</td>
                                    <td data-label="ticket"></td>
                                    <td data-label="alprice"></td>
                                    <td data-label="agprice"></td>
                                    <td data-label="netpro"></td>
                                </tr>
                               @endforeach
                               @else
                               <tr>
                                   <td colspan="12" class="text-center">No result found.</td>
                               </tr>
                               @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
	<div class="ttr-overlay"></div>
    <script src="{{asset('adminassets/js/itenaries.js')}}"></script>
@endsection
