@extends('layouts.nGlobal')
@section('content')
	<!--Container-->
	<div class="container w-full mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
			<!--Console Content-->
			<h5 class="font-normal uppercase text-gray-900">Facility >> Strains Home >> Add New </h5>
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<div class="flex flex-wrap">
            </div>
		    <!--End of Console content-->
            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <!-- Right Panel Graph Card-->
                <div class="w-1/2 p-3">
                    <div class="bg-orange-100 border border-gray-800 rounded shadow">
                        <div class="border-b border-gray-800 p-3">
                            <h5 class="font-bold uppercase text-gray-900">Active</h5>
                        </div>
                        <div class="p-5">
                            <table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                            	<thead class="bg-gray-900">
                            		<tr class="text-white text-left">
                            			<th class="font-semibold text-sm uppercase px-6 py-2"> Species </th>
                            			<th class="font-semibold text-sm uppercase px-6 py-2"> Strain </th>
                            			<th class="font-semibold text-sm uppercase px-6 py-2"> Distributable / Owner </th>
                            			
                            			<th class="font-semibold text-sm uppercase px-6 py-2"> Notes </th>
                            		</tr>
                            	</thead>
                            <tbody>
                            	@foreach($strains as $row)
                                    <tr class="border-b bg-indigo-100 border-indigo-200">
                                        <td class="text-sm text-gray-900 font-normal px-3 py-1">
                                            {{ $row->species->species_name }}
                                        </td>
                                        <td class="text-xs text-gray-900">
                                            {{ $row->strain_name }}
                                        </td>
                                        <td class="text-xs text-gray-900 text-center">
                                            {{ ucfirst($row->distributable) }} /  
                                            @if( $row->owner_id != 0)
                                                {{ $row->user->name }}
                                            @else
                                                Free
                                            @endif
                                        </td>
                                        <td class="text-xs text-gray-900" >
                                           
                                            </br>
                                            {{ $row->notes }}
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
            
            
            
            <!-- Left Panel Graph Card-->
            <div class="w-1/2  p-3">
                <div class="bg-orange-100 border border-gray-800 rounded shadow">
                    <div class="border-b border-gray-800 p-3">
                    <h5 class="font-bold uppercase text-gray-900">New Strain</h5>
                    </div>
                    <div class="w-full  p-5">
            			{!! Form::open(['method' => 'POST', 'route' => ['strain-manage.store']]) !!}
            				<label class="block text-pink-900 text-sm font-normal mb-2" for="username">
            					Species*
            				</label>
            
            				<span class="bg-yellow-200">
            					<select class="block w-full appearance-none bg-gray-100 border border-gray-200 p-4 text-gray-600 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="species_id" name="species_id">
            						<option value="0">Select</option>
            						@foreach ($species as $x)
            							<option value="{{ $x->species_id }}">{{ $x->species_name }}</option>
            						@endforeach
            					</select>
            					<p class="help-block"></p>
            					@if($errors->has('species_id'))
                                    <p class="help-block text-red-900">
                                    {{ $errors->first('species_id') }}
                                    </p>
            					@endif
            				</span>
            
            
            				<label class="block text-gray-900 text-sm font-normal mt-6 mb-2" for="username">
            					Strain Name*
            				</label>
            				<input class="shadow w-full appearance-none border rounded  py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" value="" id="strain_name" name="strain_name" type="text" placeholder="Strain Name">
            				<p class="help-block"></p>
            				@if($errors->has('strain_name'))
                                <p class="help-block text-red-900">
                                    {{ $errors->first('strain_name') }}
                                </p>
            				@endif
            				<label class="block text-gray-900 text-sm font-normal mt-6 mb-2" for="notes">
            					Notes
            				</label>
            				<input class="shadow w-full appearance-none border rounded  py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" value="" id="notes" name="notes" type="text" placeholder="Notes">
            				<p class="help-block"></p>
            				@if($errors->has('notes'))
                                <p class="help-block text-red-900">
                                    {{ $errors->first('notes') }}
                                </p>
            				@endif
            				
            				
            				<label class="block text-gray-900 text-sm font-normal mt-6 mb-2" for="username">
            					Distributable
            				</label>
            				<span class="bg-yellow-200">
                        		<select class="block w-full appearance-none  bg-gray-100 border border-gray-100 p-4 text-gray-500 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="dist" name="dist">
                        			<option value="0">Select</option>
                        			<option value="1">Yes</option>
                        			<option value="2">No</option>
                        		</select>
                        		<p class="help-block"></p>
                        		@if($errors->has('dist'))
                        			<p class="help-block text-red-900">
                        				{{ $errors->first('dist') }}
                        			</p>
                        		@endif
            				</span>
            				
            				<label class="block text-gray-900 text-sm font-normal mt-6 mb-2" for="username">
            					Per-Diem-cost
            				</label>
            				<span class="bg-yellow-200">
            					<input class="shadow w-full appearance-none border rounded  py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" value="" id="perDiemCost" name="perDiemCost" type="text" placeholder="Per-Diem-Cost">
            					    <p class="help-block"></p>
                					@if($errors->has('perDiemCost'))
                						<p class="help-block text-red-900">
                							{{ $errors->first('perDiemCost') }}
                						</p>
                					@endif
            				</span>
            
            				<div class="py-4 mt-2">
            					<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Submit</x-button>
            				</div>
            				{!! Form::close() !!}
            			</canvas>
                    </div>
                </div>
            </div>
            <!-- / End of Left Panel Graph Card-->
            </div>
			<!--/ Console Content-->
		</div>
	</div>
	<!--/container-->
