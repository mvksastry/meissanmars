	<!--Table Card-->                
	<!-- insert table -->
  <table id="userIndex2" class="table table-sm table-bordered table-hover">
    <thead>
			<tr>
				<th align="center">
          @hasanyrole('manager')
            <button wire:click="showNewCategoryCreation()" class="btn btn-success rounded">Add Category</button>
          @endhasanyrole
        </th>       
        <th align="center">
          @hasanyrole('manager')
            <button wire:click="showBulkAdditionOption()" class="btn btn-warning rounded">Bulk Addition</button>
          @endhasanyrole
				</th>
        <th align="center">
          @hasanyrole('manager')
            <button wire:click="showBulkAdditionOption()" class="btn btn-danger rounded">Clear All</button>
          @endhasanyrole
				</th>
			</tr>
		</thead>
		<tbody> 
    </tbody>
  </table>

  <table id="userIndex2" class="table table-sm table-bordered table-hover">
    <thead>
			<tr>
				<th align="center">
        </th>       
        <th align="center">
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
						<select wire:model="category_id" class="form-group font-normal rounded" 	 
							aria-label="Category">
              <option value="-1">Select</option>
							@foreach($categories as $category)
							<option value="{{ $category->category_id }}">{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
				</td>
      </tr>
      
      <tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Select Project*</label>
        </td>
        <td>
					<div class="">
						<select wire:model="resproj_id" class="form-group font-normal rounded" aria-label="Category">						
              <option value="-1">Select</option>
							<option value="100">EAF Project</option>
						</select>
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
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Vendor</label>
        </td>
        <td>
					<div class="relative h-8 w-72 min-w-[200px]">
						<select wire:model="source_desc" class="form-group rounded boarder" 	 
							aria-label="Category">
						<option value="-1">Select</option>
							@foreach($suppliers as $supplier)
							<option value="{{ $supplier->supplier_id }}">{{ ucfirst($supplier->name) }}</option>
							@endforeach
						</select>
					</div>
				</td>
      </tr>
      
			<tr>
				<td>
				  <label class="block text-sm font-normal font-bold" for="type">Cat Num*</label>
        </td>
        <td>
				  <input class="form-group border rounded" id="description" wire:model="catalog_number" type="text">
				</td>
      </tr>
      
      <tr>        
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="sampdesc">Name*</label>
        </td>
        <td>
				  <input placeholder="Description" class="form-group rounded border" wire:model.defer="item_desc">
				</td>
			</tr>
      

      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="usercode">Pack Size</label>
        </td>
        <td>
				  <input class="form-group border rounded" id="approvedBy" wire:model="pack_size" type="text">
				</td>
      </tr>
      
      <tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Unit Desc</label>
        </td>
        <td>
					<div>
						<select wire:model="units_desc" class="form-group border rounded" aria-label="Category">
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
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Num Packs</label>
        </td>
        <td>
				  <input class="form-group border rounded" id="approvedDate" wire:model="number_packs" type="text">
				</td>
			</tr>


      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="usercode">Cost</label>
        </td>
        <td>
				  <input class="form-group border rounded" wire:model="vialCost" type="text">
				</td>
			</tr>	

      <tr>	
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Currency</label>
        </td>
        <td>
					<div class="relative h-8 w-72 min-w-[200px]">
						<select wire:model="costCurrency" class="form-group border rounded" 	 
							aria-label="Category">						
							<option value="-1">Select</option>
							<option value="inr">IN Rupee</option>
							<option value="usd">US $</option>
							<option value="gbp">GB P</option>
							<option value="jpy">JP Y</option>
							<option value="euro">Euro</option>
						</select>
					</div>
				</td>
			</tr>

			<tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="usercode"> Batch Code</label>
        </td>
        <td>
				  <input class="form-group border rounded" wire:model="batchCode" type="text">
				</td>
			</tr>

			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Date MFD</label>
        </td>
        <td>
						<input class="form-group boarder rounded" id="approvedDate" wire:model="dateMFD" type="date">
				</td>
			</tr>
      
      <tr>
				<td>
				  <label class="block text-sm font-normal font-bold mt-1 mb-1" for="bulkcode">Expiry date</label>
        </td>
        <td>
				  <input class="form-group border rounded" id="approvedDate" wire:model="dateExpiry" type="date">
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
						<select wire:model="container_id" class="form-group border rounded" aria-label="Category">
							
						<option value="-1">Select</option>
							@foreach($repositories as $row)
							<option value="{{ $row->repository_id }}">{{ $row->repository_type }}</option>
							@endforeach
						</select>
					</div>
				</td>
      </tr>
      
      <tr>      
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="username">Comp ID*</label>
        </td>
        <td>
					<input size="15" class="form-group border rounded" id="validTill" wire:model="rack_shelf" type="text">
				</td>
      </tr>
      
      <tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="username">Box/SackID*</label>
        </td>
        <td>
					<input size="15" class="form-group border rounded" id="validTill" wire:model="box_sack" type="text">
				</td>
      </tr>
      
      <tr>        
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="seriescode">LocationID</label>
        </td>
        <td>
					<input size="15" class="form-group border rounded" id="approvedRef" wire:model="location_code" type="text">
				</td>
			</tr>
			
			<tr>
				<td>
					<label class="block text-sm font-normal font-bold mt-1 mb-1" for="sampdesc">Notes, If any</label>
        </td>
        <td>
					<input type="text" placeholder="Sample remarks, if any" class="form-group border rounded" wire:model.defer="note_remark">
				</td>
			</tr>
			
			<tr>
        <td colspan="2">
            
          @hasanyrole('manager')
          <button wire:click="postProductInfo()" class="btn btn-success rounded">Add To Inventory</button>
          @endhasanyrole
        </td>
			</tr>
		</tbody>    
	</table>	
	