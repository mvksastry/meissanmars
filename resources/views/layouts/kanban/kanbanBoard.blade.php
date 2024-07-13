@extends('layouts.app')
@section('content')
<script>
    var dataKboards = '<?=$kb?>';
    var dataKcards  = '<?=$kc?>';
</script>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Kanban: Office</h1>
          </div>
          <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kanban Board</li>
            </ol>
          </div>
        </div>
        <!-- / end header -->
      	
      </div>
    </section>

		<section class="content">
			<div class="container-fluid">
        @include('layouts.kanban.flexMenuKanban')
        <section class="content">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                  Boards
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
                </ul>
              </div>
            </div><!-- /.card-header -->
   
            <div class="row">
            
              <div class="col-sm-3">
                <div class="card card-row card-warning ml-3">
                  <div class="card-header">
                    <h3 class="card-title">Backlog</h3>
                  </div>
                  <div class="dropzone" id="yellow">
                    <div class="kanbanCard yellow" draggable="true">
                      <div class="mt-3">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-3">              
                <div class="card card-row card-success">
                  <div class="card-header">
                    <h3 class="card-title">To Do</h3>
                  </div>
                  <div class="dropzone" id="green">
                    <div class="kanbanCard green" draggable="true">
                      <div class="mt-3"></div>
                    </div>  
                  </div>
                </div>
              </div>

              <div class="col-sm-3">              
                <div class="card card-row card-info">
                  <div class="card-header">
                    <h3 class="card-title">In Progress</h3>
                  </div>
                    <div class="dropzone" id="blue">
                      <div class="kanbanCard blue" draggable="true">
                        <div class="mt-3"></div>
                      </div>  
                    </div>
                </div>
              </div>

              <div class="col-sm-3">              
                <div class="card card-row card-danger mr-3">
                  <div class="card-header">
                    <h3 class="card-title">Done</h3>
                  </div>
                  <div class="dropzone" id="red">
                    <div class="kanbanCard red" draggable="true">
                      <div class="mt-3"></div>
                    </div>
                  </div>
                </div> 
              </div>

            </div>
            
          </div> 
        </section>        
      </div>
    </section>

	</div>	
@endsection('content')