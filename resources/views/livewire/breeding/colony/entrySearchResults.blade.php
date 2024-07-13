
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		

		<div class="p-3">
			<table class="text-xs">
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
							<button wire:click="edit('{{ $row['ID'] }}')" class="btn btn-primary rounded">Edit</button>
						</td>
						<td align="center" width="30%">
							{{ $row['ID'] }}
						</td>
						<td align="center" width="8%">
							{{ $row['strainName'] }}
						</td>
						<td align="center" width="12%">
							{{ $row['generation'] }}
						</td>
						<td align="center" width="12%">
							{{ $row['protocol'] }}
						</td>
						<td align="center" width="13%">
							{{ date('d-m-Y',strtotime($row['birthDate'])) }}
						</td>
						<td align="center" width="8%">
							{{ $row['sex'] }}
						</td>
						<td align="center" width="8%">
							{{ $row['lifeStatus'] }}
						</td>
						<td align="center" width="8%">
							{{ $row['breedingStatus'] }}
						</td>
						<td align="center" width="8%">
							{{ $row['origin'] }}
						</td>
						<td align="center" width="8%">
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

