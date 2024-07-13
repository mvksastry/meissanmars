	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
		<table class="table table-sm">
			<thead>
				<tr>
					<th align="center">
					</th>
				</tr>
			</thead>
			<tbody> 
				<tr>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Made By*</label>
					</td>
 					<td colspan="2">
						{{ Auth::user()->name }}
					</td>         
        </tr>
        <tr>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Date*</label>
					</td>
          <td colspan="2">
						{{ date('d-m-Y') }}
					</td>         
        </tr>
        <tr>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Code*</label>
					</td>
					<td colspan="2">
						{{ $reagentCode }}
					</td>          
				</tr>
				<tr>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Name*</label>
					  <input wire:model.defer="reagent_name" 
            class="form-control form-control-sm" 
            type="text" 
            placeholder="Name">
					</td>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Nickname*</label>
					  <input wire:model.defer="reagent_nickname" 
            class="form-control form-control-sm" 
            type="text" 
            placeholder="Nickname">
					</td>
				</tr>
				<tr>
					<td colspan="4">
            <label for="exampleSelectBorderWidth2">Description*</label>
					  <input wire:model.defer="reagent_desc" 
            class="form-control form-control-sm" 
            type="text" 
            placeholder="Description">
					</td>
				</tr>
				<tr>
					<td colspan="4">
            <label for="exampleSelectBorderWidth2">Classification*</label>
						<div class="relative h-8 w-full min-w-[200px]">
              <select class="custom-select rounded-0" wire:model="reagentClassCode" id="exampleSelectRounded0">
                <option value="-1">Select</option>
                <option value="1">Custom</option>
                <option value="2">Bulk Media-Buffers-Solutions</option>
							</select>
						</div>
					</td>										
				</tr>
			</tbody>
		</table>
	</div>	
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">	
		<table class="table table-sm">
			<thead>
			</thead>
			<tbody>	
				<tr>
					<td colspan="4">
						<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
							Ingradients*(Select from inventory panel)
						</label>
					</td>
				</tr>	
			</tbody>
		</table>
		
		@if($searchResultBox1)
			<div class="p-2 bg-grey-200 border border-gray-800 rounded shadow">
				<table class="table table-sm">
					<thead>
						<tr>
						</tr>
					</thead>
					<tbody>
						@foreach($inputs as $key1 => $row)
							<tr>
								<td class="px-2 py-2 text-sm text-gray-900"> Pack Mark Code</td>
								<td>
									{{ $inputs[$key1]['pmc'] }}
								</td>
							</tr>
							<tr>
								<td class="px-2 py-2 pb-2 text-sm text-gray-900">Name</td>
								<td>
									{{ $inputs[$key1]['name'] }}
								</td>
							</tr>
							<tr>
								<td class="px-2 py-2 pb-2 text-sm text-gray-900">Quantity</td>
								<td>      
									<input type="text" class="w-1/2 shadow appearance-none border border-red-500 
										rounded w-auto py-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline"  wire:model="quantityProd.{{ $key1 }}" placeholder="Used">
										@if($inputs[$key1]['unit_desc1'] == 'm') &#956; @endif{{ $inputs[$key1]['unit_desc2'] }}
										@error('usageProd.'.$row['usage']) 
										<span class="text-danger error">{{ $message }}</span>
										@enderror
									
								</td>
							</tr>
							<tr>
								<td class="px-2 py-2 text-sm text-gray-900">Usage</td>
								<td>      
									<input type="text" class="w-full shadow appearance-none border border-red-500 
										rounded w-auto py-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline"  wire:model="usageProd.{{ $key1 }}" placeholder="Description">
										@error('usageProd.'.$row['usage']) 
										<span class="text-danger error">{{ $message }}</span>
										@enderror
								</td>
							</tr>
							<tr class="pb-2">
								<td colspan="2">
									<button class="btn btn-warning btn-sm rounded" wire:click.prevent="removeSelectedItem({{$key1}})">Remove</button>
								</td>
							</tr>								
						@endforeach
					</tbody>    
				</table>
			</div>
		@endif

		<table class="table table-sm">
			<thead>
			</thead>
			<tbody>		
				<tr>
					<td >
            <label for="exampleSelectBorderWidth2">Quantity Made*</label>
					  <input wire:model.defer="quantity_made" 
            class="form-control" 
            type="text" 
            placeholder="Number only">
					</td>
        </tr>
        <tr>
					<td>
						<label for="exampleSelectBorderWidth2">Unit Desc*</label>
						<div class="relative h-8 w-full min-w-[200px]">
              <select class="custom-select rounded-0" wire:model="units_desc" id="exampleSelectRounded0">
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
            <label for="exampleSelectBorderWidth2">Expiry Date*</label>
					  <input wire:model.defer="expirty_date" 
            class="form-control form-control-sm" 
            type="date" 
            placeholder="Number only">
					</td>											
				</tr>
			</tbody>
		</table>
	</div>
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
		<table class="table table-sm">
			<thead>
			</thead>
			<tbody>			
				<tr>
					<td colspan="4"> 
            <label for="exampleSelectBorderWidth2">Storage Information*</label>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Container*</label>
            
            <div class="relative h-8 w-full min-w-[200px]">
              <select class="custom-select rounded-0" wire:model="container_id" id="exampleSelectRounded0">
                <option value="-1">Select</option>
									@foreach($repositories as $row)
                  <option value="{{ $row->repository_id }}">{{ $row->repository_type }}</option>
                  @endforeach
							</select>
						</div>
					</td>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Compartment ID*</label>
						<input wire:model.defer="rack_shelf" 
            class="form-control" 
            type="text" 
            placeholder="Compartment">
					</td>
				</tr>
				<tr>
					<td colspan="2">
            <label for="exampleSelectBorderWidth2">Box/Sack ID*</label>
						<input wire:model.defer="box_sack" 
            class="form-control" 
            type="text" 
            placeholder="Box or Sack">						
					</td>
					<td colspan="2">
          <label for="exampleSelectBorderWidth2">Location ID*</label>
						
						<input wire:model.defer="location_code" 
            class="form-control" 
            type="text" 
            placeholder="Location">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="p-2 mt-3 bg-grey-200 border border-gray-800 rounded shadow">
		<table class="table table-sm">
			<thead>
			</thead>
			<tbody>			
				<tr>
					<td colspan="4"> 
            <label for="exampleSelectBorderWidth2">Open or Restricted*</label> 
					</td>
				</tr>
        <tr>
					<td colspan="2">
            <div class="ml-xl-4">
              <input wire:model="openrestriced" class="form-check-input" type="radio" name="radio1">  
              <label for="exampleSelectBorderWidth2">Open</label> 		
             </div>
          </td>

					<td colspan="2">
            <div class="ml-xl-4">
              <input wire:model="openrestriced" class="form-check-input" type="radio" name="radio1">    
              <label for="exampleSelectBorderWidth2">Restricted</label>
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
          <label for="exampleSelectBorderWidth2">Notes, If any</label>
						<input wire:model.defer="note_remark" class="form-control" type="text" placeholder="Sample remarks, if any">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<table class="table table-sm">
		<thead>
			<tr>
				<th align="center">
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				 <td colspan="3" class="text-sm text-gray-900">
					</br>
					@hasanyrole('pisg|manager|researcher|veterinarian')
					<button wire:click="postReagentInfo()" class="btn btn-info btn-sm rounded">Post Reagent</button>
					@endhasanyrole
				 </td>
			</tr>
		</tbody>    
	</table>	