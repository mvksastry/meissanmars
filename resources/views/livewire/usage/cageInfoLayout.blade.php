	<div class="inline-flex flex-row flex-wrap flex-grow mt-2">
	<!--Table Card-->
		<div class="w-1/2 md-1/2">
			<div class="bg-orange-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800 p-3">
					<h5 class="font-bold uppercase text-gray-900">Cage Details for Usage ID: {{ $usage_id }}</h5>
				</div>
			
        <table id="userIndex2" class="table table-bordered table-sm table-hover">
            <thead>
							<tr>
								<th> Cage ID</th>
								<th> Start Date</th>
								<th> Cage Status </th>
								<th> Location</th>
								<th> Details </th>
								<th> Transfer</th>
							</tr>
						</thead>
						<tbody>
    						@foreach($cageInfo as $row)
    							<?php $ci_id = $row->cage_id.'_'.$row->usage_id; ?>
    							<tr>
    								<td>{{ $row->cage_id }}</td>
    								<td>{{ date('d-m-Y', strtotime($row->start_date)) }}</td>
    								<td>{{ $row->cage_status }}</td>

    								@if($row->cage_status != 'Finished')
    								<td>
    									<button wire:click="location('{{ $ci_id }}')" class="btn btn-sm btn-info rounded">
      									Location
    									</button
    								</td>
    								<td>
    									<button wire:click="cageDetails('{{ $ci_id }}')" class="btn btn-sm btn-info rounded">
      									Details
    									</button>
    								</td>
    								<td>
    									<button wire:click="transferToNewCage('{{ $ci_id }}')" class="btn btn-sm btn-info rounded">
      									Transfer
    									</button>
    								</td>
										@else
											<td></td>
		  								<td></td>
		  								<td></td>
    								@endif
    							</tr>
    						@endforeach
						</tbody>
					</table>
	
			</div>
		</div>
		<!-- / End of table Card-->

	</div>
