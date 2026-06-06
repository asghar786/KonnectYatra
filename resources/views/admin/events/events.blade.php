@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Upcoming Events</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Upcoming Events</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/events/create') }}" class="btn btn-primary">
                Add Event <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Event Name</th>
                                <th scope="col">Event Location</th>
                                <th scope="col">Event Date</th>
                                <th scope="col">Event Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($events) > 0)
                            @foreach($events as $event)
                            <tr>
                                @php
                                    $timestamp = strtotime($event->event_date);
                                    $new_date_format = date('d M Y', $timestamp);
                                @endphp
                                <td class="text-center"><img src="{{ asset("news_and_events/".$event->image) }}" style="width: 100px; height: 100px;"></td>
                                <td class="text-center">{{$event->title}}</td>
                                <td class="text-center">{{$event->location}}</td>
                                <td class="text-center">{{$new_date_format}}</td>
                                <td class="text-center">{{$event->event_time}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/events/edit', $event->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$event->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/events/delete', $event->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;"><i class="text-white fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">No result found.</td>
                            </tr>
                            @endif
                        </tbody>
                        {{-- @endforeach --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection