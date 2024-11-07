<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: IAEC Projects</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">IAEC Projects</li>
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
			
        @hasrole('pient')
					@include('livewire.iaec.flexwrapPiProjects')
				@endhasrole

				<div class="row">
					<!-- Left col -->
					@hasrole('pient')
						<section class="col-lg-12 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Submitted Projects
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
											<div class="table-responsive">
												@if(count($submitProjs) > 0 )
													<table id="userIndex2" class="table table-bordered table-hover">
														<thead>
															<tr>
																<th> ID </th>
																<th class="col-6"> Title </th>
																<th> Status </th>
																<th> Action</th>
															</tr>
														</thead>
														<tbody>
															@foreach($submitProjs as $row)
																<tr>
																	<td>
																		<p class=""> {{ $row->tempproject_id }} </p>
																	</td>
																	<td>
																			<p> {{ $row->title }} </p>
																	</td>
																	<td>
																			{{ ucfirst($row->status) }}
																	</td>
																	<td>
																		@if ($row->status == 'submitted')
																			@hasanyrole('pisg|pient')
																				<a href="{{ route('projectsmanager.edit',[$row->tempproject_id]) }}">
																					<button class="btn btn-primary rounded mx-3">Edit</button>
																				</a>                         
																			@endhasanyrole
																		@endif
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												@else
													<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
														<thead class="bg-gray-900">
															<tr class="text-white text-left">
																<th class="font-semibold text-sm uppercase px-6 py-4"> No Data Found </th>
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
					@endhasrole
        </div>
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Active Projects (Click any button, details will appear in 'Result' panel below)
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
                    <div class="table-responsive">
                      @if(count($actvProjs) > 0 )
                        <table id="userIndex2" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th> ID </th>
                              <th class="col-6"> Title </th>
                              <th> Status </th>
                              <th> Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($actvProjs as $row)
                              <tr>
                                <td>
                                  <p class=""> {{ $row->projectiaec->iaecproject_id }} </p>
                                </td>
                                <td>
                                    <p> {{ $row->projectiaec->title }} </p>
                                </td>
                                <td>
                                    {{ ucfirst($row->projectiaec->status) }}
                                </td>
                                <td>
                                  @if ($row->projectiaec->status == 'active')
                                    @hasanyrole('pisg|pient')
                                      <button wire:click="show({{ $row->iaecproject_id }})" class="btn btn-primary rounded mx-2">Details</button>
                                      <a href="/iaec-usage">
                                      <button class="btn btn-warning rounded mx-2">Usage</button>
                                      </a>
                                      <button wire:click="showFormDInfo({{ $row->iaecproject_id }})" class="btn btn-danger  rounded mx-2">Form-D</button>
                                      <button wire:click="reports({{ $row->iaecproject_id }})" class="btn btn-secondary  rounded mx-2">Reports</button>
                                      <button wire:click="costs({{ $row->iaecproject_id }})" class="btn btn-success  rounded mx-2">Cost</button>
                                    @endhasanyrole
                                    
                                    @hasrole('researcher')
                                      <button wire:click="show( '{{ $row->iaecproject_id }}' )" class="btn btn-primary rounded mx-2">Details</button>
                                      <button wire:click="showFormDInfo({{ $row->iaecproject_id }})" class="btn btn-danger rounded mx-2">Form-D</button>
                                      <button wire:click="reports({{ $row->iaecproject_id }})" class="btn btn-secondary rounded mx-2">Reports</button>
                                    @endhasrole
                                    
                                    @hasrole('veterinarian')
                                      <button wire:click="showFormDInfo({{ $row->iaecproject_id }})" class="btn btn-success  rounded mx-2">Notebook</button>
                                      <button wire:click="reports({{ $row->iaecproject_id }})" class="btn btn-secondary  rounded mx-2">Reports</button>
                                    @endhasrole
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                          <thead class="bg-gray-900">
                            <tr class="text-white text-left">
                              <th class="font-semibold text-sm uppercase px-6 py-4"> No Data Found </th>
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
                  @if($updateMode)
                      @include('livewire.iaec.detailsProject')
                  @endif
                  
                  @if($updateFormD)
                      @include('livewire.iaec.user-formD')
                  @endif
                  
                  @if($updateNotebook)
                      @include('livewire.iaec.Notebook')
                  @endif
                  
                  @if($notebookUpdate)
                      @include('livewire.iaec.Notebook2')
                  @endif
                  
                  @if($updateReports)
                      @include('livewire.iaec.user-reports')
                  @endif
                  
                  @if($updateCosts)
                      @include('livewire.iaec.user-costs')
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
