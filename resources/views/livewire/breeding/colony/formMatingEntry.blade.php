<div class="w-full md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-1" id="iaMessage">
			<h5 class="font-bold uppercase text-gray-600" >
				Details: <font color="blue">{{ $iaMessage }}</font>
			</h5>
		</div>
		<div class="p-1 text-xs-bold">
			<table class="w-full p-5 text-sm text-gray-800" style="font-size: 16px;">
				<thead>
				</thead>
				<tbody>
					<tr bgcolor="#EAEDED">
            <td class="p-2">
							<font color="red">Species Name*</font>
            </td>
            <td>
            	<input wire:model.lazy="speciesName" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" value="{{ $speciesName }}" >
						</td>

						<td>
							<font color="red">Purpose</font>
						</td>
						<td>
							<input wire:model.lazy="purpose" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" value="{{ $purpose }}" >
						</td>

						<td class="space-x-5">
							
						</td>
						<td>
							
            </td>
          </tr>

          <tr bgcolor="#EADDED">
            <td class="p-2">
              <font color="red">Parent ID* </font>
            </td>
            <td>
              <input wire:model.lazy="parentID" type="text">
							</br>
							@error('parentID') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
            <td >
              <font color="red">Breeding Ref ID</font>
            </td>
            <td>
							<input wire:model.lazy="newMatingRefID" type="text" placeholder="Ref ID" value="" >
							</br>
							@error('newMatingRefID') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
            </td>
						<td>
              
            </td>
            <td>
            </td>
          </tr>

					
          <tr bgcolor="#EAEDED">
            <td class="p-2">
              <font color="red">Breeder F1 ID* </font>
            </td>
            <td>
              <input wire:model.lazy="dam1Id" type="text">
							<button wire:click="search('{{ $speciesName.'_Dam1' }}')" class="btn btn-primary btn-sm rounded">Dam 1 Search</button>
						</td>
            <td >
              <font color="red">Breeder F2 ID* </font>
            </td>
            <td>
							<input wire:model.lazy="dam2Id" type="text">
							<button wire:click="search('{{ $speciesName.'_Dam2' }}')" class="btn btn-primary btn-sm rounded">Dam 2 Search</button>
            </td>
						<td>
              <font color="red">Breeder M ID* </font>
            </td>
            <td>
							<input wire:model.lazy="sireId" type="text">
							<button wire:click="search('{{ $speciesName.'_Sire' }}')" class="btn btn-primary btn-sm rounded">Sire Search</button>
            </td>
          </tr>

          <tr>
            <td class="p-2">
							Dam 1 Info
						</td>
						<td>
							Strain:{{ $dam1Strain }};  Cage: {{ $dam1CageId }};  Diet: {{ $dam1Diet }}
							</br>
							Selection: {{ $dam1Msg }}
						</td>

						<td>
							Dam 2 Info
						</td>
						<td>
							Strain:{{ $dam2Strain }};  Cage: {{ $dam2CageId }};  Diet: {{ $dam2Diet }}
							</br>
							Selection: {{ $dam2Msg }}
						</td>

						<td>
							Sire Info
						</td>
						<td>
							Strain:{{ $sireStrain }};  Cage: {{ $sireCageId }};  Diet: {{ $sireDiet }}
							</br>
							Selection: {{ $sireMsg }}
						</td>
          </tr>

          <tr class="pt-2" bgcolor="#EADDED" >
						<td>
							Mating Diet
						</td>
						<td>
							<select wire:model.lazy="diet_key">
                <option value=""></option>
                  @foreach($diets as $item)
                    <option value="{{ $item->diet }}">{{ $item->diet }}</option>
                  @endforeach
              </select>
							</br>
							@error('diet_key') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
						
						<td class="p-2">
              <font color="red">Litter Strain*</font>
            </td>
            <td colspan="1">
							<select wire:model.lazy="strain_key" wire:change="changeStrainInfos" name="_strain_key" id="_strain_key">
                <option value=""></option>
                  @foreach($strains as $item)
                    <option value="{{ $item->strain_id }}">{{ substr($item->strain_name." : ".$item->jrNum, 0, 35) }}</option>
                  @endforeach
              </select>
							</br>
							@error('strain_key') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
            </td>
						
						<td >
							Mating Type
						</td>
						<td>
							<select wire:model.lazy="matgType">
                <option value=""></option>
                  @foreach($matingType as $item)
                    <option value="{{ $item->_matingType_key }}">{{ $item->matingType }}</option>
                  @endforeach
              </select>
							</br>
							@error('matgType') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
          </tr>
					
     			<tr bgcolor="#EADDED">
       		</tr>
					
       		<tr bgcolor="#EAEDED">
						<td class="p-2">
         			<font color="red">Litter Generation*</font>
         		</td>
         		<td colspan="1">
         			<select wire:model.lazy="generation_key">
           			<option value=""></option>
								<option value="F00">F00</option>
           				@foreach($generations as $item)
           					<option value="{{ $item->generation }}">{{ $item->generation }}</option>
          				@endforeach
           			</select>
							</br>
							@error('generation_key') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
         		</td>
						<td colspan="2">
							Needs Genotyping
							<input wire:model.lazy="genotypeneed" type="checkbox">
						</td>                                    
						<td>
							<font color="red">Owner/ Workgroup*</font>
						</td>
						<td>
							<select wire:model.lazy="ownerwg" >
								<option value="0"></option>
                  @foreach($owners as $item)
                    <option value="{{ $item->owner }}">{{ $item->owner }}</option>
                  @endforeach
                </select>
							</br>
							@error('ownerwg') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
					</tr>

					<tr>
						<td>
							Mating Date
            </td>
						<td colspan="1">
							<input wire:model.lazy="matingDate" type="date">
							</br>
							@error('matingDate') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
            <td>
							<font color="red">Wean time</font>
            </td>
            <td colspan="2">
							<input class="mx-5" wire:model.lazy="weantime" value="21" type="radio">Standard (21 days)
							</br>
							<input class="mx-5" wire:model.lazy="weantime" value="28" type="radio">Extended (28 days)
							</br>
							@error('weantime') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
						<td>

						</td>
          </tr>
					
       		<tr bgcolor="#EADDED">
         		<td class="p-2">
							<font color="red">Slot ID</font>
            </td>
            <td>
              <input wire:model.lazy="slot_id" value="" type="text">
							(Auto Select)
							</br>
							@error('slot_id') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
            </td>
						<td>
							Room*
						</td>
						<td>
							<select wire:model.lazy="room_id" wire:change="roomSelected" name="room_id" id="room_id">
                <option value="-1"></option>
								@foreach($rooms as $val)
                <option value="{{ $val->room_id }}">{{ $val->room_name }}</option>
								@endforeach
              </select>
							</br>
							@error('room_id') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
						<td>
							<font color="red">Rack*</font>
						</td>
						<td>
						<select wire:model.lazy="rack_id" wire:change="rackSelected" name="rack_id" id="rack_id">
								<option value="0"></option>
               		@foreach($racksInRoom as $item)
                 		<option value="{{ $item->rack_id }}">{{ $item->rack_name }}</option>
               		@endforeach
             	</select>
							</br>
							@error('rack_id') 
								<span class="text-danger error">
									{{ $message }}
								</span> 
							@enderror
						</td>
          </tr>
					
					<tr bgcolor="#EADDED">
            <td class="p-2">

            </td >
           	<td class="p-2">
							
           	</td >
           	<td>
							<font color="red">Total Free Slots</font>: 
           	</td>
           	<td>
							{{ $free_slots }}
           	</td>
           	<td> 
							<font color="red">First 5 Free Slot ID</font>
					 	</td>

            <td>
							{{ $fslot_num }}
            </td>
					</tr>
					
					<tr bgcolor="#EAEDED">
            <td class="p-2" >
              <font color="red">Wean Note</font>
            </td >
            <td colspan="5">
							<textarea wire:model.lazy="weannote" class="w-full resize-x border rounded focus:outline-none focus:shadow-outline"></textarea>
            </td>
          </tr>
          <tr bgcolor="#EADDED">
            <td class="p-2">
                Comments
            </td>
						<td colspan="5">
							<textarea wire:model.lazy="comments" class="w-full resize-x border rounded focus:outline-none focus:shadow-outline"></textarea>
            </td>
          </tr>
          <tr bgcolor="#EAEDED">
						<td class="p-2">
            </td>
            <td>
							<button wire:click="clearAllFlagsForEntry()" class="btn btn-primary rounded">Validate</button>
            </td>
            <td>
            </td>
						<td>
							@if($allFlagsClear)
							<button wire:click="post()" class="btn btn-primary rounded">Enter</button>
							@endif
						</td>
						<td>
							<button wire:target.prevent="resetform()" class="btn btn-primary rounded">Cancel</button>
						</td>
						<td>
						</td>
          </tr>
					<tr bgcolor="#EAEDED">
						<td class="p-2">
						</td>
						<td>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td>
						</td>
					</tr>
				</tbody>
			</table>
		<!-- Submit Button -->
		</div>
	</div>
</div>
