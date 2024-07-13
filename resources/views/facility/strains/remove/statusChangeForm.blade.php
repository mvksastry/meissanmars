@extends('layouts.nGlobal')
@section('content')
	<!--Container-->
	<div class="container w-full mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

			<!--Console Content-->
			<h5 class="font-normal uppercase text-gray-900">Facility >> Strains Home >> Status Change</h5>
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<div class="flex flex-wrap">

      </div>
			<!--End of Console content-->

			<div class="flex flex-row flex-wrap flex-grow mt-2">
				<!-- Right Panel Graph Card-->
		    <div class="w-full p-3">
	        <div class="bg-orange-100 border border-gray-800 rounded shadow">
	            <div class="border-b border-gray-800 p-3">
	              <h5 class="font-bold uppercase text-gray-900">Instructions</h5>
	            </div>
							<div class="p-5">
							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
								<thead class="bg-gray-900">
									<tr class="text-white text-left">
										<th class="font-semibold text-sm uppercase px-6 py-2"> Action </th>
										<th class="font-semibold text-sm uppercase px-6 py-2"> Select </th>
										<th class="font-semibold text-sm uppercase px-6 py-2"> Result </th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
											Make Public
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										    Distributable: Yes; Owner: Free
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										    Available to all
										</td>
									</tr>

									<tr>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
											Owner only
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										    Distributable: No; Owner: Select right owner
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										    Available only to owner
										</td>
									</tr>

									<tr>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
											Owned but distributable
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
				              Distributable: yes; Owner: Select right owner
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										  Available to all
										</td>
									</tr>

									<tr>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
											Remove Strain </br>(permanently or temporarily)
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										    Distributable: No; Owner: Free
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										    Not Available to any
										</td>
									</tr>

									<tr>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
											Restore
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										  Distributable: Yes; Owner: Select Free or Owner
										</td>
										<td class="px-6 py-4 text-gray-900 text-sm font-normal">
										  Available on Owner Status
										</td>
									</tr>
								</tbody>
							</table>
						</div>
	            <div class="p-5">
	            </div>
	        </div>
		    </div>
				<!-- / End of right Panel Graph Card-->

				<!-- Right Panel Graph Card-->
		    <div class="w-full p-3">
	        <div class="bg-orange-100 border border-gray-800 rounded shadow">
            <div class="border-b border-gray-800 p-3">
              <h5 class="font-bold uppercase text-gray-900">Active Strains</h5>
            </div>
						<div class="p-5">
							<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
								<thead class="bg-gray-900">
									<tr class="text-white text-left">
										<th class="font-semibold text-sm uppercase px-6 py-2"> Strain </th>
										<th class="font-semibold text-sm uppercase px-6 py-2"> Notes </th>
										<th class="font-semibold text-sm uppercase px-6 py-2"> Distributable </th>
										<th class="font-semibold text-sm uppercase px-6 py-2"> Owner </th>
									</tr>
								</thead>
								{!! Form::open(['method' => 'POST', 'route' => ['strains.updatestatus']]) !!}
	            	<tbody>
	            		@foreach($strains as $row)
	                	<tr>
                      <td class="px-6 py-4 text-gray-900 text-sm font-normal">
                        <input class="shadow appearance border rounded mt-2 py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" value="{{ $row->strain_id }}" id="strain_id[]" name="strain_id[]" type="checkbox">
                        {{ $row->strain_name }}
                      </td>
	            				<td class="px-6 py-4 text-gray-900 text-sm font-normal">
	            					{{ $row->notes }}
	            				</td>
	            				<td class="px-6 py-4 text-gray-900 text-sm font-normal">
	                      <span class="bg-yellow-200">
	            						<select class="block appearance-none  bg-gray-100 border border-gray-200 p-2 text-gray-600 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="dist" name="dist" value="">
	            							<option value="0">Select</option>
	            								@if( $row->distributable == 'yes')
	            									<option value="1" selected>Yes</option>
	            								@else
	            									<option value="1">Yes</option>
	            								@endif
	            								@if( $row->distributable == 'no')
	            									<option value="2" selected>No</option>
	            								@else
	            									<option value="2">No</option>
	            								@endif
	            						</select>
	            						<p class="help-block"></p>
	            						@if($errors->has('dist'))
	            							<p class="help-block text-red-200">
	            								{{ $errors->first('dist') }}
	            							</p>
	            						@endif
	            					</span>
	                    </td>

                      <td class="px-6 py-4 text-gray-900 text-sm font-normal" >
                          <span class="bg-yellow-200">
                      		<select class="block appearance-none  bg-gray-100 border border-gray-200 p-2 text-gray-600 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="owner" name="owner">
                      			<option value="0">Free</option>
                      				@foreach($users as $user)
                      					@if($row->owner_id == $user->id)
                      					<option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                      					@else
                      						<option value="{{ $user->id }}">{{ $user->name }}</option>
                      					@endif
                      				@endforeach
                      		</select>
                      		<p class="help-block"></p>
                      		@if($errors->has('owner'))
                      			<p class="help-block text-red-200">
                      				{{ $errors->first('owner') }}
                      			</p>
                      		@endif
                      	</span>
                      </td>
	                	</tr>
	              	@endforeach
	          		</tbody>
	        		</table>
						</div>
						<div class="p-5">
							<a href="#"> <x-button class="btn btn-xs bg-grey-800 hover:bg-orange-700 btn-info">Update</x-button></a>
						</div>
						{!! Form::close() !!}
	        </div>
		    </div>
			<!-- / End of right Panel Graph Card-->
			</div>
			<!--/ Console Content-->
		</div>
	</div>
	<!--/container-->
