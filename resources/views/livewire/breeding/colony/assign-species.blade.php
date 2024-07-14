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
          <section class="content">

            <!-- Default box -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"></h3>Species Permissions

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
                Start using your amazing application!
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.content -->
          
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- TO DO List -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"></h3>Species Permissions

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
                @if(count($allowedSpecies) > 0)
								  <table id="userIndex2" class="table table-sm table-bordered table-hover">
										<thead>
											<tr>
												<th> Check</th>
												<th> Species </th>
												<th> Primary Handler </th>
												<th> Back-up Handler</th>
												<th> Start Date</th>
												<th> End Date </th>
												<th> Note </th>
											</tr>
										</thead>
										<tbody>
											@foreach($allowedSpecies as $row)
												<tr>
													<td>
													<label class="inline-flex items-center">
														
													</label>
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
          <section class="col-lg-5 connectedSortable">
            
						<!-- /.card -->
					</section>
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
	</div>

</div>

