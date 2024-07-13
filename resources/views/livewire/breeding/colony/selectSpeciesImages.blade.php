<div class="card-body">
  <div class="tab-content p-0">
  <!-- Morris chart - Sales -->
    <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">                   
      <div class="p-2">
        <button wire:click="show({{ 1 }})">  
          <img class="species_id m-1" id ="MC" name="MC" src="{{ asset('/storage/colony/mouse.png') }}" alt="" width="55px" height="55px">
        </button>
        <button wire:click="show({{ 4 }})">
          <img class="species_id m-1" id ="RT" name="RT" src="{{ asset('/storage/colony/rat.png') }}" alt="" width="55px" height="55px">
        </button> 
        <button wire:click="show({{ 3 }})">
          <img class="species_id m-1" id ="RB" name="RB" src="{{ asset('/storage/colony/rabbit.png') }}" alt="" width="55px" height="55px">
        </button>
        <button wire:click="show({{ 5 }})">
          <img class="species_id m-1" id ="GP" name="GP" src="{{ asset('/storage/colony/gpig.png') }}" alt="" width="55px" height="55px">
        </button>
      </div>         
    </div>
  </div>
</div><!-- /.card-body -->