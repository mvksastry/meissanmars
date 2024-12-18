<div class="w-1/2 md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase mx-3 text-gray-600"><font color="blue">{{ $speciesName }}</font> to DB: </h5>
		</div>
		<div class="p-1">
			<table class="w-full p-5 text-sm text-gray-900">
				<thead>
				</thead>
				<tbody>
					@if(count($fullLitterDetails) > 0)
						@foreach($fullLitterDetails as $row)
						<tr>
							<td class="mx-4">
								Put pups in Database
							</td>
							<td class="mx-4">
								<input wire:model.lazy="ppidb" class="form-control-sm border" type="checkbox" value="true">
							</td>
						</tr>
						@endforeach
					@else
						<tr class="bg-warning">
							<td colspan="2" class="border px-2 p-1">
								Litter Details Not Found
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>