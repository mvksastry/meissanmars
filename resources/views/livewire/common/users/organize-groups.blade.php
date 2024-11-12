<div>
    {{-- Do your work, then step back. --}}
		{{-- The whole world belongs to you. --}}
		{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
		{{-- Success is as dangerous as failure. --}}
  <!-- Never delete or modify this div -->
  <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Groups</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Groups</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
        @hasrole('pient')
					@include('livewire.common.users.organizeGroupFlexMenu')
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
							  Authorizations {{ $panelTitle }}
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
										<!-- Inside existing Livewire component -->
										@if($showPanelGroupManage)
											<div class="p-2 overflow-x-auto">
												<table id="userIndex2" class="table table-bordered table-hover">
													<thead class="bg-gray-900">
														<tr class="text-white text-left">
															<th style="text-align:center;"> Group User Name </th>
															<th> Project </th>
															<th> Tenure Start </th>
															<th> Valid Till </th>
															<th> Notebook Access </th>
															<th> New Validity </th>
														</tr>
													</thead>
													@if( count($asProj) > 0 )
														<tbody>
															@foreach($asProj as $xcd)
																<tr class="table-primary">
																	<td rowspan="{{ $rowSpanVal }}" class="text-normal">
																		{{ $xcd['name'] }} 
																	</td>
																		<?php  $user_id = $xcd['member_id']; unset($xcd['name']); unset($xcd['member_id']); ?>
																		@foreach($xcd as $xcf)
																			@if($xcf['allowed'] == "yes")
																				<td class="table-success text-normal">{{ $xcf['title'] }}</td>
																				<td class="table-success text-normal">{{ date('d-m-Y', strtotime($xcf['tenure_start_date'])) }}</td>
																				<td class="table-success text-normal">{{ date('d-m-Y', strtotime($xcf['tenure_end_date'])) }}</td>
																				<td class="table-success text-normal">
																					{{ $xcf['notebook'] != null  ? "Yes" : "no" }}
																				</td>
																				<td class="table-success text-normal">
																					<input class="shadow disabled appearance-none border rounded 
																						w-20% py-2 px-3 text-gray-900 leading-tight focus:outline-none 
																						focus:shadow-outline"
																						wire:model="validity_.{{ $user_id.'_'.$xcf['project_id'] }}"															
																						id="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																						name="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																						type="date" placeholder="validity">
																				</td>
																			<tr class="table-danger">
																			@else
																				<td class="table-danger">{{ $xcf['title'] }}</td>
																				<td class="table-danger text-normal"> - </td>
																				<td class="table-danger text-normal"> - </td>
																				<td class="table-danger text-normal"> - </td>
																				<td class="table-danger text-normal">
																					<input class="shadow disabled appearance-none border rounded 
																					w-20% py-2 px-3 text-normal leading-tight focus:outline-none 
																					focus:shadow-outline"
																					wire:model="validity_.{{ $user_id.'_'.$xcf['project_id'] }}"															
																					id="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																					name="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																					type="date" placeholder="validity">
																				</td>
																				<tr class="table-danger">
																			@endif
																		@endforeach
																	</tr>
															@endforeach
																<tr>
																	<td colspan="6">
																		<label class="text-sm text-gray-900">
																			{{ $message }}
																		</label>
																		</br>
																		<label class="text-sm text-gray-900">
																			@hasanyrole('pient')
																				<button wire:click="userGroupUpdate()" class="btn btn-primary rounded">Update</button>
																			@endhasanyrole
																		</label>
																	</td>
																</tr>
														</tbody>
													@else
														<tbody>
															<tr>
																<td class="text-sm px-4 text-gray-900">
																	Either project not found or users have not been assigned any projects
																</td>
															</tr>
														</tbody>
													@endif
												</table>						
											</div>		
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
		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
	</div>
</div>
