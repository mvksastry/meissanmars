<div class="w-full md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800 p-1" id="iaMessage">
			<h5 class="font-bold uppercase text-gray-600" >Details: <font color="blue">{{ $iaMessage }}</font>
			</h5>
		</div>
		<div class="p-1 text-xs-bold">
			<table class="w-full p-5 text-xs-bold text-gray-800" style="font-size: 12px;">
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
							<font color="red">New Mating ID</font>
						</td>
						<td>
							<input wire:model.lazy="newmatingId" style="background-color:#EAEDED; font-weight: bold; font-size: 12px;" readonly="readonly" type="text" placeholder="Read only" value="" >
            </td>
          </tr>
          <tr bgcolor="#EADDED">
            <td class="p-2">
              <font color="red">Dam 1 ID* </font>
            </td>
            <td>
              <input wire:model.lazy="dam1Id" type="text">
							<button wire:click="search('{{ $speciesName.'_Dam1' }}')" class="btn btn-primary btn-sm rounded">Dam 1 Search</button>
						</td>
            <td >
              <font color="red">Dam 2 ID* </font>
            </td>
            <td>
							<input wire:model.lazy="dam2Id" type="text">
							<button wire:click="search('{{ $speciesName.'_Dam2' }}')" class="btn btn-primary btn-sm rounded">Dam 2 Search</button>
            </td>
						<td>
              <font color="red">Sire ID* </font>
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
							{{ $dam1Msg }}
						</td>

						<td>
							Dam 2 Info
						</td>
						<td>
							Strain:{{ $dam2Strain }};  Cage: {{ $dam2CageId }};  Diet: {{ $dam2Diet }}
							</br>
							{{ $dam2Msg }}
						</td>

						<td>
							Sire Info
						</td>
						<td>
							Strain:{{ $sireStrain }};  Cage: {{ $sireCageId }};  Diet: {{ $sireDiet }}
							</br>
							{{ $sireMsg }}
						</td>
          </tr>

          <tr bgcolor="#EADDED" >
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
						</td>
						<td class="p-2">
              <font color="red">Litter Strain*</font>
            </td>
            <td colspan="1">
							<select wire:model.lazy="strain_key" name="_strain_key" id="_strain_key">
                <option value=""></option>
                  @foreach($strains as $item)
                    <option value="{{ $item->_strain_key }}">{{ $item->strainName." : ".$item->jrNum }}</option>
                  @endforeach
              </select>
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
           				@foreach($generations as $item)
           					<option value="{{ $item->generation }}">{{ $item->generation }}</option>
          				@endforeach
           			</select>
         		</td>
						<td colspan="2">
							Needs Genotyping
							<input wire:model.lazy="genotypeneed" value="true" type="checkbox">
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
						</td>
					</tr>

					<tr>
						<td>
							Mating Date
            </td>
						<td colspan="1">
							<input wire:model.lazy="matingDate" value="{{ date('Y-m-d') }}"type="text">
						</td>
            <td>
							<font color="red">Wean time</font>
            </td>
            <td colspan="2">
							<input class="mx-5" wire:model.lazy="weantime" value="1" type="radio">Standard (18 days)
							</br>
							<input class="mx-5" wire:model.lazy="weantime" value="2" type="radio">Extended (28 days)
            </td>
						<td>

						</td>
          </tr>
       		<tr bgcolor="#EADDED">
         		<td class="p-2">
							<font color="red">Cage ID</font>
             		</td>
             		<td>
                <input wire:model.lazy="cage_id" value="standard" type="text">
            </td>
						<td colspan="2">
							<button wire:click.prevent="cageSearch()" class="btn btn-primary btn-sm rounded">Select Cage</button>
							<button wire:click.prevent="cageNew()" class="btn btn-primary btn-sm rounded">New Cage</button>
						</td>
						<td colspan="2">
						</td>
          </tr>
					<tr bgcolor="#EADDED">
            <td class="p-2">

            </td >
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
							<button wire:click="post()" class="btn btn-primary rounded">Enter</button>
            </td>
            <td>
            </td>
						<td>
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
