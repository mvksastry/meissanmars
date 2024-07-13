@extends('layouts.app')
@section('content')
	<?php 
		$bg_code = array("yellow" => "bg-warning", "blue" => "bg-primary", "green"=>"bg-success", "red"=> "bg-danger");
    $status_code = array("1"=> "Active", "0" => "Inactive");
	?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Kanban Cards</h1>
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
                  Cards
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

									@if (count($kanban_cards) > 0)
									<table id="example2" class="table table-bordered table-hover {{ count($kanban_cards) > 0 ? 'datatable' : '' }} dt-select">
										<thead>
											<tr>
												<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
												<th>Posted By</th>
												<th>Name</th>
												<th>Description</th>
												<th>Status</th>
												<th>Status Date</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($kanban_cards as $kcard)
                      <?php $bgcode = $bg_code[$kcard->color]; ?>
												<tr class="{{ $bgcode }}" data-entry-id="{{ $kcard->kbocard_id }}">
													<td></td>
													<td>{{ ucwords($kcard->posted_by) }}</td>
													<td>{{ ucfirst($kcard->item_name) }}</td>
													<td>{{ $kcard->item_desc }}</td>
													
													<td>{{ $status_code[$kcard->item_status] }}</td>
													<td>{{ date('d-m-Y', strtotime($kcard->status_date)) }}</td>
													<td>                           
														<a href="{{ route('kanban-cards.edit',$kcard->kbocard_id) }}" class="btn btn-xs btn-info">Edit</a>
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