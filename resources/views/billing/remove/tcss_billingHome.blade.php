@extends('layouts.nGlobal')
@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
	<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
		<!--Console Content-->
		<h5 class="font-normal uppercase text-gray-900">Billing Home</h5>
		<hr class="border-b-2 border-gray-600 my-2 mx-4">
		<div class="flex flex-wrap">
			<!--Metric Card 1 -->
			<div class="w-full md:w-1/2 p-3">
		    <div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
	        <div class="flex flex-row items-center">
            <div class="flex-shrink pr-4">
              <div class="rounded p-3 bg-green-600">
                <a href="{{ route('billing.perdiem') }}">
                  <i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i>
                </a>
              </div>
            </div>
            <div class="flex-1 text-left md:text-center">
              <h4 class="font-bold uppercase text-gray-900">Per-Diem Cost</h5>
              <h5 class="font-normal text-left text-sm text-gray-600">  </h5>
            </div>
	        </div>
		    </div>
			</div>
			<!--/End Metric Card 1-->

			<!--Metric Card 1 -->
			<div class="w-full md:w-1/2 p-3">
		    <div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
	        <div class="flex flex-row items-center">
            <div class="flex-shrink pr-4">
              <div class="rounded p-3 bg-green-600">
                <a href="#">
                  <i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i>
                </a>
              </div>
            </div>
            <div class="flex-1 text-left md:text-center">
              <h4 class="font-bold uppercase text-gray-900">Project Costs</h5>
              <h5 class="font-normal text-left text-sm text-gray-600"> </h5>
            </div>
	        </div>
		    </div>
			</div>
			<!--/End Metric Card 1-->
    </div>
		<!--Divider-->
		<hr class="border-b-2 border-gray-600 my-8 mx-4">
		<!--Divider-->
		<div class="flex flex-row flex-wrap flex-grow mt-2">
			<div class="w-full md:w-full p-3">
			    <div class="bg-orange-100 border border-gray-800 rounded shadow">
		        <div class="border-b border-gray-800 p-3">
		            <h5 class="font-bold uppercase text-gray-900">Cost By Project</h5>
		        </div>
		        <div class="p-5">
							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
								<thead class="bg-gray-900">
									<tr class="text-white text-left">
										<th class="font-semibold text-sm uppercase px-4 py-4"> Project ID</th>
										<th class="font-semibold text-sm uppercase px-4 py-4"> Total Cages </th>
										<th class="font-semibold text-sm uppercase px-4 py-4"> Cost </th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-200">
									@foreach($cbp as $val)
										<tr>
											<td class="px-4 py-4">
												{{ $val[0] }}
											</td>
											<td class="px-4 py-4">
												{{ $val[1] }}
											</td>
											<td class="px-4 py-4">
												&#x20B9; {{ $val[2] }}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					<canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
				</div>
			</div>
		</div>
		<!--/table Card-->
	</div>
</div>
<!--/container-->
