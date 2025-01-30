<div class="w-full md:w-2/3">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase text-gray-600">Search Open Litter Entries</h5>
		</div>

		<div class="p-1">
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
						<select wire:model.lazy="litterId_contains" >
							<option value="contains">Contains</option>
							<option value="equals">Equals</option>
						</select>
						<input wire:model.lazy="matingId" type="text" placeholder="Litter ID *">
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
									<option value="{{ $item->strain_id }}">{{ $item->strain_name." : ".$item->jrNum }}</option>
								@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<td>
						Wean Date
					</td>
					<td>
						<input wire:model.lazy="weanFromDate" type="date"/>
						<label class="px-2">
						To
					</label>
						<input wire:model.lazy="weanToDate" type="date"/>
					</td>
			 	</tr>

			 	<tr>
					<td>
				 		Staus
					</td>
					<td>
						<select wire:model.lazy="ownerWg">
							<option value="open">Open</option>
							<option value="closed">Closed</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>
					<!--
						<button wire:click="pullSelectedLitterEntries()" class="btn btn-info rounded">Pull Entries</button>
					-->
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td>
						<button wire:click="pullAllOpenLitterEntries()" class="btn btn-success rounded">Pull All Open Entries</button>
					</td>
				</tr>

			</table>
		</div>
	</div>
</div>
