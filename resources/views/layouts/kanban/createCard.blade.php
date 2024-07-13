@extends('layouts.app')
@section('content')

	<?php 
		$condChoice = array("1" => "Open", "2" => "Invitees Only", "3"=>"Group Only", "4"=>"Meeting");
		$condChoiceSel = 1;
		
	?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Create Card</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Create Card</li>
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
								  New Card
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
											<form method="POST" action="{{ route('kanban-cards.store') }}">
												@csrf

                        <div class="container">
                          <div class="row align-items-start">	
                          
                              <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Uuid*</label>
                                <input hidden type="text" name="todo_id" id="todo_id" 
                                  class="form-control" value="{{ $todo }}">
 
                                  <p class="help-block"></p>
                              
                              </div>                 
                            
                          </div>
                        </div>

                        <div class="container">
                          <div class="row align-items-start">	
                            <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Card Name*</label>
                                <input type="text" name="card_name" id="card_name" 
                                  class="form-control" value="">
                                
                                <p class="help-block"></p>
                                @if($errors->has('board_name'))
                                  <p class="help-block">
                                    {{ $errors->first('board_name') }}
                                  </p>
                                @endif
                            </div>
                          </div>
                        </div>


                        <div class="container">
                          <div class="row align-items-start">	
                            <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Description*</label>
                                <input type="text" value="{{ old('description') }}"name="description" id="description" 
                                  class="form-control">  
                                <p class="help-block"></p>
                                @if($errors->has('description'))
                                  <p class="help-block">
                                    {{ $errors->first('description') }}
                                  </p>
                                @endif
                              </div>                   
                            
                          </div>
                        </div>

												<div class="card-footer">
													<button type="submit" class="btn btn-primary">Submit</button>
												</div>

											</form>
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

