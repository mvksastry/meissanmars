<div>
    {{-- In work, do what you enjoy. --}}
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: IAEC Usage</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">IAEC Usage</li>
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
					@include('livewire.occupancy.flexMenuOccupancy')
				@endhasrole

        <div class="row">
          <section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Issue ID to be fulfilled
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

  
                      <table id="userIndex2" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Issue ID</th>
                            <th>No. Mice to Be </br> Transferred </th>
                            <th>Species ID </th>  
														<th>Strain ID </th> 														
                          </tr>
                        </thead>
              						<tbody>
													@foreach($forTransfInfo as $row)
														<tr>
															<td>
															{{ $row->issue_id }}
															</td>
															<td>
															{{ $row->number_moved }}
															</td>
															<td>
															{{ $row->species_id }}
															</td>
															<td>
															{{ $row->strain_id }}
															</td>					
															<td>
																<button wire:click="miceForTransferById({{ $row->b2p_id }})" class="btn btn-primary rounded">Details</button>	
															</td>														
														</tr>
													@endforeach
                        </tbody>
                        </table>
                               		
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


				@if($sourceDestPanel)
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Destination Cages to be populated
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
									<!-- Morris chart - Sales xxz-->
										<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
											
												<table id="userIndex2" class="table table-bordered table-hover">
													<thead>
														<tr>
															<th>ID</th>
															<th> Cage ID </th>
															<th> Rack ID </th>
															<th> Slot ID </th>
															<th> Mice ID</th>
														</tr>
													</thead>
														<tbody>
														<?php
																foreach($cage_dest as $row)
																{ 
																	$rowx = json_decode($row, true); 
																	$mice_ids = $rowx['mice_ids'];
														?>
																		<tr>
																			<td>
																			</td>
																			<td>
																				{{ $rowx['cage_id'] }}
																			</td>
																			<td>
																				{{ $rowx['rack_id']; }}
																			</td>
																			<td>
																				{{ $rowx['slot_id'] }}
																			</td>
																			<td>
																				
																				{{ $mice_ids }}
																				
																				</br>
																			</td>
																			
																		</tr>
																		<?php 
																	
																	
															
																}
															?>
												
													</tbody>
													</table>
											 
													<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
														<thead class="bg-gray-900">
															<tr class="text-white text-left">
																<th class="font-semibold text-sm uppercase px-6 py-4"> No Data Found </th>
															</tr>
														</thead>
														<tbody>                          
														</tbody>
													</table>
												
										</div>
									</div>
								</div><!-- /.card-body -->
							</div>
							<!-- /.card -->
							<!-- /.card -->
						</section>
					</div>
					
					
					<div class="row">
						<section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Result
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

		
												<table id="userIndex2" class="table table-bordered table-hover">
													<thead>
														<tr>
															<th>Mice ID</th>
															<th>Breeding Cage ID </th>
															<th> Rack ID </th>
															<th> Slot ID </th>
															
														</tr>
													</thead>
														<tbody>
														<?php
																foreach($cage_source as $row)
																{ 
																	$rowx = json_decode($row, true); 
																		//dd($rowx);
																		foreach($rowx as $key => $val)
																		{
														?>
																			<tr>
																				<td>
																				{{ $key }}
																				</td>
																				
																				<td>
																				{{ $val['bcage_id'] }}
																				</td>
																				<td>
																					{{ $val['brack_id'] }}
																				</td>
																				<td>
																					{{ $val['bslot_id'] }}
																				</td>																		
																			</tr>
														<?php 
																		}
																}
														?>
												
													</tbody>
													</table>
																		
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
				@endif
				
			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
	</div>

    
</div>
