  <!-- Small boxes (Stat box) -->
  <div class="row">
    
    <!-- .col -->
    <div class="col-lg-6 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h4>REAGENT</h4>
          <p>New</p>
        </div>
        <div class="icon">
          <i style="color:red" wire:click="newReagentForm()" class="ion ion-bag"></i>
        </div>
        <a href="#" wire:click.prevent="newReagentForm()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
 
    <!-- .col -->
    <div class="col-lg-6 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h4>REAGENT</h4>
          <p>New</p>
        </div>
        <div class="icon">
          <i style="color:blue" wire:click="remakeReagentForm()" class="ion ion-bag"></i>
        </div>
        <a href="#" wire:click.prevent="remakeReagentForm()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    
  <!-- ./col -->
  </div> <!-- /.Small boxes end -->
  <!-- /.row -->