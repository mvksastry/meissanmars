@extends('layouts.nGlobal')
@section('content')
	<!--Container-->
	<div class="container w-full mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
			<!--Console Content-->
			<h5 class="font-normal uppercase text-gray-900">Facility >> Strains Home </h5>
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<div class="flex flex-wrap">

				<!--Metric Card 2 -->
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                  <div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
                    <div class="flex flex-row items-center">
                      <div class="flex-shrink pr-4">
                        <div class="rounded p-3 bg-orange-600">
							<a href="{{ route('strain-manage.create') }}">
								<i class="fas fa-users fa-2x fa-fw fa-inverse"></i>
							</a>
						</div>
                      </div>
                      <div class="flex-1 text-right md:text-center">
                        <h5 class="font-bold uppercase text-gray-900">Add New</h5>
                        <h5 class="font-bold text-sm text-left text-gray-600"></h5>
                      </div>
                    </div>
                  </div>
                </div>
				<!--/End Metric Card 2-->

				<!--Metric Card 1 -->
				<div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <div class="bg-orange-100 border border-gray-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600">
                                	<a href="{{ route('strains.changestatus') }}">
                                		<i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i>
                                	</a>
                                </div>
                            </div>
                            <div class="flex-1 text-left md:text-center">
                                <h4 class="font-bold uppercase text-gray-900">Change Status</h5>
                                <h5 class="font-normal text-left text-sm text-gray-600">		</h5>
                            </div>
                        </div>
                    </div>
				</div>
				<!--/End Metric Card 1-->

            </div>
			<!--End of Console content-->

			<!--Divider-->
			<hr class="border-b-2 border-gray-600 my-4 mx-4">
			<!--Divider-->

            <div class="flex flex-row flex-wrap flex-grow mt-2">
				<!-- Right Panel Graph Card-->
                <div class="w-full p-3">
                    <div class="bg-orange-100 border border-gray-800 rounded shadow">
                        <div class="border-b border-gray-800 p-3">
                        <h5 class="font-bold uppercase text-gray-900">Active Strains</h5>
                        </div>
                		<div class="p-5">
                			<table class='table-auto mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                				<thead class="bg-gray-900">
                					<tr class="text-white text-left">
                					    <th class="font-semibold text-sm uppercase px-8 py-4"> Species</th>
                						<th class="font-semibold text-sm uppercase px-4 py-4"> Strain</th>
                						<th class="font-semibold text-sm uppercase px-4 py-4"> Notes </th>
                						<th class="font-semibold text-sm uppercase px-4 py-4"> Distributable </th>
                						<th class="font-semibold text-sm uppercase px-4 py-4"> Owner </th>
                					</tr>
                				</thead>
                                <tbody class="divide-y divide-gray-200">
                                	@foreach($strains as $row)
                                        <tr>
                                            <td class="px-8 py-4 text-sm text-gray-900">
                                                {{ $row->species->species_name }}
                                            </td>
                                            
                                            <td class="px-4 py-4 text-sm text-gray-900">
                                                {{ $row->strain_name }}
                                            </td>
                                        
                        					<td class="px-4 py-4 text-sm text-gray-900">
                        						{{ $row->notes }}
                        					</td>
                                        
                        					<td class="px-4 py-4 text-sm text-gray-900">
                        						{{ ucfirst($row->distributable) }}
                                            </td>
                                        
                                            <td class="px-4 py-4 text-sm text-gray-900" >
                                            	@if( $row->owner_id != 0 )
                                            		{{ $row->user->name }}
                                            	@else
                                            		Free
                                            	@endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                	    </div>
                		<div class="p-5">
                			<canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                		</div>
                	</div>
                </div>
        		<!-- / End of right Panel Graph Card-->
              </div>
			<!--/ Console Content-->
		</div>
	</div>
	<!--/container-->
