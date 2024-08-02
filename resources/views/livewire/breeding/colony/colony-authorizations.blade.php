<div>
    {{-- The best athlete wants his opponent at his best. --}}
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Colony Authorizations</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Auths</li>
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
					@include('livewire.breeding.colony.flexMenuDCR')
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
                @if(count($strainAuths) > 0)
								  <table id="userIndex2" class="table table-sm table-bordered table-hover">
										<thead>
											<tr>
												
												<th> Strain </th>
												<th> Primary Handler </th>
												<th> Start Date</th>
												<th> End Date </th>
												<th> Status </th>
												<th> Notes </th>
											</tr>
										</thead>
										<tbody>
											@foreach($strainAuths as $row)
												<tr>
													<td>
													{{ $row->strains->strain_name}}
													</td>
													<td>
													{{ $row->handler->name }}
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
													<td>
													{{ $row->notes }}
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
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
	</div>
</div>
