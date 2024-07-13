<div class="w-full md:w-full p-2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-600">Select Entry</h5>
		</div>

		<div class="p-1">
			<table class="text-xs">
				<div>
					Search Result for: {{ $searchFor }}
				</div>
				<?php if(!empty($queryResult)) { ?>
					<tr>
						<td align="center">
							<font color="red"> Select </font>
						</td>
						<td align="center">
							ID <font color="red"></font>
						</td>
						<td align="center">
							<font color="red">Strain</font>
						</td>
						<td align="center">
							<font color="red">Generation</font>
						</td>
						<td align="center">
							<font color="red">Protocol</font>
						</td>
						<td align="center">
							<font color="red">Date of Birth</font>
						</td>
						<td align="center">
							<font color="red">Sex</font>
						</td>
						<td align="center">
							<font color="red">Life Status*</font>
						</td>
						<td align="center">
							<font color="red">Breeding Status*</font>
						</td>
						<td align="center">
							<font color="red">Origin</font>
						</td>
						<td align="center">
							<font color="red">Owner</font>
						</td>
					</tr>
				<?php $i = 1; ?>
				@foreach($queryResult as $row)
				<?php //$id = $row->_mouse_key ?>
					<tr>
						<td align="center" width="4%">
							<button wire:click="pick('{{ $searchFor.'_'.$row['ID'] }}')" class="btn btn-sm btn-info rounded">Pick</button>
						</td>
						<td align="center">
							{{ $row['ID'] }}
						</td>
						<td align="center">
							{{ $row['strainName'] }}
						</td>
						<td align="center" >
							{{ $row['generation'] }}
						</td>
						<td align="center" >
							{{ $row['protocol'] }}
						</td>
						<td align="center" >
							{{ date('d-m-Y',strtotime($row['birthDate'])) }}
						</td>
						<td align="center" >
							{{ $row['sex'] }}
						</td>
						<td align="center" >
							{{ $row['lifeStatus'] }}
						</td>
						<td align="center" >
							{{ $row['breedingStatus'] }}
						</td>
						<td align="center" >
							{{ $row['origin'] }}
						</td>
						<td align="center">
							{{ $row['owner'] }}
						</td>
					</tr>
					<?php $i = $i+1; ?>
				@endforeach
				<?php } else { ?>
					 <tr>
						<td align="center">
							<font color="red"> No Data Retrived: Refine Selection </font>
						</td>
					</tr>
				 <?php } ?>
			</table>
		</div>

	</div>
</div>
