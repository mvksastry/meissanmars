@extends('layouts.app')
@section('content')

	<?php 
		$condChoice = array("1" => "Open", "2" => "Invitees Only", "3"=>"Group Only", "4"=>"Meeting");
		$condChoiceSel = 1;
		
		$timespan = array( 
			"1"  => "06:00",  "2" => "06:30",  "3" => "07:00",  "4" => "07:30", "5"  => "08:00",
			"6"  => "08:30",  "7" => "06:00",  "8" => "06:30",  "9" => "07:00", "10" => "07:30",
			"11" => "08:00", "12" => "08:30",	"13" => "09:00", "14" => "09:30", "15" => "10:00", 
			"16" => "10:30", "17" => "11:00",	"18" => "11:30", "19" => "12:00", "20" => "12:30", 
			"21" => "13:00", "22" => "13:30",	"23" => "14:00", "24" => "14:30",	"25" => "15:00", 
      "26" => "15:30", "27" => "16:00", "28" => "16:30", "29" => "17:00", "30" => "15:30",
			"31" => "17:00", "32" => "18:30", "33" => "19:00", "34" => "19:30", "35" => "20:00",
      "36" => "20:30"
			);
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
								  New Event
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
                              <label for="exampleInputBorderWidth2">Board Name*</label>
                              @if($errors->has('event_type'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('event_type') }}
                                </p>
                              @endif
                            </div>

                            <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Event Type*</label>
                              @if($errors->has('conditions'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('conditions') }}
                                </p>
                              @endif
                            </div>
                            
                          </div>
                        </div>


                        <div class="container">
                          <div class="row align-items-start">	
                          
                            <div class="form-group col">
                              {!! Form::label('journey_class', 'Start Date*', ['class' => 'control-label']) !!}
                              {!! Form::date('start_date', old('start_date'), ['class' => 'form-control', 'placeholder' => 'Class of Journey', 'required' => '']) !!}
                              <p class="help-block"></p>
                              @if($errors->has('start_date'))
                                <p class="help-block">
                                  {{ $errors->first('start_date') }}
                                </p>
                              @endif
                            </div>         
                            
                            <div class="form-group col">
                              {!! Form::label('journey_mode', 'Start Time*', ['class' => 'control-label']) !!}
                              {!! Form::select('start_time', $timespan, $timespan, ['class' => 'form-control']) !!}
                              <p class="help-block"></p>
                              @if($errors->has('start_time'))
                                <p class="help-block">
                                  {{ $errors->first('start_time') }}
                                </p>
                              @endif
                            </div>

                            <div class="form-group col">
                              {!! Form::label('budget_head', 'End Date*', ['class' => 'control-label']) !!}
                              {!! Form::date('end_date', old('end_date'), ['class' => 'form-control']) !!}
                              <p class="help-block"></p>
                              @if($errors->has('end_date'))
                                <p class="help-block">
                                  {{ $errors->first('end_date') }}
                                </p>
                              @endif
                            </div>
                            
                            <div class="form-group col">
                              {!! Form::label('tada_advance', 'End Time', ['class' => 'control-label']) !!}
                              {!! Form::select('end_time', $timespan, $timespan, ['class' => 'form-control']) !!}
                              <p class="help-block"></p>
                              @if($errors->has('end_time'))
                                <p class="help-block">
                                  {{ $errors->first('end_time') }}
                                </p>
                              @endif
                            </div>

                           </div>
                        </div>  

                        <div class="container">
                          <div class="row align-items-start">	
                          
                              <div class="form-group col">
                                {!! Form::label('budget_head', 'Venue*', ['class' => 'control-label']) !!}
                                {!! Form::text('event_venue', old('event_venue'), ['class' => 'form-control']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('event_venue'))
                                  <p class="help-block">
                                    {{ $errors->first('event_venue') }}
                                  </p>
                                @endif
                              </div>

                              <div class="form-group col">
                                {!! Form::label('budget_head', 'Comment*', ['class' => 'control-label']) !!}
                                {!! Form::text('comment', old('comment'), ['class' => 'form-control']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('comment'))
                                  <p class="help-block">
                                    {{ $errors->first('comment') }}
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

