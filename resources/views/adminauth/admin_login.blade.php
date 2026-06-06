<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{asset('assets/images2/planeicon.png')}}" type="image/x-icon"/>
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images2/icon2-logo.jpeg')}}" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{asset('assets2\css\style.css')}}">
</head>
<body>
    <div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="POST" action="{{ route('admin_login') }}">
                @csrf
				<span class="contact100-form-title" style="margin-top: -20%;">
					<p class="wlc_shafiq">Welcome To Konnect Yatra</p>
				</span>

				<span class="login100-form-avatar">
					<img src="{{ asset('assets2/images/pp.jpg') }}" alt="AVATAR" style="height: 28%; width:30%; border-radius: 50%; margin-left: 35%; margin-top: -40px;">
				</span>

				<div class="wrap-input100 validate-input" data-validate="Email is required">
                    <div class="col-lg-12">
                        <label>Email</label>
                        <input id="email" type="email" class="input100 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Enter Your Email...">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @if(session('status'))

                        <div><small style="color: red; font-weight:bold;">{{session('status')}}</small></div>

                        @elseif(session('failed'))
                        <div class="alert alert-danger" role="alert">
                        {{session('failed')}}
                        </div>
                        @endif
                        </div>
				</div>
				<div class="wrap-input100 validate-input">
                    <div class="col-lg-12">
                        <label>Password</label>
                        <input id="password" type="password" class=" input100 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Your Password...">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

				</div>

					<button class="see" type="submit">Login</button>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" style="margin-left: -15px !important; margin-top: -15px;" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>

				<div class="contact100-form-social flex-c-m" style="margin-top: -20%;">
					<a href="#" class="contact100-form-social-item flex-c-m bg1 m-r-5">
						<i class="fa fa-facebook-f" aria-hidden="true"></i>
					</a>

					<a href="#" class="contact100-form-social-item flex-c-m bg2 m-r-5">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</a>

					<a href="#" class="contact100-form-social-item flex-c-m bg3">
						<i class="fa fa-youtube-play" aria-hidden="true"></i>
					</a>
				</div>
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url({{ asset('assets2/images/bg-01.jpg') }});">
			</div>
		</div>
	</div>
</body>
</html>

