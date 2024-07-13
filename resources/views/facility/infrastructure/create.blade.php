@extends('layouts.app')
@section('content')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Add Infrastructure</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Add Infra Item</li>
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
								  Create Infra Item
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
                    
											<form method="POST" action="{{ route('infrastructure.store') }}">
												@csrf
                        <div class="row">
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Name*</label>
                            <input class="form-control form-control-border" name="name" type="text" placeholder="Name" value="{{ old('name') }}">
                            @if($errors->has('name'))
                              <p class="help-block text-danger">
                                {{ $errors->first('name') }}
                              </p>
                            @endif
                          </div>
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Nick Name*</label>
                            <input class="form-control form-control-border" name="nickname" type="text" value="{{ old('nickname') }}" placeholder="Nick Name">
                            @if($errors->has('name'))
                              <p class="help-block text-danger">
                                {{ $errors->first('name') }}
                              </p>
                            @endif
                          </div>
                        </div>
                        
                        <div class="row">  
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Description*</label>
                            <input type="text" class="form-control form-control-border"
                            name="desc" type="text" value="{{ old('desc') }}" placeholder="Description"                            
                            value="{{ old('desc') }}">
                            @if($errors->has('desc'))
                              <p class="help-block text-danger">
                                {{ $errors->first('desc') }}
                              </p>
                            @endif
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Date Acquired</label>
                            <input class="form-control form-control-border" name="dateacqrd" type="date" value="{{ old('dateacqrd') }}" placeholder="Date Acquired">
                            @if($errors->has('dateacqrd'))
                              <p class="help-block text-danger">
                                {{ $errors->first('dateacqrd') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Make</label>
                            <input class="form-control form-control-border" name="make" type="text" value="{{ old('make') }}" placeholder="Make">
                            @if($errors->has('make'))
                              <p class="help-block text-danger">
                                {{ $errors->first('make') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Model</label>
                            <input class="form-control form-control-border" name="model" type="text" value="{{ old('model') }}" placeholder="Model">
                            @if($errors->has('model'))
                              <p class="help-block text-danger">
                                {{ $errors->first('model') }}
                              </p>
                            @endif
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Vendor & Address*</label>
                            <input class="form-control form-control-border" 
                            name="vendor" id="vendor" type="text" 
                            value="{{ old('vendor') }}" placeholder="Vendor & Address">
                            @if($errors->has('vendor'))
                              <p class="help-block text-danger">
                                {{ $errors->first('vendor') }}
                              </p>
                            @endif
                          </div> 
                        </div>
                        
                        <div class="row">
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Vendor Phone*</label>
                            <input class="form-control form-control-border" name="phone" type="text" value="{{ old('phone') }}" placeholder="Phone">
                            @if($errors->has('phone'))
                              <p class="help-block text-danger">
                                {{ $errors->first('phone') }}
                              </p>
                            @endif
                          </div>
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Vendor Email*</label>
                            <input class="form-control form-control-border" name="email" type="email" value="{{ old('email') }}" placeholder="Email">
                            @if($errors->has('email'))
                              <p class="help-block text-danger">
                                {{ $errors->first('email') }}
                              </p>
                            @endif                            
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Location Building*</label>
                            <input class="form-control form-control-border" name="building" value="{{ old('building') }}" type="text" placeholder="Building">
                            @if($errors->has('building'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('building') }}
                                </p>
                            @endif
                          </div>
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Floor*</label>
                            <input class="form-control form-control-border" name="floor" type="text" value="{{ old('floor') }}" placeholder="Floor">
                            @if($errors->has('floor'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('floor') }}
                                </p>
                            @endif
                          </div>
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">Room*</label>
                            <input class="form-control form-control-border" name="room" type="text" value="{{ old('room') }}" placeholder="Room">
                            @if($errors->has('room'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('room') }}
                                </p>
                            @endif
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">AMC*</label>
                            <input class="form-control form-control-border" name="amc" type="text" value="{{ old('amc') }}" placeholder="AMC">
                            @if($errors->has('amc'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('amc') }}
                                </p>
                            @endif
                          </div>
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">AMC Strat*</label>
                            <input class="form-control form-control-border" name="amcstart" type="date" value="{{ old('amcstart') }}" placeholder="AMC Start">
                            @if($errors->has('amcstart'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('amcstart') }}
                                </p>
                            @endif
                          </div>
                          <div class="col-sm form-group">
                            <label for="exampleInputBorderWidth2">AMC End*</label>
                            <input class="form-control form-control-border" name="amcend" type="date" value="{{ old('amcend') }}" placeholder="AMC End">
                            @if($errors->has('amcend'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('amcend') }}
                                </p>
                            @endif
                          </div>
                        </div>
                        
                        <div class="col-xs-12 form-group">
                          <label for="exampleInputBorderWidth2">Supervisor*</label>
                          <input class="form-control form-control-border" 
                          name="supervisor" type="text" value="{{ old('supervisor') }}" placeholder="Supervisor">                            
                          @if($errors->has('supervisor'))
                              <p class="help-block text-danger">
                                {{ $errors->first('supervisor') }}
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

