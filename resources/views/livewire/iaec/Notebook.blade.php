	<!--Table Card-->
	<div class="w-full p-3">
        <div class="bg-orange-100 border border-gray-800 rounded shadow">
            <div class="border-b border-gray-800 p-3">
                <h5 class="font-bold uppercase text-gray-900">Form-D / Note Book Entries: Input Fields with * Mandatory</h5>
            </div>

			<div class="p-5">
				<table class="w-full p-5 text-gray-700">
					<thead>
						<tr>
							<th colspan="4" align="center">	</th>
						</tr>
					</thead>
					<tbody>				
						<tr>
							<td>
								<form wire:submit.prevent="submit">
								<label class="block text-gray-900 text-sm font-normal pt-3 mb-2" for="username">
									Issue Id*
								</label>
								<select class="shadow appearance-none border rounded  py-2 px-3 mt-2 mb-2 text-base text-gray-900 leading-tight focus:outline-none focus:shadow-outline"  id="psbi1" wire:model.lazy="issueId">
									@if(!empty($issueIdx))
										<option value="0">Select</option>
										@foreach($issueIdx as $val)
										<option value="{{ $val }}">{{ $val }}</option>
										@endforeach
									@else
										<option value="-1">None</option>
									@endif
								<select>
							</td>
						
							<td>
								<label class="block text-gray-900 text-sm font-normal pt-3 mb-2" for="cage_id">
									Cage Id*
								</label>

								<select class="shadow appearance-none border rounded  py-2 px-3 mt-2 mb-2 text-base text-gray-900 leading-tight focus:outline-none focus:shadow-outline"  id="bi1" wire:model="cageId">
								@if(!empty($cages))
						
									<option value="-3">Select</option>
									@foreach($cages as $valx)
									<option value="{{ $valx }}">{{ $valx }}</option>
									@endforeach
								@else
									<option value="-4">None</option>
								@endif
								<select>
							</td>
								
								
							<td>
								<label class="block text-gray-900 text-sm font-normal pt-3 mb-2" for="username">
									Breeder Id*
								</label>
								<select class="shadow appearance-none border rounded  py-2 px-3 mt-2 mb-2 	text-base text-gray-900 leading-tight focus:outline-none focus:shadow-outline"  id="breederId" wire:model.lazy="breederId">
									@if(!empty($breedIdx))
										<option value="0">Select</option>
										@foreach($breedIdx as $valy)
										<option value="{{ $val }}">{{ $valy }}</option>
										@endforeach
									@else
									<option value="-1">None</option>
									@endif
								<select>
							</td>
							
						
						
							<td>
								<label class="block text-gray-900 text-sm font-normal pt-3 mb-2" for="expdate">
									Experiment Date*
								</label>

								<input class="shadow appearance-none border border-red-500 rounded  py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" id="expdate" wire:model.laze="expdate" type="date">
							</td>
						
							<td>
								<label class="block text-gray-900 text-sm font-normal pt-3 mb-2" for="protocolId">
									Protocol* 
								</label>
								<input class="shadow appearance-none border border-red-500 rounded py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" id="protocolId" wire:model.defer="protocolId" type="text">
							</td>
						</tr>
						
						<tr>
							<td colspan="5">
								<label class="block text-gray-900 text-sm font-normal pt-3 mb-2" for="exptdesc">
									Expriment Description*
								</label>
								<textarea placeholder="Description" class="h-40 shadow appearance-none border border-red-500 rounded w-full py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="exptdesc1"></textarea>
							</td>
						</tr>
						
						<tr>
							<td colspan="5">
								<label class="block text-gray-900 text-sm  font-normal pt-3 mb-2" for="imgvid">
									Images / Videos
								</label>
									
										
								<input type="file" class="form-control" wire:model.defer="images" multiple>
								@error('photos.*') <span class="error">{{ $message }}</span> @enderror
								@if($errors->has('images.*'))
									<p class="help-block text-red-900">
										{{ $errors->first('images') }}
									</p>
								@endif
							</td>
						</tr>
					
						<tr>
							<td colspan="5" align="center">
								<button wire:click="saveNotebook" class="bg-pink-500 w-30 hover:bg-blue-800 text-white font-normal py-2 px-3 mx-3  rounded">Note Book</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
    </div>
	<!--/table Card-->
