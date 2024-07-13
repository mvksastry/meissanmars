@extends('layouts.app')
@section('content')
    	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Project Details</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Project Details</li>
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
					<section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Project Details
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
                    <table id="userIndex2" class="table table-sm table-bordered table-hover">
                      <thead>
                        <tr bgcolor="#BBDEFB">												
                        </tr>
                      </thead>
                      <tbody>
                        <tr bgcolor="#E1BEE7"   data-entry-id="{{ $iaecproject->iaecproject_id }}">
                          <td>ID</td>
                          <td>{{ $iaecproject->iaecproject_id }}</td>
                        </tr>
                        <tr>
                          <td>PI</td>
                          <td>{{ $iaecproject->user->name }}</td>
                        </tr>
                        <tr>                        
                          <td>Title</td>
                          <td>{{ $iaecproject->title }}</td> 
                        </tr>
                        <tr>
                          <td>Start Date</td>
                          <td>{{ date('d-m-Y', strtotime($iaecproject->start_date)) }}</td>
                        </tr>
                        <tr>
                          <td>End Date</td>
                          <td>{{ date('d-m-Y', strtotime($iaecproject->end_date)) }}</td>
                        </tr>
                      </tbody>
                    </table>                      
                  
                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">
                      <tbody>
                        <tr>
                          <td class="text-wrap text-center" colspan="6">Sanctioned Strains
                          </td>
                        </tr>
                        <tr>
                          <td class="text-xs font-normal"> Strain </td>
                          <td class="text-xs font-normal"> Year 1 </td>
                          <td class="text-xs font-normal"> Year 2 </td>
                          <td class="text-xs font-normal"> Year 3 </td>
                          <td class="text-xs font-normal"> Year 4 </td>
                          <td class="text-xs font-normal"> Year 5 </td>
                        </tr>
                        @foreach($projectstrains as $val)
                          <tr class="text-sm font-normal mt-3 mb-4">
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->strain->strain_name}}
                            </td>
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->year1 }}
                            </td>
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->year2 }}
                            </td>
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->year3 }}
                            </td>
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->year4 }}
                            </td>
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->year5 }}
                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan='6' class="text-xs text-left text-gray-200">End of Details</td>
                        </tr>
                      </tbody>
                    </table>

                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">
                      <tr>
                        <td class="text-wrap text-center" colspan="7">IAEC Decisions
                        </td>
                      </tr>
                      <tr>
                        <td class="text-wrap text-sm">Remarks</td>
                        <td class="text-wrap text-sm">{{ $iaecproject->notes }}</td>
                      </tr>
                      <tr>
                        <td class="text-wrap text-sm">IAEC Decision Remarks</td>
                        <td class="text-wrap text-sm">{{ $iaecproject->iaec_comments }}</td>
                      </tr>
                      <tr>
                        <td class="text-wrap text-xs">IAEC Meeting Date</td>
                        <td class="text-wrap text-xs">{{ $iaecproject->date_approved }}</td>
                       </tr>
                      <tr>                     
                        <td class="text-wrap text-xs">IAEC Meeting Information</td>
                        <td class="text-wrap text-xs">{{ $iaecproject->iaec_meeting_info }}</td>
                      </tr>
                      <tr>                     
                        <td class="text-wrap text-xs">Form-D Table</td>
                        <td class="text-wrap text-xs">{{ $iaecproject->formD }}</td>
                      </tr>                 
                      <tr>
                        <td class="text-wrap text-sm">View File</td>
                        <td class="text-wrap text-sm">			
                          <a href="{{ route('adminProject.download', $iaecproject->filename ) }}">
                            <button type="button" class="btn btn-sm btn-primary">
                            View Project File
                            </button>                                                   
                          </a>                        
                        </td>
                      </tr>
                      <tr>
                        <td colspan='7' class="text-xs text-left text-gray-200">End of Details</td>
                      </tr>
                    </table>
                    <div class="py-4 mt-2">
                      <a href="{{ route('projectsmanager.index') }}">
                      <button class="btn btn-xs text-xs text-gray-200 btn-info p-1">
                      Back to Home
                      </button>
                      </a>
                    </div>
                  </div>
                </div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
          
          <section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Usage Details
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
                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">
                      <tr>
                        <td class="text-wrap text-center" colspan="7">Strain wise consumption
                        </td>
                      </tr>
                      <tr>
                        <td class="text-wrap text-center text-sm"></td>
                        <td class="text-wrap text-center text-sm" colspan="3">All Years</td>
                        <td class="text-wrap text-center text-sm" colspan="3">Current Year</td>
                      </tr>
                      <tr >
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Strain</td>
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Limit </td>
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Used</td>
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Balance</td>
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Limit</td>
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Used</td>
                        <td bgcolor="#BBDEFB" class="text-wrap text-center text-xs">Balance</td>
                      <tr>
                      <?php $strainwise_info = array(); ?>
                      @if (!empty($swc))
                        @foreach ($swc as $row)
                          <tr>
                            <td class="text-wrap text-center text-sm">{{ $row[0] }}</td>
                            <td class="text-wrap text-center text-sm">{{ $row[2] }}</td>
                            <td class="text-wrap text-center text-sm">{{ $row[1] }}</td>
                            <td class="text-wrap text-center text-sm">{{ $row[2]-$row[1] }}</td>
                            <td class="text-wrap text-center text-sm">{{ $row[4] }}</td>
                            <td class="text-wrap text-center text-sm">{{ $row[3] }}</td>
                            <td class="text-wrap text-center text-sm">{{ $row[4]-$row[3] }}</td>
                          </tr>
                        @endforeach
                      @endif
                      <tr>
                        <td colspan='7' class="text-xs text-left text-gray-200">End of Details</td>
                      </tr>
                    </table>

              

                    <label class="block text-sm font-normal mt-6 mb-2" for="end date">
                      Usage Information
                    </label>
                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">
                      <tbody>
                        @if(count($issueConfirmed) > 0)
                          <tr>
                            <td class="text-xs font-bold"> Date </td>
                            <td class="text-xs font-bold"> Usage Id </td>
                            <td class="text-xs font-bold"> Strain </td>
                            <td class="text-xs font-bold"> Number </td>
                            <td class="text-xs font-bold"> Cages </td>
                            <td class="text-xs font-bold"> Status </td>
                          </tr>
                          
                          @foreach($issueConfirmed as $val)
                            <tr class="text-sm font-normal mt-3 mb-4">
                              <td class="text-xs mt-1 mb-1 font-normal">
                                {{ date('d-m-Y', strtotime($val->status_date)) }}
                              </td>
                              <td class="text-xs mt-1 mb-1 font-normal">
                                {{ $val->usage_id }}
                              </td>
                              <td class="text-xs mt-1 mb-1 font-normal">
                                {{ $val->strain->strain_name }}
                              </td>
                              <td class="text-xs mt-1 mb-1 font-normal">
                                {{ $val->number }}
                              </td>
                              <td class="text-xs mt-1 mb-1 font-normal">
                                {{ $val->cagenumber }}
                              </td>
                              <td class="text-xs mt-1 mb-1 font-normal">
                                {{ ucfirst($val->issue_status) }}
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td colspan="6">
                              Confirmed Usage Entries Not Found.
                            </td>
                          </tr>
                        @endif

                        @if(count($issue) > 0)
                          @foreach($issue as $val)
                          <tr>
                            <td class="text-xs">
                              {{ $val->status_date}}
                            </td>
                            <td class="text-xs">
                              {{ $val->usage_id }}
                            </td>
                            <td class="text-xs">
                              {{ $val->strain->strain_name }}
                            </td>
                            <td class="text-xs">
                              {{ $val->number }}
                            </td>
                            <td class="text-xs">
                              {{ $val->cagenumber }}
                            </td>
                            <td class="text-xs">
                              {{ ucfirst($val->issue_status) }}
                            </td>
                          </tr>
                          @endforeach
                        @else
                          <tr> 
                            <td colspan="6" class="text-xs">
                              Usage Entries Not Found
                            </td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                    </br>
                    <div class="py-4 mt-2">
                      <a href="{{ route('projectsmanager.index') }}">
                      <button class="btn btn-xs text-xs text-gray-200 btn-info p-1">
                      Back to Home </button>
                      </a>
                    </div>
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
							  Form-D Info
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
								<label class="block text-pink-200 text-sm font-normal mt-3 mb-2" for="end date">

								</label>
                <table id="userIndex2" class="table table-bordered table-hover">
									<tbody>
                    @if(count($formd) > 0)
                      <tr>
                        <td class="text-wrap text-center text-sm"> Date </td>
                        <td class="text-wrap text-center text-sm"> No. of animals acquired (specify species, sex and age) </td>
                        <td class="text-wrap text-center text-sm"> Name, Address and Registration No. of the Breeder from whom acquired with voucher, Bill No.
                        fromAddress</td>
                        <td class="text-wrap text-center text-sm"> 
                        Date and IAEC Approval Number</td>
                        <td class="text-wrap text-center text-sm"> 
                        Duration of Expt and Expt. Description </td>
                        
                        <td class="text-wrap text-center text-sm"> 
                        Name and address of the person authorized to conduct the Experiment</td>
                        <td class="text-wrap text-center text-sm"> 
                        Signature of the investigatory certifying that all conditions 
                        specified for such an experiment have been complied</td>
                      </tr>
											
												@foreach($formd as $val)
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-wrap text-center text-sm">
														{{ $val->entry_date}}
                          </td>
                          <td class="text-wrap text-center text-sm">
                            {{ $val->req_anim_number }}, {{ $val->species_name}},
														{{ $val->strain_name }}, {{$val->sex }}, {{ $val->age." ".$val->ageunit}}
                          </td>
                          <td class="text-wrap text-center text-sm">
                            {{ $val->breeder_add }}
                          </td>
                          <td class="text-wrap text-center text-sm">
                            {{ $val->approval_date }}
                          </td>
                          <td class="text-wrap text-center text-sm">
                          {{ $val->duration }} weeks; {{ $val->expt_desc }}
                          </td>
                          <td class="text-wrap text-center text-sm">
														{{ $val->authorized_person }}, NCCS, Pune-411007
                          </td>
                          <td class="text-wrap text-center text-sm">
														 Auto Signed
                          </td>
                        </tr>
												@endforeach
											@else
												<tr class="text-wrap text-center text-sm">
                          <td class="text-wrap text-center text-sm">
														Form-D Entries Not Found.
                          </td>
												</tr>
											@endif
									</tbody>
								</table>
                  
									
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
        
        </div>


        <div class="row">
          <section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Cost as on {{ date('d-m-Y') }}
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
									<table id="userIndex2" class="table table-bordered table-hover">
                    @if(!empty($cageCost))
											<thead>
												<tr bgcolor="#BBDEFB">												
													<th style="text-align:center;">
                          Cage ID
                          </th>
													<th>Project ID</th>
                          <th>From</th>
													<th>To*</th>
													<th>Days</th>
													<th>Price</th>
                          <th>Cost*</th>
												</tr>
											</thead>
											<tbody>
                        @foreach($cageCost as $val)
                          <tr bgcolor="#E1BEE7"   data-entry-id="">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        @endforeach
											</tbody>
                    @else
                      No Information to display
                    @endif
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
    <!-- / End of Left Panel Graph Card-->
	</div>
@endsection('content')