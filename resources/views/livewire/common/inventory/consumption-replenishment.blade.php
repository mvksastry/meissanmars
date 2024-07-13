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
						<h1 class="m-0">Home: Consumption - Replenishment</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Consumption - Replenishment</li>
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
					@include('livewire.common.inventory.flexMenuConsumReplenish')
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
                  Current Inventory
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                  </ul>
                </div>
						  </div><!-- /.card-header -->
              @if($showInventoryPanel)
                <div class="card-body">
                  <div class="tab-content p-0">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">   
                      <!--Divider-->
                      <div class="p-2">
                        <table id="inventory" class="table table-sm table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th>Product ID</th>
                              <th>Project</th>
                              <th>PMC Code</th>
                              <th>Name</th>
                              <th>Catalog #</th>
                              <th>User</th>
                              <th>Date Used</th>
                              <th>Quantity Consumed</th>
                              <th>Expt Id</th>
                              <th>Expt Date</th>
                              <th>Notes</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($consumption as $consumed)
                              <tr>
                                <div wire:key="{{$consumed->pack_mark_code}}">
                                  <td>
                                    <button class="btn btn-warning btn-sm" 
                                      wire:click="$dispatch('openModal', 
                                      {component: 'common.modals.product-confirm', arguments: 
                                      {pack_mark_code: {{ $consumed->pack_mark_code }} 
                                      } } )">
                                      Modal
                                    </button>
                                  </td>
                                  <td>{{ $consumed->pack_mark_code }}</td>
                                  <td>{{ $consumed->pack_mark_code }}</td>
                                  <td>{{ $consumed->product->name }}</td>
                                  <td>{{ $consumed->product->catalog_id }}</td>
                                  <td>{{ $consumed->user->name }} </td> 
                                  <td>{{ $consumed->date_used }}</td>
                                  <td>{{ $consumed->quantity_consumed }} {{ $consumed->units->description }}</td>
                                  <td>{{ $consumed->experiment_id }}</td>                         
                                  <td>{{ $consumed->experiment_date }}</td>
                                  <td>{{ $consumed->notes }}</td>                                 
                                </div>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- insert table -->
                    </div>
                  </div>
                </div><!-- /.card-body -->
              @endif
						</div>
						<!-- /.card -->
					</section>
					<!-- /.Left col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
    <!-- / End of Left Panel Graph Card-->
	</div>
</div>

