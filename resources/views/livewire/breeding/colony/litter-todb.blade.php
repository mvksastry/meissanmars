<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
		{{-- If your happiness depends on money, you will never be happy with yourself. --}}
		{{-- Care about people's approval and you will be their prisoner. --}}
		{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
		<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Colony: Litter Home 2</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="/dashboard">Colony</a></li>
							<li class="breadcrumb-item active">Litter Home 2</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
    <?php 
      $roomPath = "storage/facility/rooms/";
      $rackPath = "storage/facility/racks";
    ?>
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
        @hasrole('manager')
					@include('livewire.breeding.colony.flexMenuLitterHome2')
				@endhasrole
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-5 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Select Species
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
              @include('livewire.breeding.colony.selectSpeciesImages')
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>

          <section class="col-lg-7 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Search Open Litter Entries
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
						  <div class="card-body">
							<div class="tab-content p-0">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
									@if($panel1)
                       @include('livewire.breeding.colony.openLitterSearchForm')
                  @endif
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
          
					<!-- /.Left col -->
					<!-- right col -->
				</div><!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->
    
		
		@if($panel2)
		<section class="content">
			<div class="container-fluid">
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<section class="col-lg-12 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title"><font color="blue">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Open Litter Entries As on: {{ date('d-m-Y') }} 
								</font>
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
						  <div class="card-body">
                <div class="tab-content p-0">
								<!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">                   
                    <div class="p-2">
                      
                        @include('livewire.breeding.colony.resultsForOpenLitterEntries')
                      
                    </div>         
                  </div>
                </div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
        </div>
			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->    
		@endif
		
		
		
		@if($panel5)
			<section class="content">
				<div class="container-fluid">
					
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<section class="col-lg-6 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title"><font color="blue">
									<i class="fas fa-chart-pie mr-1"></i>
										Base Information: Strain Info
									</font>
								</h3>
								<div class="card-tools">
									<ul class="nav nav-pills ml-auto">
										<li class="nav-item"></li>
										<li class="nav-item"></li>
									</ul>
								</div>
								</div><!-- /.card-header -->
								<div class="card-body">
									<div class="tab-content p-0">
									<!-- Morris chart - Sales -->
										<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">                   
											<div class="p-2">

												<table class="w-full p-5 text-sm text-gray-900">
													<thead>
													</thead>
													<tbody>
														<tr class="bg-warning">
															<td colspan="2" class="border px-2 p-1">
															</td>
														</tr>

														<tr>
															<td class="border px-2 p-1">
																Auto Generate Mouse Records
															</td>
															<td class="border px-2 p-1">
																<input wire:model.lazy="agmr" class="form-control-sm border" type="checkbox" value="true">
															</td>
														</tr>

														<tr>
															<td class="border px-2 p-1">
																Per Cage Number
															</td>
															<td class="border px-2 p-1">
																<input wire:model.lazy="per_cage" class="form-control-sm border" type="text" value="">
															</td>
														</tr>
														
														<tr>
															<td class="border px-2 p-1">
																Base ID
															</td>
															<td class="border px-2 p-1">
																<input wire:model.lazy="baseMouseId" class="form-control-sm border" type="text">
															</td>
														</tr>
														
														<tr>
															<td class="border px-2 p-1 bg-gray-300">
																Protocol ID
															</td>
															<td class="border bg-gray-300 px-2 p-1">
																<select wire:model.lazy="protoKey" class="form-control-sm border">
																	<option value="null">Select</option>
																		
																</select>
															</td>
														</tr>
														
														<tr>
															<td class="border px-2 p-1 bg-gray-300">
																Use Schedules
															</td>
															<td class="border px-2 p-1 bg-gray-300">
																<select wire:model.lazy="useScheduleKeys" class="form-control-sm border" multiple>
																<option value=""></option>
																	
																</select>
															</td>
														</tr>

														<tr bgcolor="#EAEDED">
															<td class="p-2">
																<font color="red">Generation*</font>
															</td>
															<td>
																<select wire:model.lazy="_generation_key" class="form-control-sm border" name="_generation_key" id="_generation_key">
																	<option value="">Select</option>
																	<option value="F00">F00</option>
																		@foreach($generations as $item)
																			<option value="{{ $item->generation }}">{{ $item->generation }}</option>
																		@endforeach
																</select>
																</br>
																@error('_generation_key') <span class="text-danger error">{{ $message }}</span> @enderror
															</td>
														</tr>
														
														<tr bgcolor="#AHDADE">
															<td class="border px-2 p-1">
															</td >
															<td class="border px-2 p-1">											
															</td >
														</tr>
													</tbody>
												</table>


												<table class="w-full p-5 text-sm text-gray-900">													
													<thead>
														<th> Item </th>
														<th> Option 1 </th>
														<th> Option 2 </th>
													</thead>
													<tbody>
														<tr>
															<td class="border px-2 p-1">
																Room*
															</td>
															<td class="border px-2 p-1">
																<select 
																@if($hideRoom1)
																	disabled
																@endif
																wire:model.lazy="room_id1" wire:change="room1Selected" class="form-control-sm border" name="room_id" id="room_id">
																	<option value="-1"></option>
																		@foreach($rooms as $row)
																			<option value="{{ $row->room_id }}">{{ $row->room_name }}</option>
																		@endforeach																	
																</select>
																</br>
																@error('room_id') 
																	<span class="text-danger error">
																		{{ $message }}
																	</span> 
																@enderror
															</td>

															<td class="border px-2 p-1">
																<select 
																@if($hideRoom2)
																	disabled
																@endif
																wire:model.lazy="room_id2" wire:change="room2Selected" class="form-control-sm border" name="room_id" id="room_id">
																	<option value="-1"></option>
																		@foreach($rooms as $row)
																			<option value="{{ $row->room_id }}">{{ $row->room_name }}</option>
																		@endforeach																	
																</select>
																</br>
																@error('room_id') 
																	<span class="text-danger error">
																		{{ $message }}
																	</span> 
																@enderror
															</td>
														</tr>
														
														<tr>
															<td class="border px-2 p-1">
																<font color="red">Rack*</font>
															</td>
															<td class="border px-2 p-1">
																<select 
																@if($hideRack1)
																	disabled
																@endif
																wire:model.lazy="rack_id1" wire:change="rack1Selected" class="form-control-sm border" name="rack_id" id="rack_id">
																	<option value="0"></option>
																		@foreach($racksInRoom1 as $row)
																			<option value="{{ $row->rack_id }}">{{ $row->rack_name }}</option>
																		@endforeach	
																</select>
																</br>
																@error('rack_id1') 
																	<span class="text-danger error">
																		{{ $message }}
																	</span> 
																@enderror
															</td>

															<td class="border px-2 p-1">
																<select 
																@if($hideRack2)
																	disabled
																@endif
																wire:model.lazy="rack_id2" wire:change="rack2Selected" class="form-control-sm border" name="rack_id" id="rack_id">
																	<option value="0"></option>
																		@foreach($racksInRoom2 as $row)
																			<option value="{{ $row->rack_id }}">{{ $row->rack_name }}</option>
																		@endforeach	
																</select>
																</br>
																@error('rack_id2') 
																	<span class="text-danger error">
																		{{ $message }}
																	</span> 
																@enderror
															</td>
														</tr>

														<tr class="border">
															<td class="border px-2 p-1">
																<font color="red">Total Free Slots</font>: 
															</td>
															<td class="border px-2 p-1">
																{{ $free_slots1 }}
															</td>
															<td class="border px-2 p-1">
																{{ $free_slots2 }}
															</td>
														</tr>
														
														<tr class="border">
															<td class="border px-2 p-1"> 
																<font color="red">First 5 Free Slot ID</font>
															</td>

															<td class="border px-2 p-1">
																{{ $fslot_num1 }}
															</td>
															
															<td class="border px-2 p-1">
																{{ $fslot_num2 }}
															</td>
														</tr>
														
														<tr bgcolor="#EADDED">
															<td class="border px-2 p-1">
																<font color="red">Slot ID</font>
															</td>
															<td class="border px-2 p-1">
																<input wire:model.lazy="slot_id1" class="form-control-sm border" placeholder="Auto Selected" value="" type="text">
															
																</br>
																@error('slot_id') 
																	<span class="text-danger error">
																		{{ $message }}
																	</span> 
																@enderror
															</td>

															<td class="border px-2 p-1">
																<input wire:model.lazy="slot_id2" class="form-control-sm border" placeholder="Auto Selected" value="" type="text">
																
																</br>
																@error('slot_id') 
																	<span class="text-danger error">
																		{{ $message }}
																	</span> 
																@enderror
															</td>
														</tr>
														
														<tr bgcolor="#AHDADE">
															<td class="border px-2 p-1">
															</td >
															<td class="border px-2 p-1">											
															</td >
															<td class="border px-2 p-1">
															</td >
														</tr>
													</tbody>
												</table>
												
												
												<table class="w-full p-5 text-sm text-gray-900">
													<thead>
													</thead>
													<tbody>
														<tr>
															<td class="border px-2  p-1">
																Cage Label
															</td>
															<td class="border px-2  p-1">
																<input wire:model.lazy="cage_label" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Cage Label">
															</td>
														</tr>
														
														<tr>
															<td class="border px-2  p-1">
																Comments
															</td>
															<td class="border px-2  p-1">
																<input wire:model.lazy="comment" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Comments">
															</td>
														</tr>
														<tr>
															<td class="border px-2 p-1">
																@if($confirm1==="true")
																		<button wire:click="prepareDBEntryData()" class="btn btn-success rounded border">Sure?</button>
																		<button wire:click="cancelPrepareDBEntryData()" class="btn btn-success rounded border px-5">Cancel</button>
																@else
																		<button wire:click="prepareDBEntryDataSure()" class="btn btn-info rounded rounded border">Prepare DB Entries</button>
																@endif				
															</td>
															<td class="border px-2 p-1">
															</td>
														</tr>
													</tbody>
												</table>

											</div>         
										</div>
									</div>
								</div><!-- /.card-body -->
							</div>
						</section>
						
						<section class="col-lg-6 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Details of New DB  Entries 
								</h3>
								<div class="card-tools">
									<ul class="nav nav-pills ml-auto">
										<li class="nav-item"></li>
										<li class="nav-item"></li>
									</ul>
								</div>
								</div><!-- /.card-header -->
								<div class="card-body">
								<div class="tab-content p-0">
									<!-- Morris chart - Sales -->
									<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
										<!-- Show the selection form-->
										@if($panel3)				
											@include('livewire.breeding.colony.litterToMouseEntryDetailForm')
										@endif
									</div>
								</div>
								</div><!-- /.card-body -->
							</div>
						</section>						
						
						
						<!-- /.card -->
						<!-- /.card -->
					</div>
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->  
		@endif
    
		@if($panel6)
			<section class="content">
				<div class="container-fluid">
					<div class="row">
					
						<section class="col-lg-6 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title"><font color="blue">
									<i class="fas fa-chart-pie mr-1"></i>
										Base Information: Mating
									</font>
								</h3>
								<div class="card-tools">
									<ul class="nav nav-pills ml-auto">
										<li class="nav-item"></li>
										<li class="nav-item"></li>
									</ul>
								</div>
								</div><!-- /.card-header -->
								<div class="card-body">
									<div class="tab-content p-0">
									<!-- Morris chart - Sales -->
										<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">                   
											<div class="p-2">

												<table class="w-full p-5 text-sm text-gray-900">
													@if(count($dspair) > 0 )
														<thead>
															
															<th>Dam</th>
															<th>Sire</th>
															<th>RefID</th>
														</thead>
														<tbody>
															@foreach($dspair as $row)
																<tr class="bg-warning-subtle">
																	<td class="border px-2 p-1">
																		{{ $row['dam1ID'] }}
																	</td>
																	<td class="border px-2 p-1">
																		{{ $row['sireID'] }}
																	</td>
																	<td class="border px-2 p-1">
																		{{ $row['mRefID'] }}
																	</td>
																</tr>
															@endforeach
															<tr>
																<td colspan="3" class="border px-2 p-1">
																	{{ $mpairErrorMessage }}
																</td>
															</tr>
													</tbody>
													@else
														<thead>
															<th>No Data for Display</th>
														</thead>
														<tbody>
														</tbody>
													@endif
												</table>
											</div>         
										</div>
									</div>
								</div><!-- /.card-body -->
							</div>
						</section>



						<section class="col-lg-6 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="card card-primary card-outline">
								<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-pie mr-1"></i>
									Details of Mating Entries
								</h3>
								<div class="card-tools">
									<ul class="nav nav-pills ml-auto">
										<li class="nav-item"></li>
										<li class="nav-item"></li>
									</ul>
								</div>
								</div><!-- /.card-header -->
								<div class="card-body">
								<div class="tab-content p-0">
									<!-- Morris chart - Sales -->
									<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
										<table class="w-full p-5 text-sm text-gray-900">
											<thead>
											</thead>
												<tbody>
													<tr class="bg-warning">
														<td colspan="2" class="border px-2 p-1">
														</td>
													</tr>

													<tr>
														<td class="border px-2 p-1">
															Auto Generate Mating Record
														</td>
														<td class="border px-2 p-1">
															<input wire:model.lazy="agmatingr" class="form-control-sm border" type="checkbox" value="true">
														</td>
													</tr>

													<tr>
														<td class="border px-2 p-1">
															Mating Date
														</td>
														<td class="border px-2 p-1">
															<input wire:model.lazy="mating_date" class="form-control-sm border" value="{{ date('Y-m-d') }}" type="date">
														</td>
													</tr>

													<tr>
														<td class="border px-2 p-1">
															Wean Time
														</td>
														<td class="border px-2 p-1">
															<input wire:model.lazy="wean_days" class="form-control-sm border" value="28" type="text"> Days
														</td>
													</tr>

													<tr>
														<td class="border px-2 p-1">
															Wean Note
														</td>
														<td class="border px-2 p-1">
															<input wire:model.lazy="wean_note" class="form-control-sm border"  type="text">
														</td>
													</tr>
													

													<tr bgcolor="#AHDADE">
														<td class="border px-2 p-1">
														</td >
														<td class="border px-2 p-1">											
														</td >
													</tr>
													
													<tr bgcolor="#EAEDED">
														<td class="p-2">
															<font color="red">Generation*</font>
														</td>
														<td>
															<select wire:model.lazy="nm_gen_key" class="form-control-sm border" name="_generation_key" id="_generation_key">
																<option value=""></option>
																<option value="F00">F00</option>
																	@foreach($generations as $item)
																		<option value="{{ $item->generation }}">{{ $item->generation }}</option>
																	@endforeach
															</select>
															</br>
															@error('nm_gen_key') 
																<span class="text-danger error">
																	{{ $message }}
																</span> 
															@enderror
														</td>
													</tr>

													<tr>
														<td class="border px-2 p-1">
															Room*
														</td>
														<td class="border px-2 p-1">
															<select wire:model.lazy="mroom_id" wire:change="matingRoomSelected" class="form-control-sm border" name="room_id" id="room_id">
																<option value="-1"></option>
																	@foreach($rooms as $row)
																		<option value="{{ $row->room_id }}">{{ $row->room_name }}</option>
																	@endforeach
															</select>
															</br>
															@error('mroom_id') 
																<span class="text-danger error">
																	{{ $message }}
																</span> 
															@enderror
														</td>
													</tr>
													
													<tr>
														<td class="border px-2 p-1">
															<font color="red">Rack*</font>
														</td>
														<td class="border px-2 p-1">
															<select wire:model.lazy="mrack_id" wire:change="matingRackSelected" class="form-control-sm border" name="rack_id" id="rack_id">
																<option value="0"></option>
																	@foreach($mracksInRoom as $row)
																		<option value="{{ $row->rack_id }}">{{ $row->rack_name }}</option>
																	@endforeach																		
															</select>
															</br>
															@error('mrack_id') 
																<span class="text-danger error">
																	{{ $message }}
																</span> 
															@enderror
														</td>
													</tr>

													<tr class="border">
														<td class="border px-2 p-1">
															<font color="red">Total Free Slots</font>: 
														</td>
														<td class="border px-2 p-1">
															{{ $mfree_slots }}
														</td>
													</tr>
													
													<tr class="border">
														<td class="border px-2 p-1"> 
															<font color="red">First 5 Free Slot ID</font>
														</td>

														<td class="border px-2 p-1">
															{{ $mfslot_num }}
														</td>
													</tr>
													
													<tr bgcolor="#EADDED">
														<td class="border px-2 p-1">
															<font color="red">Slot ID</font>
														</td>
														<td class="border px-2 p-1">
															<input wire:model.lazy="mslot_id" class="form-control-sm border" placeholder="Auto Selected" value="" type="text">
															(Auto Selected)
															</br>
															@error('mslot_id') 
																<span class="text-danger error">
																	{{ $message }}
																</span> 
															@enderror
														</td>
													</tr>

													<tr>
														<td class="border px-2  p-1">
															Comments
														</td>
														<td class="border px-2  p-1">
															<input wire:model.lazy="mating_comment" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Comments">
														</br>
															@error('mating_comment') 
																<span class="text-danger error">
																	{{ $message }}
																</span> 
															@enderror
														
														</td>
														
													</tr>
													@if($showMatingEntryButton)
														@if($matingEntryErrorMsg != null)
														<tr>
															<td colspan="2" class="border px-2 p-1">
															{{  $matingEntryErrorMsg }}
															</td>
														</tr>
														@endif
														<tr>
															<td class="border px-2 p-1">
																@if($confirm3==="true")
																	<button wire:click="postMatingEntryData()" class="btn btn-success rounded border">Sure?</button>
																	<button wire:click="cancelPostMatingEntryData()" class="btn btn-success rounded border px-5">Cancel</button>
																@else
																	<button wire:click="postMatingEntryDataSure()" class="btn btn-info rounded rounded border">Post Mating Entries</button>
																@endif
															</td>
															<td class="border px-2 p-1">
															</td>
														</tr>
													@endif
												</tbody>
										</table>														
									</div>
								</div>
								</div><!-- /.card-body -->
							</div>
						</section>
						
					</div><!-- /.row (main row) -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->   
		@endif

		@if($panel4)
		<section class="content">
			<div class="container-fluid"> 
        <div class="row">

          <section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  DB Entries:  Messages & Errors 
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
						  <div class="card-body">
							<div class="tab-content p-0">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <!-- Show the selection form-->
                  <!-- Show the selection form-->
									<table class="w-full p-5 text-sm text-gray-900">
										<thead>
											<th>Errors and Failures</th>
										</thead>
										<tbody>
											@foreach($success_box as $val)
												<tr class="bg-success-subtle">
													<td class="border px-2 p-1">
													{{ $val }}
													</td>
												</tr>
											@endforeach
												<tr bgcolor="#AHDADE">
													<td class="border px-2 p-1">
													</td >
													<td class="border px-2 p-1">											
													</td >
												</tr>
											@foreach($error_box as $val)										
												<tr class="bg-warning-subtle">
													<td class="p-2">
														<font color="red">
															{{ $val }}
														</font>
													</td>
												</tr>
											@endforeach	
										</tbody>
									</table>														
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>
					
          <section class="col-lg-6 connectedSortable">
						<!-- Custom tabs (Charts with tabs)-->
						<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title">
							  <i class="fas fa-chart-pie mr-1"></i>
							  Mating Entries:  Messages & Errors 
							</h3>
							<div class="card-tools">
							  <ul class="nav nav-pills ml-auto">
                  <li class="nav-item"></li>
                  <li class="nav-item"></li>
							  </ul>
							</div>
						  </div><!-- /.card-header -->
						  <div class="card-body">
							<div class="tab-content p-0">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <!-- Show the selection form-->
                  <!-- Show the selection form-->
									<table class="w-full p-5 text-sm text-gray-900">
										<thead>
											<th>Messages/Errors/Failures</th>
										</thead>
										<tbody>
											@foreach($msgLTM as $val)
												<tr class="bg-success-subtle">
													<td class="border px-2 p-1">
													{{ $val }}
													</td>
												</tr>
											@endforeach											
												<tr bgcolor="#AHDADE">
													<td class="border px-2 p-1">
													</td >
													<td class="border px-2 p-1">											
													</td >
												</tr>										
											
										</tbody>
									</table>														
								</div>
							</div>
						  </div><!-- /.card-body -->
						</div>
						<!-- /.card -->
						<!-- /.card -->
					</section>





				</div>
			</div>
		</section>
		@endif
    <!-- / End of Left Panel Graph Card-->
	</div>



</div>

@script
<script>
	document.addEventListener("success", function(body){
		var body = @this.body
		//Swal.fire(body)
		Swal.fire('Message', body, 'success')			
	});

	document.addEventListener("error", function(body){
		var body = @this.body
		//Swal.fire(body)
		Swal.fire('Message', body, 'error')			
	});
	
	document.addEventListener("warning", function(body){
		var body = @this.body
		//Swal.fire(body)
		Swal.fire('Message', body, 'warning')			
	});		

	document.addEventListener("info", function(body){
		var body = @this.body
		//Swal.fire(body)
		Swal.fire('Message', body, 'info')			
	});		
</script>
@endscript