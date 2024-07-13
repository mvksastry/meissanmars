<div class="w-1/2 md-1/2 p-1">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		
		<div class="p-2">
			<table class="w-full p-1 text-xs text-gray-800">

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
							<input wire:model.lazy="cageChars" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" type="text" name="cageChars" id="cageChars" >
							<input wire:model.lazy="nextCageId" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" value="true" type="checkbox" checked name="nextCageId" id="nextCageId" > Use Next ID
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
                <option value="2">Active</option>
                <option value="3">Proposed</option>
                <option value="4">Retired</option>
              </select>
						</td>
					</tr>

					<tr>
						<td class="p-1">
							Date
						</td>
						<td class="p-1">
							<input wire:model.lazy="datex" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" type="text" name="datex" id="datex">
						</td>
					</tr>

					<tr>
						<td class="p-1">
							Room
						</td>
						<td class="p-1">
							<select wire:model.lazy="cageRooms" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" name="cageRooms" id="cageRooms">
                <option value="-1"></option>
                  @foreach($rooms as $item)
                    <option value="{{ $item->room_id }}">{{ $item->room_name }}</option>
                  @endforeach
              </select>
            </td >
					</tr>

					<tr>
						<td class="p-1">
							Comments
						</td>
						<td class="p-1">
							<textarea wire:model.lazy="cageComment" rows="3"></textarea>
						</td>
          </tr>

					<tr>
						<td colspan="2">
							<div id="Message">
								{{ $cageCreateMessage }}
							</div>
						</td>
					</tr>
					<tr>
						<td class="p-1">
							<button wire:click="addNewCage()" class="btn btn-primary rounded">Add Cage</button>
						</td>
						<td class="p-1">
							<button wire:click="closeNewCage()" class="btn btn-primary rounded">Close</button>
						</td>
          </tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
