@extends('layouts.app')
@section('content')


	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Edit User</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Edit User</li>
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
                        <label for="exampleInputBorderWidth2">Name*</label>
                        <input type="text" class="form-control form-control-border" 
                        name="name" id="name" disabled value="{{ $user->name }}" placeholder="Name">
                        @if($errors->has('rack_name'))
                          <p class="help-block text-danger">
                            {{ $errors->first('rack_name') }}
                          </p>
                        @endif
                      </div>

                      <div class="col-xs-12 form-group">
                        <label for="exampleInputBorderWidth2">Email*</label>
                        <input type="text" class="form-control form-control-border" 
                        name="email" id="email" disabled value="{{ $user->email }}" placeholder="Email">
                        @if($errors->has('email'))
                          <p class="help-block text-danger">
                            {{ $errors->first('email') }}
                          </p>
                        @endif
                      </div>
                    
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Password*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="password" id="password" value="" placeholder="New Password">
                            @if($errors->has('password'))
                              <p class="help-block text-danger">
                                {{ $errors->first('password') }}
                              </p>
                            @endif
                          </div> 

                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Inactivate*</label>
                            <select class="form-control shadow border rounded" 
                            name="inactivate" id="inactivate">
                              <option value="active">Active</option>
                              <option value="inactivated">Inactivated</option>
                            </select>
                            @if($errors->has('inactivate'))
                              <p class="help-block text-danger">
                                {{ $errors->first('inactivate') }}
                              </p>
                            @endif
                          </div>
                    <!-- end of project data entry form -->
                    <button type="submit" class="btn btn-success rounded">Update</button>
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
