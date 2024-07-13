<div>
  {{-- The best athlete wants his opponent at his best. --}}
  
    	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Allottment</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Allottment</li>
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
                      <button wire:click="showRacks('{{ $room->image_id }}')">
                      <img class="inline m-1" src="{{ asset($roomPath.$room->image_id) }}" alt="" width="75px" height="75px">
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
							  Racks
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
                    @include('livewire.occupancy.racksinrooms')
                  @endif

									
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
        
        </div>

			</div><!-- /.container-fluid -->
		</section>


    
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Layout
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

                  @if($layoutRack)
                    @include('livewire.occupancy.rackLayout')
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
							  Cage Details
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
                  @if($cageInfos)
                    @include('livewire.occupancy.cageDetails')
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
    <!-- / End of Left Panel Graph Card-->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
         <div class="row">
          <section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Racks
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
                          <th> Check </th>
                          <th> Rack ID </th>
                          <th> Rack Name </th>
                          <th> Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($rackInfos as $rack)
                      <tr>
                      </tr>
                      <tr>
                        <td>
                          <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox" value="{{ $rack->rack_id }}" wire:model="rackid">
                          </label>
                        </td>
                        <td>{{ $rack->rack_id }}</td>
                        <td>{{ $rack->rack->rack_name }}</td>
                        <td>{{ $rack->total }}</td>
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
      </div>
    </section>
    
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
							  Search
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
						  <div class="card-body">
							<div class="tab-content p-3">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <table id="userIndex2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th> Check ID </th>
                          <th> Usage ID </th>
                          <th> Strain </th>
                          <th> Sex</th>
                          <th> Age</th>
                          <th> Number </br> Requested</th>
                          <th> Cages </br>Requested</th>
                          <th> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($issues as $val)
                        <tr>
                          <td>
                            <label class="inline-flex items-center">
                              <input type="checkbox" class="form-checkbox" value="{{ $val->usage_id }}" wire:model="issx_id">
                            </label>
                          </td>
                          <td>
                            {{ $val->usage_id }}
                          </td>
                          <td>
                            {{ $val->strain->strain_name }}
                          </td>
                          <td>
                            {{ $val->sex }}
                          </td>
                          <td>
                            {{ $val->age }}-{{ $val->ageunit }}
                          </td>
                          <td>
                            {{ $val->number }}
                          </td>
                          <td>
                            {{ $val->cagenumber }}
                          </td>
                          <td>
                            <button wire:click="selectForSearch({{ $val->usage_id }})" class="btn btn-success rounded">Select</button>
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
          
          <section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Search Results
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
                    @include('livewire.allottment.detailsAllottment')
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
    <!-- / End of Left Panel Graph Card-->    
    
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
							  Search Errors, if any
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
                          <th> </th>
                        </tr>
                    </thead>
                      <tbody>
                        
                          <tr>
                            <td>
                              
                            </td>
                          </tr>
                        
                      </tbody>
                    </table>
									
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
          
          <section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Allottment Final Result
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
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          </th>
													<th></th>
                          <th></th>
													<th></th>
													<th></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
											</tbody>
										</table>                      
									
										No Information to display
									

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
    <!-- / End of Left Panel Graph Card-->      
    
	</div>
  
</div>
