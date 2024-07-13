  <div class="p-2">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-3">
        <div class="py-2 inline-block mx-auto w-full sm:px-6 lg:px-8">
          <div class="overflow-hidden">
            <input hidden type="text" id="rackid" name="rackid" value="{{ $rack_id }}" readonly>
            <table class="w-3/4 table-auto  mx-auto whitespace-nowrap">
              <thead class="bg-white border-b">
                <tr class="border-b bg-green-200 border-gray-200">
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-center rounded-lg">
                    Rack: {{ ucfirst($rack_name) }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-gray-100 border-b">
                  <td class="text-sm text-gray-600 text-center font-light px-6 py-2 whitespace-nowrap">
                    (Drag & Drop the Cage Number to desired location & Update)
                  </td>
                </tr>
                <tr class="border-b">
                  <td class="text-lg text-center">
                  {{ $cageReorgMsg }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>

  <?php
    //echo $image_id; echo BR;
    $slotNo = 0; $xslotNo=0;
    $seatNo = 0; $xseatNo = 0;
    $row_limit = $rows;
    $col_limit = $cols;
    $shelf = 1;
    
    foreach($groups as $group)
    {
      $group_id = $group['id'];
      $group_name = $group["name"];
    }
    
  ?>
    
    <div wire:sortable-group="updateTaskOrder()" style="display: flex">      
      <div class="table table-bordered">
        @for($k = 0; $k < $levels; $k++)
          @for($i = 0; $i < $row_limit; $i++)
            <ul wire:sortable-group.item-group="{{ $k+1 }}"  class="list-group list-group-horizontal">
              <li class="list-group-item">Shelf #{{ $k+1 }}</li> 
                @for($j = 0; $j < $col_limit; $j++)
                  <?php 
                    $xseatNo = $j + $xslotNo;          
                    $xrow = $rack_info[$xseatNo]; 
                    if( $xrow['status'] == "O")
                    {
                      $cage_id = $xrow['cage_id'];
                    }else {
                      $cage_id = "A";
                    }
                  ?>                                         
                    <li wire:key="task-{{ $xrow['slot_id'] }}" wire:sortable-group.item="{{ $xrow['slot_id'] }}_{{ $cage_id }}" class="boarder list-group-item">
                      @if($cage_id != "A")
                      <span wire:click="markCages('{{ $xrow['cage_id'] }}')" >
                      <button class="z-n2 btn btn-block btn-success" type="button" wire:sortable-group.handle
                        data-toggle="tooltip" title="Cage ID {{ $cage_id }}" data-placement="top">
                          <?php echo sprintf("%04d", $xrow['cage_id'] ); ?>
                        </button>
                      </span>
                      @else
                        <span wire:click="markCages('{{ $xrow['cage_id'] }}')">
                        <button class="z-n2 btn btn-block btn-warning" type="button" wire:sortable-group.handle
                        data-toggle="tooltip" title="Slot ID {{ $xseatNo + 1 }}" data-placement="top">
                          <?php echo sprintf("%04d", $xrow['cage_id'] ); ?>
                        </button>
                        </span>
                      @endif
                    </li>                        
                @endfor
            </ul>
            <?php $xslotNo = $xslotNo +  $col_limit; ?>
          @endfor
          </br>
        @endfor
      </div> 
    </div>    
     
  </br>
  </br>
  <div id="reorgmsg" class="" align="center">
  {{ $cageReorgMsg }}
  </div>
	<div id="test" class="block text-pink-200 text-sm font-normal mb-2" align="center">                       
    <button  wire:click="updateCageLocationsOrder()" type="button" class="btn btn-block btn-primary btn-lg" id="postreorg">
      Update Cage Locations
    </button>
	</div>
  </br>
  </br>
        
>
    
