@extends('layouts.app')
@section('content')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Add Building</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Add Building</li>
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
								  New Building
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
									<div class="card card-primary">
                    <!--
										<div class="card-header">
											<h3 class="card-title">All Inputs Mandatory</h3>
										</div>
                    -->
										<!-- /.card-header -->

										<div class="card-body">
											<form method="POST" action="{{ route('building.store') }}">
												@csrf

                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Building Name*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="bldg_name" id="bldg_name" value="{{ old('bldg_name') }}" placeholder="Building Name">
                            @if($errors->has('leave_reason'))
                              <p class="help-block text-danger">
                                {{ $errors->first('leave_reason') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Notes*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="bldg_name" id="bldg_name" value="{{ old('bldg_name') }}" placeholder="Building Name">
                            @if($errors->has('leave_reason'))
                              <p class="help-block text-danger">
                                {{ $errors->first('leave_reason') }}
                              </p>
                            @endif
                          </div>
  


												<div class="card-footer">
													<button type="submit" class="btn btn-primary">Submit</button>
												</div>

											</form>
										</div>


									  <!-- /.card-body -->
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

