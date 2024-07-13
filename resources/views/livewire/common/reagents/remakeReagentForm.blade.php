@if($openRemakeReagentFields)
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
		<table class="w-full p-5 text-gray-700">
			<thead>
				<tr>
					<th align="center">
					</th>
				</tr>
			</thead>
			<tbody> 
				<tr>
					<td colspan="2">
					  <label class="block text-gray-900 text-sm font-bold" for="sampdesc">Made By</label>
						{{ Auth::user()->name }}
					</td>
					<td>
					  <label class="block text-gray-900 text-sm font-bold" for="sampdesc">Date</label>
						{{ date('Y-m-d') }}
					</td>
					<td>
					  <label class="block text-gray-900 text-sm font-bold" for="sampdesc">Code</label>
						{{ $reagentCode }}
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
					  <label class="block text-gray-900 text-sm font-bold" for="sampdesc">Name</label>
					  {{ $rmName }}
					</td>
					<td colspan="2">
					  <label class="block text-gray-900 text-sm font-bold" for="sampdesc">Nickname</label>
						{{ $rmNickName }}
					</td>
				</tr>
				<tr>
					<td colspan="4">
					  <label class="block text-gray-900 text-sm font-bold mb-2" for="sampdesc">Description / Quantity Made</label>
						{{ $rmDesc }}, {{ $rmQuantity }} {{ $rmUnitDesc}}
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
					  <label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="type">Classification*</label>
						<div class="relative h-8 w-full min-w-[200px]">
							<select wire:model="rmReagentClassCode" 
								class="form-select appearance-none
                              block w-full px-3 py-1.5 text-base font-normal
                              text-gray-700 bg-white bg-clip-padding bg-no-repeat
                              border border-solid border-gray-300
                              rounded transition ease-in-out m-0
                              focus:text-gray-700 focus:bg-white 
										border border-red-500 rounded focus:border-blue-600 
										focus:outline-none">
									<option value="-1">Select</option>
									<option value="1">Custom</option>
									<option value="2">Bulk Media-Buffers-Solutions</option>
							</select>
						</div>
					</td>										
				</tr>
				<tr>
					<td colspan="4">
						@error('rmReagentClassCode') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>	
	
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow overflow-x-auto">	
		<table class="w-full p-5 text-gray-700">
			<thead>
				<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
					Ingradients
				</label>
			</thead>
				@if(!empty($rmIngradients)) 
					<tbody>
						<tr>
							<td>
								<label class="block px-2 text-gray-900 text-sm font-bold mb-1" for="sampdesc">
									PM Code
								</label>
							</td>
							<td>
								<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
									Name
								</label>
							</td>
							<td>
								<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
									Cat No
								</label>
							</td>
							<td>
								<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
									Need
								</label>
							</td>
							<td>
								<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
									Qty Left
								</label>
							</td>
						</tr>
						@foreach ($usedReagents as $row)	
							@if(array_key_exists('row_flag', $row))
								<tr class="px-2 bg-red-200 mb-2">
							@else
								<tr class="px-2 bg-gray-200 mb-2">
							@endif
								<td class="px-2 text-gray-800 text-sm font-normal mb-2">
								{{ $row['pmc'] }} 
								</td>
								<td class="px-2 text-gray-800 text-sm font-normal mb-2">
								{{ substr($row['name'], 0, 15) }}.. 
								</td>
								<td class="px-2 text-gray-800 text-sm font-normal mb-2">
								{{ $row['cat_num'] }}
								</td>
								<td class="px-2 text-gray-800 text-sm font-normal mb-2">
								{{ $row['quantity'] }}
								</td>
								<td class="px-2 text-gray-800 text-sm font-normal mb-2">
								{{ $row['quantity_left'] }}
								</td>
							</tr>					
						@endforeach
					</tbody>
				@endif
		</table>
		
		@if(count($altProdInfo) > 0) 
			<table class="w-full p-5 text-gray-700">
				<thead>
					<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
						Alternate Suggestions
					</label>
				</thead>
				<tbody>
					<tr>
						<td>
							<label class="block px-2 text-gray-900 text-sm font-bold mb-1" for="sampdesc">
								Sel
							</label>
						</td>
						<td>
							<label class="block px-2 text-gray-900 text-sm font-bold mb-1" for="sampdesc">
								PMCode
							</label>
						</td>
						<td>
							<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
								Name
							</label>
						</td>
						<td>
							<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
								Cat No
							</label>
						</td>
						<td>
							<label class="block px-2 text-gray-900 text-sm font-bold mb-2" for="sampdesc">
								Qty Left
							</label>
						</td>
					</tr>
					@foreach ($altProdInfo as $row)	
						<tr>
							<td class="px-2 text-gray-800 text-sm font-normal mb-2">
								<input wire:model="rmCodePM.{{ $row->pack_mark_code }}" 
								type="checkbox" class="bg-red-100 
								border-red-300 text-red-500 focus:ring-red-200" />
							</td>
							<td class="px-2 text-gray-800 text-sm font-normal mb-2">
							{{ $row->pack_mark_code }} 
							</td>
							<td class="px-2 text-gray-800 text-sm font-normal mb-2">
							{{ substr($row->name, 0, 15) }}.. 
							</td>
							<td class="px-2 text-gray-800 text-sm font-normal mb-2">
							{{ $row->catalog_id }}
							</td>
							<td class="px-2 text-gray-800 text-sm font-normal mb-2">
							{{ $row->quantity_left }} @if($row->units->symbol == "m") &#956; @endif {{ $row->units->symbol_add }} 
							</td>
						</tr>					
					@endforeach
						<tr class="px-2 mt-3 bg-red-400 mb-2">
							<td colspan="5">
								@error('rmCodePM') <span class="error text-gray-900 text-sm font-normal">{{ $message }}</span> @enderror
							</td>
						</tr>
				</tbody>
			</table>	
		@endif
		</br>

		<table class="w-full p-5 text-gray-700">
			<thead>
			</thead>
			<tbody>		
				<tr>
					<td >
					  <label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="type">Quantity To be Made*</label>
					  <input class="shadow appearance-none border border-red-500 rounded 
					  w-full py-1 text-gray-700 mb-1 leading-tight focus:outline-none 
					  focus:shadow-outline" placeholder="Number only" 
					  wire:model="rmQuantity" type="text">
					</td>
				</tr>
				<tr>
					<td>
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="bulkcode">Unit Desc</label>
						<div class="relative h-8 w-full min-w-[200px]">
							<select wire:model="rmUnits_desc" 
								class="form-select appearance-none
                              block w-full px-3 py-1.5 text-base font-normal
                              text-gray-700 bg-white bg-clip-padding bg-no-repeat
                              border border-solid border-gray-300
                              rounded transition ease-in-out m-0
                              focus:text-gray-700 focus:bg-white 
										border border-red-500 rounded focus:border-blue-600 
										focus:outline-none">
								<option value="-1">Select</option>
									@foreach($units as $unit)
									<option value="{{ $unit->unit_id }}">{{ ucfirst($unit->description) }}</option>
									@endforeach
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>
					  <label class="block text-gray-900 text-sm font-normal font-bold mb-2" for="type">Expiry Date*</label>
					  <input class="shadow appearance-none border border-red-500 rounded 
					  w-full py-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" 
					  id="description" wire:model="rmExpiryDate" type="date">
					 
					</td>											
				</tr>
			</tbody>
		</table>
		
		
		<table class="w-full p-5 text-gray-700">
			<tbody>		
				<tr>
					<td>
						@error('rmQuantity') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmUnits_desc') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmExpiryDate') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
					</td>
				</tr>
			</tbody>
		</table>
		
	</div>
	
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
		<table class="w-full p-5 text-gray-700">
			<thead>
			</thead>
			<tbody>			
				<tr>
					<td colspan="4"> 
						<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
							Storage Information*
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="username">Container*</label>
						<div class="relative h-8 w-72 min-w-[200px]">
							<select wire:model="rmStorContId" 
								class="form-select appearance-none
                              block w-full px-3 py-1.5 text-base font-normal
                              text-gray-700 bg-white bg-clip-padding bg-no-repeat
                              border border-solid border-gray-300
                              rounded transition ease-in-out m-0
                              focus:text-gray-700 focus:bg-white 
										border border-red-500 rounded focus:border-blue-600 
										focus:outline-none">
										<option value="-1">Select</option>
										@foreach($repositories as $row)
										<option value="{{ $row->repository_id }}">{{ $row->repository_type }}</option>
										@endforeach
							</select>
						</div>
					</td>
					<td colspan="2">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="username">Compartment ID*</label>
						<input size="15" placeholder="Compartment" class="shadow appearance-none border 
						border-red-500 rounded w-full py-1 text-gray-700 mb-1 leading-tight focus:outline-none 
						focus:shadow-outline" id="validTill" wire:model="rmShelfRackId" type="text">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="username">Box/Sack ID*</label>
						<input size="15" placeholder="Box or Sack" class="shadow appearance-none border 
						border-red-500 rounded w-full py-1 text-gray-700 mb-1 leading-tight focus:outline-none 
						focus:shadow-outline" id="validTill" wire:model="rmBoxSackId" type="text">
					</td>
					<td colspan="2">
						<label class="block text-gray-900 text-sm font-bold font-normal mb-2" for="seriescode">Location ID</label>
						<input size="15" placeholder="Location" class="shadow appearance-none border 
						border-red-500 rounded w-full py-1 text-gray-700 mb-1 leading-tight focus:outline-none 
						focus:shadow-outline" id="approvedRef" wire:model="rmLocationCode" type="text">
					</td>
				</tr>
			</tbody>
		</table>
		<table class="w-full p-5 text-gray-700">
			<tbody>		
				<tr>
					<td>
						@error('rmStorContId') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmShelfRackId') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmBoxSackId') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
						</br>
						@error('rmLocationCode') <span class="error text-red-900 text-sm font-normal">{{ $message }}</span> @enderror
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
		<table class="w-full p-5 text-gray-700">
			<thead>
			</thead>
			<tbody>			
				<tr>
					<td colspan="4"> 
						<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
							Open or Restricted
						</label>   
					</td>
				</tr>
					<td colspan="2">
						<div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
							<input wire:model="rmOpenRestrict" value="1"
							  class="relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:checked:focus:border-primary"
							  type="radio"/>
							  
							<label
							  class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
							  for="radioDefault01">
							  Open 
							</label>
						</div>
					</td>
					<td colspan="2">
						<div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
							  <input wire:model="rmOpenRestrict" value="0"
							  class="relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:checked:focus:border-primary"
							  type="radio"/>
							<label
							  class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
							  for="radioDefault01">
							  Restricted
							</label>
						</div>
						
					</td>
				</tr>
				<tr>
					<td>
						@error('rmOpenRestrict') <span class="error">{{ $message }}</span> @enderror
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<label class="block text-gray-900 text-sm pt-3 mb-2" for="sampdesc">
							Notes, If any
						</label>
						<input placeholder="Sample remarks, if any" class="h-15 shadow appearance-none 
						border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight 
						focus:outline-none focus:shadow-outline" wire:model.defer="rmNotes">
						@error('rmNotes') <span class="error text-red-900 text-sm">{{ $message }}</span> @enderror
					</td>
				</tr>
			</tbody>
		</table>
		<table class="w-full p-5 text-gray-700">
			<thead>
				<tr>
					<th align="center">
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					 <td colspan="3" class="text-sm text-gray-900">
						<div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
							<input wire:model="rmMakeSame" type="checkbox" class="bg-red-100 border-red-300 text-red-500 focus:ring-red-200" />
							Make Same
	
					 </td>
				</tr>
				<tr>
					<td>
						<span class="error text-red-900 text-sm font-normal">{{ $this->rmMakeSameError }}</span>
						</br>
					</td>
				</tr>
				<tr>
					<td>
						@if(count($rmQuantityErrors) > 0)
							@foreach($rmQuantityErrors as $val)
								<span class="error text-red-900 text-sm font-normal">
									{{ $val }}
								</span>
							@endforeach
						@endif
					</td>
				</tr>
				<tr>
					<td colspan="3" class="text-sm text-gray-900">
						@if(!$stopFlag)
							@hasanyrole('pisg|manager|researcher|veterinarian')
							<button wire:click="postRemakeReagentInfo('{{ $reagentCode }}')" class="btn btn-success rounded">Remake Reagent</button>
							@endhasanyrole
						@endif
					</td>
				</tr>
			</tbody>    
		</table>	
	</div>
@endif