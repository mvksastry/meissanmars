<div class="w-1/2 md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase mx-3 text-gray-600">Species: {{ $speciesName }}</h5>
		</div>
		<div class="p-1">
			<table class="w-full p-5 text-sm text-gray-900">
				<thead>
					<div id="iaMessage">
						
						</br>
						Must Select option in gray cells
					</div>
				</thead>
				<tbody>
					<tr>
						<td class="border px-2  p-1">
							Purpose
						</td>
						<td class="border px-2  p-1">
							{{ $purpose }}
						</td>
					</tr>

          <tr>
            <td class="border px-2  p-1">
              Mating ID*
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="matKey" class="border" type="text" >
							@if($purpose == "New")
							<button wire:click="searchMates('{{ $speciesName }}')" class="btn btn-primary rounded mt-2">Select Mating</button>
							@endif
						</td>
					</tr>
					<tr>
            <td class="border px-2  text-xs text-red-600 p-1" colspan="2">
              @if(!empty($mqryResult))
                Dam1: {{ $mqryResult->_dam1_key }}; Dam2: {{ $mqryResult->_dam1_key }}; Sire: {{ $mqryResult->_dam1_key }};
                </br>
                Mating Date: {{ date('d-m-Y', strtotime($mqryResult->matingDate)) }}; Generation: {{ $mqryResult->generation }}; Strain: {{ $mqryResult->_strain_key }};
              @else
                Select Mating Entry
              @endif
						</td>
					</tr>

					<tr>
						<td colspan="2" class="border px-2  p-1">
							Birth Information
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
              Date Born
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="dateBorn" type="text" placeholder="YYYY-MM-DD">
							(Def: Today)
						</br>
							<input wire:model="autoDates" type="checkbox" value="true">Calculate Dates
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
                A: # Total Born
            </td>
            <td class="border px-2  p-1">
                <input wire:model.lazy="totalBorn" type="text">
            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              B: # Born Dead
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="bornDead" type="text" placeholder="">
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
              C: # Females /
							</br>
							D: # Males
            </td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="numFemales" class="border gray-600" type="text"> /
              </br>
							<input wire:model.lazy="numMales" class="border mt-2 " type="text">
            </td>
          </tr>

					<tr class="">
            <td class="border px-2  p-1 bg-secondary">
                Status
            </td>
            <td class="border px-2  p-1">
							<select wire:model.lazy="birthEventStatusKey" >
								<option value="null">Select</option>
                  @foreach($birthStatuses as $item)
                    <option value="{{ $item->abbreviation }}">{{ $item->birthEventStatus }}</option>
                  @endforeach
              </select>
            </td>
          </tr>


					<tr class="">
						<td class="border px-2  p-1 bg-secondary">
              Origin
						</td>
            <td class="border px-2  p-1">
							<select wire:model.lazy="origin" >
								<option value="null">Select</option>
                  @foreach($origins as $item)
                    <option value="{{ $item->Origin }}">{{ $item->Origin }}</option>
                  @endforeach
	            </select>
						</td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              Litter #
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="litterNum" class="border" type="text" placeholder="">
							@if($purpose == "New")
                <button class="btn btn-primary btn-sm rounded">Next Litter #</button>
							@endif
						</td>
					</tr>


					<tr>
            <td class="border px-2  p-1">
              E: # Culled at Wean
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="culledAtWean" class="border gray-600" type="text" placeholder="">
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
                F: # Missing at Wean
            </td>
            <td class="border px-2  p-1">
                <input wire:model.lazy="missAtWean" class="border gray-600" type="text">
            </td>
          </tr>

					<tr class="">
            <td class="border px-2  p-1 bg-secondary">
              Litter Type
            </td>
            <td class="border px-2  p-1">
							<select wire:model.lazy="litType" >
								<option value="null">Select</option>
                    @foreach($litterTypes as $item)
                      <option value="{{ $item->_litterType_key }}">{{ $item->litterType }}</option>
                    @endforeach
                </select>
            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
                Wean Date
            </td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="weanDate" type="text" placeholder="YYYY-MM-DD">
							(Def: 21 days)
            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              Tag Date
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="tagDate" type="text" placeholder="YYYY-MM-DD">
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
              Comments
						</td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="coment" type="text" class="w-full" placeholder="Comments">
						</td>
					</tr>

					<tr>
						<td class="border px-2 p-1">
							<button wire:click="enterLitter()" class="btn btn-primary rounded">Enter</button>
						</td>
						<td class="border px-2 p-1">
							<button wire:target.prevent="resetForm" class="btn btn-primary rounded">Cancel</button>
						</td>
          </tr>

				</tbody>
			</table>
		</div>
	</div>
</div>



