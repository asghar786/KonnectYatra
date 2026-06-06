@extends('layouts.app')

@section('content')
<!-- Inner Content Box ==== -->
    <div class="page-content">
    <!-- Page Heading Box ==== -->
        <div class="page-banner ovbl-light" style="background-image:url({{ asset('assets/images2/blog-4.jpg') }});">
            <div class="container">
                <div class="page-banner-entry">
                    <h1 class="text-white">Reset Password </h1>
                 </div>
            </div>
        </div>
        <div class="breadcrumb-row">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li>Reset Password </li>
                </ul>
            </div>
        </div>
        <div class="content-block py-5">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group row">
                    @if (session('status'))
                    <div class="offset-lg-4 col-lg-6 text-center">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                    @endif
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
