<div class="w-1/2 md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase mx-1 text-gray-600"><font color="blue">Litter Details Recorded Till: {{ date('d-m-Y') }} </font></h5>
		</div>
		<div class="p-1">
			@if(count($fullLitterDetails) > 0)
				<table class="w-full p-5 text-sm text-gray-900">
					<thead>
						<th>Mating</br>Key</th>
						<th>Birth</br>Date</th>
						<th>Total</br>Born</th>
						<th>Dead</th>
						<th>F / M</th>
						<th>Status</th>
						<th>Status</br>Date</th>
					</thead>
					<tbody>
						@foreach($fullLitterDetails as $row)
							<tr>
								<td class="mx-4">
								{{ $row->_mating_key }}
								</td>
								<td class="mx-4">
								{{ date('d-m-Y', strtotime($row->birthDate)) }}
								</td>
								<td class="mx-4">
								{{ $row->totalBorn }}
								</td>
								<td class="mx-4">
								{{ $row->numberBornDead }}
								</td>
								<td class="mx-4">
								{{ $row->numFemale }} / {{ $row->numMale }}
								</td>
								<td class="mx-4">
								{{ $row->entry_status }} 
								</td>
								<td class="mx-4">
								{{ date('d-m-Y', strtotime($row->entry_status_date)) }} 
								</td>
							</tr>
						@endforeach					
					</tbody>
				</table>
			@else
				<table class="w-full p-5 text-sm text-gray-900">
					<thead>
						<th class="border px-2 p-1 bg-warning"> Litter Details Not Found/Selected</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			@endif
		</div>
	</div>
</div>