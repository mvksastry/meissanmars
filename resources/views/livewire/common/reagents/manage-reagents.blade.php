<div>
    {{-- Success is as dangerous as failure. --}}
      <!-- Never delete or modify this div -->
    	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Reagents</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Reagents</li>
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
					@include('livewire.common.reagents.flexMenuReagents3')
				@endhasrole
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-5 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  {{ $left_panel_title }}
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
                    @if($showNewReagentEntry)
                      @include('livewire.common.reagents.newReagentForm')
                    @endif
                    
                    @if($showRemakeReagentEntry)
                      @include('livewire.common.reagents.remakeReagentForm')
                    @endif
                  </div>
                  
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
          
          <section class="col-lg-7 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  {{ $right_panel_title }}
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
										@if($showNewReagentEntry)									
                      <table id="inventoryx" class="table table-sm table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>PMC Code</th>
                              <th>Name</th>
                              <th>Catalog #</th>
                              <th>Num Packs</th>
                              
                              <th>Open / Unopened</th>
                              <th>Quantity Left</th>
                              
                              <th>Storage container id</th>
                              <th>Shelf Rack Id</th>
                              <th>Box Id</th>
                              <th>Box Pos. Id</th>
                              <th>Open Storage</th>
                              <th>Entry By</th>
                              <th>Entry Date</th>
                              <th>notes</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($products as $product)
                            <tr>
                              <div wire:key="{{$product->product_id}}">
                                <td>
                                  <button wire:click="selectedItem('{{ $product->pack_mark_code }}')" 
                                     id="invent" class="btn btn-sm btn-success rounded">
                                      Select
                                  </button>
                                </td>
                                <td>{{ $product->pack_mark_code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->catalog_id }}</td>
                                <td>{{ $product->num_packs }}  x {{ $product->pack_size }} 
                                @if($product->units->description == "micro liter")
                                &#956l
                                @else
                                {{ $product->units->symbol_add }}
                                @endif
                                </td> 
                                                                          
                                <td>
                                  @if($product->status_open_unopened == 1)
                                    Opened
                                  @else
                                    Unopened
                                  @endif                              
                                </td>
                                <td>{{ $product->quantity_left }} 
                                @if($product->units->description == "micro liter")
                                &#956l
                                @else
                                {{ $product->units->symbol_add }}
                              {{ $product->units->symbol }}
                                @endif
                                </td>
                                
                                <td>{{ $product->storage_container_id }}</td>
                                <td>{{ $product->shelf_rack_id }}</td>
                                <td>{{ $product->box_id }}</td>
                                <td>{{ $product->box_position_id }}</td>
                                <td>{{ $product->open_storage }}</td>
                                <td>{{ $product->enteredby_id }}</td>
                                <td>{{ $product->date_entered }}</td>
                                <td>{{ $product->notes }}</td>                            
                              </div>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
										@endif
										@if($showRemakeReagentEntry)
                      <table id="inventoryx" class="table table-sm table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>Nick Name</th>
                              <th>Name</th>                              
                              <th>Quantity Made</th>                              
                              <th>Quantity Left</th>                             
                              <th>Made By</th>
                              <th>Date Made</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($rmStockReagents as $rsr)
                            <tr>
                              <div wire:key="{{$rsr->reagent_id}}">
                                <td>
                                  <button wire:click="selectedReagent('{{ $rsr->reagent_id }}')" 
                                     id="invent" class="btn btn-sm btn-success rounded">
                                      Select
                                  </button>
                                </td>
                                <td>{{ $rsr->nick_name }}</td>
                                <td>{{ $rsr->name }}</td>                                                                                                        
                                <td>{{ $rsr->quantity_made }} {{ $rsr->units->description }}</td>                              
                                <td>{{ $rsr->quantity_left }} {{ $rsr->units->description }}</td>
                                <td>{{ $rsr->users->name }}</td>
                                <td>{{ $rsr->date_made }}</td>                        
                              </div>
                            </tr>
                          @endforeach
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
          
					<!-- /.Left col -->
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
	</div>

</div>
