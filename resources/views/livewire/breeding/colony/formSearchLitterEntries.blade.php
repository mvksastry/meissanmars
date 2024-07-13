
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase text-gray-600">Search Litter Entries</h5>
		</div>

		<div class="p-2">
			<table class="text-xs">
				<tr>
					<td>
						Species Name:
					</td>
					<td>
						<input wire:model.lazy="speciesName" disabled type="text" value="{{ $speciesName }}" >
					</td>
				</tr>

				<tr>
					<td>
						Litter ID:
					</td>
					<td>
						<select wire:model.lazy="matingId_contains" >
							<option value="contains">Contains</option>
							<option value="equals">Equals</option>
						</select>
						<input wire:model.lazy="litterId" type="text" placeholder="Litter ID *">
					</td>
				</tr>

				<tr>
					<td>
						Strain:
					</td>
					<td>
						<select wire:model.lazy="strainKey">
							<option value=""></option>
								@foreach($strains as $item)
									<option value="{{ $item->_strain_key }}">{{ $item->strainName." : ".$item->jrNum }}</option>
								@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<td>
						Mating Date
					</td>
					<td>
						<input wire:model.lazy="fromDate" type="text"/>
						<label class="px-2">
						To
					</label>
						<input wire:model.lazy="toDate" type="text"/>
					</td>
			 	</tr>

			 	<tr>
					<td>
				 		Owner / Workgroup
					</td>
					<td>
						<select wire:model.lazy="ownerWg">
							@foreach($owners as $item)
							<option value="{{ $item->owner }}">{{ $item->owner }}</option>
							@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<button wire:click="pullLitterEntries()" class="btn btn-info rounded">Pull Entries</button>
					</td.
				</tr>

			</table>
		</div>
	</div>

