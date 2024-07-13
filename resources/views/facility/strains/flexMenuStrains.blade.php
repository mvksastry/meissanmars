  <!-- Small boxes (Stat box) -->
  <div class="row">
    
    <!-- .col -->
    <div class="col-lg-4 col-12">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h4>ADD STRAIN</h4>
          <p>Total Active: {{ count($strains) }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('strains.create') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

    <!-- .col -->
    <div class="col-lg-4 col-12">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <!-- h3><sup style="font-size: 20px"></sup></h3 -->
          <h4>UPDATE STATUS</h4>
          <p>Total Active: {{ count($strains) }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('strains.changestatus') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>   
    <!-- ./col -->   
    
    <!-- .col -->
    <div class="col-lg-4 col-12">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <!-- h3><sup style="font-size: 20px"></sup></h3 -->
          <h4>PER-DIEM-COST</h4>
          <p>Home</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('billing.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    

    
  </div> <!-- /.Small boxes end -->
  <!-- /.row -->