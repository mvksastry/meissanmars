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
							<li class="breadcrumb-item"><a href="/cage-register">Cage</a></li>
							<li class="breadcrumb-item active">Register</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>		
		<!-- /.content-header -->
    <?php 
      $roomPath = "storage/facility/rooms/";
      $rackPath = "storage/facility/racks";
    ?>
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
        @hasrole('manager')
					@include('livewire.breeding.colony.flexMenuColonyReview')
				@endhasrole
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Rooms
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
                  @if( count($rooms) > 0 )
                   <div class="p-2">
                    @foreach($rooms as $room)
                    
                      <button wire:click="show('{{ $room->image_id }}')">
                      <img class="inline m-1 border border-primary" src="{{ asset($roomPath.$room->image_id) }}" alt="" width="75px" height="75px">
                      </button>
                      
                    @endforeach
                    </div>
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
          
          <section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Racks in Room: {{ $room_name }}
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

									@if($rackUpdate)
                    @include('livewire.occupancy.rackInfos')
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


		@if($defaultPanel)
		<section class="content">
			<div class="container-fluid">
					<!-- Main row -->
					<div class="row">
						<section class="col-lg-12 connectedSortable">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-chart-pie mr-1"></i>
										Cage Entries
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
															<th>Cage ID</th>
															<th>Project ID</th>
															<th>Issue ID</th>
															<th>Request By</th>
															<th>Species</th>
															<th>Strain</th>
															<th>Start Date</th>
															<th>End Date</th>
															<th>Ack Date</th>
															<th>Status</th>
															<th>Type</th>
															<th>Label</th>
															<th>Notes</th>
														</tr>
													</thead>
													<tbody>
														@if(count($cageEntries1) > 0 )
															@foreach($cageEntries1 as $row)
																<tr>
																	<td>{{ $row->cage_id }}</td>
																	<td>{{ $row->project_id  }}</td>
																	<td>{{ $row->issue_id  }}</td>
																	@if($row->user != null)
																	<td>{{ $row->user->name }}</td>
																	@else 
																		<td>-</td>
																	@endif
																	
																	@if($row->species != null)
																	<td>{{ $row->species->species_name }}</td>
																	@endif
																	@if($row->strain != null)
																	<td>{{ $row->strain->strain_name  }}</td>
																	@endif
																	<td>{{ $row->start_date  }}</td>
																	<td>{{ $row->end_date  }}</td>
																	<td>{{ $row->ack_date  }}</td>
																	<td>{{ $row->cage_status  }}</td>
																	<td>{{ $row->cage_type }}</td>
																	<td>{{ $row->cage_label }}</td>
																	<td>{{ $row->notes  }}</td>
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
		@endif

		@if($cagesPanel)
		<section class="content">
			<div class="container-fluid">
					<!-- Main row -->
					<div class="row">
						<section class="col-lg-12 connectedSortable">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										<i class="fas fa-chart-pie mr-1"></i>
										Cage Details in Rack: {{ $rackName }}
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
												<table id="example3" class="table table-bordered table-striped">
													<thead>
														<tr>
															<th>Cage ID</th>
															<th>Slot ID</th>
															<th>Project ID</th>
															<th>Issue ID</th>
															<th>Request By</th>
															<th>Species</th>
															<th>Strain</th>
															<th>Start Date</th>
															<th>End Date</th>
															<th>Ack Date</th>
															<th>Status</th>
															<th>Type</th>
															<th>Label</th>
															<th>Notes</th>
														</tr>
													</thead>
													<tbody>
														@if(count($cageEntries2) > 0 )
															@foreach($cageEntries2 as $row)
																<tr>
																	<td>{{ $row->cages->cage_id }}</td>
																	<td>{{ $row->slot_id }}</td>
																	<td>{{ $row->cages->project_id  }}</td>
																	<td>{{ $row->cages->issue_id  }}</td>
																	@if($row->cages->user != null)
																	<td>{{ $row->cages->user->name }}</td>
																	@else 
																		<td>-</td>
																	@endif
																	
																	@if($row->cages->species != null)
																	<td>{{ $row->cages->species->species_name }}</td>
																	@endif
																	
																	@if($row->cages->strain != null)
																	<td>{{ $row->cages->strain->strain_name  }}</td>
																	@endif
																	
																	<td>{{ $row->cages->start_date  }}</td>
																	<td>{{ $row->cages->end_date  }}</td>
																	<td>{{ $row->cages->ack_date  }}</td>
																	<td>{{ $row->cages->cage_status  }}</td>
																	<td>{{ $row->cages->cage_type }}</td>
																	<td>{{ $row->cages->cage_label }}</td>
																	<td>{{ $row->cages->notes  }}</td>
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
			@script
				<script>
					$(document).ready(function() {
						alert("started:");
							$('#example3').DataTable({
									"responsive": true, "lengthChange": false, "autoWidth": false,
									"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
								}).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
					});
				</script>
			@endscript		
		@endif
		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
  </div>
</div>