@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Strains</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Strains</li>
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
					@include('facility.strains.flexMenuStrains')
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
							  Active Strains
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



                    @if( count($strains) > 0)
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          <input type="checkbox" id="select-all" />
                          </th>
													<th>Species</th>
                          <th>Notes</th>
													
													<th>Distributable</th>
													<th>Owner</th>
                          <th>Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach($strains as $row)
                          <tr bgcolor="#f3e5f5"   data-entry-id="">
                            <td>{{ $row->species->species_name }}</td>
                            <td>{{ $row->strain_name }}</td>
                            <td>{{ $row->notes }}</td>
                            <td>{{ ucfirst($row->distributable) }}</td>
                            <td>
                                @if( $row->owner_id != 0 )
                                  {{ $row->user->name }}
                                @else
                                  Free
                                @endif
                            </td>
                            <td>
                            <a href="{{ route('strains.edit',$row->strain_id) }}" class="btn btn-block btn-primary btn-sm">Edit</a>
                            
                            </td>
                          </tr>
												@endforeach					
											</tbody>
										</table>                      
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
					<!-- /.Left col -->
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>


		
	</div>	
@endsection('content')