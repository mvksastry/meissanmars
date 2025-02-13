<div class="w-full md:w-full p-2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-600">Select Entry</h5>
		</div>

		<div class="p-1">
				<div>
					Search Result for: {{ $searchFor }}
				</div>
			<table id="example4" class="text-xs">

				
				@if(!empty($queryResult))
					<thead>
						<tr>
							<th align="center">
								<font color="red"> Select </font>
							</th>
							<th align="center">
								ID <font color="red"></font>
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
								<font color="red">Breeding Status*</font>
							</th>
							<th align="center">
								<font color="red">Exit Date*</font>
							</th>
							<th align="center">
								<font color="red">Origin</font>
							</th>
							<th align="center">
								<font color="red">Owner</font>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach($queryResult as $row)
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
								{{ $row['exit_date'] }}
							</td>
							<td align="center" >
								{{ $row['origin'] }}
							</td>
							<td align="center">
								{{ $row['owner'] }}
							</td>
						</tr>
					@endforeach
					</tbody>
				@else
					<tbody>
						<tr>
							<td align="center">
								<font color="red"> No Data Retrived: Refine Selection </font>
							</td>
						</tr>
					</tbody>
				@endif
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