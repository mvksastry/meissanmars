@extends('layouts.fpwapp')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Profile</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Password Change</li>
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
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Password Change
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
              
											<form method="POST" action="{{ route('change-password') }}">
												@csrf
                          <table id="userIndex2" class="table table-bordered table-hover">
                            <thead>
                              
                            </thead>
                            <tbody>

															<tr>
																<td>
																	<div class="form-group">
																		<label for="exampleInputEmail1">First Login On</label>
																		</br>
																		{{ $flogin }}
																	</div>
																</td>
															</tr>
																
                                <tr>
                                  <td>                                 
																		<div class="form-group">
																			<label for="exampleInputEmail1">Last Password Changed On</label>
																			</br>
																			{{ $last_pw_change }}
																		</div>
                                  </td>
																</tr>
                                <tr>
                                  <td>
                  								    <div class="form-group">
																				<label for="exampleInputEmail1">Current Password</label>
																				<input type="text" class="form-control" 
																				name="current_password" id="current_password" 
																				placeholder="Current Password">
																			</div>
																				@if($errors->has('end_date'))
																					<p class="text-danger">
																					{{ $errors->first('end_date') }}
																					</p>
																				@endif
                                  </td>
																</tr>																																

                                <tr>
                                  <td>
                                  
																	    <div class="form-group">
																				<label for="exampleInputEmail1">New Password</label>
																				<input type="text" class="form-control" 
																				name="password" id="password" placeholder="New Password">
																			</div>
																				@if($errors->has('password'))
																					<p class="text-danger">
																					{{ $errors->first('password') }}
																					</p>
																				@endif
                                  </td>
																</tr>
																
																<tr>
                                  <td>
                                    <div class="form-group">
																				<label for="exampleInputEmail1">Confirm New Password</label>
																				<input type="text" class="form-control" 
																				name="conf_password" id="conf_password" placeholder="Confirm New Password">
																			</div>
																				@if($errors->has('conf_password'))
																					<p class="text-danger">
																					{{ $errors->first('conf_password') }}
																					</p>
																				@endif
                                  </td>
                                </tr>
                              
                            </tbody>
                          </table>                      
                          <td colspan="2" align="center">
                            <button class="btn btn-primary w-40 rounded" type="submit">Set New Password</button>
                          </td>
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