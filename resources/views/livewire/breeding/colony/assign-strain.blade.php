<div>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Permissions: Strain</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Permissions</a></li>
							<li class="breadcrumb-item active">Strain</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">

          <!-- Main content -->
          <!-- /.content -->
          
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- TO DO List -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"></h3>Strain Permissions

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
								  <table id="userIndex2" class="table table-sm table-bordered table-hover">
										<tbody>
											<div class="card-body">
												<div class="form-check">
													<label for="exampleSelectBorderWidth2"><code>Strain</code></label>
													<div class="row row-cols-3">
														@foreach($activStrains as $row)
															<div class="col">
																<input type="checkbox" wire:model.defer="strain_ids" value="{{ $row->strain_id }}" class="form-check-input" id="exampleCheck1">
																<label class="form-check-label" for="exampleCheck1">{{ $row->strain_name }}</label>
															</div>
														@endforeach
													</div>	
												</div>
											
												<div class="row">
													<div class="col-4">
														<div class="form-group">
															<label for="exampleSelectBorderWidth2"><code>Primary Handler</code></label>
															<select wire:model.defer="ph_id" class="custom-select form-control-border border-width-2" id="exampleSelectBorderWidth2">
																@foreach($curUsers as $row)
																<option value="{{ $row->id }}">{{ $row->name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-4">
														<div class="form-group">
															<label for="exampleInputPassword1">Start Date</label>
															<input wire:model.defer="start_date" type="date" class="form-control" name="start_date" placeholder="Start Date">
														</div>
													</div>
													<div class="col-4">
														<div class="form-group">
															<label for="exampleInputPassword1">End Date</label>
															<input wire:model.defer="end_date" type="date" class="form-control" name="end_date" placeholder="End Date">
														</div>
													</div>	
												</div>
												
												<div class="form-group">
													<label for="exampleInputPassword1">Notes</label>
													<input wire:model.defer="notes" type="text" class="form-control" name="notes" placeholder="Notes">
												</div>
											
												<!--
												<div class="form-check">
													<input wire:model.defer="auto_ext" type="checkbox" class="form-check-input" id="exampleCheck1">
													<label class="form-check-label" for="exampleCheck1">Automatic 30 Day Extension</label>
												</div>
												-->
											</div>
											<!-- /.card-body -->

											<div class="card-footer">
												<button wire:click="postStrainPerms()" class="btn btn-primary rounded">Enter</button>
											</div>											
										</tbody>
									</table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
							<a href="/colony-authorizations" class="small-box-footer">
                <button class="btn btn-primary rounded">Back To Authorizations</button>
							</a>
              </div>
              <!-- /.card-footer-->
            </div>            
						<!-- /.card -->
					</section>
					<!-- /.Left col -->

					<!-- right col (We are only adding the ID to make the widgets sortable)-->          
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
	</div>

</div>

