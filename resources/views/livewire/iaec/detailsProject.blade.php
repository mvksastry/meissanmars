<!--Table Card-->
		<div class="bg-orange-100 border border-gray-800 rounded shadow">
			<div class="border-b border-gray-800 p-3">
				<h5 class="font-bold uppercase text-gray-900">Details</h5>
			</div>
			<div class="p-2">
        <table id="userIndex2" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th> Information </th>
							<th> Detail </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Title
							</td>
							<td>
								{{ $title }}
							</td>
						</tr>

						<tr>
							<td>
								Start Date
							</td>
							<td>
								{{ date('d-m-Y', strtotime($start_date)) }}
							</td>
						</tr>

						<tr>
							<td>
								End Date
							</td>
							<td>
								{{ date('d-m-Y', strtotime($end_date)) }}
							</td>
						</tr>

						<tr>
							<td>
								Date Approved
							</td>
							<td>
                {{ date('d-m-Y', strtotime($date_approved)) }}
								
							</td>
						</tr>

						<tr>
							<td>
								IAEC Meeting
							</td>
							<td>
								{{ $iaec_meeting_info }}
							</td>
						</tr>

						<tr>
							<td>
								IAEC Comments
							</td>
							<td>
								{{ str_replace("none", "", $iaec_comments) }}
							</td>
						</tr>

						<tr>
							<td>
								File
							</td>
							<td>
								<button wire:click="piprojectDownload('{{ $projfile }}')" class="btn btn-info rounded">View Projet File</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<!-- / End of table Card-->
