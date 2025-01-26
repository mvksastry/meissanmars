<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Colony: Mortalities</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Colony</a></li>
							<li class="breadcrumb-item active">Mortalities</li>
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
						@include('livewire.breeding.colony.flexMenuColonyReview')
					@endhasrole
					<!-- Main row -->
					<div class="row">
						<section class="col-lg-12 connectedSortable">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-chart-pie mr-1"></i>
										Mouse DB Entries
									</h3>
									<div class="card-tools">
										<ul class="nav nav-pills ml-auto">
											<li class="nav-item"></li>
											<li class="nav-item"></li>
										</ul>
									</div>
								</div><!-- /.card-header -->
							
			
						
									<!-- Left col -->
									<!-- Custom tabs (Charts with tabs)-->
									<div class="card-body">
										<div class="tab-content p-0">
											<!-- Morris chart - Sales -->
											<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
												<table id="example1" class="table table-bordered table-striped">
													<thead>
														<tr>
															<th>Species</th>
															<th>Strain</th>
															
															<th>Project ID</th>
															<th>PI ID</th>
															
															<th>Number Dead</th>
															<th>Colony Info</th>
															<th>Strain Incharge</th>
															<th>Cage Id</th>
															<th>CoD/ Notes</th>
															<th>Posted By</th>
															<th>Date Posted</th>
														</tr>
													</thead>
													<tbody>
														@if(count($mortalities) > 0 )
															@foreach($mortalities as $row)
																<tr>
																	<td>{{ $row->species->species_name }}</td>
																	<td>{{ $row->strain->strain_name }}</td>
																	
																	<td>{{ $row->project_id }}</td>
																	<td>{{ $row->pi_id }}</td>
																	
																	<td>{{ $row->number_dead }}</td>
																	<td>{{ $row->colony_info }}</td>
																	<td>
																		@if($row->incharge != null)
																		{{ $row->incharge->name }}
																		@endif
																	</td>
																	<td>{{ $row->cage_id }}</td>
																	
																	<td>{{ $row->cod }}: {{ $row->notes }}</td>
																	
																	
																	<td>
																		@if($row->postedby != null)
																			{{ $row->postedby->name }}
																		@endif
																	</td>
																	<td>{{ date('d-m-Y', strtotime($row->date_posted)) }}</td>
																</tr>
															@endforeach
														@endif
													</tbody>
													<tfoot>
													</tfoot>
												</table>
											</div>
										</div>
									</div><!-- /.card-body -->
								
							</div>
						</section>
					</div>
			</div>
		</section>


		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
  </div>
</div>

