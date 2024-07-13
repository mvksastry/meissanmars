@extends('layouts.nGlobal')
@section('content')
	<!--Container-->
	<div class="container min-h-screen mx-auto pt-20">
		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

			<!--Divider-->
			<h5 class="font-normal uppercase text-gray-900">Billing Home</h5>
			<hr class="border-b-2 border-gray-600 my-2 mx-4">
			<!--Divider-->

            <div class="flex flex-row flex-wrap flex-grow mt-2">
            	<div class="w-full p-3">
                    <div class="bg-orange-100 border border-gray-800 rounded shadow">
                        <div class="border-b border-gray-800 p-3">
                          <h5 class="font-bold uppercase text-gray-900">Set Per Diem Costs</h5>
                        </div>
                        <div class="w-2/3 p-5">
							{!! Form::open(['method' => 'POST', 'route' => ['billing.setperdiem']]) !!}
							<div class="w-full p-5">
								<table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
									<thead class="bg-gray-900">
										<tr class="text-white text-left">
											<th class="font-semibold text-sm uppercase px-4 py-4"> Strain ID</th>
											<th class="font-semibold text-sm uppercase px-4 py-4"> Species</th>
											<th class="font-semibold text-sm uppercase px-4 py-4"> Strain Name</th>
											<th class="font-semibold text-sm uppercase px-4 py-4"> Effective Date </th>
											<th class="font-semibold text-sm uppercase px-4 py-4"> Per Diem Cost </th>
										</tr>
									</thead>
                                    @if(!empty($strain_info))
                                        @foreach($strain_info as $row)
                                            <tr>
                                                <td class="px-8 py-4 text-gray-900 text-sm font-normal" align="left">
                                                  {{ $row['strain_id'] }}
                                                </td>
                                                <td class="px-4 py-4 text-gray-900 text-sm font-normal" align="left">
                                                  {{ $row->species->species_name }}
                                                </td>
                                                <td class="px-4 py-4 text-gray-900 text-sm font-normal" align="left">
                                                 {{ $row->strain_name }}
                                                </td>
                                                <td class="px-4 py-4 text-gray-900 text-sm font-normal" align="center">
                                                  {{ date('d-m-Y', strtotime($row->cost->effective_cost_date)) }}
                                                </td>
                                                <td  align="left" class="px-4 py-4 text-gray-900 text-sm font-normal">
                                                    <div class="text-gray-900 text-sm font-bold px-5 mt-2 mb-2">
                                                    {!! Form::number("per_diem_cost[]", $row->cost->per_diem_cost, ['class' => "input", 'style'=>"width: 90px;"]) !!}
                                                	</div>
                                                
                                                	<div class="text-gray-900 text-sm font-normal">
                                                    {!! Form::hidden("sp_str_id[]", $row['species_id'].'_'.$row['strain_id'], ['class' => "input"]) !!}
                                                	</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    	<tr>
                                            <td  colspan="7" align="center">
                                                <Label><strong>Strains Not Present. No Per-Diem Cost Retrieved</strong> </label>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
								<div class="py-4 mt-2">
									<x-button class="btn btn-xs text-xs text-gray-200 btn-info p-1">Submit</x-button>
								</div>
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
