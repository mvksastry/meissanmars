@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Usages: Pending</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Usages / Pending</li>
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
                  Pending
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
                  <form method="POST" action="{{ route('usageapprovals.update', $usageRequest->usage_id) }}">
                    @csrf
                    @method('PUT')
                        
                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">
                      <thead>
                        <tr bgcolor="#BBDEFB">
                          <th> Item</th>
                          <th> Detials</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Usage Request Id</td>
                          <td>{{ $usageRequest->usage_id }}</td>
                        </tr>
                        <tr>
                          <td>Project Id</td>
                          <td>{{ $usageRequest->iaecproject_id }}</td>
                        </tr>
                        <tr>
                          <td>PI</td>
                          <td>{{ $usageRequest->user->name }}</td>
                        </tr>
                        <tr>
                          <td>Species</td>
                          <td>{{ $usageRequest->species->species_name }}</td>
                        </tr>
                        <tr>
                          <td>Strain</td>
                          <td>{{ $usageRequest->strain->strain_name }}</td>
                        </tr>
                        <tr>
                          <td>Sex, Age</td>
                          <td>{{ $usageRequest->sex." , ".$usageRequest->age." ".$usageRequest->ageunit }}</td>
                        </tr>
                        <tr>
                          <td>Number</td>
                          <td>{{ $usageRequest->number }}</td>
                        </tr>
                        <tr>
                          <td>No. Cages</td>
                          <td>{{ $usageRequest->cagenumber }}</td>
                        </tr>
                        <tr>
                          <td>Termination</td>
                          <td>{{ $usageRequest->termination }}</td>
                        </tr>
                        <tr>
                          <td>Duration</td>
                          <td>{{ $usageRequest->duration }} week(s)</td>
                        </tr>
                        <tr>
                          <td>Expt Description</td>
                          <td>{{ $usageRequest->expt_desc }}</td>
                        </tr>
                        <tr>
                          <td>Products</td>
                          <td>{{ $usageRequest->products }}</td>
                        </tr>
                        <tr>
                          <td>Remarks</td>
                          <td>{{ $usageRequest->remarks }}</td>
                        </tr>
                        <tr>
                          <td>Remarks</td>
                          <td>
                          <input class="form-control shadow appearance-none border rounded" value="{{ old('remarks') }}" id="remarks" name="remarks" type="text" placeholder="Remarks if any">
                          </td>
                        </tr>
                        <tr>
                          <td>Final Decision</td>
                          <td>
                            <div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input" value="1" id="decision" value="{{ old('decision') }}"name="decision" type="radio">
                                <label class="form-check-label">Approved</label>
                              </div>
                            
                            
                              <div class="form-check">
                                <input class="form-check-input" value="0" id="decision" name="decision" type="radio">
                                <label class="form-check-label">Not Approved</label>
                              </div>
                              @if($errors->has('decision'))
                                <p class="help-block text-red-700">
                                    {{ $errors->first('decision') }}
                                </p>
                              @endif
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <button class="btn btn-xs text-xs text-gray-100 btn-info p-1">Submit </button>
                          </td>
                        </tr>
                      </tbody>   
                    </table>
                  </form>
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