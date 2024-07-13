@extends('layouts.app')
@section('content')
	<?php 
		$eventchoice = array("1" => "Assessment - 1st year", "2" => "Assessment - 2nd year", "3"=>"Assessment - 3rd year", "4"=>"Assessment - 4th year", 
		"5"=>"Assessment - 4th year", "6"=>"Colloquium", "7"=>"Work Presentation", 
		"8"=>"Synopsis Seminar", "9"=>"Ph.D. Viva");
		$eventchoiceSel = 1;
    
    $status = array("0" => "Inactive", "1"=> "Active");
	?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Kanban Boards</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Kanban Boards</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				@include('layouts.kanban.flexMenuKanban')
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
                  Boards
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

									@if (count($kanban_boards) > 0)
									<table id="example2" class="table table-bordered table-hover {{ count($kanban_boards) > 0 ? 'datatable' : '' }} dt-select">
										<thead>
											<tr>
												<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
												<th>Posted By</th>
												<th>Name</th>
												<th>Description</th>
												<th>Color</th>
												<th>Seq.Id</th>
												<th>Status Date</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($kanban_boards as $kboard)
												<tr data-entry-id="{{ $kboard->uuid }}">
													<td></td>
													<td>{{ ucwords($kboard->posted_by) }}</td>
													<td>{{ ucfirst($kboard->name) }}</td>
													<td>{{ $kboard->description }}</td>
													<td>{{ ucfirst($kboard->color) }}</td>
													<td>{{ $kboard->sequence_id }}</td>
													<td>{{ date('d-m-Y', strtotime($kboard->status_date)) }}</td>
													<td>
                            @hasexactroles('admin|director')
                              <a href="{{ route('kanban-boards.show',$kboard->uuid) }}" class="btn btn-xs btn-info">View All</a>
                              <a href="{{ route('kanban-boards.edit',$kboard->uuid) }}" class="btn btn-xs btn-info">Edit</a>														
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
	</div>
@endsection('content')