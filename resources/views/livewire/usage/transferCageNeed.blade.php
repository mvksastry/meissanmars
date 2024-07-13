<!--Table Card-->
	<div class="w-1/2 md:w-1/2">
		<div class="bg-orange-100 border border-gray-800 rounded shadow">
			<div class="border-b border-gray-800 p-2">
				<h5 class="font-bold uppercase text-gray-900">Transfer to New Cage</h5>
			</div>
			<div class="p-1">
        <table id="userIndex2" class="table table-bordered table-sm table-hover">
				
					<thead>
						<tr>
							<th> Item </th>
							<th> Details </th>
						</tr>
					</thead>
					<tbody>
						@foreach($caInfos as $x)
							<tr>
								<td>Cage Id</td>
								<td>{{ $x->cage_id }}</td>
							</tr>
							<tr>
								<td>Issue Id</td>
								<td>{{ $x->usage_id }}</td>
							</tr>
							<tr>
								<td>Project Id</td>
								<td>{{ $x->project_id }}</td>
							</tr>
							<tr>
								<td>Owner Id</td>
								<td>{{ $x->user->name }}</td>
							</tr>
							<tr>
								<td>Strain</td>
								<td>{{ $x->strain->strain_name }}</td>
							</tr>
							<tr>
								<td>Start Date</td>
								<td>{{ date('d-m-Y', strtotime($x->start_date)) }}</td>
							</tr>
								<?php
              		$start = strtotime($x->start_date);
              		$today = strtotime(date('Y-m-d'));
              		$days_between = floor(abs($today - $start) / 86400);
                ?>
							<tr>
								<td><label><strong>Total Number present</strong></label></td>
								<td><label><strong>{{ $x->animal_number }}</strong></label></td>

							</tr>

							<tr>
								<td>No of Days</td>
								<td>{{ $days_between }} days</td>
							</tr>

						@endforeach
							<tr>
								<td >

										<strong>Animal # to New Cage</strong>
								</td>
								<td>
									<input type="text" class="text-left text-gray-900" wire:model="animalnum">
								</td>
              </tr>

							<tr class="mt-10">
								<td >
										<strong> New Cages #</strong>
								</td>
								<td>
									Transfer to one new cage
								</td>
              </tr>

							<tr class="mt-10">
								<td>
	                <label class="text-left text-gray-900" for="comment">Notes:</label>
								</td>
								<td colspan="2">
	                <textarea class="form-control" id="notes" wire:model="notes" rows="4" cols="40" id="Notes"></textarea>
	              </td>
							</tr>

							<tr>
								<td colspan="2" align="center"></td>
							</tr>

							<tr>
								<td class="text-left text-gray-900" colspan="2" align="center">
									<button wire:click="enterNewCage('{{ $x->cage_id }}')" type="button" id="postobs" class="btn btn-info rounded">Make New Cage</button>
								</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!--/table Card -->
