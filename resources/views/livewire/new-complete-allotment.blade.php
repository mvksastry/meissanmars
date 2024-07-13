@extends('layouts.app')
@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Home: Allottment</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Allotment</li>
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
                  Rooms and Racks
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

									@if( count($issueRequests) > 0 )
										<table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          ID
                          </th>
													<th>PI</th>
                          <th>Title</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
                        @foreach($rackInfos as $rack)
                          <tr>
                            <td>
                                <label class="inline-flex items-center">
                                  <input type="checkbox" class="form-checkbox" value="{{ $rack->rack_id }}" wire:model="rackid">
                                </label>
                            </td>
                              <td>{{ $rack->rack_id }}</td>
                              <td>{{ $rack->rack->rack_name }}</td>
                              <td>{{ $rack->total }}</td>
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
							  Approved
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


            <table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
              <thead class="bg-gray-900">
                  <tr class="text-white text-left">
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Check ID </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Usage ID </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Strain </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Sex</th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Age</th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Number </br> Requested</th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Cages </br>Requested</th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Actions</th>
                  </tr>
              </thead>
                <tbody>
                  @foreach($issues as $val)
                    <tr class="text-gray-900 text-sm font-normal mt-3 mb-4">
                      <td class="px-8 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                        <label class="inline-flex items-center">
        									<input type="checkbox" class="form-checkbox" value="{{ $val->issue_id }}" wire:model="issx_id">
        								</label>
                      </td>
                      <td class="px-6 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                        {{ $val->issue_id }}
                      </td>
                      <td class="px-6 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                      	{{ $val->strain->strain_name }}
                      </td>
                      <td class="px-6 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                      	{{ $val->sex }}
                      </td>
                      <td class="px-6 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                      	{{ $val->age }}-{{ $val->ageunit }}
                      </td>
                      <td class="px-6 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                      	{{ $val->number }}
                      </td>
                      <td class="px-6 py-4 text-gray-900 text-xs mt-1 mb-1 font-normal">
                      	{{ $val->cagenumber }}
                      </td>
                      <td>
                        <x-button wire:click="alottSearch({{ $val->issue_id }})" class="bg-pink-500 w-30 hover:bg-blue-800 text-white font-normal py-2 px-3 rounded">Search</x-button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>











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