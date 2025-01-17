<div class="w-full md:w-full">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">

			<h5 class="font-bold uppercase text-gray-600">Select Entry</h5>
		</div>

		<div class="p-1">
			<table class="text-sm table-striped table-dark border p-3">
				
				<?php if(!empty($matSearchResults)) { ?>
					<tr class="p-3">
						<td align="center">
							<font color="red"> Select </font>
						</td>
						<td align="center">
							Mating ID <font color="red"></font>
						</td>
						<td align="center">
							Breed. Ref ID <font color="red"></font>
						</td>
						<td align="center">
							<font color="red">F-1</br>Key</font>
						</td>
						<td align="center">
							<font color="red">F-2</br>Key</font>
						</td>
						<td align="center">
							<font color="red">Male</br>Key</font>
						</td>
						<td align="center">
							<font color="red">Mating Date</font>
						</td>
						<td align="center">
							<font color="red">Wean Time</br>Days</font>
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
							<button wire:click="pick('{{ $row['mating_key'] }}')" class="btn btn-info rounded">Pick</button>
						</td>
						<td align="center">
							{{ $row['matingID'] }}
						</td>
						<td align="center">
							{{ $row['matingRefID'] }}
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
							{{ $row['weanTime'] }}
						</td>
						<td align="center">
							{{ $row['generation'] }}
						</td>
						<td align="center">
							{{ $row['owner'] }}
						</td>
						<td align="left">
							{{ $row['weanNote'] }}
						</td>
						<td align="left">
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
</div>
