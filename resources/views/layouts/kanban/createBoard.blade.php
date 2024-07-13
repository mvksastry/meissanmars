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
						<h1 class="m-0">Create Board</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Create Event</li>
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
								  New Board
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
											<form method="POST" action="{{ route('kanban-boards.store') }}">
												@csrf

                        <div class="container">
                          <div class="row align-items-start">	
                          
                              <div class="form-group col">
                                {!! Form::label('board_name', 'Board Name*', ['class' => 'control-label']) !!}
                                {!! Form::text('board_name', old('board_name'), ['class' => 'form-control']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('board_name'))
                                  <p class="help-block">
                                    {{ $errors->first('board_name') }}
                                  </p>
                                @endif
                              </div>

                              <div class="form-group col">
                                {!! Form::label('color', 'Board Color*', ['class' => 'control-label']) !!}
                                <select class="custom-select form-control rounded-1" 
                                  name="color" id="color">
                                  @foreach($colors as $color)
                                  <option value="{{ $color }}"> >{{ ucfirst($color) }}</option>
                                  @endforeach
                                
                                </select>
                                <p class="help-block"></p>
                                @if($errors->has('color'))
                                  <p class="help-block">
                                    {{ $errors->first('color') }}
                                  </p>
                                @endif
                              </div>                 
                            
                          </div>
                        </div>

                        <div class="container">
                          <div class="row align-items-start">	
                          


                              <div class="form-group col">
                                {!! Form::label('budget_head', 'Description*', ['class' => 'control-label']) !!}
                                {!! Form::text('description', old('description'), ['class' => 'form-control']) !!}
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

