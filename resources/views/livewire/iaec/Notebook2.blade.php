<!--Table Card-->
<div class="w-full">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-2">
		<h5 class="font-bold uppercase text-gray-900">Form-D / Notebook Entries: Input Fields with * Mandatory</h5>
		</div>
		<div class="p-1">
      <table id="userIndex2" class="table table-sm table-bordered table-hover">
				<thead>
					<tr>
						<th> Entered By </th>
						<th> Entry Date </th>
						<th> Animal # </th>
						<th> Details </th>
						<th> Expt. Date </th>
						<th> Expt. Desc </th>
					</tr>
				</thead>
				<tbody>
					@foreach($nbqs as $row)
						<tr>
							<td>{{ Auth::user()->name }}</td>
							<td>{{ $row->entry_date }}</td>
							<td>{{ $row->number_animals }}</td>
							<td>{{ $row->species_name }};{{ $row->strain_name }};{{ $row->sex }};{{ $row->age }}- {{ $row->ageunit }}</td>
							<td>{{ $row->expt_date }}</td>
							<td>{{ $row->expt_description }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- inser another table showing images -->

			@if($nbimages != 'None')
				<table id="userIndex2" class="table table-sm table-bordered table-hover">
					<thead>
					</thead>
					<tbody>
						<tr>
							<td>NoteBook ID</td>
							<td>Name</td>
							<td>Date </td>
							<td>Cage # </td>
							<td>Notes</td>
							<td>Image</td>
						</tr>
						@foreach($nbimages as $row)
							<?php   $folder = Auth::user()->folder;
							$tenant = tenant('id');
							$path = 'institutions/'.$folder.'/'.$row->image_file; ?>
							<tr>
								<td>{{ $row->notebook_id }}</td>
								<td>{{ $row->staff_name }}</td>
								<td>{{ $row->entry_date }}</td>
								<td>{{ $row->cage_id }};{{ $row->strain_name }};{{ $row->sex }};{{ $row->age }}- {{ $row->ageunit }}</td>
								<td>{{ $row->remarks }}</td>
								<td><img class="w-20 h-20 " src="{{ asset($path) }}" alt="User Avatar"></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif

			<!-- inser another table showing images -->

			<table id="userIndex2" class="table table-sm table-bordered table-hover">
				<thead>
					<tr>
						<th> Usage Id* </th>
						<th> Cage Id* </th>
						<th> Expt. Date </th>
						<th> Protocol </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							{{ $idissue }}
						</td>
						<td>
							{{ $idcage }}
						</td>
						<td>
							<input class="form-control rounded  id="expdate" wire:model.defer="dateexpt" type="date">
						</td>
						<td>
							<input class="form-control rounded"  id="protocolId" wire:model.defer="idprotocol" type="text">
						</td>
					</tr>
				</tbody>
			</table>

			<table id="userIndex2" class="table table-sm table-bordered table-hover">
					<tr>
						<th> Experiment Description </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5">
							<textarea placeholder="Description" class="form-control rounded h-40" wire:model.defer="descexpt"></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		<table id="userIndex2" class="table table-sm table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="4"> Images / Videos </th>
				</tr>
			</thead>
			<tbody>
				<tbody>
					<tr>
						<td>
							<input type="file" class="form-control" wire:model.defer="expimages" multiple>
							@if($errors->has('expimages.*'))
							<p class="help-block text-red-900">
							{{ $errors->first('empimages') }}
							</p>
							@endif
						</td>
						<td colspan="3">
							<input type="text" class="form-control border rounded" placeholder="Enter Legend" wire:model="legend">
							@error('legend.0') <span class="text-danger error">{{ $message }}</span>@enderror
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							</br>
							<button wire:click="saveNotebook()" class="btn btn-success rounded">Save Notebook</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--/table Card-->
