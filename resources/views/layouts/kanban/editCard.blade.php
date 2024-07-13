@extends('layouts.app')
@section('content')
	<?php 
		$colors = array( 
			"blue"  => "In-Progress",  "green" => "To Do",  "red" => "Done", "yellow"  => "Backlog"
			);
	?>
  
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Kanban: Edit Card</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Edit Card</li>
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
							  Edit Kanban Card
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
                    <form method="POST" action="{{ route('kanban-cards.update', $kcard->kbocard_id) }}">
                      
												@csrf
                        @method('PUT')
                        
                        <div class="container">
                          <div class="row align-items-start">
                          
                            <div class="form-group col">
                              <label for="exampleInputBorderWidth2">Name*</label>
              
            <input type="text" name="item_name" id="item_name" 
            value="{{ $kcard->item_name }}" class="form-control" value="">
                              @if($errors->has('item_name'))
                                <p class="help-block text-danger">
                                  {{ $errors->first('item_name') }}
                                </p>
                              @endif
                            </div>

                              <div class="form-group col">
                                
<label for="exampleInputBorderWidth2">Color*</label>

                                <select class="custom-select form-control rounded-1" 
                                      name="color" id="color">
                                  @foreach($colors as $key => $value)
                                  <option value="{{ $key }}"
                                    @if($kcard->color == $value)
                                      selected="selected"
                                    @endif
                                    >{{ ucfirst($value) }}</option>
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
                                
                                <label for="exampleInputBorderWidth2">Description*</label>
<input type="text" name="item_desc" id="item_desc" 
            value="{{ $kcard->item_desc }}" class="form-control" value="">
                                <p class="help-block"></p>
                                @if($errors->has('item_desc'))
                                  <p class="help-block">
                                    {{ $errors->first('item_desc') }}
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