<!--Table Card-->
<div class="w-1/2 md:w-1/2">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-900">Cage Details</h5>
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
							<td>Start Date</td>
							<td>{{ date('d-m-Y', strtotime($x->start_date)) }}</td>
						</tr>
						<?php
            	$start = strtotime($x->start_date);
            	$today = strtotime(date('Y-m-d'));
            	$days_between = floor(abs($today - $start) / 86400);
            ?>
						<tr>
								<td><label><strong>Total Present</strong></label></td>
								<td><label><strong>{{ $x->animal_number }}</strong></label></td>
						</tr>
						<tr>
							<td>No of Days</td>
							<td>{{ $days_between }} days</td>
						</tr>
						<tr>
							<td>Notes</td>
							<td>{{ $x->notes }}</td>
						</tr>
					@endforeach
					<tr>
            <td colspan="2" ><label><strong> Observations</strong></label></td>
          </tr>

          <tr>
  					<td rowspan="3">Overall Appearance </td>
  					<td>
  						<input type="radio" id="normal" wire:model="appearance" value="Normal">Normal
  					</td>
    			</tr>

    			<tr>
  					<td>
  						<input type="radio" id="normal" wire:model="appearance" value="Abnormal">Abnormal
  					</td>
    			</tr>

  				<tr>
  					<td>
  						<input type="radio" id="normal" wire:model="appearance" value="Need Attention">Need Attention
  					</td>
  				</tr>

          <tr class="mt-10">
  					<td>Dead</td>
  					<td>
  						<input class="form-control" id="numdead" wire:model="numdead" placeholder="# Dead">
  					</td>
  				</tr>

  				<tr class="mt-10">
  					<td>Moribund
  					</td>
  					<td>
  						<input class="form-control" id="moribund" wire:model="moribund"  placeholder="# Moribund State">
  					</td>
  				</tr>

          <tr class="mt-10">
  					<td>Housing</td>
  					<td>
  						<input id="housing" wire:model="housing" type="checkbox" value="1"> Cage Changed
  					</td>
  				</tr>

  				<tr class="mt-10">
  					<td> X Y Z </td>
  					<td>
  						<input id="xyz" wire:model="xyz" type="checkbox" value="1"> X Y Z
  					</td>
  				</tr>

          <tr class="mt-10">
						<td>
              <label class="text-left text-gray-900" for="comment">Notes:</label>
						</td>
						<td colspan="2">
              <textarea class="form-control" id="notes" wire:model="notes" rows="4" cols="40" id="Notes">None</textarea>
            </td>
					</tr>

          <tr>
						<td colspan="2" align="center">
  						<button wire:click="postCageObservations('{{ $x->cage_id }}')" id="postobs" class="btn btn-info rounded">
                      Post Observations
              </button>
            </td>
					</tr>
        	<tr>
						<td colspan="2" align="center"></td>
					</tr>
				</tbody>
			</table>
		<div>
	</div>
</div>
<!--/table Card -->
