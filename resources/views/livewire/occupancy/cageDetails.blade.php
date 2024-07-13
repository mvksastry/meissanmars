<!--Table Card-->
<div>
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-900">Cage Details</h5>
		</div>
			<table id="userIndex2" class="table table-bordered table-hover">
				<thead>
				</thead>
				<tbody>
					@foreach($caInfos as $x)
						<tr bgcolor="#E1BEE7">
							<td>Cage Id</td>
							<td>{{ $x->cage_id }}</td>
						</tr>
						<tr>
							<td>Issue Id</td>
							<td>{{ $x->usage_id }}</td>
						</tr>
						<tr>
							<td>Project Id</td>
							<td>{{ $x->iaecproject_id }}</td>
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
							<td>Total Count</td>
							<td>{{ $x->animal_number }}</td>
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
							<td>No of Days</td>
							<td>{{ $days_between }} days</td>
						</tr>
						<tr>
							<td>Notes</td>
							<td>{{ $x->notes }}</td>
						</tr>
					@endforeach
					<tr class="mt-10">
						<td colspan="2" ><label><strong> Observations</strong></label>
						</td>
					</tr>

					<tr>
						<td rowspan="3">Overall Appearance </td>
						<td>
							<input wire:model.lazy="appearance" type="radio" id="appearance" name="appearance" value="Normal">Normal
						</td>
					</tr>

					<tr>
						<td>
							<input wire:model.lazy="appearance" type="radio" id="appearance" name="appearance" value="Abnormal">Abnormal
						</td>
					</tr>

					<tr>
						<td>
							<input wire:model.lazy="appearance" type="radio" id="appearance" name="appearance" value="Need Attention">Need Attention
						</td>
					</tr>

					<tr>
						<td>Dead</td>
						<td>
							<input wire:model.lazy="numdead" class="form-control" id="numdead" name="numdead" placeholder="Number Found Dead">
						</td>
					</tr>

					<tr>
						<td>Moribund
						</td>
						<td>
						<input wire:model.lazy="moribund" class="form-control" id="moribund" name="moribund"  placeholder="Number in Moribund State">
						</td>
					</tr>

					<tr class="mt-10">
						<td>Housing</td>
						<td>
						<input wire:model.lazy="housing" id="housing" name="housing" type="checkbox" value="1"> Cage Changed
						</td>
					</tr>

					<tr class="mt-10">
						<td> X Y Z m</td>
						<td>
						<input wire:model.lazy="xyz" id="xyz" name="xyz" type="checkbox" value="1"> X Y Z
						</td>
					</tr>

					<tr class="mt-10">
						<td>
						<label class="text-left text-gray-900" for="comment">Comment:</label>
						</td>
						<td >
							<textarea wire:model.lazy="notes" class="form-control" id="notes" name="notes" rows="2" id="comment">None</textarea>
						</td>
					</tr>

					<tr>
						<td colspan="2" align="center">
							<button wire:click="cageSurveillance({{ $cage_id }})" class="btn btn-primary bg-blue-500 w-40 hover:bg-blue-800 text-white font-normal py-2 px-2  mx-3 rounded" type="button" id="postobs" class="btn btn-primary">Post Observations</button>
						</td>
					</tr>
				</tbody>
			</table>
		
	</div>
</div>
<!--/table Card -->
