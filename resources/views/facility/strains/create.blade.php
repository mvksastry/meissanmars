@extends('layouts.app')
@section('content')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Add Strain</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Add Strain</li>
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
								  New Strain
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
											<form method="POST" action="{{ route('strains.store') }}">
												@csrf
                          <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Species*</label>
                              <select class="custom-select form-control rounded-1" 
                                name="species_id" id="species_id">
                                @foreach($species as $row)
                                  <option value="{{ $row->species_id }}">{{ $row->species_name }}</option>
                                @endforeach
                              </select>
                              @if($errors->has('species_id'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('species_id') }}
                                </p>
                              @endif
                          </div>
                          
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Strain Name*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="strain_name" id="strain_name" value="{{ old('strain_name') }}" placeholder="Strain Name">
                            @if($errors->has('strain_name'))
                              <p class="help-block text-danger">
                                {{ $errors->first('strain_name') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Notes*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="notes" id="notes" value="{{ old('notes') }}" placeholder="Notes">
                            @if($errors->has('notes'))
                              <p class="help-block text-danger">
                                {{ $errors->first('notes') }}
                              </p>
                            @endif
                          </div>
  
                          <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Distributable*</label>
                              <select class="custom-select form-control rounded-1" 
                                name="dist" id="dist">
                                <option value="0">Select</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                              </select>
                              @if($errors->has('dist'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('dist') }}
                                </p>
                              @endif
                          </div>

                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Per-Diem-Cost*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="perDiemCost" id="perDiemCost" value="{{ old('perDiemCost') }}" placeholder="Per-diem-cost">
                            @if($errors->has('perDiemCost'))
                              <p class="help-block text-danger">
                                {{ $errors->first('perDiemCost') }}
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

