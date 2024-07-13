	<!--Table Card-->                
	<!-- insert table -->
  <table id="inventory" class="table  table-bordered table-hover">
  
    <thead>
    <tr>
    <th colspan="2">
      Details of Product ID:
    {{ $pinfos->pack_mark_code }}
    </th>
    </tr>
		</thead>
		<tbody> 
			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="category">Category*</label>
        </td>
        <td>
        <div>
        {{ $pinfos->category_id }}
				</div>
				</td>
      </tr>
      
      <tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Select Project*</label>
        </td>
        <td>
					<div class="">
          {{ $pinfos->resproject_id }}
					</div>
				</td>
			</tr>
			
			<tr>
				<td class="p-1 mb-1 bg-primary text-white" align="center" colspan="2"> 
					<label class="block text-sm font-normal font-bold mt-1 mb-1" class="form-group rounded" for="stroeinfos">
						Product Information*
					</label>
				</td>
			</tr>
      
			<tr>
				<td>
				  <label class="block text-sm font-normal font-bold" for="type">Cat Num*</label>
        </td>
        <td>
        {{ $pinfos->catalog_id }}
				</td>
      </tr>
      
      <tr>        
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="sampdesc">Name*</label>
        </td>
        <td>
        {{ $pinfos->name }}
				</td>
			</tr>
      
			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Vendor</label>
        </td>
        <td>
					<div class="relative h-8 w-72 min-w-[200px]">
						{{ $pinfos->catalog_id }}
					</div>
				</td>
      </tr>
      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="usercode">Pack Size</label>
        </td>
        <td>
        {{ $pinfos->pack_size }} {{ $pinfos->units->description }}
				</td>
      </tr>
      
      <tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Unit Desc</label>
        </td>
        <td>
					<div>
						{{ $pinfos->units->description }}
					</div>
				</td>
      </tr>
      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Num Packs</label>
        </td>
        <td>
        {{ $pinfos->num_packs }}
				</td>
			</tr>

			<tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="usercode"> Batch Code</label>
        </td>
        <td>
        {{ $pinfos->batch_code }}
				</td>
			</tr>
      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="usercode">Cost</label>
        </td>
        <td>
        {{ $pinfos->vial_cost }}
				</td>
			</tr>	

      <tr>	
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Currency</label>
        </td>
        <td>
					<div class="relative h-8 w-72 min-w-[200px]">
						{{ $pinfos->item_currency }}
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Date MFD</label>
        </td>
        <td>
        {{ $pinfos->mfd_date }}
				</td>
			</tr>
      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Expiry date</label>
        </td>
        <td>
        {{ $pinfos->expiry_date }}
				</td>
			</tr>
			
			<tr>
				<td class="p-1 mb-1 bg-primary text-white" align="center" colspan="2"> 
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="stroeinfos">Storage Info*</label>
				</td>
			</tr>
			
			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="username">Container*</label>
        </td>
        <td>
					<div class="relative">
						{{ $pinfos->storage_container_id }}
					</div>
				</td>
      </tr>
      
      <tr>      
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="username">Comp ID*</label>
        </td>
        <td>
        {{ $pinfos->shelf_rack_id }}
				</td>
      </tr>
      
      <tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="username">Box/SackID*</label>
        </td>
        <td>
        {{ $pinfos->box_id }} / {{ $pinfos->box_position_id }}
				</td>
      </tr>
      
      <tr>        
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="seriescode">LocationID</label>
        </td>
        <td>
        {{ $pinfos->open_storage  }}
				</td>
			</tr>
			
			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="sampdesc">Notes, If any</label>
        </td>
        <td>
        {{ $pinfos->notes }}
				</td>
			</tr>
			
			<tr>
        <td colspan="2">
        </td>
			</tr>
		</tbody>    
	</table>	
	