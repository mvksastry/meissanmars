<div class="w-full md:w-full">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			
		</div>
		<?php $males = 0; $females = 0; $total = 0; $dead = 0; ?>
		<div class="w-full md:w-full">
			<div class="bg-purple-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800">
					<h5 class="font-bold uppercase mx-1 text-gray-600"></h5>
				</div>
				<div class="p-3">
					<table class="table table-bordered table-striped">
						@if(count($openLitterEntries) > 0)
							<thead class="thead-dark">
								<th>Mating</br>Key</th>
								<th>Birth</br>Date</th>
								<th>Ref ID</th>
								<th>Total</br>Born</th>
								<th>F </th>
								<th>M</th>
								<th>Dead</th>
								<th>Wean</br>Date</th>
								<th>Status</th>
								<th>Status</br>Date</th>
								<th>Comment</th>
							</thead>
							<tbody>
							
								@foreach($openLitterEntries as $row)
								<tr>
									<td class="mx-2">
									{{ $row->_mating_key }}
									</td>
									<td class="mx-2">
									{{ date('d-m-Y', strtotime($row->birthDate)) }}
									</td>
									<td class="mx-2">
									{{ $row->mating->matingRefID }}
									</td>
									<td class="mx-2">
									<?php 
									//if($row->numFemale != null && $row->numMale != null)
									//{
										$total = $total + $row->totalBorn; 
									//}
									?>
									{{ $total }} - - {{ $row->totalBorn }} 
									</td>
									<td class="mx-2">
									{{ $row->numFemale }} <?php $females = $females + $row->numFemale; ?>
									</td>
									<td class="mx-2">
									{{ $row->numMale }} <?php $males = $males + $row->numMale; ?>
									</td>
									<td class="mx-2">
									{{ $row->numberBornDead }} <?php $dead = $dead + $row->numberBornDead; ?>
									</td>
									<td class="mx-2">
									{{ date('d-m-Y', strtotime($row->weanDate)) }}
									</td>
									<td class="mx-2">
									{{ $row->entry_status }} 
									</td>
									<td class="mx-2">
									{{ date('d-m-Y', strtotime($row->entry_status_date)) }} 
									</td>
									<td class="mx-2">
									{{ $row->comment }} 
									</td>
								</tr>
								@endforeach
								<tr>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
									<td class="mx-2 text-bold">Total </td>
									<td class="mx-2 text-bold">{{ $total }}</td>
									<td class="mx-2 text-bold">{{ $females }}</td>
									<td class="mx-2 text-bold">{{ $males }}</td>
									
									<td class="mx-2 text-bold">{{ $dead }}</td>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
								</tr>
							@else
								<tr class="bg-warning">
									<td colspan="11" class="border px-2 p-1">
										Litter Details Not Found/Selected
									</td>
								</tr>
							@endif
						</tbody>
					</table>
					
				</div>
			</div>
		</div>

	</div>
</div>
