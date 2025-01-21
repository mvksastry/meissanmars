<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Colony: Review</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Colony</a></li>
							<li class="breadcrumb-item active">Review</li>
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
					@include('livewire.breeding.colony.flexMenuColonyReview')
				@endhasrole
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
						<!-- Custom tabs (Charts with tabs)-->
						  <div class="card-body">
							<div class="tab-content p-0">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
									<livewire:breeding.colony.mouse-entries /> 
								</div>
							</div>
						  </div><!-- /.card-body -->
						<!-- /.card -->
						<!-- /.card -->
        </div>
      </div>
    </section>
		<!-- Main content -->
    <!-- / End of Left Panel Graph Card-->
  </div>
</div>

