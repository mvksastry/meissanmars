<!--Table Card-->
<div class="w-1/2 md:w-1/2 p-3">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-900">Cage Details</h5>
		</div>
		<div class="p-5">
			<table class="w-full p-5 text-sm text-gray-700">
				<thead>
				</thead>
				<tbody>
					@foreach($caInfos as $x)
						<tr>
							<td class="text-left text-gray-800">Cage Id</td>
							<td class="text-left text-gray-900">{{ $x->cage_id }}</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Issue Id</td>
							<td class="text-left text-gray-900">{{ $x->issue_id }}</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Project Id</td>
							<td class="text-left text-gray-900">{{ $x->project_id }}</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Owner Id</td>
							<td class="text-left text-gray-900">{{ $x->user->name }}</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Strain</td>
							<td class="text-left text-gray-900">{{ $x->strain->strain_name }}</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Total Count</td>
							<td class="text-left text-gray-900">{{ $x->animal_number }}</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Start Date</td>
							<td class="text-left text-gray-900">{{ date('d-m-Y', strtotime($x->start_date)) }}</td>
						</tr>
						<?php
							$start = strtotime($x->start_date);
							$today = strtotime(date('Y-m-d'));
							$days_between = floor(abs($today - $start) / 86400);
						?>
						<tr>
							<td class="text-left text-gray-800">No of Days</td>
							<td class="text-left text-gray-900">{{ $days_between }} days</td>
						</tr>
						<tr>
							<td class="text-left text-gray-800">Notes</td>
							<td class="text-left text-gray-900">{{ $x->notes }}</td>
						</tr>
					@endforeach
					<tr class="mt-10">
						<td class="text-left text-gray-900" colspan="2" ><label><strong> Observations</strong></label>
						</td>
					</tr>

					<tr>
						<td class="text-left text-gray-800" rowspan="3">Overall Appearance </td>
						<td class="text-left text-gray-900">
							<input type="radio" id="normal" name="normal" value="Normal">Normal
						</td>
					</tr>

					<tr>
						<td class="text-left text-gray-900">
							<input type="radio" id="normal" name="normal" value="Abnormal">Abnormal
						</td>
					</tr>

					<tr>
						<td class="text-left text-gray-900">
							<input type="radio" id="normal" name="normal" value="Need Attention">Need Attention
						</td>
					</tr>

					<tr class="mt-10">
						<td class="text-left text-gray-800">Dead</td>
						<td class="text-left text-gray-900">
							<input class="form-control" id="numdead" name="numdead" placeholder="Number Found Dead">
						</td>
					</tr>

					<tr class="mt-10">
						<td class="text-left text-gray-900">Moribund
						</td>
						<td>
						<input class="form-control" id="moribund" name="moribund"  placeholder="Number in Moribund State">
						</td>
					</tr>

					<tr class="mt-10">
						<td class="text-left text-gray-800">Housing</td>
						<td class="text-left text-gray-900">
						<input id="housing" name="housing" type="checkbox" value="1"> Cage Changed
						</td>
					</tr>

					<tr class="mt-10">
						<td class="text-left text-gray-800"> X Y Z m</td>
						<td class="text-left text-gray-900">
						<input id="xyz" name="xyz" type="checkbox" value="1"> X Y Z
						</td>
					</tr>

					<tr class="mt-10">
						<td class="text-left text-gray-800">
						<label class="text-left text-gray-900" for="comment">Comment:</label>
						</td>
						<td >
							<textarea class="form-control" id="notes" name="notes" rows="2" id="comment">None</textarea>
						</td>
					</tr>

					<tr>
						<td class="text-left text-gray-800" colspan="2" align="center">
							<button class="btn btn-primary bg-blue-500 w-40 hover:bg-blue-800 text-white font-normal py-2 px-2  mx-3 rounded" type="button" id="postobs" class="btn btn-primary">Post Observations</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--/table Card -->
