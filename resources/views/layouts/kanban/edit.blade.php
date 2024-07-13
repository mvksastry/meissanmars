@extends('layouts.app')
@section('content')
	<?php 
    $decision = array("1"=> "None", "2" => "Pending", "3" => "Returned", "4"=> "Rejected", "5"=> "Approved");
    $eventchoiceSel = 1;
    $openclose = array("open" => "Open to all", "close" => "Invitees only");
    $opencloseSel = "open";
  ?>
	<?php 
		$condChoice = array("1" => "Open", "2" => "Invitees Only", "3"=>"Group Only", "4"=>"Meeting");
		$condChoiceSel = 1;
		$colors = array( 
			"1"  => "blue",  "2" => "green",  "3" => "purple",  "4" => "red", "5"  => "yellow"
			);
	?>
  
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Kanban: Edit</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Edit</li>
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
							  Edit Kanban Board
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


										<div class="card-body">
                      {!! Form::model($kboard, ['method' => 'PUT', 'route' => ['kanban-boards.update', $kboard->uuid]]) !!}
												@csrf
                        @method('PUT')
                        
                        <div class="container">
                          <div class="row align-items-start">
                          
                            <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Name*</label>
                              {!! Form::text('name', $kboard->name, ['class' => 'form-control']) !!}

                              @if($errors->has('name'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('name') }}
                                </p>
                              @endif
                            </div>

                              <div class="form-group col">
                                {!! Form::label('color', 'color*', ['class' => 'control-label']) !!}
                                <select class="custom-select form-control rounded-1" 
                                      name="color" id="color">
                                  @foreach($colors as $color)
                                  <option value="{{ $color }}"
                                    @if($kboard->color == $color)
                                      selected="selected"
                                    @endif
                                    >{{ ucfirst($color) }}</option>
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