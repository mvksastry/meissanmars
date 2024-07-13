@extends('layouts.app')
@section('content')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Add Room</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Add Room</li>
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
								  New Room
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
                    
											<form method="POST" action="{{ route('room.store') }}" enctype="multipart/form-data">>
												@csrf

                          <div class="form-group col">
                            <label for="exampleInputBorderWidth2">Building*</label>
                            <select class="custom-select form-control rounded-1" 
                              name="building_id" id="building_id">
                              @foreach($buildings as $row)
                                <option value="{{ $row->building_id }}">{{ $row->building_name }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('building_id'))
                              <p class="help-block text-danger">
                                {{ $errors->first('building_id') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="form-group col">
                            <label for="exampleInputBorderWidth2">Floor*</label>
                            <select class="custom-select form-control rounded-1" 
                              name="floor_id" id="floor_id">
                              @foreach($floors as $row)
                                <option value="{{ $row->floor_id }}">{{ $row->floor_name }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('floor_id'))
                              <p class="help-block text-danger">
                                {{ $errors->first('floor_id') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Room Name*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="room" id="room" value="{{ old('room') }}" placeholder="Room Name">
                            @if($errors->has('room'))
                              <p class="help-block text-danger">
                                {{ $errors->first('room') }}
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
  
                          <div class="form-group">
                            <label for="exampleInputFile">Room Image*</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imageFile" id="imageFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                @if($errors->has('imageFile'))
                                  <p class="help-block text-danger">
                                    {{ $errors->first('imageFile') }}
                                  </p>
                                @endif
                              </div>
                              
                            </div>
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

