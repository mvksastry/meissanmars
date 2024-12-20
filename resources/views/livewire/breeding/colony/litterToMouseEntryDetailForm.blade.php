<div class="w-1/2 md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase mx-3 text-gray-600">New Mouse Entries To Be added to DB</h5>
		</div>
		<div class="p-1">
			<table class="table table-hover p-1 text-sm">
				<thead>
					<div id="iaMessage">						
					</div>
				</thead>
				<tbody>
					<tr>
            <td colspan="5" class="border px-2  p-1">
              Males
 						</td>
					</tr>
					
					<tr>
						<td class="border px-2  p-1">
							Ref ID
						</td>
						<td class="border px-2  p-1">
							New Mouse ID
						</td>
						<td class="border px-2  p-1">
							DoB
						</td>
						<td class="border px-2  p-1">			
							Litter Key
						</td>
						<td class="border px-2  p-1">
							Sex
						</td>
					</tr>

					@foreach($maleGroup as $row)
          <tr>
						<td class="border px-2  p-1">
						{{ $row['RefID'] }}
						</td>
            <td class="border px-2  p-1">
						{{ $row['ID'] }}
						</td>
						<td class="border px-2  p-1">
						{{ date('d-m-Y', strtotime($row['birthDate'])) }}
						</td>
						<td class="border px-2  p-1">
						{{ $row['_litter_key'] }}
						</td>
						<td class="border px-2  p-1">
						{{ $row['sex'] }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>				
	
			<table class="table table-hover p-1 text-sm">
				<thead>
				</thead>
				<tbody>

					<tr>
						<td colspan="5" class="border px-2  p-1">
							Females
						</td>
					</tr>				
				
					<tr>
						<td class="border px-2  p-1">
							Ref ID
						</td>
						<td class="border px-2  p-1">
							New Mouse ID
						</td>
						<td class="border px-2  p-1">
							DoB
						</td>
						<td class="border px-2  p-1">			
							Litter Key
						</td>
						<td class="border px-2  p-1">
							Sex
						</td>
					</tr>

					@foreach($femaleGroup as $row)
          <tr>
						<td class="border px-2  p-1">
						{{ $row['RefID'] }}
						</td>
            <td class="border px-2  p-1">
						{{ $row['ID'] }}
						</td>
						<td class="border px-2  p-1">
						{{ date('d-m-Y', strtotime($row['birthDate'])) }}
						</td>
						<td class="border px-2  p-1">
						{{ $row['_litter_key'] }}
						</td>
						<td class="border px-2  p-1">
						{{ $row['sex'] }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<table class="table table-hover p-1 text-sm">
				<thead>
					<div id="iaMessage">	</div>
				</thead>
				<tbody>
					<tr>
						<td class="border px-2 p-1">
							Total Male Cages Needed: {{ $cagesM }} </br>  Per Cage: {{  $jsonCagesM }}
						</td>
						<td class="border px-2 p-1">
							Total Female Cages Needed: {{ $cagesF }} </br> Per Cage: {{ $jsonCagesF }}
						</td>
          </tr>
					
					<tr>
						<td class="border px-2 p-1">
							<button wire:click="putPupsToDB()" class="btn btn-primary rounded">Put Pups To DB</button>
						</td>
						<td class="border px-2 p-1">
							<button wire:target.prevent="resetForm" class="btn btn-primary rounded">Cancel</button>
						</td>
          </tr>
				</tbody>
			</table>
			
			
		</div>
	</div>
</div>



