		<!-- Left Panel Graph Card-->
    <div class="w-1/2 md:w-1/2 p-3">
      <div class="bg-orange-100 border border-gray-800 rounded shadow">
        <div class="border-b border-gray-800 p-3">
          <h5 class="font-bold uppercase text-gray-900">Racks in Room</h5>
        </div>
        <?php
            $rackPath = "facility/racks";
        ?>
				<div class="errors">
					@if (session()->has('formmessage'))
						<div class="alert alert-success">
							{{ session('message') }}
						</div>
					@endif
				</div>
				<div class="errors">

				</div>
        <div class="p-5">
				@foreach($racks as $rack)
					<button wire:click="rackLayout('{{ $rack->rack_id }}')">
					<div class="text-gray-900 text-center">{{ $rack->rack_name }}</div>
					
					<img class="inline px-2 py-2 m-2" src="{{ tenant_asset($rackPath.'/shelf.png') }}" alt="" width="100px" height="100px">
					</button>
				@endforeach
				</div>
      </div>
    </div>
		<!-- / End of Left Panel Graph Card-->
