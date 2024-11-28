<div class="w-1/3 md-2/3 p-1">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-600">Search Cage</h5>
		</div>
		<div class="p-2">
			<table class="w-full p-5 text-xs text-gray-800">
				<thead>
					<div id="iaMessage">
					</div>
				</thead>
				<tbody>
					<tr>
            <td class="p-1">
							Room*
            </td>
            <td class="p-1">
							<select wire:model.lazy="room_id" wire:change="roomSelected" name="room_id" id="room_id">
                <option value="-1"></option>
								@foreach($rooms as $val)
                <option value="{{ $val->room_id }}">{{ $val->room_name }}</option>
								@endforeach
              </select>
						</td>
					</tr>
					
					<tr>
						<td class="p-1">
						<font color="red">Rack*</font>
						</td>
						<td>
             	<select wire:model.lazy="rack_id" wire:change="rackSelected" name="rack_id" id="rack_id">
								<option value="0"></option>
								@if($showRacks)
               		@foreach($racksInRoom as $item)
                 		<option value="{{ $item->rack_id }}">{{ $item->rack_name }}</option>
               		@endforeach
								@endif
             	</select>
            </td>
					</tr>

					<tr>
						<td class="p-1">
							Cage Status
						</td>
						<td class="p-1">
							<select wire:model.lazy="cageStatus" name="cageStatus" id="cageStatus" multiple>
                <option value="-1"></option>
                <option value="active">Active</option>
                <option value="proposed">Proposed</option>
                <option value="retired">Retired</option>
              </select>
						</td>
					</tr>


					
					<tr>
						<td>
							<button wire:click="searchCage()" class="btn btn-primary rounded">Search</button>
						</td>
						<td>
							<button wire:click="closeSearchCage()" class="btn btn-primary rounded">Close</button>
						</td>
          </tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
