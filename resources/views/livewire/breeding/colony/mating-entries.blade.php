<div>
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
						<h1 class="m-0">Colony: Mating DB</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Colony</a></li>
							<li class="breadcrumb-item active">Mating DB</li>
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
										Mating DB Entries
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
															<th>Mouse Key</th>
															<th>IDs</th>
															<th>Parent ID</th>
															<th>IFM Date</th>
															<th>Ref ID</th>
															<th>Wean Note</th>
															<th>Comment</th>
														</tr>
													</thead>
													<tbody>
														@if(count($matingEntries) > 0 )
															@foreach($matingEntries as $row)
																<tr>
																	<td>{{ $row->_mating_key }}</td>
																	<td>F:{{ $row->_dam1_key }}; M: {{ $row->_sire_key }}</td>
																	<td>{{ $row->parentID }}</td>
																	<td>{{ date('d-m-Y', strtotime($row->matingDate)) }}</td>
																	<td>{{ $row->matingRefID }}</td>
																	<td>{{ $row->weanNote }}</td>
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
