<div class="w-full md:w-2/3 p-1">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-1">
			<h6 class="font-bold uppercase text-gray-600">Select Search Parameters</h6>
		</div>

		<div class="p-2">
			<table class="text-xs">
				<tr>
					<td>
						Species Name:
					</td>
					<td>
						<input wire:model.lazy="species_name" disabled type="text" value="{{ $species_name }}" >
					</td>
				</tr>
				<tr>
					<td>
						Search For:
					</td>
					<td>
						<?php if(empty($searchFor)){ $searchFor = "Mice"; } ?>
						<input wire:model.lazy="searchFor" disabled type="text" value="{{ $searchFor }}" >
					</td>
				</tr>

				<tr>
					<td>
						{{ $species_name }} ID:
					</td>
					<td>
						<select wire:model.lazy="mouseId_contains" name="mouseId_contains" id="mouseId_contains" >
							<option value="contains">Contains</option>
							<option value="equals">Equals</option>
						</select>
						<input wire:model.lazy="mouse_id" type="text" name="mouse_id" id="mouse_id" placeholder="{{ $species_name }} ID *">
					</td>
				</tr>

				<tr>
					<td>
						Strain:
					</td>
					<td>
						<select wire:model.lazy="_strain_key" name="_strain_key" id="_strain_key">
							<option value=""></option>
								@foreach($strains as $item)
									<option value="{{ $item->_strain_key }}">{{ $item->strainName." : ".$item->jrNum }}</option>
								@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<td>
						Life Status
					</td>
					<td>
						<select wire:model.lazy="lifeStatus" name="lifeStatus" id="lifeStatus">
							@foreach($lifestatus as $item)
							<option value="{{ $item->lifeStatus }}">{{ $item->lifeStatus. " : ".$item->description }}</option>
							@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<td>
						Cage ID
					</td>
					<td>
						<select wire:model.lazy="cageIdParam" name="cageIdParam" id="cageIdParam">
							<option value="equals">Equals</option>
							<option value="greaterthan">Greater Than</option>
							<option value="lessthan">Less Than</option>
						</select>
						<input wire:model.lazy="cage_id" type="text" name="cage_id" id="cage_id" value="1" placeholder="Cage ID" >
					</td>
				</tr>

				<tr>
					<td>
						Sex
					</td>
					<td>
						<input wire:model.lazy="_sex_key" type="radio" name="_sex_key" id="_sex_key" value="M"> Male
						<input wire:model.lazy="_sex_key" type="radio" name="_sex_key" id="_sex_key" value="F"> Female
						<input wire:model.lazy="_sex_key" type="radio" name="_sex_key" id="_sex_key" value="U"> Unknown
					</td>
				</tr>

				<tr>
					<td>
						Date of Birth
					</td>
					<td>
						<input wire:model.lazy="dobfrom" id="dobfrom" name="dobfrom" type="text"/>
						<label class="px-2">
						To
					</label>
						<input wire:model.lazy="dobto" id="dobto" name="dobto" type="text"/>
					</td>
			 	</tr>

			 	<tr>
					<td>
				 		Owner / Workgroup
					</td>
					<td>
						<select wire:model.lazy="_owner_key" name="_owner_key" id="_owner_key">
							@foreach($owners as $item)
							<option value="{{ $item->owner }}">{{ $item->owner }}</option>
							@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<button wire:click="pullDetails()" class="btn btn-info rounded">Pull Entries</button>
					</td.
				</tr>

			</table>
		</div>
	</div>
</div>
