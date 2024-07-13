@extends('layouts.nGlobal')
@section('content')
	<!--Container-->
	<div class="container min-h-screen mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
						
			<!--Divider-->
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<!--Divider-->
			
            <div class="flex flex-row flex-wrap flex-grow mt-2">
            	<div class="w-full p-3">
                    <div class="bg-orange-100 border border-gray-800 rounded shadow">
                		
                        <div class="border-b border-gray-800 p-3">
                          <h5 class="font-bold uppercase text-yellow-600">Projects </h5>
                        </div>

                        <div class="w-full p-5">
                            <h5 class="font-bold uppercase text-gray-800">Submitted</h5>
                                @if( count($subProjects) > 0 )
        							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
        								<thead class="bg-gray-900">
        									<tr class="text-white text-left">
        										<th class="font-semibold text-sm uppercase px-6 py-4"> ID </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> PI </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> Title </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> Status </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> Fetch </th>
        									</tr>
        								</thead>
        							  <tbody>
        									@foreach($subProjects as $row)
        									<tr>
        										<td class="px-6 py-4 text-xs text-gray-800" align="left">{{ $row->tempproject_id }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">{{ $row->user->name }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">{{ $row->title }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">{{ ucfirst($row->status) }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">
        											<a href="{{ route('projectsmanager.submitted',[$row->tempproject_id]) }}">
        												<x-button class="btn btn-xs bg-blue-600 hover:bg-gray-200 text-xs text-gray-200 btn-info">
        													Decision
        												</x-button>
        											</a>
        										</td>
        									</tr>
        									@endforeach
        								</tbody>
        							</table>
        						@else
        							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
        								<thead class="bg-gray-900">
        									<tr class="text-white text-left">
        										<th class="font-semibold text-sm uppercase px-6 py-2"> Submitted projects Not Found. </th>
        									</tr>
        								</thead>
        								<tbody>
        									<tr>
        										<td class="text-xs text-gray-800" align="left"></td>
        									</tr>
        								</tbody>
        							</table>
        						@endif
						        </br></br>
                                <h5 class="font-bold uppercase text-gray-800">Active</h5>
						        @if( count($activeProjects) > 0 )
        							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
        								<thead class="bg-gray-900">
        									<tr class="text-white text-left">
        										<th class="font-semibold text-sm uppercase px-6 py-4"> ID </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> PI </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> Title </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> Status </th>
        										<th class="font-semibold text-sm uppercase px-6 py-4"> Fetch </th>
        									</tr>
        								</thead>
        							  <tbody>
        									@foreach($activeProjects as $row)
        									<tr>
        										<td class="px-6 py-4 text-xs text-gray-800" align="left">{{ $row->tempproject_id }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">{{ $row->user->name }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">{{ $row->title }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">{{ ucfirst($row->status) }}</td>
        										<td class="px-6 py-4 text-xs text-gray-800">
                                                    <a href="{{ route('projectsmanager.show',[$row->project_id]) }}">
                                                    	<x-button class="btn btn-xs bg-yellow-600 hover:bg-gray-200 text-xs text-gray-200 btn-info">
                                                    		Details
                                                    	</x-button>
                                                    </a>
        										</td>
        									</tr>
        									@endforeach
        								</tbody>
        							</table>
        						@else
        							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
        								<thead class="bg-gray-900">
        									<tr class="text-white text-left">
        										<th class="font-semibold text-sm uppercase px-6 py-2"> Submitted projects Not Found. </th>
        									</tr>
        								</thead>
        								<tbody>
        									<tr>
        										<td class="text-xs text-gray-800" align="left"></td>
        									</tr>
        								</tbody>
        							</table>
        						@endif
						</div>
					</div>    
				</div>
			</div>
			<!--/table Card-->
		<!--/ Console Content-->
		</div>
	</div> 
	<!--/container-->
@stop
