@extends('layouts.app')
@section('content')

	<div class="content-wrapper">
	

		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Edit Role</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
							<li class="breadcrumb-item active">Edit Role</li>
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
								  Edit Role
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
										<div class="card-header">
											<h3 class="card-title">All Inputs Mandatory</h3>
										</div>
										
										<!-- /.card-header -->
										<div class="card-body">
											<form method="POST" action="{{ route('roles.update', $role->id) }}">
												@csrf
                        @method('PUT')

												<div class="form-group">
												  <label for="exampleInputBorderWidth2">Name</label>
												  <input type="text" class="form-control form-control-border" 
												  name="name" id="name" value="{{ $role->name }}">
												</div>
												@if($errors->has('name'))
													<p class="help-block text-danger">
														{{ $errors->first('name') }}
													</p>
												@endif
                    
												<label for="role" class="col-form-label">Permissions</label>
												<select class="custom-select form-control rounded-1" multiple="multiple" 
                        name="permissions[]" id="permissions[]">
													@foreach($permissions as $key => $val)
													<option value="{{ $key }}">{{ ucfirst($val) }}</option>
													@endforeach
												</select>
												@if($errors->has('permissions'))
													<p class="help-block text-danger">
														{{ $errors->first('permissions') }}
													</p>
												@endif
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
       
<script>
  $(document).ready(function() {
      // Select2 Multiple
      $('.select2-multiple').select2({
          placeholder: "Select",
          allowClear: true
      });
  });
</script>