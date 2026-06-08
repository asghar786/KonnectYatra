@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Newsletter Subscribers</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Subscribers</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="d-flex align-items-center mb-3" style="gap:10px;flex-wrap:wrap">
                <span class="badge badge-primary" style="font-size:14px;padding:8px 14px">
                    Total: {{ count($subscribers) }}
                </span>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width:60px;">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Source</th>
                                <th scope="col">Subscribed On</th>
                                <th scope="col" style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $i => $sub)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $sub->email }}</td>
                                <td>{{ $sub->source ?: '—' }}</td>
                                <td>{{ optional($sub->created_at)->format('d M Y, h:i A') ?: '—' }}</td>
                                <td>
                                    <form method="POST" action="{{ url('/admin/subscribers/delete', $sub->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="GET">
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding:30px;">No subscribers yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
