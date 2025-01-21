<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Colony: Litter DB</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Colony</a></li>
							<li class="breadcrumb-item active">Litter DB</li>
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
										Litter DB Entries
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
															<th>Litter Key</th>
															<th>Birth Date</th>
															<th>Ref ID</th>
															<th>Parent ID</th>
															<th>Total; F; M; SB; CW; MW</th>
															<th>Weaned On</th>
															<th>Status</th>
															<th>Status Date</th>
															<th>Comment</th>
														</tr>
													</thead>
													<tbody>
														@if(count($litterEntries) > 0 )
															@foreach($litterEntries as $row)
																<tr>
																	<td>{{ $row->_litter_key }}</td>
																	<td>{{ date('d-m-Y', strtotime($row->birthDate)) }}</td>
																	<td>A{{ $row->mating->matingRefID }}</td>
																	<td>{{ $row->mating->parentID }}</td>
																	<td>T:{{ $row->totalBorn }}; 
																			F: {{ $row->numFemale }}; 
																			M: {{ $row->numMale }};
																			SB:{{ $row->numberBornDead }};
																			CW:{{ $row->numberCulledAtWean }};
																			MW:{{ $row->numberMissingAtWean }}
																	</td>
																	<td>{{ date('d-m-Y', strtotime($row->weanDate)) }}</td>
																	
																	
																	<td>{{ ucfirst($row->entry_status) }}</td>
																	<td>{{ $row->entry_status_date }}</td>
																	<td>{{ $row->comment }}</td>
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
