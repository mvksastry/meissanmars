@extends('layouts.app')
@section('content')
    	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Project Approval</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Approve Project</li>
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
                  Approve Project 
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
                    
                    
                    <form method="POST" action="{{ route('projectsmanager.update',$subProject->tempproject_id) }}">
                    @csrf
                    @method('PUT')
                    
                    <table id="userIndex2" class="table table-sm table-bordered table-hover">
                      <thead>
                        <tr bgcolor="#BBDEFB">												
                        </tr>
                      </thead>
                      <tbody>
                        <tr bgcolor="#E1BEE7"   data-entry-id="{{ $subProject->tempproject_id }}">
                          <td>ID</td>
                          <td>
                            <input class="form-control" id="tempproject_id" name="tempproject_id" value="{{ $subProject->tempproject_id }}" type="text" placeholder="Project Id" disabled>
                          </td>
                        </tr>
                        <tr>
                          <td>PI</td>
                          <td>{{ $subProject->user->name }}</td>
                        </tr>
                        <tr>                        
                          <td>Title</td>
                          <td>{{ $subProject->title }}</td> 
                        </tr>
                        <tr>
                          <td>Start Date</td>
                          <td>{{ date('d-m-Y', strtotime($subProject->start_date)) }}</td>
                        </tr>
                        <tr>
                          <td>End Date</td>
                          <td>{{ date('d-m-Y', strtotime($subProject->end_date)) }}</td>
                        </tr>
                      </tbody>
                    </table>                      
                  
                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">
                      <tbody>
                        <tr>
                          <td class="text-wrap text-center" colspan="7">Strains Requested
                          </td>
                        </tr>
                        <tr>
                          <td class="text-xs font-normal"> Strain </td>
                          <td class="text-xs font-normal"> Year 1 </td>
                          <td class="text-xs font-normal"> Year 2 </td>
                          <td class="text-xs font-normal"> Year 3 </td>
                          <td class="text-xs font-normal"> Year 4 </td>
                          <td class="text-xs font-normal"> Year 5 </td>
                          <td class="text-xs font-normal"> Total AY </td>
                        </tr>
                        @foreach($strainsPosted as $val)
                          <tr class="text-sm font-normal mt-3 mb-4">
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->strains->strain_name}}
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
                            <td class="text-xs mt-1 mb-1 font-normal">
                              {{ $val->year1 + $val->year2 + $val->year3 + $val->year4 + $val->year5 }}
                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan='7' class="text-xs text-left text-gray-200">
                          Strain Details: For all years  will be calculated based on species/strain/year wise through system</td>
                        </tr>
                        <tr>
                          <td colspan='7' class="text-xs text-left text-gray-200">End of Details</td>
                        </tr>
                      </tbody>
                    </table>

                    <table id="userIndex2" class="table table-sm table-bordered border-primary table-striped table-hover">

                      <tr>
                        <td class="text-wrap text-sm">Remarks</td>
                        <td class="text-wrap text-sm">{{ $subProject->notes }}</td>
                      </tr>

                      <tr>                     
                        <td class="text-wrap text-xs">Form-D Table</td>
                        <td class="text-wrap text-xs">
                          @if($subProject->formD != null) 
                            {{ $subProject->formD }}
                          @else 
                            Not Created 
                          @endif
                        </td>
                      </tr>  
                      
                      <tr>
                        <td class="text-wrap text-sm">View File</td>
                        <td class="text-wrap text-sm">								
                          <a href="{{ route('managerSubProject.download', $subProject->filename ) }}">
                            <button type="button" class="btn btn-sm btn-primary">
                            View Project File
                            </button>                                                   
                          </a>
                        </td>
                      </tr>
 
                      <tr>                     
                        <td class="text-wrap text-xs">IAEC Approval Ref</td>
                        <td class="text-wrap text-xs">
                        <input class="form-control form-control-border shadow border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" 
                          id="iaec_app_ref" name="iaec_app_ref" value="" type="text" placeholder="Approval Reference">
                          @if($errors->has('iaec_app_ref'))
                            <p class="help-block text-orange-200">
                              {{ $errors->first('iaec_app_ref') }}
                            </p>
                          @endif
                        </td>
                      </tr>
                      
                      <tr>                     
                        <td class="text-wrap text-xs">IAEC Comments</td>
                        <td class="text-wrap text-xs">
                        <input class="form-control form-control-border shadow border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" 
                          id="iaec_comments" name="iaec_comments" value="{{ $subProject->iaec_comments }}" type="text" placeholder="Remarks">
                          @if($errors->has('iaec_comments'))
                            <p class="help-block text-orange-200">
                              {{ $errors->first('iaec_comments') }}
                            </p>
                          @endif
                        </td>
                      </tr>
                      
                      <tr>                     
                        <td class="text-wrap text-xs">IAEC Meeting Date</td>
                        <td class="text-wrap text-xs">
                          <input class="form-control form-control-border shadow border rounded" 
                          id="iaec_date" name="iaec_date" type="date" placeholder="IAEC Approval Date: Y-m-d">
                          @if($errors->has('iaec_date'))
                            <p class="help-block text-orange-200">
                              {{ $errors->first('iaec_date') }}
                            </p>
                          @endif
                        </td>
                      </tr>

                      <tr>                     
                        <td class="text-wrap text-xs">IAEC Meeting Remarks</td>
                        <td class="text-wrap text-xs">
                          <input class="form-control form-control-border shadow rounded" 
                          id="iaec_meeting" name="iaec_meeting" type="text" placeholder="IAEC Meeting Information">
                          @if($errors->has('iaec_meeting'))
                            <p class="help-block text-orange-200">
                              {{ $errors->first('iaec_meeting') }}
                            </p>
                          @endif
                        </td>
                      </tr>                      
                      
                    <tr>                     
                        <td class="text-wrap text-xs">Project Decision</td>  
                        <td class="text-wrap text-sm">
                            <div class="form-group form-check">
                              <input class="form-check-input" value="1" id="iaec_decision" name="iaec_decision" type="radio">
                              <label class="form-check-label">Approved</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" value="0" id="iaec_decision" name="iaec_decision" type="radio">
                              <label class="form-check-label">Not Approved</label>
                            </div>             
                      </td>
                    </tr>  

                      <tr>
                        <td colspan='7' class="text-xs text-left text-gray-200" align="center">
                        <button type="submit" class="btn btn-xs text-sm text-gray-200 btn-info p-1">Submit</button>
                        </td>
                      </tr>

                      
                      <tr>
                        <td colspan='7' class="text-xs text-left text-gray-200">End of Details</td>
                      </tr>
                    </table>
                    
                  </form>  
                    
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
                    
					<!-- /.Left col -->
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
	</div>
@endsection('content')