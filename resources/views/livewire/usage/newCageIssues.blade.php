<!--Table Card-->
<div class="w-1/2 md:w-1/2 p-3">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-900">Induct New Cages</h5>
		</div>
		<div class="p-5">
			<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
				<thead class="bg-gray-900">
					<tr class="text-white text-left">
						<th class="font-semibold text-sm uppercase px-6 py-2"> Item </th>
						<th class="font-semibold text-sm uppercase px-6 py-2"> Details </th>
					</tr>
				</thead>
				<tbody>
					@foreach($issInfos as $x)
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Issue Id</td>
							<td class="text-left text-gray-900">{{ $x->issue_id }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Project Id</td>
							<td class="text-left text-gray-900">{{ $x->project_id }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">PI</td>
							<td class="text-left text-gray-900">{{ $x->user->name }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Strain</td>
							<td class="text-left text-gray-900">{{ $x->strain->strain_name }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Sex, Age, Ageunit</td>
							<td class="text-left text-gray-900">{{ $x->sex }}, {{ $x->age }} {{ $x->ageunit }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Required Number</td>
							<td class="text-left text-gray-900">{{ $x->number }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Required Cages</td>
							<td class="text-left text-gray-900">{{ $x->cagenumber }}</td>
						</tr>
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">Status</td>
							<td class="text-left text-gray-900">{{ $x->status_date }}</td>
						</tr>
					@endforeach

						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" colspan="2">
									<strong>Suggestions</strong>
							</td>
            </tr>

					@foreach($slotInfos as $row)
						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" >
									Rack {{ $row->rack_id }}
							</td>
							<td>
								Vacant: {{ $row->total }}
							</td>
            </tr>
					@endforeach

						<tr class="border-b bg-purple-100 border-indigo-200" class="mt-20">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" >
									<strong>Max # per Cage</strong>
							</td>
							<td>
								<input type="text" class="text-left text-gray-900" wire:model="animalnum">
							</td>
            </tr>

						<tr class="border-b bg-purple-100 border-indigo-200" class="mt-10">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" >
									<strong> Required Cages #</strong>
							</td>
							<td>
							{{ $cagesRequired }}
							</td>
            </tr>

						<tr class="border-b bg-purple-100 border-indigo-200" class="mt-10">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" >
									<strong> Rack Number</strong>
							</td>
							<td>
								<input type="text" class="text-left text-gray-900" wire:model="racknum">
							</td>
            </tr>

						<tr class="border-b bg-purple-100 border-indigo-200" class="mt-10">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">
								<label class="text-left text-gray-900" for="comment">Notes:</label>
							</td>
							<td colspan="2">
								<textarea class="form-control" id="notes" wire:model="notes" rows="4" cols="40" id="Notes"></textarea>
							</td>
						</tr>

						<tr class="border-b bg-purple-100 border-indigo-200">
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" colspan="2" align="center"></td>
						</tr>

						<tr>
							<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap" colspan="2" align="center">
								<button wire:click="inductRequiredCages('{{ $x->issue_id }}')" type="button" class="bg-pink-500 w-40 hover:bg-blue-800 text-white font-normal py-2 px-2  mx-3 rounded">Induct New Cages</button>
							</td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--/table Card -->
