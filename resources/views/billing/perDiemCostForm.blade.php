@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Billing</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Per-Diem-Cost</li>
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
							  Per-Diem-Cost
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
                    @if( count($strain_info) > 0 )
											<form method="POST" action="{{ route('billing.setperdiem') }}">
												@csrf
                          <table id="userIndex2" class="table table-bordered table-hover">
                            <thead>
                              <tr bgcolor="#BBDEFB">												
                                <th style="text-align:center;">
                                <input type="checkbox" id="select-all" />
                                </th>
                                <th>Species</th>
                                <th>Strain Name</th>
                                <th>Effective Date</th>
                                <th>New Effective Date</th>
                                <th>New Cost</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($strain_info as $row)
                                <tr>
                                  <td>
                                  <input type="checkbox" name="sp_str_id[]" id="sp_str_id[]" 
                                  value="{{ $row->species->species_id }}_{{ $row->strain_id }}" placeholder="Effective Date">
                                  </td>
                                  <td>
                                    {{ $row->species->species_name }}
                                  </td>
                                  <td>
                                   {{ $row->strain_name }}
                                  </td>
                                  <td>
                                    {{ date('d-m-Y', strtotime($row->cost->effective_cost_date)) }}
                                  </td>
                                  <td>
                                  <input type="date" class="form-control" id="exampleInputEmail1" 
                                  value="{{ date('Y-m-d') }}" placeholder="Effective Date">
                                    
                                  </td>
                                  <td>
                                    <input type="number" name="per_diem_cost[]" class="form-control" id="exampleInputEmail1" 
                                    value="{{ $row->cost->per_diem_cost }}" placeholder="Effective Date">
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>                      
                          <td colspan="2" align="center">
                            <button class="btn btn-primary w-40 rounded" type="submit">Set New Rates</button>
                          </td>
                      </form>
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