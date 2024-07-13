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
      				<div class="bg-orange-100 border border-gray-900 rounded shadow">
						<div class="border-b border-gray-800 p-3">
          					<h5 class="font-bold uppercase text-gray-900">New Project</h5>
        				</div>
						<div class="w-2/3 p-5">
							{!! Form::open(['method' => 'POST', "enctype" => "multipart/form-data", 'route' => ['piprojects.store']]) !!}
								<label class="block text-gray-900 text-sm font-normal mb-2" for="username">
									Name*
								</label>

								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" value="{{ Auth::user()->name }}" id="name" name="name" type="text" placeholder="{{ Auth::user()->name }}">


								<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="title">
									Title*
								</label>

								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="title" name="title" type="text" placeholder= "Project title">
								<p class="help-block"></p>
								@if($errors->has('title'))
                  					<p class="help-block text-red-900">
                    					{{ $errors->first('title') }}
                  					</p>
								@endif
								
								<div class="grid gap-4 grid-cols-2 grid-rows-1">
    								<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="start date">
    									Start Date*
    									<input class="shadow disabled appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="start_date" name="start_date" type="date" placeholder="Start Date">
        								@if($errors->has('start_date'))
                          					<p class="help-block text-red-900">
                            					{{ $errors->first('start_date') }}
                          					</p>
        								@endif
    								</label>
    								
    								<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="end date">
    									End Date*
    									<input class="shadow disabled appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="end_date" name="end_date" type="date" placeholder="End Date">
        								@if($errors->has('end_date'))
                          					<p class="help-block text-red-900">
                            					{{ $errors->first('end_date') }}
                          					</p>
        								@endif
    								</label>
								</div>
								
								<label class="py-2 block text-gray-900 text-sm font-normal mt-3 mb-2" for="end date">
									Strain Details: For all years  will be calculated based on species/strain/year wise.
								</label>

								<table class="w-full p-5 text-gray-700">
									<tbody>
                    					<tr>
										</tr>
										<?php $prevName = '';
											$stnInfo = $freestrains->merge($own_strains);
										?>
				                      @if(!empty($stnInfo))
				                        <tr class="pt-1 pb-1 bg-green-100">
				                          <td align="center" class="text-gray-900 text-xs font-normal" >Check</td>
				                          <td class="pt-1 pb-1 text-gray-900 text-xs font-normal text-center"> Strain </td>
				                          <td class="pt-1 pb-1 text-gray-900 text-xs font-normal"> Year 1 </td>
				                          <td class="pt-1 pb-1 text-gray-900 text-xs font-normal"> Year 2 </td>
				                          <td class="pt-1 pb-1 text-gray-900 text-xs font-normal"> Year 3 </td>
				                          <td class="pt-1 pb-1 text-gray-900 text-xs font-normal"> Year 4 </td>
				                          <td class="pt-1 pb-1 text-gray-900 text-xs font-normal"> Year 5 </td>
				                        </tr>
				                        @foreach ($stnInfo as $val)
											{{ $val->species_name }}
				                          @if ($val->species->species_name != $prevName)
				                            <tr class="pt-1 pb-1">
				                              <td  class="bg-indigo-200" align="center" >
				                                {!! Form::checkbox('species[]', $val->species->species_name."_".$val->species->species_id ) !!}
				                              </td>
				                              <td  class="py-1 bg-indigo-200" colspan="6">
				                                <label for="sps" class="text-gray-800 text-xs font-normal">Check box if {{ $val->species->species_name }} Required</label>
				                              </td>
				                            </tr>
				                          @endif
                            			<tr class="bg-green-100 rounded-lg text-gray-900 text-sm font-normal mt-3 mb-4">
                              				<td  class="py-2" align="center">
                                				{!! Form::checkbox('exp_strain[]', $val->species->species_name."_".$val->strain_name ) !!}
                              				</td>
                              				<td class="py-2 block text-gray-900 text-xs mt-1 mb-1 font-normal">
                                				{{ $val->strain_name }}
                              				</td>
                              				<td class="py-2">
                                				{!! Form::number($val->strain_name."[]", "", ['class' => "py-1 input bg-orange-200 text-gray-800", 'style'=>"width: 60px;"]) !!}
                              				</td>
                              				<td class="py-2">
                                				{!! Form::number($val->strain_name."[]", "", ['class' => "py-1 input bg-orange-200 text-gray-800", 'style'=>"width: 60px;"]) !!}
                              				</td>
                              				<td class="py-2">
                                				{!! Form::number($val->strain_name."[]", "", ['class' => "py-1 input bg-orange-200 text-gray-800", 'style'=>"width: 60px;"]) !!}
                              				</td>
                              				<td class="py-2">
                                				{!! Form::number($val->strain_name."[]", "", ['class' => "py-1 input bg-orange-200 text-gray-800", 'style'=>"width: 60px;"]) !!}
                              				</td>
                              				<td class="py-2">
                                				{!! Form::number($val->strain_name."[]", "", ['class' => "py-1 input bg-orange-200 text-gray-800", 'style'=>"width: 60px;"]) !!}
                              				</td>
                            			</tr>
										<?php $prevName = $val->species->species_name; ?>
                        				@endforeach
                        					<tr>
                          						<td colspan="7"></td>
                        					</tr>
                      					@endif
								</table>
								@if($errors->has('species'))
                  					<p class="help-block text-red-800">
                    					{{ $errors->first('species') }}
                  					</p>
								@endif
								@if($errors->has('exp_strain'))
                  					<p class="help-block text-red-800">
                    					{{ $errors->first('exp_strain') }}
                  					</p>
								@endif

								</br>
								{!! Form::label('filename', "Project File", ['class' => 'text-gray-800 text-sm font-normal control-label']) !!}
								</br>
								{!! Form::file('userfile',  ['class'=>"text-gray-800 text-sm font-normal", "file"=>"true", "enctype" => "multipart/form-data"]) !!}
								@if($errors->has('userfile'))
                  					<p class="help-block text-red-800">
                    					{{ $errors->first('userfile') }}
                  					</p>
								@endif

								<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="remarksifany">
									Remarks if any
								</label>

								<input class="shadow disabled appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="spcomments" name="spcomments" type="text" placeholder="Remarks">
								<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="agree">
									The above ready for submission
								</label>
                				{!! Form::checkbox('agree', '', false, ['class'=>"input", 'required'=>"required"] ) !!}
								<div class="py-4 mt-2">
									<x-button class="btn btn-xs text-xs text-gray-100 btn-info p-1">Submit</x-button>
								</div>
							{!! Form::close() !!}
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
