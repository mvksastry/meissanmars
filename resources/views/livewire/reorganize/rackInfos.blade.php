<div class="p-2">
  @foreach($racks as $rack)
    <button wire:click.prevent="rackLayoutTable('{{ $rack->rack_id }}')">
    <div class="text-gray-900 text-center">{{ $rack->rack_name }}</div>
    
      <img class="inline m-1" src="{{ asset($rackPath.'/shelf.png') }}" alt="" width="48px" height="48px">
    </button>
  @endforeach
</div>
									