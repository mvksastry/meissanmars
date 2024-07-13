@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Rooms & Racks</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Rooms & Racks</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
        @hasrole('manager')
					@include('facility.roomsnracks.flexMenuRoomsnRacks')
				@endhasrole
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Buildings
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

									@if( count($buildings) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          <input type="checkbox" id="select-all" />
                          </th>
													<th>ID</th>
                          <th>Name</th>
													<th>Notes</th>
												</tr>
											</thead>
											<tbody>
                        @foreach($buildings as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                          <th></th>
                            <td>{{ $row->building_id }}</td>
                            <td>{{ $row->building_name }}</td>
                            <td>{{ $row->notes }}</td>                           
                          </tr>
												@endforeach					
											</tbody>
										</table>                      
                  @else
										No Information to display
                  @endif
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
							  Floors
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

									@if( count($floors) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          <input type="checkbox" id="select-all" />
                          </th>
													<th>ID</th>
                          <th>Building</th>
													<th>Name</th>
													<th>Notes</th>
												</tr>
											</thead>
											<tbody>
                        @foreach($floors as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                            <td></td>
                            <td>{{ $row->floor_id }}</td>
                            <td>{{ $row->building->building_name }}</td>
                            <td>{{ $row->floor_name }}</td>
                            <td>{{ $row->notes }}</td>
                          </tr>
                        @endforeach
											</tbody>
										</table>                      
                  @else
										No Information to display
                  @endif
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
							  Rooms
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

									@if( count($rooms) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          <input type="checkbox" id="select-all" />
                          </th>
													<th>ID</th>
                          <th>Building</th>
                          <th>Floor</th>
													<th>Name</th>
													<th>Notes</th>
												</tr>
											</thead>
											<tbody>
                        @foreach($rooms as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                            <td></td>
                            <td>{{ $row->room_id }}</td>
                            <td>{{ $row->building->building_name }}</td>
                            <td>{{ $row->floor->floor_name }}</td>
                            <td>{{ $row->room_name }}</td>
                            <td>{{ $row->notes }}</td>
                          </tr>
                        @endforeach  
											</tbody>
										</table>                      
                  @else
										No Information to display
                  @endif
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
							  Racks
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

									@if( count($rackInfo) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          
                          Rack Name</th>
													<th>Location</th>
                          <th>Rows</th>
													<th>Cols</th>
													<th>Levels</th>
													<th>Capacity</th>
                          <th>Occupied</th>
                          <th>Vacant</th>
												</tr>
											</thead>
											<tbody>
                        @foreach($rackInfo as $rack)                        
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                            <td class="">{{ $rack->rack_name }}</td>
                            <td class="">{{ $rack->room->room_name }}</td>
                            <td class="">{{ $rack->rows }}</td>
                            <td class="">{{ $rack->cols }}</td>
                            <td class="">{{ $rack->levels }}</td>
                            <td class="">{{ $rack->rows*$rack->cols*$rack->levels }}</td>
                            
                            @if($rack->occupied == 0 && $rack->vacant == 0)
                            <td colspan="2"> Slots Not created </td>
                            @else 
                            <td class="">{{ $rack->occupied }}</td>
                            <td class="">{{ $rack->vacant }}</td>
                            @endif
                          </tr>
                        @endforeach 
											</tbody>
										</table>                      
									
                  @else
										No Information to display
                  @endif

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