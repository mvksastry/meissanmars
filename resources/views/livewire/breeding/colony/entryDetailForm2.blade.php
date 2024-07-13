<div class="w-full md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-3" id="iaMessage">
			<h5 class="font-bold uppercase text-gray-600">Details: <font color="blue"> {{ $iaMessage }}</font>
			</h5>
		</div>
		<div class="p-1">
			<table class="w-full p-5 text-lg-bold text-gray-800">
				<thead>
					<div id="iaMessage">
						
					</div>
				</thead>
				<tbody>
					<tr bgcolor="#EAEDED">
            <td class="p-2">
							<font color="red">Species Name*</font>
            </td>
            <td>
              <input wire:model.lazy="speciesName" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" name="speciesName" id="speciesName" value="{{ $speciesName }}" >
							<font color="red">Purpose</font>
							<input wire:model.lazy="purpose" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" name="purpose" id="purpose" value="{{ $purpose }}" >
						</td>
						<td>
							Default Limit:
						</td>
						<td>
							<input wire:model.prevent="deflimit" type="text" data-validation="custom"  name="deflimit" id="deflimit" value="5" >
            </td>
          </tr>
          <tr bgcolor="#EADDED">
            <td class="p-2" colspan="2">
              <font color="red">{{ $speciesName }} ID Code* </font>
              <input wire:model.lazy="speciesIdcode" type="text" class="w-1/0" placeholder="{{ $speciesName }} ID Code *"> -
							<input wire:model.lazy="runner" type="text" class="w-1/20" placeholder="Runner Code *">
							<input wire:model.prevent="automiceid" type="checkbox" value="true"> Auto ID
							</br>
							{{ $cmsg4 }}
						</td>
            <td >
              <font color="red">{{ $speciesName }} ID* </font>
            </td>
            <td>
              <input wire:model.lazy="speciesId" type="text" name="speciesId" id="speciesId"
                  data-validation="custom"  data-validation-regexp="^([A-Z]{2}-[A-Z]{2}-[0-9]{6}-[0-9]{4}-[0-9]{2})$"
                  data-validation="required" placeholder="{{ $speciesName }} ID *">
            </td>
          </tr>
          <tr bgcolor="#EAEDED">
            <td class="p-2">
              Protocol ID:
            </td>
            <td>
              <select wire:model.lazy="_protocol_key" name="_protocol_key" id="_protocol_key" >
                <option value=""></option>
								@if(!empty($protocols))
                  @foreach($protocols as $item)
										<option value="{{ $item->id }}">{{ $item->id }}</option>
                  @endforeach
								@endif
              </select>
            </td>
						<td>
							<button wire:target.prevent="littersel" class="btn btn-primary btn-sm rounded">Select Litter</button>
							Or Enter#
						</td>
						<td>
							<input wire:model.lazy="_litter_key" type="text" name="_litter_key" id="_litter_key"
								placeholder="Litter Id *" >
						</td>
          </tr>
          <tr bgcolor="#EADDED">
						<td>
						</td>
          </tr>
          <tr bgcolor="#EADDED">
            <td class="p-2">
              <font color="red">Strain*</font>
            </td>
            <td colspan="3" >
              <label for="all">
              <input wire:model.lazy="_strain_all" type="radio" name="_strain_all" id="_strain_all" value="1" > All
              </label>
              <label for="activeonly">
                <input wire:model.lazy="_strain_all" type="radio" name="_strain_all" id="_strain_all" value="2"> Active Only
              </label>
              <select wire:model.lazy="_strain_key" name="_strain_key" id="_strain_key">
                <option value=""></option>
                @foreach($strains as $item)
                  <option value="{{ $item->strain_id }}">{{ $item->strain_name." : ".$item->jrNum }}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr bgcolor="#EAEDED">
            <td class="p-2">
              <font color="red">Generation*</font>
              </td>
              <td>
                <select wire:model.lazy="_generation_key" name="_generation_key" id="_generation_key">
                  <option value=""></option>
                  @foreach($generations as $item)
                    <option value="{{ $item->generation }}">{{ $item->generation }}</option>
                  @endforeach
                </select>
            </td>
            <td>
							<font color="red">Date of Birth*</font>
            </td>
            <td>
              <input wire:model.lazy="dob" data-validate="required" id="dob" name="dob"
                          		placeholder="YYYY-MM-DD" type="text"/>
            </td>
          </tr>
          <tr bgcolor="#EADDED">
            <td class="p-2"><font color="red">Sex*</font>
            </td>
            <td>
              <label for="Male">
                <input wire:model.lazy="_sex_key" type="radio" name="_sex_key" id="_sex_key" value="M" > Male
              </label>
              <label for="Female">
                <input wire:model.lazy="_sex_key" type="radio" name="_sex_key" id="_sex_key" value="F"> Female
              </label>
              <label for="Unknown">
                <input wire:model.lazy="_sex_key" type="radio" name="_sex_key" id="_sex_key" value="U"> Unknown
              </label>
            </td>
						<td>
							Gender Mixing
						</td>
						<td>
							Yes/No
						</td>
          </tr>
          <tr bgcolor="#EAEDED">
            <td class="p-2">
              <font color="red">Breeding Status*</font>
            </td>
            <td>
              <label for="breeding">
                <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="B"> Breeding
              </label>
              <label for="rb">
                <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="R"> Retired Breeder
              </label>
              <label for="virgin">
                <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="V"> Virgin
              </label>
              <label for="unknwon">
                <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="U"> Unknown
              </label>
            </td>
						<td>
							<font color="red">Life Status*</font>
						</td>
						<td>
							<select wire:model.lazy="_lifeStatus_key" name="_lifeStatus_key" id="_lifeStatus_key">
								<option value="0"></option>
									@foreach($lifestatus as $item)
										<option value="{{ $item->lifeStatus }}">{{ $item->description }}</option>
									@endforeach
							</select>
						</td>
          </tr>
					<tr bgcolor="#EADDED">
            <td class="p-2">
                <font color="red">Suggested Cage ID*</font>
              </td >
              <td>
							{{ $cageNumSuggestion }}
              <input wire:model.prevent="cageInfos" type="text" name="cage_code" id="cage_code" value="">
							<input wire:model.prevent="usenextid" type="checkbox" data-validation="custom"  name="usenextid" id="usenextid" value="true" data-validation-regexp="^([0-9])$">
							Use Next ID
            </td>

            <td >
              <button wire:target.prevent="cagesel" class="btn btn-primary btn-sm rounded">Select Cage</button>
            </td >
            <td>
              <button wire:target.prevent="cagenew" class="btn btn-primary btn-sm rounded">New Cage</button>
            </td>  
          </tr>
					<tr bgcolor="#EAEDED">
            <td class="p-2">
                <font color="red">Live Information</font>
            </td >
            <td>
              Total to Cage {{ $count }}, {{ $cmsg }}
							</br> [ DB Live: {{ $countx }}, {{ $cmsg1 }} ]
							</br> {{ $cmsg2 }}
							</br> {{ $cmsg3 }}
            </td>
            <td>
                <font color="red">Room*</font>
            </td>
            <td>
              <select wire:model.lazy="room_id" name="room_id" id="room_id">
								<option value="0"></option>
                  @foreach($rooms as $item)
                    <option value="{{ $item->room_id }}">{{ $item->room_name }}</option>
                  @endforeach
              </select>
            </td>
          </tr>
          <tr bgcolor="#EAEDED">
           	<td class="p-2">   	
            </td>
            <td>
            </td>
            <td>
             	<font color="red">Rack*</font>
            </td>
            <td>
             	<select wire:model.lazy="rack_id" name="rack_id" id="rack_id">
								<option value="0"></option>
               		@foreach($racks as $item)
                 		<option value="{{ $item->rack_id }}">{{ $item->rack_name }}</option>
               		@endforeach
             	</select>
            </td>
          </tr>
          <tr bgcolor="#EAEDED">
           	<td class="p-2">
           	</td >
           	<td>
           	</td>
           	<td>
             	<font color="red">Slot* (Auto Next Available)</font>
           	</td>
           	<td> 
             	<input wire:model.prevent="slotval" name="slot_id" id="slot_id" type="text" value="{{ $slotID }}">
					 	</td>
          </tr>
          <tr bgcolor="#EADDED">
           	<td class="p-2">
             	Coat Color
           	</td>
           	<td >
             	<select wire:model.lazy="_coatColor_key" name="_coatColor_key" id="_coatColor_key">
             		<option value=""></option>
               		@foreach($coatcolors as $item)
                 		<option value="{{ $item->coatColor }}">{{ $item->coatColor. " : ".$item->description }}</option>
               		@endforeach
             	</select>
           	</td>
           	<td>
             	Diet
           	</td>
           	<td>
             	<select wire:model.lazy="_diet_key" name="_diet_key" id="_diet_key">
               	<option value=""></option>
               		@foreach($diets as $item)
               			<option value="{{ $item->diet }}">{{ $item->diet }}</option>
               		@endforeach
             	</select>
           	</td>
          </tr>
          <tr bgcolor="#EAEDED">
           	<td class="p-2">
             	<font color="red">Owner / Workgroup*</font>
           	</td>
           	<td>
             	<select wire:model.lazy="_owner_key" name="_owner_key" id="_owner_key">
					      <option value="0"></option>
               		@foreach($owners as $item)
                 		<option value="{{ $item->owner }}">{{ $item->owner }}</option>
               		@endforeach
             	</select>
           	</td>
           	<td >
             	<font color="red">Origin*</font>
           	</td>
           	<td >
             	<select wire:model.lazy="_origin_key" name="_origin_key" id="_origin_key">
               	<option value=""></option>
                 	@foreach($origins as $item)
                 		<option value="{{ $item->Origin }}">{{ $item->Origin }}</option>
                 	@endforeach
             	</select>
           	</td>
          </tr>
          <tr bgcolor="#EADDED">
           	<td class="p-2">
             	Replacement Tag Base
           	</td>
           	<td>
					    <input wire:model.lazy="tagBase" type="text">
             	<input wire:model.lazy="replacement_tag" type="text" name="replacement_tag" id="replacement_tag"
                data-validate="required|min:3" placeholder="Replacement Tag">
						</br>
						{{ $tagMsg }}
           	</td>
						<td>
             	Cage Card
           	</td>
           	<td>
							<input wire:model.lazy="cage_card" type="text" name="cage_card" id="cage_card"
               	data-validate="required|min:3" placeholder="Cage Card">
           	</td>
          </tr>
          <tr bgcolor="#EAEDED">
           	<td class="p-2">
             	Phenotypes
           	</td>
           	<td >
					  	<select wire:model.lazy="_phenotype_key" name="_phenotype_key" id="_phenotype_key" multiple>
                <option value=""></option>
                  @foreach($phenotypes as $item)
                    <option value="{{ $item->_phenotype_key }}">{{ $item->phenotype }}</option>
                  @endforeach
             	</select>
           	</td>
						<td>
							Use Schedules
						</td>
						<td >
							<select wire:model.lazy="usescheduleterm_key" name="usescheduleterm_key" id="usescheduleterm_key" multiple>
							<option value=""></option>
								@foreach($useScheduleTerms as $item)
									<option value="{{ $item->_useScheduleTerm_key }}">{{ $item->useScheduleTermName }}</option>
								@endforeach
							</select>
						</td>
          </tr>
          <tr bgcolor="#EADDED">
           	<td class="p-2">
             	Comments
           	</td>
           	<td >
             	<textarea wire:model.lazy="comments" class="form-control" name="comments"
                id="comments" rows="2"></textarea>
           	</td>
						<td>
							Add Flag: @if($addToCageFlag) True @else False @endif
						</td>
						<td>
							Create Flag: @if($cageCreateFlag) True @else False @endif
					<tr bgcolor="#EADDED">
           	<td class="p-2">
           	</td>
           	<td >
           	</td>
						<td>
							@if($addToCageFlag)
							<button wire:click="post()" class="btn btn-primary rounded">Enter</button>
							@else

							@endif
						</td>
						<td>
							<button wire:target.prevent="resetForm()" class="btn btn-primary rounded">Cancel</button>
						</td>
         	</tr>
				</tbody>
			</table>
		<!-- Submit Button -->
		</div>
	</div>
</div>
