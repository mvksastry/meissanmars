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
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Active Projects
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
                    @if(count($issueReqs) > 0 )
                      <table id="userIndex2" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th> Strain </th>
                            <th> Req. On </th>
                            <th> Status </th>
                            <th> Action</th>
                          </tr>
                        </thead>
              						<tbody>
              							@foreach($issueReqs as $row)
              								<tr>
              									<td>
              										{{ $row->usage_id }}
              									</td>
              									<td>
              										{{ $row->strain->strain_name }}
              									</td>
              									<td>
              										{{ date('d-m-Y', strtotime($row->created_at)) }}
              									</td>
              									<td>
              										{{ ucfirst($row->issue_status) }}
              									</td>
              									<td>
              										@hasrole('pisg|pient')
              											@if ($row->issue_status == 'submitted' || $row->issue_status == 'confirmed')
              												<button wire:click="edit({{ $row->usage_id }})" class="btn btn-primary rounded">View/Edit</button>
              											@endif
              										@endhasrole
              										
                                  @hasrole('pisg|researcher')
                                    @if ($row->issue_status == 'approved')
                                      <button wire:click="addNewCages('{{ $row->usage_id }}')" class="btn btn-primary rounded">Add New</button>
                                    @endif
              										@endhasrole
              										
                                  @hasrole('pisg|pient|researcher')
                                    @if ($row->issue_status == 'issued' )
                                      <button wire:click="cages('{{ $row->usage_id }}')" class="btn btn-primary rounded">Cages</button>
                                    @else
                                      Waiting For Issue
                                    @endif
              										@endhasrole
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
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
        </div>
        <div class="row">
          <section class="col-lg-6 connectedSortable">
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

 							@if($cageAndLayout)
          			@include('livewire.usage.cageInfoLayout')
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
          <section class="col-lg-6 connectedSortable">
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
                  @if($cageDetailsPi)
                    @include('livewire.usage.detailsPiCage')
                  @endif

                  @if($layoutPiCage)
                    @include('livewire.usage.piCageLayout')
                  @endif

                  @if($transferCage)
                    @include('livewire.usage.transferCageNeed')
                  @endif
    
                  @if($cageInduction)
                    @include('livewire.usage.newCageIssues')
                  @endif
                  
                  @if($updateMode)
                    @include('livewire.usage.issue-update')
                  @endif
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>         
          
          
          
          
          
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
	</div>

    
</div>
