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
                    <div class="bg-gray-900 border border-gray-800 rounded shadow">
                		
                        <div class="border-b border-gray-800 p-3">
                          <h5 class="font-bold uppercase text-yellow-600">Project Decision </h5>
                        </div>

                        <div class="w-2/4 p-5">
                            @if(count($subProjects) > 0 )
    				            @foreach($subProjects as $x)
    						        {!! Form::model($subProjects, ['method' => 'PUT', 'route' => ['projectsmanager.update', $x->tempproject_id]]) !!}
    				
    								<label class="block text-pink-200 text-sm font-normal mb-2" for="username">
    									Name*
    								</label>
    								
    								<label class="block w-full h-8 bg-gray-800	text-gray-200 text-sm font-normal mt-3 mb-2">
    									{{ $x->user->name }}
    								</label>
    
    								<label class="block text-pink-200 text-sm font-normal mt-3 mb-2" for="title">
    									Title*
    								</label>
    								
    								<label class="block w-full h-8 bg-gray-800	text-gray-200 text-sm font-normal mt-3 mb-2">
    									{{ $x->title }}
    								</label>
    								
    								<label class="block text-pink-200 text-sm font-normal mt-3 mb-2" for="start date">
    									Start Date*
    								</label>
    								<label class="block w-full h-8 bg-gray-800	text-gray-200 text-sm font-normal mt-3 mb-2">
    									{{ $x->start_date }}
    								</label>
    								
    								<label class="block text-pink-200 text-sm font-normal mt-3 mb-2" for="end date">
    									End Date*
    								</label>
    								
    								<label class="block w-full h-8 bg-gray-800	text-gray-200 text-sm font-normal mt-3 mb-2">
    									{{ $x->end_date }}
    								</label>
    								
    								<label class="block text-pink-200 text-sm font-normal mt-6 mb-2" for="end date">
    									Posted Information
    								</label>
    								
    								<table class="w-full p-5 text-gray-700">
    									<tbody>
    										<tr>
                          <td class="text-yellow-200 text-xs font-normal"> Strain </td>
                          <td class="text-yellow-200 text-xs font-normal"> Year 1 </td>
                          <td class="text-yellow-200 text-xs font-normal"> Year 2 </td>
                          <td class="text-yellow-200 text-xs font-normal"> Year 3 </td>
                          <td class="text-yellow-200 text-xs font-normal"> Year 4 </td>
                          <td class="text-yellow-200 text-xs font-normal"> Year 5 </td>
                        </tr>   
                          @foreach($strainsPosted as $val)
                            <tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                              <td class="text-gray-200 text-xs mt-1 mb-1 font-normal">
                                  {{ $val->strains->strain_name}}
                              </td>
                              <td class="text-gray-200 text-xs mt-1 mb-1 font-normal">
                                  {{ $val->year1 }}
                              </td>
                              <td class="text-gray-200 text-xs mt-1 mb-1 font-normal">
                                  {{ $val->year2 }}
                              </td>
                              <td class="text-gray-200 text-xs mt-1 mb-1 font-normal">
                                  {{ $val->year3 }}
                              </td>
                              <td class="text-gray-200 text-xs mt-1 mb-1 font-normal">
                                  {{ $val->year4 }}
                              </td>
                              <td class="text-gray-200 text-xs mt-1 mb-1 font-normal">
                                  {{ $val->year5 }}
                              </td>
                            </tr>
                          @endforeach
    									</tbody>
    								</table>
    
    								<label class="block text-pink-200 text-sm font-normal mt-3 mb-2" for="end date">
    									Strain Details: For all years  will be calculated based on species/strain/year wise.
    								</label
        							</br>
    
    								<label class="block text-gray-200 text-sm font-normal mt-3 mb-1" for="remarksifany">
    									Remarks
    								</label>
    								<label class="block text-yellow-200 text-sm font-normal mt-1 mb-2" for="remarksifany">
    								{{ $x->notes }}
    								</label>
    								
    								<label class="block text-gray-200 text-sm font-normal mt-3 mb-2" for="remarksifany">
    									IAEC Decision Remarks
    								</label>
    								<input class="shadow disabled appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="iaec_comments" name="iaec_comments" value="" type="text" placeholder="Remarks">
    								@if($errors->has('iaec_comments'))
                                      <p class="help-block text-orange-200">
                                        {{ $errors->first('iaec_comments') }}
                                      </p>
    								@endif
    								
    								<label class="block text-gray-200 text-sm font-normal mt-3 mb-2" for="remarksifany">
    									IAEC Meeting Date
    								</label>
    								<input class="shadow disabled appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="iaec_date" name="iaec_date" value="" type="date" placeholder="IAEC Approval Date: Y-m-d">
    								@if($errors->has('iaec_date'))
                                      <p class="help-block text-orange-200">
                                        {{ $errors->first('iaec_date') }}
                                      </p>
    								@endif
    								
    								<label class="block text-gray-200 text-sm font-normal mt-3 mb-2" for="remarksifany">
    									IAEC Meeting Information
    								</label>
    								<input class="shadow disabled appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="iaec_meeting" name="iaec_meeting" value="" type="text" placeholder="IAEC Meeting Information">
    								@if($errors->has('iaec_meeting'))
                                      <p class="help-block text-orange-200">
                                        {{ $errors->first('iaec_meeting') }}
                                      </p>
    								@endif
    								
    								<label class="block text-gray-200 text-sm font-normal mt-3 mb-2" for="agree">
    									Final Decision
    								</label>
             
    								<label class="block text-green-200 text-sm font-normal mt-3 mb-2" for="agree">
                                        {!!  Form::radio('decision', '1', false) !!} Approved
    								</label>
    
    								<label class="block text-red-200 text-sm font-normal mt-3 mb-2" for="agree">
      							        {!!  Form::radio('decision', '0', false) !!} Not Approved
    								</label>
    								@if($errors->has('decision'))
                                      <p class="help-block text-orange-200">
                                        {{ $errors->first('decision') }}
                                      </p>
    								@endif
    								<div class="py-4 mt-2">
    									<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Submit</x-button>
    								</div>
    							    {!! Form::close() !!}
    							    </br>
    								<a href="{{ URL::route('managerSubProject.download', [$x->filename]) }}">
    									<x-button class="btn btn-xs bg-blue-600 hover:bg-gray-200 text-xs text-gray-200 btn-info">
    									View Project File
    									</x-button>
    								</a>
    						    @endforeach
						    @else 
						        <label class="block text-pink-200 text-lg font-normal mt-3 mb-2" for="agree">
  							        Projects For Approval Not Found
								</label>
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
