@extends('admin.layouts.app')
@section('content')
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">

			<div class=" search row db-breadcrumb" >
               
                    <div class="col-6">
                    <h4 class="breadcrumb-title">Ticket Details</h4>
                    </div>
                    <div class="col-6" >
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    </div>    	
			</div>
            @foreach ($itenaryadults as $adult)
            @if($adult)
            <div class="container-fluid mt-4 p-4 student-table">
            
                <div class="row p-3">
                
                    <div class="col-12 adult">
                            <div class="row">
                                @foreach($itenaries as $itenary)
                                <div class="col-12">
                            
                                    <h5><i class="fa fa-male fa-lg"></i>  {{$adult->firstnamea}} {{$adult->lastnamea}} </h5>
                                    <span class="cat">Adult-{{$itenary->class}}</span>
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-1 ">
                            
                                <span class="email"><i class="fa fa-envelope"></i>  {{$itenary->email}}</span><br>
                                <span class=" contact"><i class="fa fa-phone"></i>  {{$itenary->contact}}</span><br>
                                <span class=" dateofbirth"><i class="fa fa-calendar"></i>  {{$adult->doba}}</span>
                                
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-3">
                                        <span style="color:#4c1864; float:right;"><i class="fa fa-clock-o"></i> Trip Duration:    <span class="tripduration"><i class="fa fa-calendar"></i> {{$itenary->depart}} ---------------- <i class="fa fa-calendar"></i> {{$itenary->return}}</span> </span>
                                </div>
                                <div class="col-lg-6 col-sm-12 text-left mt-2">
                                <span style="color:#4c1864;" class="city1"><i class=" fa fa-plane fa-lg"></i>  {{$itenary->from}} ---------</span><span  style="color:#4c1864;" class="city2">---- <i class=" fa fa-plane fa-lg"></i>  {{$itenary->to}}</span>
                                
                                </div>
                               @endforeach
                            </div>
                    </div> 
                </div>
            </div>
            @endif
            @endforeach

            @foreach ($itenarychilds as $child)
            @if($child)
            <div class="container-fluid mt-4 p-4 student-table">
            
                <div class="row p-3">
                
                    <div class="col-12 adult">
                        
                            <div class="row">
                               @foreach($itenaries as $itenary)
                                <div class="col-12">
                            
                                    <h5><i class="fa fa-male fa-lg"></i>  {{$child->firstnamec}} {{$child->lastnamec}} </h5>
                                    <span class="cat">Child-{{$itenary->class}}</span>
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-1 ">
                            
                                <span class="email"><i class="fa fa-envelope"></i>  {{$itenary->email}}</span><br>
                                <span class=" contact"><i class="fa fa-phone"></i>  {{$itenary->contact}}</span><br>
                                <span class=" dateofbirth"><i class="fa fa-calendar"></i>  {{$child->dobc}}</span>
                                
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-3">
                                        <span style="color:#4c1864; float:right;"><i class="fa fa-clock-o"></i> Trip Duration:    <span class="tripduration"><i class="fa fa-calendar"></i> {{$itenary->depart}} ---------------- <i class="fa fa-calendar"></i> {{$itenary->return}}</span> </span>
                                </div>
                                <div class="col-lg-6 col-sm-12 text-left mt-2">
                                <span style="color:#4c1864;" class="city1"><i class=" fa fa-plane fa-lg"></i>  {{$itenary->from}} ---------</span><span  style="color:#4c1864;" class="city2">---- <i class=" fa fa-plane fa-lg"></i>  {{$itenary->to}}</span>
                                
                                </div>
                                
                                @endforeach
                            </div>
                    </div> 
                </div>
        </div>
            @endif
            @endforeach


            @foreach ($itenaryinfants as $infant)
            @if($infant)
            <div class="container-fluid mt-4 p-4 student-table">
            
                <div class="row p-3">
                
                    <div class="col-12 adult">
                            <div class="row">
                              
                                <div class="col-12">
                            
                                    <h5><i class="fa fa-male fa-lg"></i>  {{$infant->firstnamei}} {{$infant->lastnamei}} </h5>
                                    @foreach($itenaries as $itenary)
                                    <span class="cat">Infant-{{$itenary->class}}</span>
                                    @endforeach
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-1 ">
                                @foreach($itenaries as $itenary)
                                <span class="email"><i class="fa fa-envelope"></i>  {{$itenary->email}}</span><br>
                                <span class=" contact"><i class="fa fa-phone"></i>  {{$itenary->contact}}</span><br>
                                <span class=" dateofbirth"><i class="fa fa-calendar"></i>  {{$infant->dobi}}</span>
                                @endforeach
                                </div>
                                @foreach($itenaries as $itenary)
                                <div class="col-lg-6 col-sm-12 mt-3">
                                        <span style="color:#4c1864; float:right;"><i class="fa fa-clock-o"></i> Trip Duration:    <span class="tripduration"><i class="fa fa-calendar"></i> {{$itenary->depart}} ---------------- <i class="fa fa-calendar"></i> {{$itenary->return}}</span> </span>
                                </div>
                                @endforeach
                                @foreach($itenaries as $itenary)
                                <div class="col-lg-6 col-sm-12 text-left mt-2">
                                <span style="color:#4c1864;" class="city1"><i class=" fa fa-plane fa-lg"></i>  {{$itenary->from}} ---------</span><span  style="color:#4c1864;" class="city2">---- <i class=" fa fa-plane fa-lg"></i>  {{$itenary->to}}</span>
                                
                                </div>
                                @endforeach
                            
                            </div>
                    </div> 
                </div>
             </div>
            @endif
            @endforeach
	<div class="ttr-overlay"></div>
   
    
   
   



@endsection