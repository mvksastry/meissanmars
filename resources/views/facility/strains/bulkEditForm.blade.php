@extends('layouts.app')
@section('content')
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Bulk Update Strains</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Bulk Update Strains</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						
							<div class="card-header">
								<h3 class="card-title">
								  <i class="fas fa-chart-pie mr-1"></i>
								  Bulk Update
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
									<div class="card card-primary">
                    <!--
										<div class="card-header">
											<h3 class="card-title">All Inputs Mandatory</h3>
										</div>
                    -->
										<!-- /.card-header -->

										<div class="card-body">
											<form method="POST" action="{{ route('strains.updatestatus') }}">
                        @method('PUT')
												@csrf


                        @if( count($strains) > 0)
                          <table id="userIndex2" class="table table-bordered table-hover">
                            <thead>
                              <tr bgcolor="#BBDEFB">												
                                <th style="text-align:center;">
                                <input type="checkbox" id="select-all" />
                                </th>
                                <th>Species</th>
                                 <th>Strain</th>
                                <th>Notes</th>
                                
                               
                                <th>Distributable</th>
                                <th>Owner</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($strains as $row)
                                <tr bgcolor="#f3e5f5"   data-entry-id="">
                                <td><input type="checkbox" value="{{ $row->strain_id }}" name="strain_id[]" id="strain_id[]" /></td>
                                  <td>{{ $row->species->species_name }}</td>
                                  <td width="18%">
                                    <input type="text" class="form-control form-control-border" 
                                    name="floor" id="floor" value="{{ $row->strain_name }}" placeholder="Strain Name">
                                  </td>
                                  <td><input type="text" class="form-control form-control-border" 
                                    name="floor" id="floor" value="{{ $row->notes }}" placeholder="Strain Name">
                                    </td>
                                  
                                  <td width="18%"><select class="custom-select form-control rounded-1" 
                                        name="distributable" id="distributable">
                                
                                        <option value="yes" @if($row->distributable == "yes") selected @endif   >Yes</option>
                                        <option value="no" @if($row->distributable == "no") selected @endif >No</option>
                                      </select>
                              
                                  </td>
                              
                                  <td>
                                    <select class="custom-select form-control rounded-1" 
                                        name="building" id="building">
                                      @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                      @endforeach
                                      </select>
                                  </td>
                                 
                                </tr>
                              @endforeach					
                            </tbody>
                          </table>                      
                        @else
                          No Information to display
                        @endif

												<div class="card-footer">
													<button type="submit" class="btn btn-primary">Submit</button>
												</div>

											
										</div>

									  <!-- /.card-body -->
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

