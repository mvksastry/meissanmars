	<!--Table Card-->                
	<!-- insert table -->
	<table class="w-full p-5 text-gray-700">
		<thead>
			<tr>
				<th colspan="4" align="center">
					<label class="block text-gray-900 text-sm font-bold pt-3 mb-2" for="stroeinfos">
						New Category*
					</label>
				</th>
			</tr>
		</thead>
		<tbody> 		
			<tr>
				<td colspan="4"> 
					
				</td>
			</tr>
			
			<tr>
				<td colspan="4">
					<label class="block text-gray-900 text-sm pt-3 mb-2" for="sampdesc">
						New Category
					</label>
					<input type="text" placeholder="Type new category name" class="h-15 shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="newCategory">
					</br>
					@error('newCategory') 
						<span class="text-danger error">{{ $message }}</span>
					@enderror
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<label class="block text-gray-900 text-sm pt-3 mb-2" for="sampdesc">
						Description
					</label>
					<input type="text" placeholder="Type new category description" class="h-15 shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="newCatDesc">
					</br>
					@error('newCatDesc') 
						<span class="text-danger error">{{ $message }}</span>
					@enderror
				</td>
			</tr>
			<tr>
				 <td colspan="3" class="text-sm text-gray-900">
					</br>
					@hasanyrole('pient|manager')
					<button wire:click="postNewCategoryInfo()" class="btn btn-success rounded">Create Category</button>
					@endhasanyrole
				 </td>
			</tr>
		</tbody>    
	</table>