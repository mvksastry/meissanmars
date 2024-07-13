@extends('layouts.app')
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Dashboard: Principal Investigator</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
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
					@include('layouts.home.manager.flexMenuManager')
				@endhasrole

          <!-- Main content -->
          <section class="content">

            <!-- Default box -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Dashboard Principal Investigator</h3>

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
                <table id="userIndex2" class="table table-bordered table-hover">
											<thead>
												<tr bgcolor="#BBCEFB">												
													<th colspan="8"  style="text-align:center;">
                          Dashboard
                          </th>
												</tr>
											</thead>
											<tbody>
                        <tr>
                          <td colspan="8">
                          Projects
                          </td>
                        </tr>
												<tr bgcolor="#E1BEE7"   data-entry-id="">											
													<td style="text-align:left;">
                            Active
                          </td>
													<td>{{ $appProjects }}</td>
                          <td>Submitted</td>
													<td>                        
                          {{ $subProjects }}
                          </td>
													<td>Amended</td>
													<td>
                          {{ $amendProjects }}
                            </td>
                            <td>Expired</td>
													<td>
                          {{ $expiredProjects }}
                            </td>
												</tr>
                        <tr>
                          <td colspan="8">
                          Usage Requests
                          </td>
                        </tr>
                        <tr bgcolor="#E1BEE7"   data-entry-id="">
                          <td>Submitted</td>
                          <td>{{ $submittedIssues }}</td>
                          <td>Confirmed</td>
                          <td>{{ $confirmedIssues }}</td>
                          <td>Approved</td>
                          <td>{{ $approvedIssues }}</td>
                          <td>Issued</td>
                          <td>{{ $issuedIssues }}</td>
                        </tr>

                        
                        <tr>
                          <td colspan="8">
                            Tasks
                          </td>
                        </tr>
                        <tr bgcolor="#E1BEE7"   data-entry-id="">
                          <td></td>
                          <td></td>
                          <td>Personal Tasks</td>
                          <td>{{ $personalTasks }}</td>
                          <td>Group Tasks</td>
                          <td>{{ $groupTasks }}</td>
                          <td></td>
                          <td></td>
                        </tr>																	
											</tbody>
										</table>                  
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.content -->
          
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-7 connectedSortable">
						<!-- TO DO List -->
            @include('layouts.dashToDoList')
						<!-- /.card -->
					</section>
					<!-- /.Left col -->

					<!-- right col (We are only adding the ID to make the widgets sortable)-->          
          <section class="col-lg-5 connectedSortable">
            @include('layouts.dashCalander')
						<!-- /.card -->
					</section>
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
	</div>
@endsection('content')





