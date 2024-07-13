  <!-- Small boxes (Stat box) -->
  <div class="row">
    
      <!-- .col -->
      <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h5>STRAINS</h5>
            <p>F: {{$freeStrains}}; P: {{$ownerStrains}}</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route('strains.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
     
      <!-- .col -->
      <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <!-- h3><sup style="font-size: 20px"></sup></h3 -->
            <h5>R & R</h5>
            <p>Room: {{$rooms}}; Rack: {{$racks}}</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ route('roomsnracks.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <!-- .col -->
      <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h5>OCCUPANCY</h5>
            <p>Enter</p>
          </div>
          <div class="icon">
            <i class="ion ion-card"></i>
          </div>
          <a href="/occupancy" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <!-- ./col -->
      <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h5>ALLOTTMENT</h5>
            <p>Enter</p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-email-outline"></i>
          </div>
          <a href="/comp-allot" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h5>INFRAS</h5>
          <p>Infras: {{$totInfraItems}}</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-options"></i>
          </div>
          <a href="{{ route('infrastructure.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

    <!-- .col -->
    <div class="col-lg-2 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h5>MAINT'ANCE</h5>
          <p>Items:</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-options"></i>
          </div>
          <a href="{{ route('maintenance.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div> <!-- /.Small boxes end -->
  <!-- /.row -->