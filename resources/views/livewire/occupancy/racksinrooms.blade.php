<div class="p-2 row">
  @foreach($room_racks as $rack)
		<div class="col-sm-2 m-1 border border-primary">
			<button wire:click.prevent="rackLayout('{{ $rack->rack_id }}')">
				<div class="text-center">{{ $rack->rack_name }}</div>
				<img class="inline m-1 border border-primary" src="{{ asset($rackPath.'/shelf.png') }}" alt="" width="48px" height="48px">
			</button>
		</div>
  @endforeach
</div>
									