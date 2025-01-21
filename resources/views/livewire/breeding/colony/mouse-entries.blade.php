<div>
    {{-- Success is as dangerous as failure. --}}
		<section class="col-lg-12 connectedSortable">
			<!-- Custom tabs (Charts with tabs)-->
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title">
						<i class="fas fa-chart-pie mr-1"></i>
						Entries
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
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Mouse Key</th>
										<th>ID</th>
										<th>Strain Key</th>
										<th>Birth Date</th>
										<th>Sex</th>
										<th>Cage/Rack/Slot</th>
										<th>CoD/Notes</th>
									</tr>
								</thead>
								<tbody>
									@if(count($mouseEntries) > 0 )
										@foreach($mouseEntries as $row)
											<tr>
												<td>{{ $row->_mouse_key }}</td>
												<td>{{ $row->ID }}</td>
												<td>{{ $row->strainSelected->strain_name }}</td>
												<td>{{ date('d-m-Y', strtotime($row->birthDate)) }}</td>
												<td>{{ $row->sex }}</td>
												<td>{{ $row->cage_id }}/{{ $row->rack_id }}/{{ $row->slot_id }}</td>
												<td>{{ $row->cod }}/{{ $row->codNotes }}</td>
											</tr>
										@endforeach
									@endif
								</tbody>
								<tfoot>
								</tfoot>
							</table>
						</div>
					</div>
				</div><!-- /.card-body -->
			</div>
			<!-- /.card -->
			<!-- /.card -->
		</section>
</div>
