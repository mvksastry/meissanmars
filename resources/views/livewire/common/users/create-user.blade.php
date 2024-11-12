<div>
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
						<h1 class="m-0">Home: Users</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Users</li>
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
					<section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Current Group Members
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

    		<div class="p-1">
    			@if(count($own_group) > 0 )
    				<table id="userIndex2" class="table table-bordered table-hover">
    					<thead>
    						<tr>
    							<th> Name </th>
    							<th> Start Date </th>
    							<th> End Date </th>
									<th> Action </th>
    						</tr>
    					</thead>
    					<tbody>
    						@foreach($own_group as $row)
								 @foreach($row->members as $val)
    							<tr>
    								<td>{{ ucfirst($val->name) }}</td>
    								<td>{{ date('d-m-Y',strtotime($val->start_date)) }}</td>
    								<td>{{ date('d-m-Y',strtotime($val->expiry_date)) }}</td>
										<td>
    									<button wire:click="editUser('{{ $row->member_id }}')" class="btn btn-info btn-sm rounded">Edit</button>
    								</td>
    							</tr>
									@endforeach
								@endforeach
    					</tbody>
    				</table>
    			@else
    				<table id="userIndex2" class="table table-bordered table-hover">
    					<thead>
    						<tr class="border-b bg-purple-100 border-purple-200">
    							<th scope="col" class="text-sm font-medium text-gray-900 px-3 py-2 text-left">No Information to show </td>
    						</tr>
    					</thead>
    					<tbody>
    					</tbody>
    				</table>
    			@endif
    			</br></br>
        </div>

				
                  </div>                 
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
							  Add User
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

								@if($new_user_panel)
									
									<div class="form-group">
										<label for="exampleInputEmail1">Role</label>
										<select class="form-control shadow border rounded" name="role" id="role" wire:model.lazy="role">
											<option value="0">Select</option>
											<option value="researcher">Researcher</option>
											<option value="tech_help">Tech. Assistant
											<option value="vets">Veternarian</option>
											<option value="guest_res">Guest Researcher</option>
										</select>
										@if($errors->has('role'))
											<p class="text-danger">
											{{ $errors->first('role') }}
											</p>
										@endif  
									</div>
									
									<div class="form-group">
										<label for="exampleInputEmail1">Name</label>
										<input type="text" class="form-control" name="name" id="name" wire:model.lazy="name" placeholder="Name">
										@if($errors->has('name'))
											<p class="text-danger">
											{{ $errors->first('name') }}
											</p>
										@endif  
									</div>

									<div class="form-group">
										<label for="exampleInputEmail1">Email</label>
										<input type="text" class="form-control" name="email" id="email" wire:model.lazy="email" placeholder="Email">
										@if($errors->has('email'))
											<p class="text-danger">
											{{ $errors->first('email') }}
											</p>
										@endif  
									</div>
									
									<div class="row">
										<div class="col-lg-6 form-group">
											<label for="exampleInputEmail1">Start Date</label>
											<input type="date" class="form-control" wire:model.lazy="start_date" name="start_date" id="start_date" placeholder="Start Date">
											@if($errors->has('start_date'))
												<p class="text-danger">
												{{ $errors->first('start_date') }}
												</p>
											@endif   
										</div>
										
										<div class="col-lg-6 form-group">
											<label for="exampleInputEmail1">End Date</label>
											<input type="date" class="form-control" wire:model.lazy="end_date" name="end_date" id="end_date" placeholder="End Date">
											@if($errors->has('end_date'))
												<p class="text-danger">
												{{ $errors->first('end_date') }}
												</p>
											@endif
										</div>
									</div>
									
									<input type="checkbox" name="agree" value="1" />
									<label class="form-check-label text-normal font-weight-normal" for="defaultCheck2">
										Agree with terms and conditions
									</label>
									
									<div class="card-footer">
										<label class="form-check-label text-success font-weight-bold" for="defaultCheck2">
											{{ $userAddMessageSuccess }}
										</label>	
									</div>
									
									<div class="card-footer">
										<button wire:click="addNewUser()" type="submit" class="btn btn-primary">Add User</button>
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
