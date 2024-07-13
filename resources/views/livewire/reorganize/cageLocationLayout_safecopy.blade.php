  <div class="p-5">
    <div class="flex flex-col">
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
              </tbody>
            </table>
          </div>
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
  ?>

  <?php $index = 0; $stn=0; ?>
  <div wire:sortable="updateGroupOrder" wire:sortable-group="updateTaskOrder" style="display: flex">
    @foreach ($groups as $group)
      <div wire:key="group-{{ $group['id'] }}" wire:sortable.item="{{ $group['id'] }}">
        <div style="display: flex">
          <h5 wire:sortable.handle>{{ $group["name"] }}</h5>
        </div>


        @for($k = 0; $k < $levels; $k++)
          <?php $shelf = $k +1; ?>
          <table class="table table-bordered table-hover text-nowrap">
          </br>
            @for($i = 0; $i < $row_limit; $i++)
              <tr>
                <td>Shelf # {{ $shelf }} </td>
                @for($j = 0; $j < $col_limit; $j++)
                  <?php $xseatNo = $j + $xslotNo; ?>          
                  <?php $xrow = $rack_info[$xseatNo]; ?>                     
                  <td wire:sortable-group.item-group="{{ $group['id'] }}">
                    @if( $xrow['status'] == "O")
                      <div align="center">
                        <div wire:key="task-{{ $xrow['slot_id'] }}" wire:sortable-group.item="{{ $xrow['cage_id'] }}">
                          <button class="btn btn-block btn-success" type="button" wire:sortable-group.handle><?php echo sprintf("%04d", $xrow['cage_id'] ); ?></button>
                        </div>
                      </div>
                    @else 
                      <?php $xrow['cage_id'] = 0; ?>
                      <div align="center">
                        <div wire:key="task-{{ $xrow['slot_id'] }}" wire:sortable-group.item="{{ $xrow['cage_id'] }}">
                          <button class="btn btn-block btn-warning" type="button" wire:sortable-group.handle><?php echo sprintf("%04d", $xrow['cage_id'] ); ?></button>
                        </div>
                      </div>
                    @endif
                  </td>
                @endfor
              </tr>
              <?php $xslotNo = $xslotNo +  $col_limit; ?>
            @endfor
          </table>
        @endfor
      </div>
    @endforeach 
  </div>    
    



  
  
  
  
  
  
  
  
  
  
  
  
</br>
</br>
  <div id="reorgmsg" class="" align="center">
  </div>
	<div id="test" class="block text-pink-200 text-sm font-normal mb-2" align="center">
    <button  wire:click="updateTaskOrder()" type="button" class="btn btn-block btn-primary btn-lg" id="postreorg">
      Update Cage Locations
    </button>
	</div>
</br>
</br>
