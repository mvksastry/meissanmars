<div class="w-full md:w-full">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			
		</div>
		<?php $males = 0; $females = 0; $total = 0; $dead = 0; ?>
		<div class="w-full md:w-full">
			<div class="bg-purple-100 border border-gray-800 rounded shadow">
				<div class="border-b border-gray-800">
					<h5 class="font-bold uppercase mx-1 text-gray-600"></h5>
				</div>
				<div class="p-3">
					<table class="table table-bordered table-striped">
					<caption>List of Active Etnries</caption>
						<thead class="thead-dark">
							<th>Mating</br>Key</th>
							<th>Ref ID</th>
							<th>Birth</br>Date</th>
							<th>Total</br>Born</th>
							<th>F </th>
							<th>M</th>
							<th>Dead</th>
							<th>Wean</br>Date</th>
							<th>Status</th>
							<th>Status</br>Date</th>
							<th>Comment</th>
						</thead>
						<tbody>
							@if(count($openLitterEntries) > 0)
								@foreach($openLitterEntries as $row)
								<tr>
									<td class="mx-2">
									{{ $row->_mating_key }}
									</td>
									<td class="mx-2">
									{{ $row->mating->matingRefID }}
									</td>
									<td class="mx-2">
									{{ date('d-m-Y', strtotime($row->birthDate)) }}
									</td>
									<td class="mx-2">
									{{ $row->totalBorn }} <?php $total = $total + $row->totalBorn; ?>
									</td>
									<td class="mx-2">
									{{ $row->numFemale }} <?php $females = $females + $row->numFemale; ?>
									</td>
									<td class="mx-2">
									{{ $row->numMale }} <?php $males = $males + $row->numMale; ?>
									</td>
									<td class="mx-2">
									{{ $row->numberBornDead }} <?php $dead = $dead + $row->numberBornDead; ?>
									</td>
									<td class="mx-2">
									{{ date('d-m-Y', strtotime($row->weanDate)) }}
									</td>
									<td class="mx-2">
									{{ $row->entry_status }} 
									</td>
									<td class="mx-2">
									{{ date('d-m-Y', strtotime($row->entry_status_date)) }} 
									</td>
									<td class="mx-2">
									{{ $row->comment }} 
									</td>
								</tr>
								@endforeach
								<tr>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
									<td class="mx-2 text-bold">Total </td>
									<td class="mx-2 text-bold">{{ $total }}</td>
									<td class="mx-2 text-bold">{{ $males }}</td>
									<td class="mx-2 text-bold">{{ $females }}</td>
									
									<td class="mx-2 text-bold">{{ $dead }}</td>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
									<td class="mx-2"></td>
								</tr>
							@else
								<tr class="bg-warning">
									<td colspan="2" class="border px-2 p-1">
										Litter Details Not Found/Selected
									</td>
								</tr>
							@endif
						</tbody>
					</table>
					


					<table class="w-full p-5 text-sm text-gray-900">
						<thead>
						</thead>
						<tbody>
							<tr class="bg-warning">
								<td colspan="2" class="border px-2 p-1">
								</td>
							</tr>

							<tr>
								<td class="border px-2 p-1">
									Auto Generate Mouse Records
								</td>
								<td class="border px-2 p-1">
									<input wire:model.lazy="agmr" class="form-control-sm border" type="checkbox" value="true">
								</td>
							</tr>

							<tr>
								<td class="border px-2 p-1">
									Base Mouse Id
								</td>
								<td class="border px-2 p-1">
									<input wire:model.lazy="baseMouseId" class="form-control-sm border" type="text">
								</td>
							</tr>
							
							<tr>
								<td class="border px-2 p-1 bg-gray-300">
									Protocol ID
								</td>
								<td class="border bg-gray-300 px-2 p-1">
									<select wire:model.lazy="protoKey" class="form-control-sm border">
										<option value="null">Select</option>
											@foreach($protocols as $item)
												<option value="{{ $item->_mouseProtocol_key }}">{{ $item->id }}</option>
											@endforeach
									</select>
								</td>
							</tr>
							
							<tr>
								<td class="border px-2 p-1 bg-gray-300">
									Use Schedules
								</td>
								<td class="border px-2 p-1 bg-gray-300">
									<select wire:model.lazy="useScheduleKeys" class="form-control-sm border" multiple>
									<option value=""></option>
										@foreach($useScheduleTerms as $item)
											<option value="{{ $item->_useScheduleTerm_key }}">{{ $item->useScheduleTermName }}</option>
										@endforeach
									</select>
								</td>
							</tr>

							<tr bgcolor="#AHDADE">
								<td class="border px-2 p-1">
								</td >
								<td class="border px-2 p-1">											
								</td >
							</tr>
							
							<tr bgcolor="#EAEDED">
								<td class="p-2">
									<font color="red">Generation*</font>
								</td>
								<td>
									<select wire:model.lazy="_generation_key" class="form-control-sm border" name="_generation_key" id="_generation_key">
										<option value=""></option>
										@foreach($generations as $item)
											<option value="{{ $item->generation }}">{{ $item->generation }}</option>
										@endforeach
									</select>
									</br>
									@error('_generation_key') <span class="text-danger error">{{ $message }}</span> @enderror
								</td>
							</tr>

							<tr>
								<td class="border px-2 p-1">
									Room*
								</td>
								<td class="border px-2 p-1">
									<select wire:model.lazy="room_id" wire:change="roomSelected" class="form-control-sm border" name="room_id" id="room_id">
										<option value="-1"></option>
										@foreach($rooms as $val)
										<option value="{{ $val->room_id }}">{{ $val->room_name }}</option>
										@endforeach
									</select>
									</br>
									@error('room_id') 
										<span class="text-danger error">
											{{ $message }}
										</span> 
									@enderror
								</td>
							</tr>
							<tr>
								<td class="border px-2 p-1">
									<font color="red">Rack*</font>
								</td>
								<td class="border px-2 p-1">
									<select wire:model.lazy="rack_id" wire:change="rackSelected" class="form-control-sm border" name="rack_id" id="rack_id">
										<option value="0"></option>
											@foreach($racksInRoom as $item)
												<option value="{{ $item->rack_id }}">{{ $item->rack_name }}</option>
											@endforeach
									</select>
									</br>
									@error('rack_id') 
										<span class="text-danger error">
											{{ $message }}
										</span> 
									@enderror
								</td>
							</tr>

							<tr class="border">
								<td class="border px-2 p-1">
									<font color="red">Total Free Slots</font>: 
								</td>
								<td class="border px-2 p-1">
									{{ $free_slots }}
								</td>
							</tr>
							<tr class="border">
								<td class="border px-2 p-1"> 
									<font color="red">First 5 Free Slot ID</font>
								</td>

								<td class="border px-2 p-1">
									{{ $fslot_num }}
								</td>
							</tr>
							<tr bgcolor="#EADDED">
								<td class="border px-2 p-1">
									<font color="red">Slot ID</font>
								</td>
								<td class="border px-2 p-1">
									<input wire:model.lazy="slot_id" class="form-control-sm border" placeholder="Auto Selected" value="" type="text">
									(Auto Selected)
									</br>
									@error('slot_id') 
										<span class="text-danger error">
											{{ $message }}
										</span> 
									@enderror
								</td>
							</tr>

							<tr>
								<td class="border px-2  p-1">
									Comments
								</td>
								<td class="border px-2  p-1">
									<input wire:model.lazy="comment" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Comments">
								</td>
							</tr>
							<tr>
								<td class="border px-2 p-1">
									<button wire:click="prepareDBEntryData()" class="btn btn-info rounded">Prepare Entries</button>
								</td>
								<td class="border px-2 p-1">
									
								</td>
							</tr>
						</tbody>
					</table>					
					
					
				</div>
			</div>
		</div>

	</div>
</div>
