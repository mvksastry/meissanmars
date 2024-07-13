@extends('layouts.nGlobal')
@section('content')

	<!--Container-->
	<div class="container min-h-screen mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">


			<!--Divider-->
			<h5 class="font-normal uppercase text-gray-900">Projects Home</h5>
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<!--Divider-->

			<!--/table Card-->
      <div class="flex flex-row flex-wrap flex-grow mt-2">

		<div class="w-1/2 md:1/2 p-3">
          <div class="bg-orange-100 border border-gray-800 rounded shadow">
            <div class="border-b border-gray-900 p-3">
              <h5 class="font-bold uppercase text-gray-900">Project Details</h5>
            </div>
            <div class="w-full p-5">
				<label class="block text-gray-900 text-sm font-normal mb-2" for="username">
					Name*
				</label>
				<label class="block w-full h-8 bg-orange-300	text-gray-900 text-sm font-normal mt-3 mb-2">
					{{ $project->user->name }}
				</label>
				<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="title">
					Title*
				</label>
				<label class="block w-full h-8 bg-orange-300	text-gray-900 text-sm font-normal mt-3 mb-2">
					{{ $project->title }}
				</label>
				<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="start date">
					Start Date*
				</label>
				<label class="block w-full h-8 bg-orange-300	text-gray-900 text-sm font-normal mt-3 mb-2">
					{{ $project->start_date }}
				</label>
				<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="end date">
					End Date*
				</label>
				<label class="block w-full h-8 bg-orange-300	text-gray-800 text-sm font-normal mt-3 mb-2">
					{{ $project->end_date }}
				</label>
				<label class="block text-gray-900 text-sm font-normal mt-6 mb-2" for="end date">
					Sanctioned
				</label>
				<table class="w-full p-5 text-gray-700">
					<tbody>
						<tr>
                    		<td class="text-gray-900 text-xs font-normal"> Strain </td>
                    		<td class="text-gray-900 text-xs font-normal"> Year 1 </td>
                    		<td class="text-gray-900 text-xs font-normal"> Year 2 </td>
                    		<td class="text-gray-900 text-xs font-normal"> Year 3 </td>
                    		<td class="text-gray-900 text-xs font-normal"> Year 4 </td>
                    		<td class="text-gray-900 text-xs font-normal"> Year 5 </td>
                  		</tr>
						@foreach($projectstrains as $val)
							<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                        		<td class="text-gray-800 text-xs mt-1 mb-1 font-normal">
								{{ $val->strain->strain_name}}
                        		</td>
                        <td class="text-gray-800 text-xs mt-1 mb-1 font-normal">
                            {{ $val->year1 }}
                        </td>
                        <td class="text-gray-800 text-xs mt-1 mb-1 font-normal">
                            {{ $val->year2 }}
                        </td>
                        <td class="text-gray-800 text-xs mt-1 mb-1 font-normal">
                            {{ $val->year3 }}
                        </td>
                        <td class="text-gray-800 text-xs mt-1 mb-1 font-normal">
                            {{ $val->year4 }}
                        </td>
                        <td class="text-gray-800 text-xs mt-1 mb-1 font-normal">
                            {{ $val->year5 }}
                        </td>
                      </tr>
										@endforeach
								</tbody>
							</table>

								<label class="block text-pink-800 text-sm font-normal mt-3 mb-2" for="end date">
									Strain Details: For all years  will be calculated based on species/strain/year wise.
								</label>

								</br>

									<a href="{{ route('adminProject.download', $project->filename ) }}">
									<x-button class="btn btn-xs bg-blue-600 hover:bg-gray-200 text-xs text-gray-900 btn-info">
										View Project File
									</x-button>
								</a>
								</br>

								<label class="block text-gray-800 text-sm font-normal mt-3 mb-1" for="remarksifany">
									Remarks
								</label>

								<label class="block text-yellow-800 text-sm font-normal mt-1 mb-2" for="remarksifany">
								{{ $project->notes }}
								</label>

								<label class="block text-gray-800 text-sm font-normal mt-3 mb-2" for="remarksifany">
									IAEC Decision Remarks
								</label>

								<label class="block text-yellow-800 text-sm font-normal mt-1 mb-2" for="remarksifany">
								{{ $project->iaec_comments }}
								</label>

								<label class="block text-gray-800 text-sm font-normal mt-3 mb-2" for="remarksifany">
									IAEC Meeting Date
								</label>

								<label class="block text-yellow-800 text-sm font-normal mt-1 mb-2" for="remarksifany">
									{{ $project->date_approved }}
								</label>

								<label class="block text-gray-800 text-sm font-normal mt-3 mb-2" for="remarksifany">
									IAEC Meeting Information
								</label>

								<label class="block text-yellow-800 text-sm font-normal mt-1 mb-2" for="remarksifany">
								 {{ $project->iaec_meeting_info }}
								</label>

								<label class="block text-gray-800 text-sm font-normal mt-3 mb-2" for="agree">
									FormD
								</label>

								<label class="block text-yellow-800 text-sm font-normal mt-1 mb-2" for="remarksifany">
								{{ $project->formD }}
								</label>

								<div class="py-4 mt-2">
									<a href="{{ route('projectsmanager.index') }}">
									<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Back to Home</x-button>
									</a>
								</div>

						</div>

					</div>
				</div>

		<div class="w-1/2 md:w-1/2 p-3">
          <div class="bg-orange-100 border border-gray-800 rounded shadow">
            <div class="border-b border-gray-800 p-3">
              <h5 class="font-bold uppercase text-gray-900">Usage Details</h5>
            </div>

						<div class="p-5">
							<div class="content table-responsive table-full-width">
								<table class="table-auto" align='center'>
									<tr>
										<td colspan="7" class="text-sm text-left text-gray-900 font-bold">Strain wise Consumption
										</td>
									</tr>
									<tr>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Strain</td>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Sanct. <br>(All Years)</td>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Total Consumed <br> (All Years)</td>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Balance (All Years)</td>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Cur. Year Limit</td>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Cur. Year Consumed</td>
										<td class="w-auto text-xs text-right text-gray-900 font-bold" align='center'>Cur. Year Remained</td>
									<tr>
								<?php $strainwise_info = array(); ?>
                @if (!empty($swc))
                  @foreach ($swc as $row)
                    <tr>
                      <td class="text-xs text-right text-gray-900">{{ $row[0] }}</td>
                      <td class="text-xs text-right text-gray-900">{{ $row[2] }}</td>
                      <td class="text-xs text-right text-gray-900">{{ $row[1] }}</td>
                      <td class="text-xs text-right text-gray-900">{{ $row[2]-$row[1] }}</td>
											<td class="text-xs text-right text-gray-900">{{ $row[4] }}</td>
                      <td class="text-xs text-right text-gray-900">{{ $row[3] }}</td>
                      <td class="text-xs text-right text-gray-900">{{ $row[4]-$row[3] }}</td>
                    </tr>
                  @endforeach
                @endif
								<tr>
									<td colspan='7' class="text-xs text-left text-gray-200">End of Details</td>
								</tr>
							</table>
						</div>
					</div>

            <div class="w-full p-5">

								<label class="block text-gray-900 text-sm font-normal mt-6 mb-2" for="end date">
									Issue Information
								</label>

								<table class="w-full p-5 text-gray-700">
									<tbody>
										<tr>
											<td class="text-gray-900 text-xs font-bold"> Date </td>
                      <td class="text-gray-900 text-xs font-bold"> Issue Id </td>
                      <td class="text-gray-900 text-xs font-bold"> Strain </td>
                      <td class="text-gray-900 text-xs font-bold"> Number </td>
                      <td class="text-gray-900 text-xs font-bold"> Cages </td>
					<td class="text-gray-900 text-xs font-bold"> Status </td>
                    </tr>
											@if(!empty($issueConfirmed))
												@foreach($issueConfirmed as $val)
												<tr class="text-gray-900 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														{{ date('d-m-Y', strtotime($val->status_date)) }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->issue_id }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->strain->strain_name }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->number }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->cagenumber }}
                          </td>
													<td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ ucfirst($val->issue_status) }}
                          </td>
                        </tr>
												@endforeach
											@else
												<tr class="text-gray-900 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														No Entries Found.
                          </td>
												</tr>
											@endif

											@if(!empty($issue))
												@foreach($issue as $val)
												<tr class="text-gray-900 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														{{ $val->status_date}}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->issue_id }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->strain->strain_name }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->number }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->cagenumber }}
                          </td>
													<td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ ucfirst($val->issue_status) }}
                          </td>
                        </tr>
												@endforeach
											@else
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														No Entries Found.
                          </td>
												</tr>
											@endif
									</tbody>
								</table>
								</br>
								<div class="py-4 mt-2">
									<a href="{{ route('projectsmanager.index') }}">
									<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Back to Home </x-button>
									</a>
								</div>
						</div>

					</div>
				</div>

			</div>
			<!--/table Card-->

						<!--/table Card-->
      <div class="flex flex-row flex-wrap flex-grow mt-2">

				<div class="w-1/2 md:1/2 p-3">
          <div class="bg-orange-100 border border-gray-800 rounded shadow">

            <div class="border-b border-gray-800 p-3">
              <h5 class="font-bold uppercase text-gray-900">Form-D Entries</h5>
            </div>

            <div class="w-full p-5">

								<label class="block text-pink-200 text-sm font-normal mt-3 mb-2" for="end date">

								</label>

								<table class="w-full p-5 text-gray-700">
									<tbody>
										<tr>
											<td class="text-gray-900 text-xs font-bold"> Date </td>
                      <td class="text-gray-900 text-xs font-bold"> Req.Animals </td>
                      <td class="text-gray-900 text-xs font-bold"> Breeder </td>
                      <td class="text-gray-900 text-xs font-bold"> IAEC Approval </td>
                      <td class="text-gray-900 text-xs font-bold"> Duration of Expt </td>

                    </tr>
											@if(!empty($formd))
												@foreach($formd as $val)
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														{{ $val->entry_date}}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->req_anim_number }}, {{ $val->species}},
														{{ $val->strain }}, {{ $val->age." ".$val->ageunit}}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->breeder_add }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val->approval_date }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            To be included
                          </td>

                        </tr>
												@endforeach
												<td class="text-yellow-900 text-xs font-normal"> Authorized Person </td>

												<td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														{{ $val->authorized_person }}
                          </td>
												<td class="text-yellow-900 text-xs font-normal"> Signature Investigator </td>
													<td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														Signed
                          </td>
											@else
												<tr class="text-gray-900 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														No Entries Found.
                          </td>
												</tr>
											@endif
									</tbody>
								</table>


								<div class="py-4 mt-2">
									<a href="{{ route('projectsmanager.index') }}">
									<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Back to Home </x-button>
									</a>
								</div>


						</div>
					</div>
				</div>
				<?php
					$cageCost = $costs[0];
					$projCost = $costs[1];
				?>
				<div class="w-1/2 md:w-1/2 p-3">
          <div class="bg-orange-100 border border-gray-800 rounded shadow">

            <div class="border-b border-gray-800 p-3">
              <h5 class="font-bold uppercase text-gray-900">Cost as on {{ date('d-m-Y') }}</h5>
            </div>

            <div class="w-full p-5">
								<label class="block text-gray-900 text-sm font-normal mt-3 mb-2" for="agree">
									* Experiments may be in progress
								</label>
								<table class="w-full p-5 text-gray-700">
									<tbody>
										<tr>
											<td class="text-gray-900 text-xs font-bold"> Cage ID </td>
                      						<td class="text-gray-900 text-xs font-bold"> Project ID </td>
                      						<td class="text-gray-900 text-xs font-bold"> From </td>
                      						<td class="text-gray-900 text-xs font-bold"> To* </td>
                      						<td class="text-gray-900 text-xs font-bold"> Days </td>
											<td class="text-gray-900 text-xs font-bold" align="center"> Price </td>
											<td class="text-gray-900 text-xs font-bold" align="center"> Cost* </td>
                    </tr>
											@if(!empty($cageCost))
												@foreach($cageCost as $val)
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														{{ $val[0] }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val[1] }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ date('d-m-Y', strtotime($val[2])) }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ date('d-m-Y', strtotime($val[3])) }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $val[4] }}
                          </td>
													<td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            &#x20B9; {{ $val[5] }}
                          </td>
													<td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            &#x20B9;  {{ number_format((float)$val[6], 2, '.', '') }}
                          </td>
                        </tr>
												@endforeach
											@else
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														No Entries Found.
                          </td>
												</tr>
											@endif
									</tbody>
								</table>

								<table class="w-full mt-10 p-5 text-gray-700">
									<tbody>
										<tr>
											<td class="text-gray-900 text-xs font-bold"> Project Id </td>
                      						<td class="text-gray-900 text-xs font-bold"> Total Cages </td>
                      						<td class="text-gray-900 text-xs font-bold"> Cost* </td>
										</tr>
											@if(!empty($projCost))
												@foreach($projCost as $x)
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														{{ $x[0] }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            {{ $x[1] }}
                          </td>
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
                            &#x20B9; {{ number_format((float)$x[2], 2, '.', '') }}
                          </td>
                        </tr>
												@endforeach
											@else
												<tr class="text-gray-800 text-sm font-normal mt-3 mb-4">
                          <td class="text-gray-900 text-xs mt-1 mb-1 font-normal">
														No Entries Found.
                          </td>
												</tr>
											@endif
									</tbody>

								</table>

								</br>
								<div class="py-4 mt-2">
									<a href="{{ route('projectsmanager.index') }}">
									<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1"> Back to Home </x-button>
									</a>
								</div>
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
