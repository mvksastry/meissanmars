<!--Table Card-->
<div class="w-1/2 p-3">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
		<h5 class="font-bold uppercase text-gray-900">Select File</h5>
		</div>
		<div class="p-5">

			<table id="userIndex2" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th colspan ="3"> Report for Project ID: {{ $project_id }} </th>
					</tr>
				</thead>
				<tbody>
					<tr class="border-b bg-indigo-100 border-indigo-200">
						<td class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">
							Report
						</td>
						<td colspan ="2" class="text-sm text-gray-900 font-medium px-3 py-1 whitespace-nowrap">
							<select name="type" wire:model="reportx" class="shadow appearance-none border border-red-500 rounded w-auto py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" id="reportx" name="reportx" type="select">
							<option value="Monthly">Montly</option>
							<option value="Querterly">Querterly</option>
							<option value="HalfYear">Half Year</option>
							<option value="Annual">Annual</option>
							<option value="Completion">Completion</option>
						</td>
					</tr>
					<tr>
						<td>
							From
						</td>
						<td colspan ="2">
							<input size="5" wire:model="repFromDate" class="shadow appearance-none border border-red-500 rounded w-auto py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" id="repFromDate" name="repFromDate" type="date">
						</td>
					</tr>
					<tr>
						<td>
							To
						</td>
						<td colspan ="2">
							<input size="5" wire:model="repToDate" class="shadow appearance-none border border-red-500 rounded w-auto py-1 px-1 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" id="repToDate" name="repToDate" type="date">
						</td>
					</tr>
					<tr>
						<td colspan ="3">
							<input type="file" wire:model="photo">
							@error('photo')
							<span class="error">{{ $message }}</span>
							@enderror
						</td>
					</tr>
					<tr>
						<td colspan ="2">
						</td>
						<td align="right">
							<button wire:click="" class="btn btn-primary rounded">Save</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--/table Card-->

<!--Table Card-->
<div class="w-1/2 p-3">
	<div class="bg-orange-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3">
			<h5 class="font-bold uppercase text-gray-900">List of Reports for Project Id: {{ $project_id }}</h5>
		</div>
		<div class="p-5">
			<table id="userIndex2" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th> Type </th>
						<th> From </th>
						<th> To </th>
						<th> Posted By </th>
						<th> View </th>
					</tr>
				</thead>
				<tbody>
					@foreach ($projReps as $val)
						<tr>
							<td>
							{{ $val->report_type}}
							</td>
							<td>
							{{ date('d-m-Y', strtotime($val->date_from))}}
							</td>
							<td>
							{{ date('d-m-Y', strtotime($val->date_to))}}
							</td>
							<td>
							{{ $val->user->name}}
							</td>
							<td>
							<button wire:click="piReportDownload('{{ $val->filename }}')" class="bg-blue-500 w-20 hover:bg-blue-800 text-white font-normal py-2 px-2  mx-3 rounded">View</button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--/table Card-->
