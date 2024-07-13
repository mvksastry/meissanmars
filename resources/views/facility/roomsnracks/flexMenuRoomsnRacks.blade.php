  <!-- Small boxes (Stat box) -->
  <div class="row">
    
    <!-- .col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h4>BUILDINGS</h4>
          <p>Total: {{ count($buildings) }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('building.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
   
    <!-- .col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <!-- h3><sup style="font-size: 20px"></sup></h3 -->
          <h4>FLOORS</h4>
          <p>Total: {{ count($floors) }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('floor.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    
    <!-- .col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h4>ROOMS</h4>
          <p>Total: {{ count($rooms) }} </p>
        </div>
        <div class="icon">
          <i class="ion ion-card"></i>
        </div>
        <a href="{{ route('room.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h4>RACKS</h4>
          <p>Total: {{ count($racks) }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-email-outline"></i>
        </div>
        <a href="{{ route('rack.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div> <!-- /.Small boxes end -->
  <!-- /.row -->