</br>
	<!-- Left Panel Graph Card-->
    <div class="border rounded shadow">
  		<div class="border-b border-gray-800 p-3">
        <h5 class="font-bold uppercase">Usage: Strain wise usage info</h5>
  		</div>
			<div class="p-2">
				@if(count($issueConfirmed) > 0)
          <table id="userIndex2" class="table table-sm table-bordered table-hover">
						<thead>
							<tr>
								<th align="center"> Usage ID </th>
								<th align="center"> Date </th>
								<th align="center"> Strain </th>
								<th align="center"> Number </th>
								<th align="center"> Cages </th>
								<th align="center"> Status </th>
							</tr>
						</thead>
						<tbody>
							@foreach($issueConfirmed as $val)
								<tr>
									<td>
						      	{{ $val->usage_id }}
						      </td>
						      <td>
										{{ date('d-m-Y', strtotime($val->status_date)) }}
						      </td>

						      <td>
						      	{{ $val->strain->strain_name }}
						      </td>
						      <td>
						      	{{ $val->number }}
						      </td>
						      <td>
						      	{{ $val->cagenumber }}
						      </td>
									<td>
						      	{{ ucfirst($val->issue_status) }}
						      </td>
						    </tr>
							@endforeach
              <tr>
        				<td colspan='6' class="text-xs text-left">End of Details</td>
      				</tr>
						</tbody>
					</table>
				@else
          <table id="userIndex2" class="table table-sm table-bordered table-hover">
						<thead>
							<tr>
								<th> No Entries Found. </td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				@endif
			</div>

      <div class="p-2">
        <div class="content table-responsive table-full-width">
          <table id="userIndex2" class="table table-sm table-bordered table-hover">
						<thead>
							<tr>
	              <th rowspan="2" style="vertical-align : middle;text-align:center;">Strain</th>
	              <th colspan="3" style="vertical-align : middle;text-align:center;">All Years</th>
	              <th colspan="3" style="vertical-align : middle;text-align:center;">Current Year</th>
               </tr>
               <tr>
	              <td align="center">Sanctioned</td>
	              <td align="center">Consumed</td>
	              <td align="center">Balance</td>
	              <td align="center">Sanctioned</td>
	              <td align="center">Consumed</td>
	              <td align="center">Balance</td>
							<tr>
						</thead>
						<tbody>
						<?php $strainwise_info = array(); ?>
        			@if (!empty($swc))
        				@foreach ($swc as $row)
                  <tr>
                    <td>{{ $row[0] }}</td>
                    <td>{{ $row[2] }}</td>
                    <td>{{ $row[1] }}</td>
                    <td>{{ $row[2]-$row[1] }}</td>
				  					<td>{{ $row[4] }}</td>
                    <td>{{ $row[3] }}</td>
                    <td>{{ $row[4]-$row[3] }}</td>
                  </tr>
        				@endforeach
        			@endif
      				<tr>
        				<td colspan='7' class="text-xs text-left text-gray-900">End of Details</td>
      				</tr>
						</tbody>
        	</table>
    		</div>
  		</div>
		</div>
	<!-- / End of Left Panel Graph Card-->

	<!--Table Card-->  
	<!--/table Card-->

	<!-- Right Panel Graph Card-->
		<div class="border rounded shadow">
  		<div class="border p-3">
    			<h5 class="font-bold uppercase text-gray-900">Usage Request Form</h5>
  		</div>
	  	<div class="p-2">
				<div class="">
					<form>
            <table id="userIndex2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>
										Item
									</th>
									<th>
										Details
									</th>
								<tr>
							</thead>
		      		<tbody>
								<tr>
		          		<td>Project Id</td>
									
									<td>
									{{ $project_id }}
									</td>
		        		</tr>

								<tr>
		          		<td>Strains</td>
									
									<td>
										<select class="form-control border rounded" name="pstx1" id="pstx1" wire:model.lazy="pstx1">
										<option value="">Select</option>
										@foreach($pstx as $val)
										<option value="{{ $val['species_id'].";".$val['strain_id'] }}">{{ $val['name'] }}</option>
										@endforeach
									</select>
									</td>
		        		</tr>

								<tr>
									<td>
									</td>
									<td>
										@error('pstx1')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

	      				<tr>
	        				<td>
	          					Sex
									</td>
									
									<td>
										<select class="form-control shadow border rounded" name="sex" id="sex" wire:model.lazy="sex">
											<option value="">Select</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Any">Any</option>
										</select>
									</td>
								</tr>

								<tr>
									<td></td>
									<td>
										@error('sex')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

								<tr>
		      				<td>
		        					Age
		      				</td>
		      				
		      				<td>
										<input type="text" class="form-control" id="age" placeholder="Age" wire:model="age">
		      				</td>
		    				</tr>

								<tr>
									<td>
									</td>
									<td>
										@error('age')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

	              <tr class="border-b">
	                <td>Age - Unit</td>
	                
	                <td>
										<select class="form-control" name="ageunit" id="ageunit" wire:model.lazy="ageunit">
											<option value="">Select</option>
											<option value="Days">Days</option>
											<option value="Weeks">Weeks</option>
											<option value="Months">Months</option>
											<option value="Years">Years</option>
										</select>
	                </td>
	              </tr>

	      				<tr>
									<td>
									</td>
									<td>
										@error('ageunit')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

								<tr>
	        				<td>Required Number</td>
	      					
									<td>
										<input type="text" class="form-control shadow border rounded" id="number" placeholder="Number" wire:model="number">
									</td>
								</tr>

								<tr>
									<td>
									</td>
									<td>
										@error('number')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

	              <tr>
	                <td>
	                  Number of Cages
	                </td>
	                
	                <td>
									<input type="text" class="form-control shadow border rounded" id="cagenumber" placeholder="Cage Number" wire:model="cagenumber">
	                </td>
	              </tr>

								<tr>
									<td>
									</td>
									<td>
										@error('cagenumber')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

	              <tr>
	                <td>
	                  Expt Termination
	                </td>
	                
	                <td>
									<input type="text" class="form-control shadow border rounded" id="termination" placeholder="Termination" wire:model="termination">
	                </td>
	              </tr>

								<tr>
									<td>
									</td>
									<td>
										@error('termination')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

	              <tr>
	                <td>
	                  Expt Duration (in weeks)
	                </td>
	                <td>
									<input type="text" class="form-control shadow border rounded" id="duration" placeholder="Number Only " wire:model="duration">
	                </td>
	              </tr>

	              <tr>
	                <td>
	                  Expt Description (Cryptic)
	                </td>
	                <td>
									<input type="text" class="form-control shadow border rounded" id="expt_desc" placeholder="Cryptic Description " wire:model="expt_desc">
	                </td>
	              </tr>
                
								<tr>
									<td>
									</td>
									<td>
										@error('termination')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>
                
	              <tr>
	                <td>
	                  Animal Products
	                </td>
	                
	                <td>
									<input type="text" class="form-control shadow border rounded" id="products" placeholder="Products" wire:model="products">
	                </td>
	              </tr>

								<tr>
									<td>
									</td>
									<td>
										@error('products')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

	              <tr>
	              	<td>Issue Remarks</td>
	              	
	              	<td>
										<input type="text" class="form-control shadow border rounded" id="remarks" placeholder="Remarks" wire:model="remarks">
	              	</td>
	              </tr>

							  <tr>
									<td>
									</td>
									<td>
										@error('products')
											<span class="text-red-500 text-xs">
												{{ $message }}
											</span>
										@enderror
									</td>
							  </tr>

	              <tr>
	                <td colspan="2">
										<input type="checkbox" class="shadow border rounded" id="agree" placeholder="Agree" wire:model="agree" value="1">
	                <label class="text-base"for="agree">Have you submitted all reports?</label>
	              </tr>

								<tr>
									<td colspan="2">
										@error('agree')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>

                <tr>
                  <td colspan="2">
                  {{ $irqMessage }}
                  </td>
                </tr>  
                <tr>
		            	<td>
										<button wire:click.prevent="store()" class="btn btn-success btn-rounded">Submit</button>
		              </td>
									<td>
										<button wire:click.prevent="resetIssueForm()" class="btn btn-warning btn-rounded">Reset</button>
									</td>
	            	</tr>
							</tbody>
	      		</table>
					</form>
	  		</div>
	  	</div>
		</div>
	<!-- / End of right Panel Graph Card-->

<!--/table Card-->
