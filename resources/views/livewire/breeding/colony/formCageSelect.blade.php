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
							Cage ID*
            </td>
            <td class="p-1">
							<select wire:model.lazy="cageParams" name="paramcage" id="paramcage" multiple>
                <option value="-1"></option>
                <option value="equals">Equals</option>
                <option value="greater than">Greater than</option>
                <option value="less than">Less than</option>
              </select>
							<input wire:model.lazy="cageChars" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" type="text" name="cageChars" id="cageChars" >
						</td>
					</tr>
					<tr>
						<td class="p-1">
							Cage Name
						</td>
						<td class="p-1">
							<input wire:model.lazy="cageName" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" type="text" name="cageName" id="cageName" >
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
						<td class="p-1">
							Room
						</td>
						<td class="p-1">
							<select wire:model.lazy="cageRooms" name="cageRooms" id="cageRooms">
                <option value="-1"></option>
                  @foreach($rooms as $item)
                    <option value="{{ $item->room_id }}">{{ $item->room_name }}</option>
                  @endforeach
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
