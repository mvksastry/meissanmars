<div class="w-1/2 md-1/2">
	<div class="bg-purple-100 border border-gray-800 rounded shadow">
		<div class="border-b border-gray-800">
			<h5 class="font-bold uppercase mx-3 text-gray-600">Species: {{ $speciesName }}</h5>
		</div>
		<div class="p-1">
			<table class="table table-hover p-1 text-sm">
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
              <input wire:model.lazy="matKey" placeholder="Select Mating Entry" class="form-control-sm border bg-secondary-subtle" type="text" >
							@if($purpose == "New")
							<button wire:click="searchMates('{{ $speciesName }}')" class="btn btn-primary rounded">Select Mating</button>
							@endif
						</td>
					</tr>
					
					<tr>
            <td class="border px-2  text-sm text-red p-1" colspan="2">
              @if(!empty($mqryResult))
                Mating Ref ID: {{ $mqryResult->matingRefID }}; 
								</br>
								Dam1: {{ $mqryResult->_dam1_key }}; Dam2: {{ $mqryResult->_dam2_key }}; Sire: {{ $mqryResult->_sire_key }}; Mating Date: {{ date('d-m-Y', strtotime($mqryResult->matingDate)) }}; 
                </br>
                Wean Time: {{ $mqryResult->weanTime }} days; Generation: {{ $mqryResult->generation }}; Strain: {{ $mqryResult->_strain_key }};
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
              <input wire:model.lazy="dateBorn" class="form-control-sm border bg-secondary-subtle" type="date" placeholder="YYYY-MM-DD">
							(Def: Today)
						</br>
							<input wire:model="autoDates" class="border bg-secondary-subtle" type="checkbox" value="true">Calculate Dates
						</br>
						@error('dateBorn') <span class="text-danger error">{{ $message }}</span> @enderror
						
						</td>
					</tr>





					
					<tr>
            <td class="border px-2  p-1">
                A: # Total Born
            </td>
            <td class="border px-2  p-1">
                <input wire:model.lazy="totalBorn" placeholder="Total Born" class="form-control-sm border bg-primary-subtle" type="text">
						</br>
						@error('totalBorn') <span class="text-danger error">{{ $message }}</span> @enderror

            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              B: # Females /
							</br>
							C: # Males
            </td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="numFemales" placeholder="Females" class="form-control-sm border bg-secondary-subtle" type="text"> /
              </br>
							@error('numFemales') <span class="text-danger error">{{ $message }}</span> @enderror
							</br>
							<input wire:model.lazy="numMales" placeholder="Males" class="form-control-sm border bg-secondary-subtle mt-2 " type="text">
							</br>
							@error('numMales') <span class="text-danger error">{{ $message }}</span> @enderror
						</td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              D: # Dead
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="bornDead" wire:change="deadValueEntered()" placeholder="Dead" class="form-control-sm border bg-secondary-subtle" type="text" placeholder="">
							</br>
							@error('bornDead') <span class="text-danger error">{{ $message }}</span> @enderror

						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
              E: # Culled at Wean
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="culledAtWean" wire:change="culledAtWeanEntered()" placeholder="Culled At Wean" class="form-control-sm border bg-secondary-subtle" type="text" placeholder="">
							</br>
							@error('culledAtWean') <span class="text-danger error">{{ $message }}</span> @enderror
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
                F: # Missing at Wean
            </td>
            <td class="border px-2  p-1">
                <input wire:model.lazy="missAtWean" wire:change="missAtWeanEntered()" placeholder="Missing At Wean" class="form-control-sm border bg-secondary-subtle" type="text">
							</br>
							@error('missAtWean') <span class="text-danger error">{{ $message }}</span> @enderror
            </td>
          </tr>





					<tr>
            <td class="border px-2  p-1">
                Wean Date
            </td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="weanDate" class="form-control-sm border bg-secondary-subtle" type="date" placeholder="YYYY-MM-DD">
							(Def: {{ $wean_time }} days)
            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              Tag Date
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="tagDate" class="form-control-sm border bg-secondary-subtle" type="date" placeholder="YYYY-MM-DD">
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
              Comments (Litter Entries)
						</td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="coment" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Comments">
							</br>
							@error('coment') <span class="text-danger error">{{ $message }}</span> @enderror
 
						</td>
					</tr>

					@if($showCodRowInputs)
						<tr>
							<td class="border px-2  p-1">
									Colony Info 
							</td>
							<td class="border px-2  p-1">
								<input wire:model.lazy="colonyInfo" class="form-control-sm border bg-secondary-subtle" type="text" placeholder="Colony Info">
							</br>
							@error('colonyInfo') <span class="text-danger error">{{ $message }}</span> @enderror

							</td>
						</tr>

						<tr>
							<td class="border px-2  p-1">
								Cause of Death
							</td>
							<td class="border px-2  p-1">
								<input wire:model.lazy="cofdeath" class="form-control-sm border bg-secondary-subtle" type="text" placeholder="Cause of Death">
							</br>
							@error('cofdeath') <span class="text-danger error">{{ $message }}</span> @enderror

							</td>
						</tr>

						<tr>
							<td class="border px-2  p-1">
								Notes (Mortality Related)
							</td>
							<td class="border px-2  p-1">
								<input wire:model.lazy="mortNotes" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Notes ">
							</br>
							@error('mortNotes') <span class="text-danger error">{{ $message }}</span> @enderror

							</td>
						</tr>						
					@endif

					<tr class="border bg-warning-subtle">
						<td colspan="2" class="bg-warning border px-2 p-1">
						{{ $iaMessage2 }}
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



