<div>
    {{-- The best athlete wants his opponent at his best. --}}
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Daily Colony Reports</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">D C R</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
			
				@hasrole('colony_asst')
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
                
								  <table id="userIndex2" class="table table-sm table-bordered table-hover">
										<thead>
											<tr>
												
												<th> Strain </th>
												<th> Primary Handler </th>
												<th> Back-up Handler</th>
												<th> Start Date</th>
												<th> End Date </th>
												<th> Note </th>
											</tr>
										</thead>
										<tbody>
											
												<tr>
													<td>
													
													</td>
													<td>
													
													</td>
													<td>
													
													</td>
													<td>
													
													</td>
													
													<td>
														
													</td>
													<td>
														
													</td>
												</tr>
											
										</tbody>
									</table>
								
									No Information to display
								
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
