<!--Table Card-->
<div class="w-full">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
  		<h5 class="font-bold uppercase text-gray-900">Cost as on {{ date('d-m-Y') }}* (Experiments may be in progress)</h5>
		</div>
		<div class="p-2">
			@if(!empty($ic))
        <table id="userIndex2" class="table table-bordered table-sm table-hover">
					<thead>
						<tr>
							<th> Project ID </th>
							<th> Cage ID </th>
							<th> From </th>
							<th> To* </th>
							<th> Days </th>
							<th> Price </th>
							<th> Cost* </th>
						</tr>
					</thead>
					<tbody>
						@foreach($ic as $val)
							<tr>
								<td>
									{{ $val[1] }}
    						  	</td>
    						  	<td>
    									{{ $val[0] }}
    						  	</td>
    						  	<td>
    									{{ date('d-m-Y', strtotime($val[2])) }}
    						  	</td>
    						  	<td>
    									{{ date('d-m-Y', strtotime($val[3])) }}
    						  	</td>
    						  	<td>
    									{{ $val[4] }}
    						  	</td>
    								<td>
    									&#x20B9; {{ $val[5] }}
    						  	</td>
    								<td>
    									&#x20B9;  {{ number_format((float)$val[6], 2, '.', '') }}
    						  	</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<table id="userIndex2" class="table table-bordered table-sm  table-hover">
					<thead class="bg-gray-900">
						<tr class="text-white text-left">
							<th class="font-semibold text-sm uppercase px-12 py-2"> No Entries Found</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
							<td class="px-12 text-gray-900 text-lg mt-1 mb-1 font-normal">
								
							</td>
						</tr>
					</tbody>
				</table>
			@endif

			</br>
			@if(!empty($pc))
				<table id="userIndex2" class="table table-bordered table-sm table-hover">
					<thead>
						<tr>
							<th> Project ID </th>
							<th> Total Cages </th>
							<th> Cost* </th>
						</tr>
					</thead>
					<tbody>
						@foreach($pc as $x)
							<tr>
								<td>
								{{ $x[0] }}
								</td>
						  	<td>
								{{ $x[1] }}
						  	</td>
						  	<td>
								&#x20B9; {{ number_format((float)$x[2], 2, '.', '') }}
						  	</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<table id="userIndex2" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th> No Entries Found </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
						</tr>
					</tbody>
				</table>
			@endif
		</div>
	</div>
</div>
<!--/table Card-->
