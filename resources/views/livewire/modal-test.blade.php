<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    Hello, KS
    <div class="p-6">
      <form wire:submit="save">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" />
        </div>
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
        </div>
        
        <div class="">		
          <table id="inventoryx" class="table table-sm table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>PMC Code</th>
                <th>Name</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $prodetails->product_id }}</td>
                <td>{{ $prodetails->pack_mark_code }}</td>
                <td>{{ $prodetials->name }} </td>
              </tr>
            </tbody>
          </table>
        
        
        <div class="mt-4">
            <button class="brn btn-primary btn-sm rounded">
                Save
            </button>
        </div>
      </form>
    </div>
</div>



    
