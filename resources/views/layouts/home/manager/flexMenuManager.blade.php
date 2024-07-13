  <!-- Small boxes (Stat box) -->
  <div class="row">
    
    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h5>PROJECTS</h5>
          <p>Act: {{count($activeProjects) }}  Sub: {{count($subProjects) }} </p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('projectsmanager.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
   
    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <!-- h3><sup style="font-size: 20px"></sup></h3 -->
          <h5>USAGE</h5>
          <p>App: {{$appUsage }} Pend: {{$penUsage }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('usageapprovals.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    
    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h5>KANBAN</h5>
          <p>Boards</p>
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
          <h5>I O COMMS</h5>
          <p>New: </p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-email-outline"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h5>FACILITY</h5>
          <p>Enter</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-options"></i>
          </div>
          <a href="{{ route('facility.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

  <!-- .col -->
  <div class="col-lg-2 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h5>USERS</h5>
        <p>{{ $users }}</p>
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