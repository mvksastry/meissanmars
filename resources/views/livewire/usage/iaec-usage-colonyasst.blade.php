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
												<?php $b2p_id = $row->b2p_id ?>
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
															<button wire:click="miceForTransferById({{ $b2p_id }})" class="btn btn-primary rounded">Details</button>	
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
													<th> Move From </th>
													<th> MoveTo </th>
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
																	
																	foreach($cage_dest as $krow)
																	{
																		$krowx = json_decode($krow, true); 
																		$mice_ids = json_decode($krowx['mice_ids']);
																		if(in_array($key, $mice_ids))
																		{
																			$toCage_id = $krowx['cage_id'];
																			$toRack_id = $krowx['rack_id'];
																			$toSlot_id = $krowx['slot_id'];
																		}
																	}
												?>
																	<tr>
																		<td>
																		{{ $key }}
																		</td>
																		<td>
																			BCage: {{ $val['bcage_id'] }}
																			BRack: {{ $val['brack_id'] }}
																			BSlot: {{ $val['bslot_id'] }}
																		</td>								
																		<td>
																			Cage: {{ $toCage_id }}; Rack: {{ $toRack_id }}; Slot: {{ $toSlot_id }}
																	</tr>
												<?php 
																}
														}
												?>
											</tbody>
										</table>
										<input type="checkbox" wire:model="job_done" name="slot[]" value="1" />
										<label class="form-check-label text-success font-weight-bold" for="defaultCheck2">
											Job Done
										</label>
										</br>
										@if($job_msg != null)
										{{ $job_msg }}
										@else 
											
										@endif
										</br>					
										</br>
										<button wire:click="miceTransferUpdate({{ $b2p_id }})" class="btn btn-primary rounded">Update</button>	
														
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
