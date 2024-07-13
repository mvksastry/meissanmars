<div>
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
						<h1 class="m-0">Home: Log Books</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Log Books</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
        
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Add New Stock Item
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
 							@if(count($activeInfras) > 0 )
								<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
									<thead class="bg-gray-900">
										<tr class="text-white text-left">
											<th class="font-semibold text-sm uppercase px-6 py-2"> S.No. </th>
											<th class="font-semibold text-sm uppercase px-6 py-2"> Nick Name </th>
											<th class="font-semibold text-sm uppercase px-6 py-2"> Description </th>
											<th class="font-semibold text-sm uppercase px-6 py-2"> Status </th>
											<th colspan="3" class="font-semibold text-sm uppercase px-6 py-2"> Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($activeInfras as $row)
											<tr>
												<td class="px-6 py-2 text-sm text-gray-900" align="left">
													{{ $row->infra_id }}
												</td>
												<td class="px-6 py-2 text-sm text-gray-900">
													{{ $row->nickName }}
												</td>
												<td class="px-6 py-2text-sm text-gray-900" align="left">
													{{ $row->description }}
												</td>
												<td class="px-6 py-2 text-sm text-gray-900" align="left">
													{{ $row->status }}
												</td>
												<td class="text-sm text-gray-900">
													<button wire:click="createLogEntry({{ $row->infra_id }})" class="btn btn-primary rounded">
													Log Book
													</button>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@else
								<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
									<thead class="bg-gray-900">
										<tr class="text-white text-left">
											<th class="font-semibold text-sm uppercase px-6 py-2"> No Data to display </th>
											</tr>
									</thead>
									<tbody>						
									</tbody>
								</table>
							@endif
                                     
                  </div>                 
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
							  Options
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
                  @if($isLogEntryPanelOpen)
                    <div class="w-full p-3">
                      <div class="bg-orange-100 border border-gray-800 rounded shadow">
                        <div class="border-b border-gray-800 p-3">
                          <h5 class="font-bold uppercase text-gray-900">Log Book: {{ $infraName[0] }}</h5>
                        </div>
                        <div class="p-3">		
                          @if(count($logEntries) > 0)
                            <table class="table table-sm">
                              <thead class="bg-gray-900">
                                <tr class="text-white text-left">
                                  <th> Date </th>
                                  <th> User </th>
                                  <th> Equipment </th>
                                  <th> Start </th>
                                  <th> End </th>
                                  <th> Accessories</th>
                                  <th> Status</th>
                                  <th> Remarks</th>
                                </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-200">
                                @foreach($logEntries as $row)
                                  <tr>
                                    <td>
                                        {{ date('d-m-Y', strtotime($row->created_at)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $row->user->name }} 
                                    </td>
                                    <td class="px-6 py-4">
                                      {{ $row->infra->nickName }}
                                    </td>
                                    <td class="px-6 py-4">
                                      <p class=""> {{ $row->start_hour }}:{{ $row->start_min }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                      <p class=""> {{ $row->end_hour }}:{{ $row->end_min }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                      {{ ucfirst($row->accessories) }}
                                    </td>
                                    <td class="text-sm text-gray-900">
                                      <p class=""> {{ ucfirst($row->status) }}</p>		  
                                    </td>
                                    <td class="text-sm text-gray-900">
                                      <p class="">{{ ucfirst($row->remarks) }}</p>		  
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>	
                          @else 
                            <table class="table table-sm">
                              <thead class="bg-gray-900">
                                <tr class="text-white text-left">
                                  <th class="font-semibold text-sm uppercase px-6 py-2"> No Entries </th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          @endif
                        </div>

                        <!-- Start of log entry block -->
                        <div class="p-3">
                            
                          <table class="table table-sm">
                            <thead>
                              <tr>
                                <th colspan="2" class="px-5 py-3 border-b-2 border-gray-200 bg-indigo-100 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                    Make New Log Entry
                                </th>
                              </tr>
                            </thead>
                              
                              <tbody>
                                  <tr>
                                      <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm">
                                          <input placeholder="Start Hour" wire:model.lazy="newLogEntry.start_hour"
                                          class="form-control" />
                                          @error('newLogEntry.start_hour')
                                              <span class="error text-red-900">{{ $message }}</span> 
                                          @enderror
                                      </td>
                                      <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm">
                                          <input placeholder="Start min" wire:model.lazy="newLogEntry.start_min"
                                          class="form-control" />
                                          @error('newLogEntry.start_min') 
                                              <span class="error text-red-900">{{ $message }}</span> 
                                          @enderror
                                      </td>
                                  </tr>
                                  
                                  <tr>
                                      <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm">
                                          <input placeholder="End Hour" wire:model.lazy="newLogEntry.end_hour"
                                          class="form-control" />
                                          @error('newLogEntry.end_hour') 
                                              <span class="error text-red-900">{{ $message }}</span> 
                                          @enderror
                                      </td>
                                      <td class="px-2 py-3 border-b border-gray-200 bg-white text-sm">
                                          <input placeholder="End Min" wire:model.lazy="newLogEntry.end_min"
                                          class="form-control" />
                                          @error('newLogEntry.end_min') 
                                              <span class="error text-red-900">{{ $message }}</span> 
                                          @enderror
                                      </td>
                                  </tr>
                                  
                                  <tr>
                                      <td colspan="2" class= "w-1/2 md:w-full sm:full px-2 py-3 border-b border-gray-200 bg-white text-sm">
                                          <input placeholder="Accessories"  wire:model.lazy="newLogEntry.accessories"
                                          class="form-control" />
                                          @error('newLogEntry.accessories') 
                                              <span class="error text-red-900">{{ $message }}</span> 
                                          @enderror
                                      </td>
                                  </tr>
                                  
                                  <tr>
                                      <td colspan="2" class="w-1/2 md:w-full sm:full px-2 py-3 border-b border-gray-200 bg-white text-sm">
                                          <input placeholder="Remarks" wire:model.lazy="newLogEntry.remarks"
                                          class="form-control" />
                                          @error('newLogEntry.remarks') 
                                              <span class="error text-red-900">{{ $message }}</span> 
                                          @enderror
                                      </td>
                                  </tr>
                                  
                                  <tr>
                                      <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                          <button type="button" wire:click="$set('isLogEntryPanelOpen', false)"
                                            class="btn btn-warning rounded">
                                            Cancel
                                         </button>
                                      </td>
                                      <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                          <button type="button" wire:click.prevent="saveNewLogEntry()"
                                            class="btn btn-success rounded">
                                            Confirm
                                         </button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                            
                        </div>
        				<!-- /end of log entry block -->	
					</div>
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

