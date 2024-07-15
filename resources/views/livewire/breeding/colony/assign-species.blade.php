<div>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Permissions: Species</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Permissions</a></li>
							<li class="breadcrumb-item active">Species</li>
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
					@include('livewire.breeding.colony.flexMenuColonyPerms')
				@endhasrole

          <!-- Main content -->
           <!-- /.content -->
          
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- TO DO List -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"></h3>Active Strains & Permissions

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                @if(count($allowedStrains) > 0)
								  <table id="userIndex2" class="table table-sm table-bordered table-hover">
										<thead>
											<tr>
												<th> Strain </th>
												<th> Primary Handler </th>
												<th> Back-up Handler</th>
												<th> Start Date</th>
												<th> End Date </th>
												<th> Notes </th>
											</tr>
										</thead>
										<tbody>
											@foreach($allowedStrains as $row)
												<tr>
													<td>
													{{ $row->strains->strain_name}}
													</td>
													<td>
													{{ $row->handler->name }}
													</td>
													<td>
													{{ $row->backup->name }}
													</td>
													<td>
													{{ $row->start_date }}
													</td>
													<td>
														{{ $row->end_date }}
													</td>
													<td>
														{{ ucfirst($row->status) }}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								@else
									No Information to display
								@endif
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>           
						<!-- /.card -->
					</section>
					<!-- /.Left col -->

					<!-- right col (We are only adding the ID to make the widgets sortable)-->          
          <section class="col-lg-12 connectedSortable">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"></h3>Assign Permissions for Strains

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
							  <div class="card-body">
             
									
									<div class="form-group">
										<label for="exampleSelectBorder">Select Strains</label>
										<select class="custom-select form-control-border" wire:model.lazy="strain_id" id="exampleSelectBorder">
											<option value="-1">Select</option>
											@foreach($activeStrains as $row)
											<option value="{{ $row->strain_id }}">{{ $row->strain_name }}</option>
											@endforeach
										</select>
									</div>
								

									<div class="row">
										<div class="form-group col-lg-6">
											<label for="exampleSelectBorder">Primary Handler</label>
											<select class="custom-select form-control-border" wire:model.lazy="handler_id" id="exampleSelectBorder">
												<option value="-1">Select</option>
												@foreach($users as $row)
												<option value="{{ $row->id }}">{{ $row->name }}</option>
												@endforeach
											</select>
										</div>									

										<div class="form-group col-lg-6">
											<label for="exampleSelectBorder">Back-up Handler</label>
											<select class="custom-select form-control-border" wire:model.lazy="backup_id" id="exampleSelectBorder">
												<option value="-1">Select</option>
												@foreach($users as $row)
												<option value="{{ $row->id }}">{{ $row->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col-lg-6">
											<label for="exampleSelectBorder">Permission Start Date</label>
												<input type="date" class="form-control" wire:model.lazy="start_date" id="exampleInputPassword1" placeholder="Start Date">
										</div>								

										<div class="form-group col-lg-6">
											<label for="exampleSelectBorder">Permission End Date</label>
												<input type="date" class="form-control" wire:model.lazy="end_date" id="exampleInputPassword1" placeholder="End Date">
										</div>	
									</div>
									
                  <div class="form-group">
                    <label for="exampleInputEmail1">Notes</label>
                    <input type="text" class="form-control" wire:model.lazy="notes" id="exampleInputEmail1" placeholder="Notes">
									</div>

								<div class="card-footer">
                  <button wire:click="postPermForSpecies()" class="btn btn-info">Create Permission</button>
                  <button wire:click="resetForm()" class="btn btn-default float-right">Cancel</button>
                </div>
								
                </div>
							
			
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>             
						<!-- /.card -->
					</section>
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
	</div>

</div>

