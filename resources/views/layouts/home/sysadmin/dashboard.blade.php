@extends('layouts.app')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Admin Dashboard</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
			
				@hasrole('admin')
					@include('layouts.home.sysadmin.flexMenuSysadmin')
				@endhasrole
								
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-7 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Admin Dashboard
							</h3>
						  </div><!-- /.card-header -->
						  <div class="card-body">
							<div class="tab-content p-0">
							  <!-- Morris chart - Sales -->
							  <div class="chart tab-pane active" id="revenue-chart"
								   style="position: relative; height: 300px;">
								  <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
							   </div>
							  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
								<canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
							  </div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->

						<!-- DIRECT CHAT -->
						<!--/.direct-chat -->

						<!-- TO DO List -->
						
						<!-- /.card -->
					</section>
					<!-- /.Left col -->
					
					
					<!-- right col (We are only adding the ID to make the widgets sortable)-->
					<section class="col-lg-5 connectedSortable">
						<!-- Map card -->
						
						<!-- /.card -->

						<!-- solid sales graph -->
						
						<!-- /.card -->

						<!-- Calendar -->
						<div class="card bg-gradient-success">
						  <div class="card-header border-0">

							<h3 class="card-title">
							  <i class="far fa-calendar-alt"></i>
							  Calendar
							</h3>
							<!-- tools card -->
							<div class="card-tools">
							  <!-- button with a dropdown -->
							  <div class="btn-group">
								<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
								  <i class="fas fa-bars"></i>
								</button>
								<div class="dropdown-menu" role="menu">
								  <a href="#" class="dropdown-item">Add new event</a>
								  <a href="#" class="dropdown-item">Clear events</a>
								  <div class="dropdown-divider"></div>
								  <a href="#" class="dropdown-item">View calendar</a>
								</div>
							  </div>
							  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							  </button>
							  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
								<i class="fas fa-times"></i>
							  </button>
							</div>
							<!-- /. tools -->
						  </div>
						  <!-- /.card-header -->
						  <div class="card-body pt-0">
							<!--The calendar -->
							<div id="calendar" style="width: 100%"></div>
						  </div>
						  <!-- /.card-body -->
						</div>
						<!-- /.card -->
					</section>
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
	</div>
@endsection('content')





