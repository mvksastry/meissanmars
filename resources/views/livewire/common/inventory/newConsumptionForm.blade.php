	<!--Table Card-->              
	<!-- insert table -->
	@if($showConsumptionUpdate)
		<table class="w-full p-5 text-gray-700">
			<thead>
				<tr>
					 <th align="center">
						  
					 </th>
				</tr>
			</thead>
			<tbody> 
				<tr>
					<td colspan="4"> 
						<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
							Enter Consumption*
						</label>
					</td>
				</tr>
				<tr>
					<td> 
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="nsc">Sample Code*</label>
						{{ $sampCode }}
					</td>	
					<td>
						<label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="category">Category*</label>
						<div class="relative h-8 w-72 min-w-[200px]">
						{{ $category_name }}
						</div>
					</td>
					<td>
						<label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="category">Vendor</label>
						<div class="relative h-8 w-72 min-w-[200px]">
						{{ $vendor_name }}
						</div>
					</td>
					<td>
					</td>
				</tr>

				<tr>
					<td>
						<label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="type">Cat Number*</label>
						{{ $catalogNumber }}
					</td>
					<td colspan="3">
						<label class="block text-gray-900 text-sm font-bold mb-2" for="sampdesc">Name*</label>
						{{ $itemDesc }}
					</td>
				</tr>

				
				<tr>
					<td>
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="bulkcode">Status</label>
						<div class="relative h-8 w-72 min-w-[200px]">
							@if($sampCode != null )
								@if($open_status == 1) 
									Unopened 
								@else 
									Opened 
								@endif 
							@endif
						</div>
					 </td>
					 <td>
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="usercode">Status Date</label>
						<div class="relative h-8 w-72 min-w-[200px]">
							@if($sampCode != null )
								{{ date('d-m-Y', strtotime($status_date)) }}
							@endif
						</div>
					 </td>
					 <td>
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="bulkcode">Quantity Left</label>
						<div class="relative h-8 w-72 min-w-[200px]">
							{{ $quantity_left }} @if($unit_desc1 == 'm') &#956; @endif {{ $unit_desc2 }}
						</div>
					 </td>
					 <td>
						
					 </td>
				</tr>

				<tr>
					<td colspan="3">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="username">Expt ID*</label>
						<div class="relative h-8 w-72 min-w-[200px]">	
							<input type='text' placeholder="Experiment ID" class="shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="expt_id">
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="username">Expt Date*</label>
						<div class="relative h-8 w-72 min-w-[200px]">	
							<input type='date' placeholder="Quantity Consumed" class="shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="expt_date">

						</div>						  
					</td>
				</tr>
				<tr>          
					<td colspan="3">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="username">Consumed*</label>
						<div class="relative h-8 w-72 min-w-[200px]">	
							<input type='text' placeholder="Quantity Consumed" class="shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="consumed">

						</div>						  
					</td>
				</tr>
				<tr>
					<td colspan="3">
					  <label class="block text-gray-900 text-sm pt-3 mb-2" for="sampdesc">
							Notes, if any: 
					  </label>
					  <input placeholder="Notes, if any" class="shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="notes_ifany">
					</td>
				</tr>
				<tr>
					 <td colspan="4" class="text-sm text-gray-900">
						</br>
						@hasanyrole('pisg|researcher|manager')
							@if($sampCode != "")
							<button wire:click="postConsumptionInfo()" class="btn btn-warning btn-sm rounded">Update Consumption</button>
							@endif
						@endhasanyrole
					 </td>
				</tr>						
			</tbody>    
		</table>
	@endif
