@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Usages</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Usages</li>
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
                  Pending
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

									@if( count($issueRequests) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          ID
                          </th>
													<th>PI</th>
                          <th>Title</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach($issueRequests as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="{{ $row->usage_id }}">
                            <td style="text-align:center;">{{ $row->usage_id }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->project->title }}</td>
                            <td>{{ ucfirst($row->issue_status) }}</td>
                            <td>
                              <a href="{{ route('usageapprovals.show',[$row->usage_id]) }}">
                                <button class="btn btn-xs bg-blue-600 hover:bg-gray-200 text-xs text-gray-200 btn-info">
                                  Decision
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
							  Approved
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

									@if( count($irAwaiting) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          ID
                          </th>
													<th>PI</th>
                          <th>Title</th>
													<th>Status</th>
													<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
												@foreach($irAwaiting as $row)
                          <tr bgcolor="#E1BEE7"   data-entry-id="{{ $row->iaecproject_id }}">
                            <td style="text-align:center;">{{ $row->iaecproject_id }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->project->title }}</td>
                            <td>{{ ucfirst($row->issue_status) }}</td>
                            <td>
                              <a href="{{ url('comp-allot') }}">
                                <button class="btn btn-xs bg-blue-600 hover:bg-gray-200 text-xs text-gray-200 btn-info">
                                  Awaiting Issue
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