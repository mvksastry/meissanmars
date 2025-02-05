<div class="w-full md:w-full">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">

			<h5 class="font-bold uppercase text-gray-600">Select Entry</h5>
		</div>

		<div class="p-1">
			<table id="example4" class="text-sm table-bordered table-striped table-dark border p-3">
				
				<?php if(!empty($matSearchResults)) { ?>
				<thead>
					<tr class="p-3">
						<th align="center">
							<font color="red"> Select </font>
						</th>
						<th align="center">
							Mating ID <font color="red"></font>
						</th>
						<th align="center">
							Breed. Ref ID <font color="red"></font>
						</th>
						<th align="center">
							<font color="red">F-1</br>Key</font>
						</th>
						<th align="center">
							<font color="red">F-2</br>Key</font>
						</th>
						<th align="center">
							<font color="red">Male</br>Key</font>
						</th>
						<td align="center">
							<font color="red">Mating Date</font>
						</th>
						<th align="center">
							<font color="red">Wean Time</br>Days</font>
						</th>
						<th align="center">
							<font color="red">Generation</font>
						</th>
						<th align="center">
							<font color="red">Owner</font>
						</th>

						<th align="center">
							<font color="red">Wean Note</font>
						</th>
						<th align="center">
							<font color="red">Comments</font>
						</th>
					</tr>
				</thead>
				<?php $i = 1; ?>
				<tbody>
				@foreach($matSearchResults as $row)
				<?php //$id = $row->_mouse_key ?>
					<tr>
						<td align="center" width="4%">
							<button wire:click="pick('{{ $row['mating_key'] }}')" class="btn btn-info rounded">{{ $row['matingRefID'] }}</button>
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
				</tbody>
			</table>
		</div>

	</div>
</div>

@script
	<script>
			document.addEventListener("matingSearchResultsDone", function(){
				$(document).ready(function(){
					$('#example4').DataTable({
							"responsive": true, 
							"lengthChange": false, 
							"autoWidth": false,
							"buttons": ["copy", "csv", "excel", "print", "colvis",
									{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
									}
							],
					}).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
				});
			});
	</script>
@endscript