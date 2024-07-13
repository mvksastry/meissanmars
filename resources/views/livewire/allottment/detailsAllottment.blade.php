	<!--Table Card-->
	<div class="card-body">
    <div class="tab-content p-0">
      <div class="bg-orange-100 border border-gray-800 rounded shadow">
        <div class="border-b border-gray-800 p-3">
        @if($adr !=  null)
          <h5 class="font-bold uppercase text-gray-900">Search Results: Total found: @if( empty($this->adr) ) 0 @else {{ count($this->adr) }} @endif ; Checked: {{ count($mice_id) }}</h5>
        @else
          <h5 class="font-bold uppercase text-gray-900">Not Yet Searched </h5>
        @endif
       </div>
        <div class="p-2">
          @if($adr !=  null)
            <table id="userIndex2" class="table table-sm table-bordered table-hover">
              <thead>
                <tr>
                  <th> Check</th>
                  <th> Species </th>
                  <th> Strain </th>
                  <th> ID</th>
                  <th> DoB</th>
                  <th> Age </th>
                  <th> Sex </th>
                  <th> Cage # </th>
                  <th> Diet </th>
                  <th> Origin </th>
                  <th> Comment</th>
                </tr>
              </thead>
              <tbody>
                @foreach($adr as $row)
                  <tr>
                    <td>
                    <label class="inline-flex items-center">
                      <input type="checkbox" class="form-checkbox" value="{{ $row['ID'] }}" wire:model="idmice" >
                    </label>
                  </td>
                  <td>
                    {{ $row['_species_key'] }}
                  </td>
                  <td>
                    {{ $row['_strain_key'] }}
                  </td>
                  <td>
                    {{ $row['ID'] }}
                  </td>
                  <td>
                    {{ date('d-m-Y', strtotime($row['birthDate'])) }}
                  </td>
                  <?php
                    $HowManyWeeks = ( strtotime( date('Y-m-d H:i:s')) - strtotime($row['birthDate']) ) / 604800;
                   ?>
                  <td>
                    {{ floor($HowManyWeeks) }}
                  </td>
                  <td>
                    {{ $row['sex']}}
                  </td>
                  <td>
                    {{ $row['_pen_key']}}
                  </td>
                  <td>
                    {{ $row['diet'] }}
                  </td>
                  <td>
                    {{ $row['origin'] }}
                  </td>
                  <td>
                    {{ $row['comment'] }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <table class='table-auto  mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
              <thead>
                <tr>
                  <th> No entries found</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
    <!-- / End of table Card-->

    <!--Table Card-->

    <div class="border rounded shadow">
      <div class="border p-2">
        <h5>Search for Issue Id: {{ $usage_id }}</h5>
      </div>
      <div class="p-2">
        <table id="userIndex2" class="table table-sm table-bordered table-hover">
          <thead>
            <tr>
              <th class=""> Species </th>
              <th class=""> Strain </th>
              <th class=""> Born After</th>
              <th class=""> Born Before</th>
              <th class=""> Sex </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-sm text-left text-gray-900 w-1/5">
                <label class="inline-flex items-center">
                  <span class="ml-2">
                    <input wire:model="spcx" type="radio" class="form-radio" name="radio" value="1" checked>
                    Mice
                  </span>
                </label>
                </br>
                <label class="inline-flex items-center">
                  <span class="ml-2">
                    <input wire:model="spcx" type="radio" class="form-radio" name="radio" value="2">
                      Rat
                  </span>
                </label>
                </br>
                <label class="inline-flex items-center">
                  <span class="ml-2">
                    <input wire:model="spcx" type="radio" class="form-radio" name="radio" value="3">
                      Rabbit
                  </span>
                </label>
                </br>
                <label class="inline-flex items-center">
                  <span class="ml-2">
                    <input wire:model="spcx" type="radio" class="form-radio" name="radio" value="4">
                      G-Pig
                  </span>
                </label>
              </td>

              <td class="px-6 py-4 text-sm text-left text-gray-900 w-1/5">
                <input type="text" placeholder="Born After" value={{ $strain_name }} wire:model="strain_name"
                class="form-control px-2 py-1 rounded text-sm border" />
              </td>

              <td class="px-6 py-4 text-sm text-left text-gray-900 w-1/5">
                <input type="date" placeholder="Born After" wire:model="adate"
                class="form-control px-2 py-1 rounded text-sm border" />
              </td>

              <td class="px-6 py-4 text-sm text-left text-gray-900">
                <input type="date" placeholder="Born Before" wire:model="bdate"
                class="form-control px-2 py-1 rounded text-sm border" />
              </td>

              <td class="px-6 py-4 text-sm text-left text-gray-900 w-1/5">
                <input type="text" placeholder="Sex M/F/A" wire:model="xsex"
                class="form-control px-2 py-1 rounded text-sm" />
              </td>
            </tr>
            <td colspan="5">
            </br>
                <button wire:click="dbQuery()" class="btn btn-primary rounded">Search</button>
                @if($alotButton)
                  <button wire:click="alottComplete({{ $val->issue_id }})" class="btn btn-success rounded">Alott</button>
                @endif
            </td>
          </tbody>
        </table>
      </div>
    </div>
  </div>
	<!-- / End of table Card-->
