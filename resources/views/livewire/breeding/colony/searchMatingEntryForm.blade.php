<div class="w-full md:w-2/3">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase text-gray-600">Search Mating Entries</h5>
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
						Mating ID:
					</td>
					<td>
						<select wire:model.lazy="matingId_contains" >
							<option value="contains">Contains</option>
							<option value="equals">Equals</option>
						</select>
						<input wire:model.lazy="matingId" type="text" placeholder="Mating ID *">
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
						Mating Date
					</td>
					<td>
						<input wire:model.lazy="fromDate" type="date"/>
						<label class="px-2">
						To
					</label>
						<input wire:model.lazy="toDate" type="date"/>
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
						<button wire:click="pullMatingEntries()" class="btn btn-info rounded">Pull Entries</button>
					</td.
				</tr>

			</table>
		</div>
	</div>
</div>

@script
<script>
		document.addEventListener("success", function(body){
			var body = @this.body
			toastr.success(body);
		});

		document.addEventListener("error", function(body){
			var body = @this.body
			toastr.error(body);
		});		

		document.addEventListener("warning", function(body){
			var body = @this.body
			toastr.warning(body);
		});		

		document.addEventListener("info", function(body){
			var body = @this.body
			toastr.info(body);
		});		
</script>
@endscript