	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="p-2">
			<table class="w-full p-2 text-xs text-gray-800">
				<thead>
					<div id="iaMessage">
						{{ $iaMessage }}
					</div>
				</thead>

				<tbody>
					<tr>
            <td class="w-1/6 p-1" bgcolor="#EAEDED">
							<font color="red">Species Name*</font>
            </td>
            <td  bgcolor="#EAEDED">
              <input wire:model.lazy="speciesName" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" name="speciesName" id="speciesName" value="{{ $speciesName }}" >
						</td>
						<td>
						</td>
						<td>
							<font color="red">Purpose</font>
						</td>
						<td>
              <input wire:model.lazy="purpose" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" name="purpose" id="purpose" value="{{ $purpose }}" >
            </td>
          </tr>

       		<tr>
            <td class="p-1">
                <font color="red">{{ $speciesName }} ID Code* </font>
            </td>
            <td>
							<font color="red">{{ $entry->ID }}</font>
						</td>
            <td >

            </td>
            <td>

            </td>
          </tr>

          <tr>
            <td class="p-1">
                Protocol ID:
            </td>
						<td>
							{{ $protoSelected }}
            </td>
						<td>
              @if(!empty($protocols))
                <select wire:model.lazy="_protocol_key" name="_protocol_key" id="_protocol_key" >
                  <option value=""></option>
                    @foreach($protocols as $item)
                      <option value="{{ $item->id }}" @if($item->id == $protoSelected ) selected="selected" @endif >{{ $item->id }}</option>
                    @endforeach
                </select>
              @endif
            </td>
						<td>
							Litter #
						</td>
						<td>
							@if($entry->_litter_key == null) None @endif
						<td>
							<input wire:model.lazy="_litter_key" type="text" name="_litter_key" id="_litter_key"
								placeholder="Litter *" >
						</td>
          </tr>

          <tr>
						<td class="p-1" colspan="4">
						</td>
          </tr>

          <tr>
            <td>
                Strain*
            </td>
						<td>
							{{ $entry->strainSelected->strainName }}
						</td>

            <td colspan="3" >
              <select wire:model.lazy="_strain_key" name="_strain_key" id="_strain_key">
                <option value=""></option>
                  @foreach($strains as $item)
                  <option value="{{ $item->_strain_key }}" @if($item->_strain_key == $entry->_strain_key) selected="selected" @endif >{{ $item->strainName." : ".$item->jrNum }}</option>
                  @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <td class="p-1">
                <font color="red">Generation*</font>
            </td>
						<td>
							<font color="red">{{ $entry->genSelected->generation }}</font>
						</td>
            <td>
            </td>
            <td>
							<font color="red">Date of Birth*</font>
            </td>
						<td color="red">
							<font color="red">{{ date('d-m-Y', strtotime($entry->birthDate)) }}</font>
            <td>
							<?php
								$diff = strtotime(date('Y-m-d')) - strtotime($entry->birthDate);
								$res = abs(round($diff / 86400));
							?>
							<font color="red">Age: {{ $res }} days</font>
            </td>
          </tr>

          <tr>
            <td class="p-1">
							<font color="red">Sex*</font>
            </td>
						<td color="red">
							<font color="red">{{ $entry->sex }}</font>
						</td>
            <td>
            </td>
            <td >
                Life Status*
            </td>
						<td>
							{{ $entry->lifestatusSelected->description }}
						</td>
            <td >
              <select wire:model.lazy="_lifeStatus_key" name="_lifeStatus_key" id="_lifeStatus_key">
                <option value="0"></option>
                  @foreach($lifestatus as $item)
                    <option value="{{ $item->_lifeStatus_key }}">{{ $item->description }}</option>
                  @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <td class="p-1">
                Breeding Status*
            </td>
						<td>
							{{ $entry->breedingStatus }}
						</td>
            <td>
                <label for="breeding">
                    <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="B"> <b><u>B</u></b>reeding
                </label>
                <label for="rb">
                    <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="R"> <b><u>R</u></b>etired Breeder
                </label>
                <label for="virgin">
                    <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="V"> <b><u>V</u></b>irgin
                </label>
                <label for="unknwon">
                    <input wire:model.lazy="_breedingStatus_key" type="radio" name="_breedingStatus_key" id="_breedingStatus_key" value="U"> <b><u>U</u></b>nknown
                </label>
            </td>
          </tr>

					<tr>
            <td class="p-1">
                Cage ID Code*
            </td >
						<td>
							{{ $entry->_pen_key}}
            </td>
            <td>
							<input wire:model.lazy="cage_id" type="text" name="cage_id" id="cage_id"
								readonly placeholder="Cage ID">
            </td>

						<td>
							
            </td>
						<td>
              <button wire:click.prevent="cageSearch()" class="btn btn-info btn-sm rounded">Select Cage</button>
						</td>
            <td>
              <button wire:click.prevent="cagenew()" class="btn btn-info btn-sm rounded">New Cage</button>
						</td>
          </tr>

					<tr>
            <td class="p-1">
              Total in cage
            </td>
						<td>
						</td>
            <td>
              Total in Cage {{ $count }}
            </td>
            <td>
              Room*
            </td>
						<td>
							{{ $roomInfo->containerName }}
						</td>
            <td>
              <select wire:model.lazy="_room_key" name="_room_key" id="_room_key">
                <option value="0"></option>
                  @foreach($rooms as $item)
                    <option value="{{ $item->_room_key }}">{{ $item->roomName }}</option>
                  @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <td class="p-1">
              Coat Color
            </td>
						<td>
							{{ $entry->coatColor}}
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
							{{ $entry->diet }}
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

          <tr>
            <td class="p-1">
                <font color="red">Owner / Workgroup*</font>
            </td>
            <td>
              <font color="red">{{ $entry->ownerSelected->owner }}</font>
            <td>

            </td>
            <td >
                Origin*
            </td>
            <td>
              {{ $entry->origin }}
            </td>
            <td >
                <select wire:model.lazy="_origin_key" name="_origin_key" id="_origin_key">
                    <option value=""></option>
                    @foreach($origins as $item)
                      <option value="{{ $item->_origin_key }}">{{ $item->Origin }}</option>
                    @endforeach
                </select>
            </td>
          </tr>

          <tr>
            <td class="p-1">
                Replacement Tag
            </td>

						<td>
							{{ $entry->newTag }}
						</td>

            <td>
              <input wire:model.lazy="replacement_tag" type="text" name="replacement_tag" id="replacement_tag"
                  value="{{ $entry->newTag }}" placeholder="Replacement Tag">
            </td>

						<td>
              Cage Card
            </td>

						<td>
						</td>

            <td>
							<input wire:model.lazy="cage_card" type="text" name="cage_card" id="cage_card"
                        	data-validate="required|min:3" placeholder="Cage Card">
            </td>
          </tr>

          <tr>
            <td class="p-1">
                Phenotypes
            </td>
						<td>
							@foreach($av as $val)
								{{ $val }}
							@endforeach
						</td>
            <td>
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
						<td>
							@foreach($av2 as $val)
								{{ $val }} </br>
							@endforeach
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

					<tr>
            <td class="p-1">
              Vial ID
            </td>
						<td>
						</td>
            <td >
							<input wire:model.lazy="vialId" type="text" name="vialId" id="vialId"
                placeholder="Vial ID">
            </td>
						<td>
							Vial Position
						</td>
						<td>
						</td>
						<td >
							<input wire:model.lazy="vialIdposition" type="text" name="vialIdposition" id="vialIdposition"
                        	placeholder="Vial ID Location">
						</td>
          </tr>

          <tr>
            <td class="p-1">
              Comments
            </td>
						<td>
							{{ $entry->comment }}
						</td>
            <td >
              <textarea wire:model.lazy="comments" class="form-control" name="comments"
                  id="comments" rows="2"></textarea>
            </td>
						<td>
						</td>
          </tr>
					<tr>
						<td class="p-1">
							<button wire:click="update('{{ $entry->ID }}')" class="btn btn-primary rounded">Update</button>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td>
							<button wire:target.prevent="resetForm" class="btn btn-primary rounded">Cancel</button>
						</td>
					</tr>
				</tbody>
			</table>
		<!-- Submit Button -->
		</div>
	</div>

