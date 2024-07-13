
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-600">Select Entry</h5>
		</div>

		<div class="p-5">
			<table class="text-xs">
				<div>
					{{ $iaMessage }}
				</div>
				<?php if(!empty($matSearchResults)) { ?>
					<tr>
						<td align="center">
							<font color="red"> Select </font>
						</td>
						<td align="center">
							Mating ID <font color="red"></font>
						</td>
						<td align="center">
							<font color="red">Dam 1</font>
						</td>
						<td align="center">
							<font color="red">Dam 2</font>
						</td>
						<td align="center">
							<font color="red">Sire</font>
						</td>
						<td align="center">
							<font color="red">Mating Date</font>
						</td>
						<td align="center">
							<font color="red">Generation</font>
						</td>
						<td align="center">
							<font color="red">Owner</font>
						</td>

						<td align="center">
							<font color="red">Wean Note</font>
						</td>
						<td align="center">
							<font color="red">Comments</font>
						</td>
					</tr>
				<?php $i = 1; ?>
				@foreach($matSearchResults as $row)
				<?php //$id = $row->_mouse_key ?>
					<tr>
						<td align="center" width="4%">
							<button wire:click="edit('{{ $row['mating_key'] }}')" class="bg-blue-500 w-15 hover:bg-blue-800 text-white font-normal py-1 px-1  mx-1 rounded">Edit</button>
						</td>
						<td align="center">
							{{ $row['matingID'] }}
						</td>
						<td align="center">
							{{ $row['_dam1_key'] }}
						</td>
						<td align="center">
							{{ $row['_dam2_key'] }}
						</td>
						<td align="center">
							{{ $row['_sire_key'] }}
						</td>
						<td align="center">
							{{ date('d-m-Y',strtotime($row['matingDate'])) }}
						</td>
						<td align="center">
							{{ $row['generation'] }}
						</td>
						<td align="center">
							{{ $row['owner'] }}
						</td>
						<td align="center">
							{{ $row['weanNote'] }}
						</td>
						<td align="center">
							{{ $row['comment'] }}
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
