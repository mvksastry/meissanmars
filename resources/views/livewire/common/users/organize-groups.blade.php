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
        @hasrole('manager')
					@include('livewire.common.inventory.flexMenuInventory')
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
							  Authorizations
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
                  <div class="p-2">
                  <!-- Inside existing Livewire component -->
                                       
                  </div>                 
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





   {{-- The best athlete wants his opponent at his best. --}}
	<!--Container-->
	<!--Console Content-->
	<div class="flex flex-wrap">	
			
			    <!--Metric Card 1 -->
				<!--/End Metric Card 1-->
				
				<!--Metric Card 1 -->
				<!--
				<div class="w-full md:w-1/3 xl:w-1/3 sm:w-full p-3">
					<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
						<div class="flex flex-row items-center">
							<div class="flex-shrink pr-4">
								<div class="rounded p-3 bg-green-600">
									<i wire:click="showResGroups()" class="fa fa-wallet fa-2x fa-fw fa-inverse"></i>
								</div>
							</div>
							<div class="flex-1 text-left md:text-center">
								<h4 class="font-bold uppercase text-gray-900">Research Group</h5>
								<h5 class="font-normal text-left text-sm text-gray-900"></h5>
							</div>
						</div>
					</div>
				</div>
				-->
				<!--/End Metric Card 1-->
				
				<!--Metric Card 1 -->
				<div class="w-full md:w-1/3 xl:w-1/3 sm:w-full p-3">
					<div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
						<div class="flex flex-row items-center">
							<div class="flex-shrink pr-4">
								<div class="rounded p-3 bg-green-600">
									<i wire:click="showIaecGroups()" class="fa fa-wallet fa-2x fa-fw fa-inverse"></i>
								</div>
							</div>
							<div class="flex-1 text-left md:text-center">
								<h4 class="font-bold uppercase text-gray-900">IAEC Group</h5>
								<h5 class="font-normal text-left text-sm text-gray-900"></h5>
							</div>
						</div>
					</div>
				</div>
				<!--/End Metric Card 1-->
				
	</div>
	<!--End of Console content-->
	
	<!--Divider-->
	<hr class="border-b-2 border-gray-600 my-2 mx-4">
	<!--Divider-->
			
			
	<div class="flex flex-row flex-wrap flex-grow mt-2">
		<!-- Left Panel Graph Card-->
		<div class="w-full md:w-full p-3">
			<div class="bg-orange-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800 p-3">
					<h5 class="font-bold uppercase text-gray-900">{{ $panelTitle }}</h5>
				</div>
							
				<div class="errors">
					<div class="alert alert-success mx-10">
					    
					</div>
				</div>
				@if($showPanelGroupManage)
				    <div class="p-5 overflow-x-auto">
						<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-red-700 overflow-hidden'>
							<thead class="bg-gray-900">
								<tr class="text-white text-left">
									<th class="font-semibold text-sm uppercase px-6 py-2"> Group User Name </th>
									<th class="font-semibold text-sm uppercase px-6 py-2"> Project </th>
									<th class="font-semibold text-sm uppercase px-6 py-2"> Tenure Start </th>
									<th class="font-semibold text-sm uppercase px-6 py-2"> Valid Till </th>
									<th class="font-semibold text-sm uppercase px-6 py-2"> Notebook </br> Access </th>
									<th class="font-semibold text-sm uppercase px-6 py-2"> New </br> Validity </th>
								</tr>
							</thead>
							@if( count($asProj) > 0 )
								<tbody>
									@foreach($asProj as $xcd)
										<tr class="border-b border-red-400">
											<td rowspan="{{ count($actvProjs) }}" class="px-6 py-2 text-lg font-bold text-red-900 ">
												{{ $xcd['name'] }} 
											</td>
						    				<?php  $user_id = $xcd['member_id']; unset($xcd['name']); unset($xcd['member_id']); ?>
												@foreach($xcd as $xcf)
													@if($xcf['allowed'] == "yes")
														<td class="bg-green-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">{{ $xcf['title'] }}</td>
														<td class="bg-green-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">{{ date('d-m-Y', strtotime($xcf['tenure_start_date'])) }}</td>
														<td class="bg-green-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">{{ date('d-m-Y', strtotime($xcf['tenure_end_date'])) }}</td>
														<td class="bg-green-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">
															{{ $xcf['notebook'] != null  ? "Yes" : "no" }}
														</td>
														<td class=" bg-green-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">
															<input class="shadow disabled appearance-none border rounded 
																w-20% py-2 px-3 text-gray-900 leading-tight focus:outline-none 
																focus:shadow-outline"
																wire:model="validity_.{{ $user_id.'_'.$xcf['project_id'] }}"															
																id="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																name="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																type="date" placeholder="validity">
														</td>
															<tr class="border-b border-red-900">
															@else
																	<td class="bg-red-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">{{ $xcf['title'] }}</td>
																	<td class="bg-red-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400"> - </td>
																	<td class="bg-red-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400"> - </td>
																	<td class="bg-red-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400"> - </td>
																	<td class=" bg-red-200 px-6 py-2 text-sm text-gray-900 border-b border-gray-400">
																		<input class="shadow disabled appearance-none border rounded 
																		w-20% py-2 px-3 text-gray-900 leading-tight focus:outline-none 
																		focus:shadow-outline"
																		wire:model="validity_.{{ $user_id.'_'.$xcf['project_id'] }}"															
																		id="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																		name="validity_{{ $user_id.'_'.$xcf['project_id'] }}" 
																		type="date" placeholder="validity">
																	</td>
																<tr class="border-b border-red-900">
															@endif
														@endforeach
													</tr>
												@endforeach
												<tr>
													<td>
														</br>
														<label class="text-sm text-gray-900">
															{{ $message }}
														</label>
														</br>
														<label class="text-sm text-gray-900">
															@hasanyrole('pisg')
																<button wire:click="userGroupUpdate()" class="bg-blue-500 w-20 hover:bg-blue-800 text-white font-normal py-2 px-2  mx-3 rounded">Update</button>
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
	</div>
	<!--/ Console Content-->


		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
	</div>
</div>
