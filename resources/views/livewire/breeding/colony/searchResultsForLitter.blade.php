
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-600">Select Entry</h5>
		</div>

		<div class="p-3">
			<table class="text-xs">
				<?php if(!empty($litterSearchResults)) { ?>
					<tr>
						<td align="center">
							<font color="red"> Select </font>
						</td>
						<td align="center">
							Litter ID <font color="red"></font>
						</td>
						<td align="center">
							<font color="red">totalBorn</font>
						</td>
						<td align="center">
							<font color="red"> # Female</font>
						</td>
						<td align="center">
							<font color="red"># Male</font>
						</td>

					</tr>
				<?php $i = 1; ?>
				@foreach($litterSearchResults as $row)
				<?php //$id = $row->_mouse_key ?>
					<tr>
						<td align="center" width="4%">
							<button wire:click="edit('{{ $row['litterID'] }}')" class="btn btn-primary rounded">Pick</button>
						</td>
						<td align="center">
							{{ $row['litterID'] }}
						</td>
						<td align="center">
							{{ $row['totalBorn'] }}
						</td>
						<td align="center" >
							{{ $row['numFemale'] }}
						</td>
						<td align="center" >
							{{ $row['numMale'] }}
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

