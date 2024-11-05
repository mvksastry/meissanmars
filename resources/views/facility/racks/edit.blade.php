<style>
 .checkbox-grid {
  display: flex;
  flex-wrap: wrap;
  list-style-type: none;
}

.checkbox-grid li {
  flex: 0 0 12%;
}
</style>
@extends('layouts.app')
@section('content')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Edit Rack</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Edit Rack</li>
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
								  Edit Rack : {{ $msg }}
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

											<form method="POST" action="{{ route('rack.update', $rack->rack_id) }}">
                        @method('PUT')
												@csrf
                        <input type="text" hidden class="form-control form-control-border" 
                            name="purpose" id="purpose" value="edit" placeholder="Edit">
                            
                          <div class="form-group col">
                            <label for="exampleInputBorderWidth2">Room Name*</label>
                            <select class="custom-select form-control rounded-1" 
                              name="room_id" id="room_id">
                              @foreach($rooms as $row)
                                <option value="{{ $row->room_id }}"
                                @if($rack->room_id == $row->room_id)
                                  selected="selected"
                                @endif
                                >{{ $row->room_name }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('room_id'))
                              <p class="help-block text-danger">
                                {{ $errors->first('room_id') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Rack Name*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="rack_name" id="rack_name" value="{{ $rack->rack_name }}" placeholder="Rack Name">
                            @if($errors->has('rack_name'))
                              <p class="help-block text-danger">
                                {{ $errors->first('rack_name') }}
                              </p>
                            @endif
                          </div>

                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Rows*</label>
                            <input type="text" class="form-control form-control-border"
														@if($edit) readonly @endif
                            name="rows" id="rows" value="{{ $rack->rows }}" placeholder="Rows">
                            @if($errors->has('rows'))
                              <p class="help-block text-danger">
                                {{ $errors->first('rows') }}
                              </p>
                            @endif
                          </div>
 
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Columns*</label>
                            <input type="text" class="form-control form-control-border" 
														@if($edit) readonly @endif
                            name="cols" id="cols" value="{{ $rack->cols }}" placeholder="Columns">
                            @if($errors->has('cols'))
                              <p class="help-block text-danger">
                                {{ $errors->first('cols') }}
                              </p>
                            @endif
                          </div> 

                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Shelfs*</label>
                            <input type="text" class="form-control form-control-border" 
														@if($edit) readonly @endif
                            name="levels" id="levels" value="{{ $rack->levels }}" placeholder="Shelfs">
														@if($errors->has('levels'))
                              <p class="help-block text-danger">
                                {{ $errors->first('levels') }}
                              </p>
                            @endif
                          </div>
                          
                          <div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">Notes*</label>
                            <input type="text" class="form-control form-control-border" 
                            name="notes" id="notes" value="{{ $rack->notes }}" placeholder="Notes">
                            @if($errors->has('notes'))
                              <p class="help-block text-danger">
                                {{ $errors->first('notes') }}
                              </p>
                            @endif
                          </div>
													<?php
														$total = $rack->rows*$rack->cols*$rack->levels;
													?>
													
													<div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">
															Key: <p class="text-warning font-weight-bold">Active Cages</p>
															<p class="text-success font-weight-bold">Available Slots</p>
															<p class="text-danger font-weight-bold">Blocked/Reserved Slots</p>
														</label>
													</div>
													<div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">
															Slot Status: Check Green box for disabling
														</label>
														<ul class="checkbox-grid">														
															@foreach($rStat as $row)
																@if($row->status == "O" || $row->status == "R")
																	<li>
																		<input disabled type="checkbox" name="slot[]" 
																		value="{{ $row->slot_id }}" />
																		<label 
																		@if($row->status == "O")
																		class="form-check-label text-warning font-weight-bold" for="defaultCheck2">
																		@else
																		class="form-check-label text-danger font-weight-light" for="defaultCheck2">
																		@endif
																		ID {{ $row->slot_id }}
																		</label>
																	</li> 
																@else
																	<li>
																		<input type="checkbox" name="slot[]" 
																		value="{{ $row->slot_id }}" />
																		<label class="form-check-label text-success font-weight-bold" for="defaultCheck2">
																			ID {{ $row->slot_id }}
																		</label>
																	</li>
																@endif
															@endforeach
														</ul>
													</div>
													
													<div class="col-xs-12 form-group">
                            <label for="exampleInputBorderWidth2">
															Edit Slots: Check box for Re-Enabling
														</label>
														<ul class="checkbox-grid">														
															@foreach($rStat as $row)
																@if($row->status == "R")																		
																	<li>
																		<input type="checkbox" name="slotR[]" 
																		value="{{ $row->slot_id }}" />
																		<label class="form-check-label text-danger font-weight-bold" for="defaultCheck2">
																			ID {{ $row->slot_id }}
																		</label>
																	</li>
																@endif
															@endforeach
														</ul>
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

