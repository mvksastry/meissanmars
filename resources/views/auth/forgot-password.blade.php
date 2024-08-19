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
          <p class="login-box-msg">First Login/Reset Password</p>
					<div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
						{{ __('Either First attempt to login or Forgot your password! No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
					</div>

					<!-- Session Status -->
					<x-auth-session-status class="mb-4" :status="session('status')" />

					<form method="POST" action="{{ route('password.email') }}">
						@csrf

						<!-- Email Address -->
						<div>
								<x-input-label for="email" :value="__('Email')" />
								<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
								<x-input-error :messages="$errors->get('email')" class="mt-2" />
						</div>

							<div class="flex items-center justify-end mt-4">
									<button class="btn-primary">
											{{ __('Email Password Reset Link') }}
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
