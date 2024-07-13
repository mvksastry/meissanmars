	<div class="inline-flex flex-row flex-wrap flex-grow mt-2">
		<!-- Right Panel Graph Card-->
    <div class="w-1/2 md:w-1/2">
    	<div class="bg-orange-100 border border-gray-800 rounded shadow">
     		<div class="border-b border-gray-800 p-3">
     			<h5 class="font-bold uppercase text-gray-900">Issue Request Form</h5>
     		</div>
				<div class="errors">
					<span class="mx-5 my-3 text-base text-red-900 text-sm">
						{{ $irqMessage }}
					</span>
				</div>
        <div class="p-1">
					<div class="">
						<form>
              <table id="userIndex2" class="table table-bordered table-hover">
            
								<tr>
         					<td class="text-text-base text-left text-gray-900">Request Id</td>
									<td>
										{{ $usage_id }}
									</td>
       					</tr>
								<tr>
           				<td>Project Id</td>
									<td>
									{{ $iaecproject_id }}
									</td>
       					</tr>
								<tr>
           				<td>Strain</td>
									<td>
										<select class="form-control shadow appearance-none border rounded" name="psbi1" id="psbi1" wire:model.lazy="psbi1">
										<option value="">Select</option>
										@foreach($psbi as $val)
										<option value="{{ $val['species_id'].";".$val['strain_id'] }}">{{ $val['name'] }}</option>
										@endforeach
									</select>
									</td>
       					</tr>
								<tr>
									<td colspan="2">
										@error('psbi1')
											<span class="text-red-500 text-sm">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>
       					<tr>
         					<td>
         						Sex
									</td>
									<td class="text-xs text-left text-gray-900">
										<select class="form-control shadow appearance-none border rounded" name="sex" id="sex" wire:model.lazy="sex">
											<option value="">Select</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Any">Any</option>
									</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
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
										<input type="text" class="form-control shadow appearance-none border rounded" id="age" placeholder="Age" wire:model="age">
	                </td>
								</tr>
								<tr>
									<td colspan="2">
										@error('age')
											<span class="text-red-500 text-xs">
											{{ $message }}
											</span>
										@enderror
									</td>
								</tr>
					      <tr>
					        <td>Age - Unit</td>
					        <td>
										<select class="form-control shadow appearance-none border rounded" name="ageunit" id="ageunit" wire:model.lazy="ageunit">
											<option value="">Select</option>
											<option value="Days">Days</option>
											<option value="Weeks">Weeks</option>
											<option value="Months">Months</option>
											<option value="Years">Years</option>
										</select>
					        </td>
					      </tr>
		            <tr>
									<td colspan="2">
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
										<input type="text" class="form-control shadow appearance-none border rounded" id="number" placeholder="Number" wire:model="number">
									</td>
								</tr>
								<tr>
									<td colspan="2">
											@error('number')
											<span>
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
										<input type="text" class="form-control shadow appearance-none border rounded" id="cagenumber" placeholder="Cage Number" wire:model="cagenumber">
						      </td>
						    </tr>
								<tr>
									<td colspan="2">
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
										<input type="text" class="form-control shadow border rounded id="termination" placeholder="Termination" wire:model="termination">
						      </td>
						    </tr>
								<tr>
									<td colspan="2">
										@error('termination')
											<span>
												{{ $message }}
											</span>
										@enderror
									</td>
								</tr>
                
						    <tr>
						      <td>
						        Duration
						      </td>
						      <td>
										<input type="text" class="form-control shadow border rounded id="termination" placeholder="Duration" wire:model="duration"> {{ $duration_unit }}
						      </td>
						    </tr>
								<tr>
									<td colspan="2">
										@error('duration')
											<span>
												{{ $message }}
											</span>
										@enderror
									</td>
								</tr>                

						    <tr>
						      <td>
						        Expt Description
						      </td>
						      <td>
										<input type="text" class="form-control shadow border rounded id="termination" placeholder="Description" wire:model="expt_desc">
						      </td>
						    </tr>
								<tr>
									<td colspan="2">
										@error('duration')
											<span>
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
										<input type="text" class="form-control shadow appearance-none border rounded" id="products" placeholder="Products" wire:model="products">
									</td>
						    </tr>
								<tr>
									<td colspan="2">
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
										<input type="text" class="form-control shadow appearance-none border rounded w-full py-2 px-3 mt-2 mb-2 text-base text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="remarks" placeholder="Remarks" wire:model="remarks">
						      </td>
						    </tr>
								<tr>
									<td colspan="2">
										@error('products')
											<span>
												{{ $message }}
											</span>
										@enderror
									</td>
								</tr>
							  <tr>
							    <td colspan="2">
										<input type="checkbox" class="shadow appearance-none border rounded" id="agree" placeholder="Agree" wire:model="agree" value="1">
							      <label class="mb-5 text-base"for="agree">Have you submitted all reports?</label>
							  </tr>
								<tr>
									<td colspan="2">
										@error('agree')
											<span>
												{{ $message }}
											</span>
										@enderror
									</td>
								</tr>
						    <tr>
						      <td colspan="2">
										<button wire:click.prevent="store()" class="btn btn-success rounded">Submit</button>
						      </td>
						    </tr>
            	</table>
						</form>
					</div>
        </div>
      </div>
		</div>
		<!-- / End of right Panel Graph Card-->
  </div>
<!--/table Card-->
