@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Projects</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Projects</li>
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
					@include('projects.manager.flexMenuAdminNewProjects')
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
							  Submitted
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
								<div class="table-responsive" id="revenue-chart" style="position: relative;">



									@if( count($subProjects) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
																							
													<th style="text-align:center;">ID</th>
													<th>PI</th>
													<th>Title</th>                       
                          <th>Start Date</th>
                          <th>End Date</th>
													<th>Actions</th>
                          
												</tr>
											</thead>
											<tbody>
												@foreach($subProjects as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="{{ $row->tempproject_id }}">
                            <td>{{ $row->tempproject_id }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->title }}</td>
                            <td>{{ date('d-m-Y', strtotime($row->start_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($row->end_date)) }}</td>
                            <td>
                            @hasexactroles('pient')
                              <a href="{{ route('projectsmanager.edit',[$row->tempproject_id]) }}">
                                <button class="btn btn-sm btn-warning">
                                  Edit
                                </button>
                              </a>
                            @endhasexactroles
                            @hasexactroles('manager')
                              <a href="{{ route('projectsmanager.submitted',[$row->tempproject_id]) }}">
                                <button class="btn btn-sm btn-info">
                                  Decision
                                </button>
                              </a>
                            @endhasexactroles
                            </td>
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
							  Active
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
								<div class="table-responsive" id="revenue-chart2" style="position: relative;">

									@if( count($activeProjects) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">ID</th>
													<th>PI</th>
													<th>Title</th>                       
                          <th>Start Date</th>
                          <th>End Date</th>
													<th>Details</th>
												</tr>
											</thead>
											<tbody>
												@foreach($activeProjects as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="{{ $row->tempproject_id }}">
                            <td>{{ $row->iaecproject_id }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->title }}</td>
                            <td>{{ date('d-m-Y', strtotime($row->start_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($row->end_date)) }}</td>
                            <td>
                              <a href="{{ route('projectsmanager.show',[$row->iaecproject_id]) }}">
                                <button class="btn btn-sm btn-info">
                                  View
                                </button>
                              </a>
                            </td>
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