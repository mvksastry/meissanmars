@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Infrastructure</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Infrastructure</li>
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
					@include('facility.infrastructure.flexMenuInfras')
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
							  Infrastructure
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

                  @if(count($infras) > 0)

									
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          Name/</br> Nick Name
                          </th>
													<th>Make / Model</th>
                          <th>Vendor</th>
													<th>AMC</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											@foreach($infras as $row)	
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                            <td>{{  $row->name }}/ </br> {{ $row->nickName }}</td>
                            <td>{{  $row->make }}/ </br> {{ $row->model }}</td>
                            <td>{{  $row->vendor_address }}/ </br> {{ $row->vendor_phone }}/ </br> {{ $row->vendor_email }}</td>
                            <td>{{  $row->amc }}/ </br> {{ $row->amc_start }}/ </br> {{ $row->amc_end }}</td>
                            <td>{{  $row->status }}</td>
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