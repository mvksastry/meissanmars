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
						</td>
					</tr>
					
					<tr>
            <td class="border px-2  p-1">
                A: # Total Born
            </td>
            <td class="border px-2  p-1">
                <input wire:model.lazy="totalBorn" class="form-control-sm border bg-primary-subtle" type="text">
            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              B: # Dead
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="bornDead" class="form-control-sm border bg-secondary-subtle" type="text" placeholder="">
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
              C: # Females /
							</br>
							D: # Males
            </td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="numFemales" class="form-control-sm border bg-secondary-subtle" type="text"> /
              </br>
							<input wire:model.lazy="numMales" class="form-control-sm border bg-secondary-subtle mt-2 " type="text">
            </td>
          </tr>

					<tr>
            <td class="border px-2  p-1">
              E: # Culled at Wean
						</td>
						<td class="border px-2  p-1">
              <input wire:model.lazy="culledAtWean" class="form-control-sm border bg-secondary-subtle" type="text" placeholder="">
						</td>
					</tr>

					<tr>
            <td class="border px-2  p-1">
                F: # Missing at Wean
            </td>
            <td class="border px-2  p-1">
                <input wire:model.lazy="missAtWean" class="form-control-sm border bg-secondary-subtle" type="text">
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
              Comments
						</td>
            <td class="border px-2  p-1">
              <input wire:model.lazy="coment" class="form-control-sm border bg-secondary-subtle" type="text" class="w-full" placeholder="Comments">
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



