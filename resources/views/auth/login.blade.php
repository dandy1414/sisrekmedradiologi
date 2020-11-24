<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sistem Rekam Medis Radiologi Rumah Sakit Umum Banjar Patroman</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{ asset('login_template/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_template/css/main.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf

					<span class="login100-form-title p-b-43">
						Silahkan Login
					</span>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

					{{-- <div class="wrap-input100">
						<input class="input100" type="email" name="email" value="{{ old('email') }}">
						<span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                        @error('email')
                        <span class="help-block" style="color: red">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
					</div>


					<div class="wrap-input100" style="margin-top: 30px">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                        @error('password')
                        <span class="help-block" style="color: red">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
					</div> --}}

					<div class="container-login100-form-btn" style="margin-top: 30px">
						<button type="submit" class="login100-form-btn" style="background: #337ab7">
							Login
						</button>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('{{ asset('storage/bg/bg-03.png') }}');">
				</div>
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="{{ asset('login_template/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_template/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_template/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('login_template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_template/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_template/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('login_template/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_template/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('login_template/js/main.js') }}"></script>

</body>
</html>
