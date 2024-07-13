  <!-- Small boxes (Stat box) -->
  <div class="row">
    
    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h4>{{ $employee_count }}</h4>
          <p>Employees</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('employees.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
   
    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <!-- h3><sup style="font-size: 20px">{{ $project_count }}</sup></h3 -->
          <h4>{{ $project_count }}</h4>
          <p>Active Projects</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('projects.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    
    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h4>KB</h4>
          <p>Kanban Board</p>
        </div>
        <div class="icon">
          <i class="ion ion-card"></i>
        </div>
        <a href="{{ route('kanban.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    
    <!-- ./col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h4>{{ count($communications) }}</h4>
          <p>Communications</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-email-outline"></i>
        </div>
        <a href="{{ route('iocomms.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

  <!-- .col -->
  <div class="col-lg-2 col-6">
    <!-- small box -->
    <div class="small-box bg-secondary">
      <div class="inner">
        <h4> Upcoming </h4>
        <p>Not Coded</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-options"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

  <!-- .col -->
  <div class="col-lg-2 col-6">
    <!-- small box -->
    <div class="small-box bg-secondary">
      <div class="inner">
        <h4> Upcoming </h4>
        <p>Not Coded</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-options"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  </div> <!-- /.Small boxes end -->
  <!-- /.row -->