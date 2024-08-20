<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}} | Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/dist/img/Hlogo.png')}}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  </head>
	
	  <body class="hold-transition login-page">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">          
            <a href="{{url('/')}}" class="h1"><b>{{env('APP_NAME')}}</b></a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Reset Password</p>

					<!-- Session Status -->
					<x-auth-session-status class="mb-4" :status="session('status')" />

					<form method="POST" action="{{ route('password.store') }}">
							@csrf

							<!-- Password Reset Token -->
							<input type="hidden" name="token" value="{{ $request->route('token') }}">

							<!-- Email Address -->
							<div class="input-group mb-3">
								<input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email', $request->email) }}" placeholder="Email" required autocomplete="email" autofocus>
								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-envelope"></span>
									</div>
								</div>
							</div>

							<!-- Password -->							
							<div class="input-group mb-3">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
									@error('password')
										<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
										</span>
									@enderror
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
							</div>
						
							<!-- Confirm Password -->
							<div class="input-group mb-3">
								<input id="password_confirmation" name="password_confirmation" 
								type="password" 
								class="form-control @error('password_confirmation') is-invalid @enderror" 
								
								placeholder="Confirm Password" required autocomplete="new-password">
									@error('password_confirmation')
										<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
										</span>
									@enderror
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
							</div>
							
              <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
              </div>
					</form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
  </body>
</html>
