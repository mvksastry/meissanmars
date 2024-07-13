@extends('layouts.app')
@section('content')


	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: User Details</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">User Details</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				
				<!-- Main row -->
          @if(session()->has('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
         @endif
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  User Data
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
						  <div class="card-body">
							<div class="tab-content p-0">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <form method="POST" action="{{ route('users.update', $user->id) }}" enctype ="multipart/form-data">
                    @method('PUT')
                    @csrf
                   <!-- project data entry form -->
                   
                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Name</label>
                        {{ $user->name }}
                      </div>

                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Email</label>
                        {{ $user->email }}
                      </div>
                    
                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Email Verified On</label>
                        {{ $user->email_verified_at }}
                      </div>

                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Current Team ID</label>
                        {{ $user->current_team_id  }}
                      </div>                      

                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Folder</label>
                        {{ $user->folder  }}
                      </div>                      



                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Start Date</label>
                        {{ $user->start_date }}
                      </div>

                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Expiry Date</label>
                        {{ $user->expiry_date  }}
                      </div>                      

                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">First Log In</label>
                        {{ $user->first_login  }}
                      </div>







                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Status*</label>
                            {{ $user->status }}

                          </div>
                    <!-- end of project data entry form -->
                    
                  </form>
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
					<!-- /.Left col -->
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>

		
	</div>	







@endsection('content')
