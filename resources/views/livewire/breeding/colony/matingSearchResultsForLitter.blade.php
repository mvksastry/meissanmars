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
							Mating ID
						</th>
						<th align="center">
							Breed. Ref ID
						</th>
						<th align="center">
							F-1</br>Key
						</th>
						<th align="center">
							F-2</br>Key
						</th>
						<th align="center">
							Male</br>Key
						</th>
						<th align="center">
							Mating Date
						</th>
						<th align="center">
							Wean Time</br>Days
						</th>
						<th align="center">
							Generation
						</th>
						<th align="center">
							Owner
						</th>

						<th align="center">
							Wean Note
						</th>
						<th align="center">
							Comments
						</th>
					</tr>
				</thead>
				
				<tbody>
				@foreach($matSearchResults as $row)
				
					<tr>
						<td align="center" width="4%">
							<button id="pickedid" value="{{ $row['mating_key'] }}" class="btn btn-info rounded">{{ $row['matingRefID'] }}</button>					
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
		//alert("working"+id);
		Livewire.dispatch('pickedid', { pickedid: id })
	});
</script>
@endscript
@script
	<script>
			document.addEventListener("matingSearchResultsDone", function(){
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