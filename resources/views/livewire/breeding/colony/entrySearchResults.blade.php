
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		

		<div class="p-3">
		<table id="example4" class="text-sm table-bordered table-striped table-dark border p-3">
			
				<?php if(!empty($queryResult)) { ?>
				<thead>
					<tr>
						<th text="center">
							<font color="red"> Select </font>
						</th>
						<th text="center">
							 <font color="red">ID</font>
						</th>
						<th align="center">
							<font color="red">Strain</font>
						</th>
						<th align="center">
							<font color="red">Generation</font>
						</th>
						<th align="center">
							<font color="red">Protocol</font>
						</th>
						<th align="center">
							<font color="red">Date of Birth</font>
						</th>
						<th align="center">
							<font color="red">Sex</font>
						</th>
						<th align="center">
							<font color="red">Life Status*</font>
						</th>
						<th align="center">
							<font color="red">Location</font>
						</th>
						<th align="center">
							<font color="red">Breeding Status*</font>
						</th>
						<th align="center">
							<font color="red">Origin</font>
						</th>
						<th align="center">
							<font color="red">Owner</font>
						</th>
					</tr>
				<?php $i = 1; ?>
				<tbody>
				@foreach($queryResult as $row)
				<?php //$id = $row->_mouse_key ?>
					<tr>
						<td align="center" width="4%">
							<button id="pickedid" value="{{ $row['_mouse_key'] }}" class="btn btn-primary rounded">Edit</button>
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
							R:  S:  C:
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
				</tbody>
			</table>
		</div>

	</div>

@script
<script>
		document.addEventListener("fMSResults", function(body){
			var body = @this.body
			$(document).Toasts('create', {
        title: 'Results Loaded',
				icon: 'success',
				autohide: true,
        delay: 5750,
        body: body
      });
			//Swal.fire(body)
			//Swal.fire('Results Loaded', body, 'success')			
		});
</script>
@endscript
@script
<script>
	$(document).on('click', '#pickedid', function()
	{
		let id = $(this).val(); 
		alert("working"+id);
		Livewire.dispatch('pickedid', { pickedid: id })
	});
</script>
@endscript
@script
	<script>
			document.addEventListener("entrySearchDone", function(){
				$(document).ready(function(){
					$('#example4').DataTable({
							"responsive": true, 
							"lengthChange": false, 
							"autoWidth": false,
							"buttons": ["copy", "csv", "excel", "print", 
									{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
									},
									"colvis"
							],
					}).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
				});
			});
	</script>
@endscript