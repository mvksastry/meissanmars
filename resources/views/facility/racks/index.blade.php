@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Racks</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Racks</li>
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
					@include('facility.racks.flexMenuRacks')
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
                          <th>Action</th>
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
                            <td class="">
                              <a href="{{ route('rack.edit',[$rack->rack_id]) }}">
                                <button class="btn btn-sm btn-info">
                                  Edit
                                </button>
                              </a>
                            </td>                            
                            @else 
                            <td class="">{{ $rack->occupied }}</td>
                            <td class="">{{ $rack->vacant }}</td>
                            <td class="">
                              <a href="{{ route('rack.edit',[$rack->rack_id]) }}">
                                <button class="btn btn-sm btn-info">
                                  Edit
                                </button>
                              </a>
                            </td>
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